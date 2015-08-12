<?php
/**
 *
 * 绩效考核管理 Action
 * author：悟空HR
**/
class AppraisalmanagerAction extends Action{
	public function _initialize(){
		$action = array(
			'users'=>array('index', 'delete', 'view', 'enableTemplate', 'getuserlistdialog', 'getDetailAsk'),
			'anonymous'=>array()
		);
		B('Authenticate', $action);
	}

	public function index(){
		$p = $this->_get('p','intval',1);
		$appraisal_manager_list = D('AppraisalManager')->getAppraisalManager($p, array());
		$this->managerlist = $appraisal_manager_list['managerlist'];
		$this->assign('page', $appraisal_manager_list['page']);
		$this->alert = parseAlert();
		$this->display();
	}
	
	public function view(){
		$appraisal_manager_id = $_GET['id'];
		if(!empty($appraisal_manager_id)){
			$d_appraisal_manager = D('AppraisalManager');
			$appraisal_manager = $d_appraisal_manager->getAppraisalManagerById($appraisal_manager_id);
			$this->appraisalmanager = $appraisal_manager;
		}else{
			alert('error', '参数错误！', U('hrm/appraisalmanager/index'));
		}
		$this->alert = parseAlert();
		$this->display();
	}
	
	
	//删除已启用的绩效考核
	public function delete(){
		$appraisal_manager_id = $_REQUEST['id'];
		$d_appraisal_manager = D('AppraisalManager');
		$appraisal_manager = $d_appraisal_manager->getAppraisalManagerById($appraisal_manager_id);
		if(2 == $appraisal_manager['status']){
			alert('error', '删除失败，成绩已汇总！', U('hrm/appraisalmanager/index'));
		}
		if (!empty($appraisal_manager_id)){
			if ($d_appraisal_manager->deleteAppraisalManager($appraisal_manager_id)) {
				alert('success', '删除成功！', U('hrm/appraisalmanager/index'));
			}else{
				alert('error', '删除失败！', U('hrm/appraisalmanager/index'));
			}
		} else {
			alert('error', '删除失败，未选择需要删除的记录！', U('hrm/appraisalmanager/index'));
		}
	}
	
	//启用模板
	public function enableTemplate(){
		$d_appraisal_manager = D('AppraisalManager');
		if ($this->isPost()) {
			$data['name'] = trim($_POST['name']);
			$data['appraisal_template_id'] = intval($_POST['appraisal_template_id']);
			$data['executor_id'] = intval($_POST['executor_id']);
			$data['start_time'] = time();
			$data['end_time'] = strtotime($_POST['end_time']);
			$data['status'] = 1;
			$data['examinee_user_id'] = $_POST['examinee_user_id'];
			$data['examiner_user_id'] = $data['examinee_user_id'].session('user_id').',';
			
			if('' == $data['name']){
				alert('error','未填写名称！',$_SERVER['HTTP_REFERER']);
			}
			if('' == $data['appraisal_template_id']){
				alert('error','未选择模板！',$_SERVER['HTTP_REFERER']);
			}
			if('' == $data['end_time']){
				alert('error','未选择截止日期！',$_SERVER['HTTP_REFERER']);
			}
			if('' == $data['examinee_user_id']){
				alert('error','未选择考核对象！',$_SERVER['HTTP_REFERER']);
			}
//			if('' == $data['examiner_user_id']){
//				alert('error','未选择评分对象！',$_SERVER['HTTP_REFERER']);
//			}
			
			if($d_appraisal_manager->enableTemplate($data)){
				$d_message = D('Message');
				//发站内信给负责人(负责人就是创建考核的人)
				$info['title'] = '您有一封新的站内信通知：'.$data['name'].' 考核信息需要您进行负责跟进和督促考核进度，请您认真处理！';
				$info['content'] = '您有一封新的站内信通知：'.$data['name'].' 考核信息需要您进行负责跟进和督促考核进度，请您认真处理！';
				$info['user_id'] = 1;
				$info['to_user_id'] = session('user_id');
				$info['send_time'] = time();
				$d_message->send($info);
				//发站站内信给评分人
				$message['title'] = '您有一封新的站内信通知：'.$data['name'].' 需要您在时间短内进行 “在线考评” ，请及时处理！';
				$message['content'] = '您有一封新的站内信通知：'.$data['name'].' 需要您在时间短内进行 “在线考评” ，请及时处理！';
				$message['user_id'] = 1;
				$message['send_time'] = time();
				$examiner_idsArr = array_filter(explode(',', $data['examinee_user_id']));
				foreach($examiner_idsArr as $k=>$v){
					$message['to_user_id'] = $v;
					$d_message->send($message);
				}
                //传递name参数（GET），然后通过name参数来对数据进行查询，在输入时规定必须用不同的规格的名字来进行区分，这样可以方便进行查询。
				alert('success', '启用成功！', U('hrm/appraisalmanager/getDetailAsk?name=', array('name' => $data['name'])));
			}else{
				alert('error','启用失败！', $_SERVER['HTTP_REFERER']);
			}
		}else{
			$this->start_time = time();
		}
		$this->alert = parseAlert();
		$this->display();
	}

