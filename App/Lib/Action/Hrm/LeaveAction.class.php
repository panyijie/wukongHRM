<?php
/**
 *
 * 请假 Action
 * author：悟空HR
**/

class LeaveAction extends Action{
	public function _initialize(){
		$action = array(
			'users'=>array('index','add', 'edit', 'delete', 'view', 'export'),
			'anonymous'=>array()
		);
		B('Authenticate', $action);
	}

	public function index(){
		$search_user_name = empty($_GET['search_user_name']) ? '' : trim($_GET['search_user_name']);
		$search_category = empty($_GET['search_category']) ? '' : intval($_GET['search_category']);
		$search_status = '' == $_GET['search_status'] ? '' : intval($_GET['search_status']);
		$search_start_time = empty($_GET['search_start_time']) ? '' : strtotime($_GET['search_start_time']);
		$search_end_time = empty($_GET['search_end_time']) ? '' : strtotime($_GET['search_end_time']);

		if(!empty($search_user_name)){
			$condition['user_name'] = $search_user_name;
		}
		if(!empty($search_category)){
			$condition['leave_category_id'] = $search_category;
		}
		if('' !== $search_status){
			$condition['status'] = $search_status;
		}
		if(!empty($search_start_time)){
			if(!empty($search_end_time)){
				$condition['start_time'] = array('between', array($search_start_time, $search_end_time));
			}else{
				$condition['start_time'] = array('between', array($search_start_time-1, $search_start_time+86400));
			}
		}
		if(!empty($search_end_time)){
			if(!empty($search_start_time)){
				$condition['end_time'] = array('between', array($search_start_time, $search_end_time));
			}else{
				$condition['end_time'] = array('between', array($search_end_time-1, $search_end_time+86400));
			}
		}

        //年假重置判断
        $annual_reset_user = D('User');
        $annual_user = $annual_reset_user->getUserInfo(array('user_id'=>session('user_id')));
        $annual_reset = $annual_user['annual_leave_reset'];

        $time_now = strtotime("now");
        $time_2016 = strtotime("8 February 2016");
        $time_2017 = strtotime("28 January 2017");
        $time_2018 = strtotime("16 February 2018");
        $time_2019 = strtotime("5 February 2019");
        $time_2020 = strtotime("25 January 2020");

        if(($time_now>$time_2016) && ($time_now<$time_2017) && ((int)$annual_reset<2016)){
            //如果已经过了2016年的春节了，还没有到2017年的春节，而年假的重置还是2016年之前重置的，那么就需要重置一下年假
            auunaulReset("2016");
        }else if(($time_now>$time_2017) && ($time_now<$time_2018) && ((int)$annual_reset<2017)){
            //如果已经过了2017年的春节了，还没有到2018年的春节，而年假的重置还是2017年之前重置的，那么就需要重置一下年假
            auunaulReset("2017");
        }else if(($time_now>$time_2018) && ($time_now<$time_2019) && ((int)$annual_reset<2018)){
            //如果已经过了2018年的春节了，还没有到2019年的春节，而年假的重置还是2018年之前重置的，那么就需要重置一下年假
            auunaulReset("2018");
        }else if(($time_now>$time_2019) && ($time_now<$time_2020) && ((int)$annual_reset<2019)){
            //如果已经过了2019年的春节了，还没有到2020年的春节，而年假的重置还是2019年之前重置的，那么就需要重置一下年假
            auunaulReset("2019");
        }
        //重置年假
        function auunaulReset($year){
            $user['user_id'] = session('user_id');
            $user['annual_leave'] = 8;
            $user['annual_leave_reset'] = $year;
            D('User')->editUserInfo($user);
        }

		$p = $this->_get('p','intval',1);
		$leavelist = D('Leave')->getLeave($p, $condition);
		$this->leavelist = $leavelist['leavelist'];
		$this->assign('page', $leavelist['page']);
		$this->alert = parseAlert();
		$this->display();
	}
	
