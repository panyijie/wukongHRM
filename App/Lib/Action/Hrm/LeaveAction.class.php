<?php
/**
 *
 * 请假 Action
 * author：悟空HR
**/
class LeaveAction extends Action{

	public function _initialize(){
		$action = array(
			'users'=>array('index','add', 'edit', 'delete', 'view'),
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
			$data['start_time'] = strtotime($_POST['start_time']);
			$data['end_time'] = strtotime($_POST['end_time']);
			$data['content'] = $_POST['content'];
            $data['annual_leave'] = (int)$_POST['annual_leave'];
            $data['leave_days'] = (int)$_POST['leave_days'];
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
                //给主管发送一封站内信，通知主管进行请假审核
                $d_message = D('Message');
                $info['title'] = '您有一封新的站内信通知：'.session('name').' 有请假信息需要您跟进，请即刻处理！';
                $info['content'] = '您有一封新的站内信通知：'.session('name').' 有请假信息需要您跟进，请您认真处理！';
                $info['user_id'] = session('user_id');
                $info['to_user_id'] = 5;
                $info['send_time'] = time();
                $d_message->send($info);

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
		$this->alert = parseAlert();
		$this->display();
	}
	
	public function edit(){
		$leave_id = $_REQUEST['id'];
		if(!empty($leave_id)){
			if ($this->isPost()) {
				$data['leave_id'] = intval($leave_id);
                $data['user_id'] = session('user_id');
//              $data['user_id'] = trim($_POST['user_id']);
				$data['maker_user_id'] = session('user_id');
                $data['entrust_user_id'] = trim($_POST['user_id']);
				$data['leave_category_id'] = $_POST['leave_category_id'];
                $data['annual_leave'] = (int)$_POST['annual_leave'];
                $data['leave_days'] = (int)$_POST['leave_days'];
				$data['start_time'] = strtotime($_POST['start_time']);
				$data['end_time'] = strtotime($_POST['end_time']);
				$data['content'] = $_POST['content'];

                if((int)$data['user_id'] != 5){
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
        if((int)session('user_id') != 5){
            alert('error', '删除失败,您没有权限！', U('hrm/leave/index'));
        }
		if (!empty($leave_id)){
			$d_leave = D('Leave');
			if ($d_leave->deleteLeave($leave_id)) {
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
                }else if($data['status'] == 2){
                    $info['title'] = '您的请假申请未通过审核，请前往请假管理查看详情！';
                    $info['content'] = '您的请假审核经过'.session('name').'审核未通过，请前往请假管理查看详细审核结果！';
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
	}
	
}