    public function getDetailAsk(){
        //根据名字获取KPI模版的信息
        if($this->isPost()){
            $appraisal_manager_id = $_POST['managerId'];
            $sizeScore = $_POST['numLen'];
            $scoreCommentArr = [];
            for($i=1; $i<=$sizeScore; $i++){
                $scoreCom = "description".$i;
                array_push($scoreCommentArr, $_POST[$scoreCom]);
            }

            $d_appraisal_manager = D('AppraisalManager');
            $appraisal_manager_1 = $d_appraisal_manager->getAppraisalManagerById($appraisal_manager_id);
            $appManager = $d_appraisal_manager->getAppraisalManId($appraisal_manager_id);
            $i = 0;
            foreach($appraisal_manager_1['template']['score'] as $val){
                $temp['appraisal_manager_id'] = $appraisal_manager_id;
                $temp['point'] = 0;
                $temp['comment'] = "";
                $temp['examinee_user_id'] = explode(',',$appManager['examinee_user_id'])[0];
                $temp['examiner_user_id'] = session('user_id');
                $temp['score_id'] = $val['score_id'];
                $temp['is_point'] = 0;
                $temp['kpi_detail'] = $scoreCommentArr[$i];
                $i++;
                $data[] = $temp;
            }
            $i = 0;
            foreach($appraisal_manager_1['template']['score'] as $val){
                $temp['appraisal_manager_id'] = $appraisal_manager_id;
                $temp['point'] = 0;
                $temp['comment'] = "";
                $temp['examinee_user_id'] = explode(',',$appManager['examinee_user_id'])[0];
                $temp['examiner_user_id'] = explode(',',$appManager['examinee_user_id'])[0];
                $temp['score_id'] = $val['score_id'];
                $temp['is_point'] = 0;
                $temp['kpi_detail'] = $scoreCommentArr[$i];
                $i++;
                $data[] = $temp;
            }

            $d_appraisal_point = D('AppraisalPoint');
            if($d_appraisal_point->addPoint($data)){
                alert('success', '添加成功！', U('hrm/appraisalmanager/index'));
            }
        }

        $appraisal_name = $_GET['name'];
        //首先需要根据名字来获取KPI模版中的各个项目，然后通过项目点获取页面输入内容
        $d_appraisal_manager = D('AppraisalManager');
        $appraisal_manager = $d_appraisal_manager->getAppraisalTem($appraisal_name);
        $m_score = M('appraisalTemplateScore');
        $score = $m_score->where('appraisal_template_id = %d', $appraisal_manager['appraisal_template_id'])->select();
        $scoreArr = [];
        foreach($score as $scoreVal){
            array_push($scoreArr, $scoreVal[name]);
        }
        $this->assign('managerId', $appraisal_manager['appraisal_manager_id']);
        $this->assign('scoreList', $scoreArr);
        $this->alert = parseAlert();
        $this->display();
    }

	//汇总
	public function summary(){
		$appraisal_manager_id = intval($_GET['appraisal_manager_id']);
		$d_appraisal_manager = D('AppraisalManager');
		$d_appraisal_point = D('AppraisalPoint');

//		$appraisal_manager = $d_appraisal_manager->getAppraisalManagerById($appraisal_manager_id);
//		if(isset($_GET['user_key'])){
//			$user_key = $_GET['user_key'];
//			$examinee_user = $appraisal_manager['examinee_user'][$user_key];
//			if(!empty($examinee_user)){
//				//汇总分数
//				// 个人本次考核单项平均分
//				$avg_pre_user_score = array();
//				$avg_pre_score_point = $d_appraisal_point->get_point($examinee_user['user_id'], $appraisal_manager_id);
//				foreach($avg_pre_score_point as $key=>$val){
//					$avg_pre_user_score[] = array('examinee_user_id'=>$examinee_user['user_id'], 'appraisal_manager_id'=>$appraisal_manager_id, 'score_id'=>$key, 'avg_point'=>$val);
//				}
//				if($d_appraisal_point->addAvgPoint($avg_pre_user_score)){
//					$this->ajaxReturn(array('status'=>1, 'tip'=>$examinee_user['name']));
//				}else{
//					$this->ajaxReturn(array('status'=>2, 'tip'=>$examinee_user['name'].'汇总失败！'));
//				}
//			}else{
//				//改变考核表状态
//				$data['appraisal_manager_id'] = $appraisal_manager_id;
//				$data['status'] = 2;
//				$d_appraisal_manager->editAppraisalManager($data);
//				$this->ajaxReturn(array('status'=>2, 'tip'=>'已完成汇总！'));
//			}
//		}else{
//			$this->appraisalmanager = $appraisal_manager;
//			$this->display();
//		}
	}
	
	//撤销汇总
	public function reset(){
		$appraisal_manager_id = intval($_GET['appraisal_manager_id']);
		if(!empty($appraisal_manager_id)){
			$d_appraisal_manager = D('AppraisalManager');
			$data['appraisal_manager_id'] = $appraisal_manager_id;
			$data['status'] = 1;
			if($d_appraisal_manager->editAppraisalManager($data)){

				alert('success','撤销汇总成功！', $_SERVER['HTTP_REFERER']);
			}else{
				alert('error','撤销汇总失败！', $_SERVER['HTTP_REFERER']);
			}
		}else{
			alert('error','参数错误！', $_SERVER['HTTP_REFERER']);
		}
	}
	
	
	public function getUserListDialog(){
		$d_user = D('User');
		$userlist = $d_user->getUserList();
		$this->assign('userlist', $userlist);
		$this->display();
	}
}