	public function add(){
		if ($this->isPost()) {
			$data['user_id'] = session('user_id');
//          $data['user_id'] = trim($_POST['user_id']);
			$data['maker_user_id'] = session('user_id');
            $data['entrust_user_id'] = trim($_POST['user_id']);
			$data['leave_category_id'] = $_POST['leave_category_id'];
			$data['start_time'] = trim($_POST['start_time']);
			$data['end_time'] = trim($_POST['end_time']);
			$data['content'] = $_POST['content'];
            $data['annual_leave'] = $_POST['annual_leave'];
            $data['leave_days'] = $_POST['leave_days'];
			$data['create_time'] = time();
			$data['status'] = 0;
			
			if('' == $data['entrust_user_id']){
				alert('error','未选择工作委托人！',$_SERVER['HTTP_REFERER']);
			}
			if('' == $data['start_time']){
					alert('error','请设置开始时间！',$_SERVER['HTTP_REFERER']);
			}
			if('' == $data['end_time']){
				alert('error','请设置结束时间！',$_SERVER['HTTP_REFERER']);
			}
			if('' == $data['content']){
				alert('error','未填写请假原因！',$_SERVER['HTTP_REFERER']);
			}
            if(((int)$data['leave_category_id'] == 3) && ($data['annual_leave']<$data['leave_days'])){
                alert('error','年假申请超出剩余年假时间！',$_SERVER['HTTP_REFERER']);
            }

			$d_leave = D('Leave');
			if($d_leave->addLeave($data)){
                $leave_duser = D('User');
                $leave_user_info = $leave_duser->getUserInfo(array('user_id'=>$data['user_id']));
                $auditingUserList = explode(',', $leave_user_info['hr_supervisor']);
                foreach($auditingUserList as $val){
                    $d_message = D('Message');
                    $info['title'] = '您有一封新的站内信通知：'.session('name').' 有请假信息需要您跟进，请即刻处理！';
                    $info['content'] = '您有一封新的站内信通知：'.session('name').' 有请假信息需要您跟进，请您认真处理！';
                    $info['user_id'] = session('user_id');
                    $info['to_user_id'] = $val['user_id'];
                    $info['send_time'] = time();
                    $d_message->send($info);

                    $email_user_info = $leave_duser->getUserInfo(array('user_id'=>$val['user_id']));
                    C(F('smtp'),'smtp');
                    import('@.ORG.Mail');
                    $content = $leave_user_info['name'].'有一项请假请求需要您进行处理，请您登录ShowJoyHRM系统（hrm.showjoy.net）进行处理操作。谢谢'.'<br/><br/>--'.'(这是一封自动产生的email，请勿回复。)';
                    SendMail($email_user_info['email'], '【ShowJoyHRM】来自'.$leave_user_info['name'].'的请假审批请您处理', $content,'尚妆人力资源管理系统');
                }

//                给主管发送一封站内信，通知主管进行请假审核
//                $d_message = D('Message');
//                $info['title'] = '您有一封新的站内信通知：'.session('name').' 有请假信息需要您跟进，请即刻处理！';
//                $info['content'] = '您有一封新的站内信通知：'.session('name').' 有请假信息需要您跟进，请您认真处理！';
//                $info['user_id'] = session('user_id');
//                $info['to_user_id'] = 5;
//                $info['send_time'] = time();
//                $d_message->send($info);

                //修改剩余年假
                if((int)$data['leave_category_id'] == 3){
                    $user['user_id'] = session('user_id');
                    $user['annual_leave'] = $data['annual_leave'] - $data['leave_days'];
                    D('User')->editUserInfo($user);
                }
				alert('success','添加成功！', U('hrm/leave/index'));
			}else{
				alert('error','添加失败！', U('hrm/leave/index'));
			}
		}else{
            //进入请假模块，直接进行添加而不是进行提交的时候会把当前的名字输出
            $this->maker_user_name = session('name');
            $d_user = D('User');
            $user = $d_user->getUserInfo(array('user_id'=>session('user_id')));
            $this->annual_leave = $user['annual_leave'];
			$this->alert = parseAlert();
			$this->display();
		}
	}
	
	public function view(){
		$leave_id = $_GET['id'];
		if(!empty($leave_id)){
			$d_leave = D('Leave');
			$leave = $d_leave->getLeaveById($leave_id);
			$this->leave = $leave;
		}else{
			alert('error', '参数错误！', U('hrm/leave/index'));
		}
        $leave_user_id = $_REQUEST['leave_user_id'];
        $session_user_id = session('user_id');
        $dUser = D('User');

        $is_sub_user = $dUser->checkIsSubUser($leave_user_id, $session_user_id);

        $this->assign('isSubUser', $is_sub_user);
		$this->alert = parseAlert();
		$this->display();
	}
	
	public function edit(){
		$leave_id = $_REQUEST['id'];
		if(!empty($leave_id)){
			if ($this->isPost()) {
				$data['leave_id'] = intval($leave_id);
                $data['user_id'] = trim($_POST['make_user_id']);
//              $data['user_id'] = trim($_POST['user_id']);
				$data['maker_user_id'] = trim($_POST['make_user_id']);
                $data['entrust_user_id'] = intval($_POST['user_id']);
				$data['leave_category_id'] = $_POST['leave_category_id'];
                $data['annual_leave'] = $_POST['annual_leave'];
                $data['leave_days'] = $_POST['leave_days'];
				$data['start_time'] = trim($_POST['start_time']);
				$data['end_time'] = trim($_POST['end_time']);
				$data['content'] = $_POST['content'];

                if(session('user_id') != 1){
                    alert('error','您没有编辑权限！', U('hrm/leave/view', 'id='.$leave_id));
                }

				if('' == $data['entrust_user_id']){
					alert('error','未选择工作交接人！',$_SERVER['HTTP_REFERER']);
				}
				if('' == $data['start_time']){
						alert('error','请设置开始时间！',$_SERVER['HTTP_REFERER']);
				}
				if('' == $data['end_time']){
					alert('error','请设置结束时间！',$_SERVER['HTTP_REFERER']);
				}
				if('' == $data['content']){
					alert('error','未填写请假原因！',$_SERVER['HTTP_REFERER']);
				}
                if(((int)$data['leave_category_id'] == 3) && ($data['annual_leave']<$data['leave_days'])){
                    alert('error','年假申请超出剩余年假时间！',$_SERVER['HTTP_REFERER']);
                }
				
				$d_leave = D('Leave');
				if($d_leave->editLeave($data)){
                    if((int)$data['leave_category_id'] == 3){
                        $user['user_id'] = session('user_id');
                        $user['annual_leave'] = $data['annual_leave'] - $data['leave_days'];
                        D('User')->editUserInfo($user);
                    }
					alert('success','编辑成功！', U('hrm/leave/view', 'id='.$leave_id));
				}else{
					alert('error','编辑失败！', U('hrm/leave/view', 'id='.$leave_id));
				}
			}else{
				$d_leave = D('Leave');
				$this->leave = $d_leave->getLeaveById($leave_id);
                $d_user = D('User');
                $user = $d_user->getUserInfo(array('user_id'=>session('user_id')));
                $this->annual_leave = $user['annual_leave'];
			}
		}else{
			alert('error', '参数错误！', U('hrm/leave/index'));
		}
		$this->alert = parseAlert();
		$this->display();
	}
	
	//删除任务
	public function delete(){
		$leave_id = $_REQUEST['id'];
        $leave_category = trim($_REQUEST['leave_category_id']);
        $leave_user_id = $_REQUEST['leave_user_id'];
        $annual_leave = (float)$_REQUEST['annual_leave'] + (float)$_REQUEST['leave_days'];

        if((int)session('user_id') != 1){
            alert('error', '删除失败,您没有权限！', U('hrm/leave/index'));
        }

		if (!empty($leave_id)){
			$d_leave = D('Leave');
			if ($d_leave->deleteLeave($leave_id)) {
                if($leave_category == 3){
                    $user['user_id'] = $leave_user_id;
                    $user['annual_leave'] = $annual_leave;
                    D('User')->editUserInfo($user);
                }
				alert('success', '删除成功！', U('hrm/leave/index'));
			}else{
				alert('error', '删除失败！', U('hrm/leave/index'));
			}
		} else {
			alert('error', '删除失败，未选择需要删除的记录！', U('hrm/leave/index'));
		}
	}
	
	//审核
	public function auditing(){
		$leave_id = $_REQUEST['id'];
		$ref = $_GET['ref'];
		$data['leave_id'] = $leave_id ;
		$data['status'] = $_REQUEST['status'];
        $user_id = $_REQUEST['uid'];
        $enuser_id = $_REQUEST['euid'];
		if (empty($data['leave_id'])){
			alert('error', '未选择需要审核的记录！', U('hrm/leave/index'));
		}
		if (empty($data['status'])){
			alert('error', '未选择审核状态！', U('hrm/leave/index'));
		}

        //在这里的审核设计中，自己不能审核自己的请假条
        //同时需要注意在得到登记内容的同时需要得到自己相对应上级的
        if ($user_id == session('user_id')){
            alert('error', '自己不能审核自己的请假条！', U('hrm/leave/index'));
        }

        $dUser = D('User');
        $leave_user_information = $dUser->getUserInfo(array('user_id'=>$user_id));
        //获取user_id之后获取其hr_supervisor_id，通过其人事管理来确认是否有权限进行信息的审核。
        $auditingUserList = explode(',', $leave_user_information['hr_supervisor']);

        if(in_array(session('user_id'), $auditingUserList)){
            $d_leave = D('Leave');
            $leave = $d_leave->getLeaveById($leave_id);
            if($data['status'] == $leave['status']){
                alert('error', '请勿重复审核', U('hrm/leave/index'));
            }else{
                if ($d_leave->auditingLeave($data)) {
                    //将审核结果发给相应的同学，其中包括申请请假的同学和交接的同学都会收到相应的通知。（Message模块）
                    $d_message = D('Message');
                    if($data['status'] == 1){
                        $info['title'] = '您的请假申请已通过审核，可前往请假管理查看详情！';
                        $info['content'] = '您的请假审核经过'.session('name').'审核通过，可前往请假管理查看详细审核结果！';

                        C(F('smtp'),'smtp');
                        import('@.ORG.Mail');
                        $content = '您的请假已通过审批，可登录ShowJoyHRM系统（hrm.showjoy.net）进行查看。谢谢'.'<br/><br/>--'.'(这是一封自动产生的email，请勿回复。)';
                        SendMail($leave_user_information['email'], '【ShowJoyHRM】您的请假已通过审批', $content,'尚妆人力资源管理系统');

                    }else if($data['status'] == 2){
                        $info['title'] = '您的请假申请未通过审核，请前往请假管理查看详情！';
                        $info['content'] = '您的请假审核经过'.session('name').'审核未通过，请前往请假管理查看详细审核结果！';
                        C(F('smtp'),'smtp');
                        import('@.ORG.Mail');
                        $content = '您的请假未通过审批，可登录ShowJoyHRM系统（hrm.showjoy.net）进行查看。谢谢'.'<br/><br/>--'.'(这是一封自动产生的email，请勿回复。)';
                        SendMail($leave_user_information['email'], '【ShowJoyHRM】您的请假未通过审批', $content,'尚妆人力资源管理系统');
                    }
                    $info['user_id'] = session('user_id');
                    $info['to_user_id'] = $user_id;
                    $info['send_time'] = time();
                    $d_message->send($info);

                    if($data['status'] == 1){
                        $info_en['title'] = '与您交接的小伙伴请假申请已通过审核，可前往请假管理查看详情！';
                        $info_en['content'] = '与您交接的小伙伴请假审核经过'.session('name').'审核通过，可前往请假管理查看详细审核结果！';
                    }else if($data['status'] == 2){
                        $info_en['title'] = '与您交接的小伙伴请假申请未通过审核，请前往请假管理查看详情！';
                        $info_en['content'] = '与您交接的小伙伴请假审核经过'.session('name').'审核未通过，请前往请假管理查看详细审核结果！';
                    }
                    $info_en['user_id'] = session('user_id');
                    $info_en['to_user_id'] = $enuser_id;
                    $info_en['send_time'] = time();
                    $d_message->send($info_en);
                    alert('success', '审核成功！', U('hrm/leave/index'));
                }else{
                    alert('error', '审核失败！', U('hrm/leave/index'));
                }
            }
        }else{
            alert('error', '您没有权限审核！', U('hrm/leave/index'));
        }
	}

    public function export(){
        if($this->isPost()){
            if(session('user_id') != 1){
                alert('error', '您没有权限审核！', U('hrm/leave/index'));
            }else{
                $consoleTime = $_POST['search_start_time'];
                $search_start_time = strtotime($consoleTime);
                $search_end_time = strtotime($_POST['search_end_time']);
                if(!empty($search_start_time)){
                    if(!empty($search_end_time)){
                        $condition['start_time'] = array('between', array($search_start_time, $search_end_time));
                    }else{
                        $condition['start_time'] = array('between', array($search_start_time-1, $search_start_time+86400));
                    }
                }
                if(!empty($search_end_time)){
                    if(!empty($search_start_time)){
                        $condition['end_time'] = array('between', array($search_start_time, $search_end_time));
                    }else{
                        $condition['end_time'] = array('between', array($search_end_time-1, $search_end_time+86400));
                    }
                }
                $p = $this->_get('p','intval',1);
                $leavelist = D('Leave')->getLeave($p, $condition);

                //excel代码开始：
                Vendor("PHPExcel.PHPExcel");
                $objPHPExcel = new PHPExcel();
                $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                $Year = explode("-",$consoleTime)[0];
                $Month = explode("-",$consoleTime)[1];
                $excelTitle = $Year.'年'.$Month.'月请假导出';
                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->setTitle($excelTitle);
                $objPHPExcel->getActiveSheet()->setCellValue('A1', $excelTitle);
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->mergeCells('A1:AO2');
                $objPHPExcel->getActiveSheet()->setCellValue('A3', '花名');
                $objPHPExcel->getActiveSheet()->mergeCells('A3:A4');
                $objPHPExcel->getActiveSheet()->setCellValue('B3', '姓名');
                $objPHPExcel->getActiveSheet()->mergeCells('B3:B4');
                $objPHPExcel->getActiveSheet()->setCellValue('C3', '星期');
                $objPHPExcel->getActiveSheet()->setCellValue('C4', '日');
                //设置单元格颜色
//                $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//                $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('112233');
                $start_day = $_POST['search_start_time'];
                D('Leave')->getExcelDay($start_day,$objPHPExcel);
                D('Leave')->getExcelWk($start_day,$objPHPExcel);
                $objPHPExcel->getActiveSheet()->setCellValue('AJ3', '总天数');
                $objPHPExcel->getActiveSheet()->getStyle('AJ3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('AK3', '年假');
                $objPHPExcel->getActiveSheet()->getStyle('AK3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('AL3', '事假');
                $objPHPExcel->getActiveSheet()->getStyle('AL3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('AM3', '病假');
                $objPHPExcel->getActiveSheet()->getStyle('AM3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('AN3', '调休');
                $objPHPExcel->getActiveSheet()->getStyle('AN3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('AO3', '其他');
                $objPHPExcel->getActiveSheet()->getStyle('AO3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('AJ4', '天数');
                $objPHPExcel->getActiveSheet()->getStyle('AJ4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('AK4', '天数');
                $objPHPExcel->getActiveSheet()->getStyle('AK4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('AL4', '天数');
                $objPHPExcel->getActiveSheet()->getStyle('AL4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('AM4', '天数');
                $objPHPExcel->getActiveSheet()->getStyle('AM4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('AN4', '天数');
                $objPHPExcel->getActiveSheet()->getStyle('AN4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('AO4', '天数');
                $objPHPExcel->getActiveSheet()->getStyle('AO4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                //获取所有用户的花名，由于数据库中还没有加入真名，等加入真名功能之后再在excel中加入真名
                $user = D('UserView');
                $userlist = $user->where(array('status'=>1))->select();
                $excelDataStartLine = 5;
                $addUserDateLine = $excelDataStartLine;
                foreach($userlist as $key=>$val){
                    if($userlist[$key]['user_id'] == 1){
                        continue;
                    }

                    //各类假期计数变量的定义
                    $userTotleYearLeave = 0;
                    $userTotleEventLeave = 0;
                    $userTotleIllLeave = 0;
                    $userTotleElseLeave = 0;
                    $userTotleTiaoLeave = 0;

                    //获取用户姓名等信息，后面进行其他信息的获取
                    $e_addUserDateLine = "A".$addUserDateLine;
                    $e_addUserRealNameLine = "B".$addUserDateLine;
                    $objPHPExcel->getActiveSheet()->setCellValue("C".$addUserDateLine, "上午");
                    $objPHPExcel->getActiveSheet()->setCellValue($e_addUserDateLine, $userlist[$key]['name']);
                    $objPHPExcel->getActiveSheet()->getStyle("C".$addUserDateLine)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle($e_addUserDateLine)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $addUserDateLine++;
                    $objPHPExcel->getActiveSheet()->setCellValue("C".$addUserDateLine, "下午");
                    $objPHPExcel->getActiveSheet()->getStyle("C".$addUserDateLine)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $e_merge_addUserDateLine = $e_addUserDateLine.":"."A".$addUserDateLine;
                    $e_merge_addUserRealNameLine = $e_addUserRealNameLine.":"."B".$addUserDateLine;
                    $objPHPExcel->getActiveSheet()->mergeCells($e_merge_addUserDateLine);
                    $objPHPExcel->getActiveSheet()->mergeCells($e_merge_addUserRealNameLine);
                    $objPHPExcel->getActiveSheet()->getStyle($e_merge_addUserDateLine)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle($e_merge_addUserRealNameLine)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $addUserDateLine++;

                    $excelLeaveData = [];
                    foreach(range('C','Z') as $v){
                        array_push($excelLeaveData,$v);
                    }
                    foreach(range('A','H') as $v){
                        array_push($excelLeaveData,'A'.$v);
                    }

                    //获取该用户的所有请假条的信息，然后根据用户的请假条信息进行判断
                    $only_condition['user_name'] = $userlist[$key]['name'];
                    $p = $this->_get('p','intval',1);
                    $userLeavelist = D('Leave')->getLeave($p, $only_condition);


                    foreach($userLeavelist['leavelist'] as $key=>$value){
                        $userLeaveStartTime = strtotime($userLeavelist['leavelist'][$key]['start_time']);
                        $userLeaveEndTime = strtotime($userLeavelist['leavelist'][$key]['end_time']);
                        $leaveCategory = $userLeavelist['leavelist'][$key]['category_id'];

                        if($leaveCategory == 1){
                            $S_leaveCategory = '○';
                        }elseif($leaveCategory == 2){
                            $S_leaveCategory = '☆';
                        }elseif($leaveCategory == 3){
                            $S_leaveCategory = '●';
                        }elseif($leaveCategory == 5){
                            $S_leaveCategory = '※';
                        }else{
                            $S_leaveCategory = '※';
                        }

                        if(($search_start_time>=$userLeaveStartTime && $search_end_time<=$userLeaveEndTime) || ($search_start_time>=$userLeaveStartTime && $search_start_time<=$userLeaveEndTime && $search_end_time>=$userLeaveEndTime) || ($search_start_time<=$userLeaveStartTime && $search_end_time>=$userLeaveEndTime) || ($userLeaveStartTime>=$search_start_time && $search_end_time>=$userLeaveStartTime && $search_end_time<=$userLeaveEndTime)){
                            if($search_start_time>=$userLeaveStartTime && $search_end_time<=$userLeaveEndTime){
                                //这里是请了整个月的假，每天都在请假
                                $to_e_leaveStartDay = substr(date('Y-m-d H:i:s',$search_start_time),0,11)."09:00:00";
                                $to_e_leaveEndDay = substr(date('Y-m-d H:i:s',$search_end_time),0,11)."09:00:00";
                            }elseif($search_start_time>=$userLeaveStartTime && $search_start_time<=$userLeaveEndTime && $search_end_time>=$userLeaveEndTime){
                                //从这个月的开始就请了，这个月并没有请完，后面有没请假的时候
                                $to_e_leaveStartDay = substr(date('Y-m-d H:i:s',$search_start_time),0,11)."09:00:00";
                                $to_e_leaveEndDay = date('Y-m-d H:i:s',$userLeaveEndTime);
                            }elseif($search_start_time<=$userLeaveStartTime && $search_end_time>=$userLeaveEndTime){
                                //在这个月中间请的假，前后可能都有没有请的
                                $to_e_leaveStartDay = date('Y-m-d H:i:s',$userLeaveStartTime);
                                $to_e_leaveEndDay = date('Y-m-d H:i:s',$userLeaveEndTime);
                            }elseif($userLeaveStartTime>=$search_start_time && $search_end_time>=$userLeaveStartTime && $search_end_time<=$userLeaveEndTime){
                                //从月中请的假，持续到了下个月，结束时间是下个月
                                $to_e_leaveStartDay = date('Y-m-d H:i:s',$userLeaveStartTime);
                                $to_e_leaveEndDay = substr(date('Y-m-d H:i:s',$search_end_time),0,11)."09:00:00";
                            }

//                        $objPHPExcel->getActiveSheet()->setCellValue("F7", date('Y-m-d H:i:s',$userLeaveStartTime));
//                        $objPHPExcel->getActiveSheet()->setCellValue("F8", $to_e_leaveStartDay);
//                        $objPHPExcel->getActiveSheet()->setCellValue("F9", substr(date('Y-m-d H:i:s',$search_start_time),11,19));
//                        $objPHPExcel->getActiveSheet()->setCellValue("F10", substr(date('Y-m-d H:i:s',$search_end_time),0,11)."06:00:00");

                            $e_leaveStartDate = substr($to_e_leaveStartDay,8,2);
                            $e_leaveStartTime = substr($to_e_leaveStartDay,11,8);
                            $e_leaveEndDate = substr($to_e_leaveEndDay,8,2);
                            $e_leaveEndTime = substr($to_e_leaveEndDay,11,8);

                            for($monthDate=1; $monthDate<=31; $monthDate++){
//                            $objPHPExcel->getActiveSheet()->setCellValue("F7", $e_leaveStartTime);
//                            $objPHPExcel->getActiveSheet()->setCellValue("F8", $e_leaveStartDate);
                                if($e_leaveStartDate == $monthDate){
                                    if(($e_leaveEndDate == $e_leaveStartDate) || (($e_leaveEndDate==((int)$e_leaveStartDate+1)) && ($e_leaveEndTime=="09:00:00"))){
                                        //请假在一天以内
                                        if($e_leaveStartTime == "09:00:00" && $e_leaveEndTime == "12:00:00"){
                                            $userLine = $addUserDateLine-2;
                                            $objPHPExcel->getActiveSheet()->setCellValue($excelLeaveData[$monthDate].$userLine, $S_leaveCategory);
                                            $objPHPExcel->getActiveSheet()->getStyle($excelLeaveData[$monthDate].$userLine)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                                        $userTotleLeave += 0.5;
                                            if($leaveCategory == 1){//事假
                                                $userTotleEventLeave += 0.5;
                                            }elseif($leaveCategory == 2){//病假
                                                $userTotleIllLeave += 0.5;
                                            }elseif($leaveCategory == 3){//年假
                                                $userTotleYearLeave += 0.5;
                                            }elseif($leaveCategory == 5){//调休
                                                $userTotleTiaoLeave += 0.5;
                                            }else{//其他
                                                $userTotleElseLeave += 0.5;
                                            }
                                        }elseif($e_leaveStartTime == "12:00:00"){
                                            $userLine = $addUserDateLine-1;
                                            $objPHPExcel->getActiveSheet()->setCellValue($excelLeaveData[$monthDate].$userLine, $S_leaveCategory);
                                            $objPHPExcel->getActiveSheet()->getStyle($excelLeaveData[$monthDate].$userLine)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                                        $userTotleLeave += 0.5;
                                            if($leaveCategory == 1){//事假
                                                $userTotleEventLeave += 0.5;
                                            }elseif($leaveCategory == 2){//病假
                                                $userTotleIllLeave += 0.5;
                                            }elseif($leaveCategory == 3){//年假
                                                $userTotleYearLeave += 0.5;
                                            }elseif($leaveCategory == 5){//调休
                                                $userTotleTiaoLeave += 0.5;
                                            }else{//其他
                                                $userTotleElseLeave += 0.5;
                                            }
                                        }elseif($e_leaveStartTime == "09:00:00" && $e_leaveEndTime == "18:00:00"){
                                            $userLine = $addUserDateLine-2;
                                            $objPHPExcel->getActiveSheet()->setCellValue($excelLeaveData[$monthDate].$userLine, $S_leaveCategory);
                                            $objPHPExcel->getActiveSheet()->getStyle($excelLeaveData[$monthDate].$userLine)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                            $userLine = $addUserDateLine-1;
                                            $objPHPExcel->getActiveSheet()->setCellValue($excelLeaveData[$monthDate].$userLine, $S_leaveCategory);
                                            $objPHPExcel->getActiveSheet()->getStyle($excelLeaveData[$monthDate].$userLine)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                                        $userTotleLeave += 1;
                                            if($leaveCategory == 1){//事假
                                                $userTotleEventLeave += 1;
                                            }elseif($leaveCategory == 2){//病假
                                                $userTotleIllLeave += 1;
                                            }elseif($leaveCategory == 3){//年假
                                                $userTotleYearLeave += 1;
                                            }elseif($leaveCategory == 5){//调休
                                                $userTotleTiaoLeave += 1;
                                            }else{//其他
                                                $userTotleElseLeave += 1;
                                            }
                                        }
                                        continue;
                                    }else{
                                        if($e_leaveStartTime == "09:00:00"){
                                            $userLine = $addUserDateLine-2;
                                            $objPHPExcel->getActiveSheet()->setCellValue($excelLeaveData[$monthDate].$userLine, $S_leaveCategory);
                                            $objPHPExcel->getActiveSheet()->getStyle($excelLeaveData[$monthDate].$userLine)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                            $userLine = $addUserDateLine-1;
                                            $objPHPExcel->getActiveSheet()->setCellValue($excelLeaveData[$monthDate].$userLine, $S_leaveCategory);
                                            $objPHPExcel->getActiveSheet()->getStyle($excelLeaveData[$monthDate].$userLine)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                                        $userTotleLeave += 1;
                                            if($leaveCategory == 1){//事假
                                                $userTotleEventLeave += 1;
                                            }elseif($leaveCategory == 2){//病假
                                                $userTotleIllLeave += 1;
                                            }elseif($leaveCategory == 3){//年假
                                                $userTotleYearLeave += 1;
                                            }elseif($leaveCategory == 5){//调休
                                                $userTotleTiaoLeave += 1;
                                            }else{//其他
                                                $userTotleElseLeave += 1;
                                            }
                                        }elseif($e_leaveStartTime == "12:00:00"){
                                            $userLine = $addUserDateLine-1;
                                            $objPHPExcel->getActiveSheet()->setCellValue($excelLeaveData[$monthDate].$userLine, $S_leaveCategory);
                                            $objPHPExcel->getActiveSheet()->getStyle($excelLeaveData[$monthDate].$userLine)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                                        $userTotleLeave += 0.5;
                                            if($leaveCategory == 1){//事假
                                                $userTotleEventLeave += 0.5;
                                            }elseif($leaveCategory == 2){//病假
                                                $userTotleIllLeave += 0.5;
                                            }elseif($leaveCategory == 3){//年假
                                                $userTotleYearLeave += 0.5;
                                            }elseif($leaveCategory == 5){//调休
                                                $userTotleTiaoLeave += 0.5;
                                            }else{//其他
                                                $userTotleElseLeave += 0.5;
                                            }
                                        }
                                        continue;
                                    }
                                }else if($e_leaveEndDate == $monthDate){
                                    if($e_leaveStartTime == "12:00:00"){
                                        $userLine = $addUserDateLine-2;
                                        $objPHPExcel->getActiveSheet()->setCellValue($excelLeaveData[$monthDate].$userLine, $S_leaveCategory);
                                        $objPHPExcel->getActiveSheet()->getStyle($excelLeaveData[$monthDate].$userLine)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                                    $userTotleLeave += 0.5;
                                        if($leaveCategory == 1){//事假
                                            $userTotleEventLeave += 0.5;
                                        }elseif($leaveCategory == 2){//病假
                                            $userTotleIllLeave += 0.5;
                                        }elseif($leaveCategory == 3){//年假
                                            $userTotleYearLeave += 0.5;
                                        }elseif($leaveCategory == 5){//调休
                                            $userTotleTiaoLeave += 0.5;
                                        }else{//其他
                                            $userTotleElseLeave += 0.5;
                                        }
                                    }elseif($e_leaveStartTime == "18:00:00"){
                                        $userLine = $addUserDateLine-1;
                                        $objPHPExcel->getActiveSheet()->setCellValue($excelLeaveData[$monthDate].$userLine, $S_leaveCategory);
                                        $objPHPExcel->getActiveSheet()->getStyle($excelLeaveData[$monthDate].$userLine)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                                    $userTotleLeave += 0.5;
                                        if($leaveCategory == 1){//事假
                                            $userTotleEventLeave += 0.5;
                                        }elseif($leaveCategory == 2){//病假
                                            $userTotleIllLeave += 0.5;
                                        }elseif($leaveCategory == 3){//年假
                                            $userTotleYearLeave += 0.5;
                                        }elseif($leaveCategory == 5){//调休
                                            $userTotleTiaoLeave += 0.5;
                                        }else{//其他
                                            $userTotleElseLeave += 0.5;
                                        }
                                    }
                                    continue;
                                }elseif($e_leaveStartDate < $monthDate && $e_leaveEndDate > $monthDate){
                                    $userLine = $addUserDateLine-2;
                                    $objPHPExcel->getActiveSheet()->setCellValue($excelLeaveData[$monthDate].$userLine, $S_leaveCategory);
                                    $objPHPExcel->getActiveSheet()->getStyle($excelLeaveData[$monthDate].$userLine)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                    $userLine = $addUserDateLine-1;
                                    $objPHPExcel->getActiveSheet()->setCellValue($excelLeaveData[$monthDate].$userLine, $S_leaveCategory);
                                    $objPHPExcel->getActiveSheet()->getStyle($excelLeaveData[$monthDate].$userLine)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                                $e_leaveStartDate += 1;
                                    if($leaveCategory == 1){//事假
                                        $userTotleEventLeave += 1;
                                    }elseif($leaveCategory == 2){//病假
                                        $userTotleIllLeave += 1;
                                    }elseif($leaveCategory == 3){//年假
                                        $userTotleYearLeave += 1;
                                    }elseif($leaveCategory == 5){//调休
                                        $userTotleTiaoLeave += 1;
                                    }else{//其他
                                        $userTotleElseLeave += 1;
                                    }
                                    continue;
                                }
                            }

                        }
                    }
                    $userTotleLeave = $userTotleYearLeave + $userTotleEventLeave + $userTotleIllLeave + $userTotleElseLeave + $userTotleTiaoLeave;
                    $objPHPExcel->getActiveSheet()->setCellValue("AJ".($addUserDateLine-2), $userTotleLeave);
                    $objPHPExcel->getActiveSheet()->setCellValue("AK".($addUserDateLine-2), $userTotleYearLeave);
                    $objPHPExcel->getActiveSheet()->setCellValue("AL".($addUserDateLine-2), $userTotleEventLeave);
                    $objPHPExcel->getActiveSheet()->setCellValue("AM".($addUserDateLine-2), $userTotleIllLeave);
                    $objPHPExcel->getActiveSheet()->setCellValue("AN".($addUserDateLine-2), $userTotleTiaoLeave);
                    $objPHPExcel->getActiveSheet()->setCellValue("AO".($addUserDateLine-2), $userTotleElseLeave);
                    $objPHPExcel->getActiveSheet()->getStyle("AJ".($addUserDateLine-2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle("AK".($addUserDateLine-2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle("AL".($addUserDateLine-2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle("AM".($addUserDateLine-2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle("AN".($addUserDateLine-2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle("AO".($addUserDateLine-2))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                }

                $objPHPExcel->getActiveSheet()->getStyle('A1:AR2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A3:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A3:A4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B3:B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B3:B4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                foreach(range('A','Z') as $v){
                    $objPHPExcel->getActiveSheet()->getColumnDimension($v)->setWidth(6);
                }
                foreach(range('A','O') as $v){
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A'.$v)->setWidth(6);
                }
                $objPHPExcel->createSheet();
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save($Year.'-'.$Month.".xlsx");
                $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
                header("Pragma: public");
                header("Expires: 0");
                header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
                header("Content-Type:application/force-download");
                header("Content-Type:application/vnd.ms-execl");
                header("Content-Type:application/octet-stream");
                header("Content-Type:application/download");
                header('Content-Disposition:attachment;filename="'.$Year.'-'.$Month.'请假导出'.'.xls"');
                header("Content-Transfer-Encoding:binary");
                $objWriter->save('php://output');
//          对所有的请假条进行的操作
//            $this->leavelist = $leavelist['leavelist'];
//            $this->assign('page', $leavelist['page']);
//            alert('success', '导出成功！', U('hrm/leave/index'));
            }
        }

        $d_leave = D('Leave');
        $leave = $d_leave->where(array('status'=>1))->order('create_time')->limit(1)->select();
        $this->leave = $leave;
        $this->alert = parseAlert();
        $this->display();
    }
}