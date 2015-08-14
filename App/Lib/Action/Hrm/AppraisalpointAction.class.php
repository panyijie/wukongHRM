<?php
/**
 *
 * 绩效考核评分 Action
 * author：悟空HR
**/
class AppraisalpointAction extends Action{
	public function _initialize(){
		$action = array(
			'users'=>array(),
			'anonymous'=>array()
		);
		B('Authenticate', $action);
	}

	public function index(){
		$p = $this->_get('p','intval',1);
		$d_appraisal_point = D('AppraisalPoint');
		$appraisal_point = $d_appraisal_point->getAppraisalPoint();
        $appraisal_examiner_point = $d_appraisal_point->getAppraisalExaminerPoint();
        $appraisal_point_1 = $d_appraisal_point->getAppraisalPoint_1();
        $appraisal_examiner_point_1 = $d_appraisal_point->getAppraisalExaminerPoint_1();
//        foreach($appraisal_point_1 as $val){
//            echo $val['status_name'];
//        }
        $this->appraisalexaminerpoint_1 = $appraisal_examiner_point_1;
        $this->appraisalpoint_1 = $appraisal_point_1;
        $this->appraisalexaminerpoint = $appraisal_examiner_point;
		$this->appraisalpoint = $appraisal_point;
		$this->alert = parseAlert();
		$this->display();
	}
	
	public function edit(){
		$appraisal_manager_id = $_REQUEST['id'];
		if(!empty($appraisal_manager_id)){
			$d_appraisal_manager = D('AppraisalManager');
			$d_appraisal_point = D('AppraisalPoint');

			if($this->isPost()){
				$appraisal_manager = $d_appraisal_manager->getAppraisalManagerById($appraisal_manager_id);
				foreach($appraisal_manager['template']['score'] as $val){
					$temp['appraisal_manager_id'] = $appraisal_manager_id;
					$temp['point'] = $_POST['point'][$val['score_id']];
					$temp['comment'] = $_POST['comment'][$val['score_id']];
					$temp['examinee_user_id'] = $_POST['examinee_user_id'];
					$temp['examiner_user_id'] = session('user_id');
					$temp['score_id'] = $val['score_id'];
                    $temp['is_point'] = 0;
                    if(!is_numeric($temp['point']) || $temp['point'] > $val['high_scope']){
                        alert('error', "【 ".$val['name']." 】".'份数格式不正确！', $_SERVER['HTTP_REFERER']);
                    }
                    $d_appraisal_point->where(array('examiner_user_id'=>$temp['examiner_user_id'], 'appraisal_manager_id'=>$temp['appraisal_manager_id'], 'score_id'=>$temp['score_id']))->save($temp);
				}
				if(1){
                    if($appraisal_manager['status'] == 1){
                        $data['appraisal_manager_id'] = $appraisal_manager['appraisal_manager_id'];
                        $data['status'] = 5;
                        $d_appraisal_manager->editAppraisalManager($data);
                    }
                    if($appraisal_manager['status'] == 3){
                        $data['appraisal_manager_id'] = $appraisal_manager['appraisal_manager_id'];
                        $data['status'] = 6;
                        $d_appraisal_manager->editAppraisalManager($data);
                    }
                    alert('success', '评分结束，待确认后提交主管评价！', U('hrm/appraisalpoint/index'));
				}else{
					alert('error', '评分失败！', $_SERVER['HTTP_REFERER']);
				}
			}else{
				$appraisal_manager = $d_appraisal_manager->getAppraisalManagerById($appraisal_manager_id);
				$have_point_user = $d_appraisal_point->havePoint(session('user_id'), $appraisal_manager_id);
				if(sizeOf($have_point_user) == sizeOf($appraisal_manager['examinee_user'])){
					alert('error', '您已为该考核表打过分！', U('hrm/appraisalpoint/index'));
				}
                $point_detail = $d_appraisal_point->getPointByIdAndIsPoint($appraisal_manager_id, 1);
                $this->pointdetail = $point_detail;
				$this->have_point_user = $have_point_user;
				$this->appraisalmanager = $appraisal_manager;
			}
		}else{
			alert('error', '参数错误！', U('hrm/appraisalpoint/index'));
		}
		$this->alert = parseAlert();
		$this->display();
	}
	
	//成绩
	public function results(){
		$appraisal_manager_id = intval($_GET['id']);
		if(!empty($appraisal_manager_id)){
			$d_appraisal_manager = D('AppraisalManager');
			$d_appraisal_point = D('AppraisalPoint');
			$appraisal_manager = $d_appraisal_manager->getAppraisalManagerById($appraisal_manager_id);
			foreach($appraisal_manager['examinee_user'] as $key=>$val){
				$appraisal_manager['examinee_user'][$key]['sum_point'] = $d_appraisal_point->getSumPoint($val['user_id'], $appraisal_manager_id);
			}
			$this->appraisal = $appraisal_manager;
		}else{
			alert('error','参数错误！', $_SERVER['HTTP_REFERER']);
		}
		$this->alert = parseAlert();
		$this->display();
	}
	
	//详细成绩
	public function detailResults(){
		$examinee_user_id = $_GET['uid'];
		$appraisal_manager_id = $_GET['id'];
		$d_appraisal_manager = D('AppraisalManager');
		$d_appraisal_point = D('AppraisalPoint');
		$appraisal_manager = $d_appraisal_manager->getAppraisalManagerById($appraisal_manager_id);
		$preSocreAvgPoint = $d_appraisal_point->getPreSocreAvgPoint($examinee_user_id, $appraisal_manager_id);
		$this->appraisalmanager = $appraisal_manager;
		$this->preSocreAvgPoint = $preSocreAvgPoint;
		$this->display();
	}

    public function view(){
        $appraisal_manager_id = intval($_GET['appraisal_manager_id']);
        $d_appraisal_manager = D('AppraisalManager');
        $d_appraisal_point = D('AppraisalPoint');
        $appraisal_manager = $d_appraisal_manager->getAppraisalManId($appraisal_manager_id);
        $appraisal_score = $d_appraisal_point->getScoreByTemId($appraisal_manager['appraisal_template_id']);
        $d_userview = D('UserView');
        $examinee_user = $d_userview->where(array('user_id'=>explode(',',$appraisal_manager['examiner_user_id'])[0]))->find();
        $examiner_user = $d_userview->where(array('user_id'=>explode(',',$appraisal_manager['examiner_user_id'])[1]))->find();
        $examiner_point = [];
        foreach($appraisal_score as $key=>$val){
            $appraisal_score[$key]['examineePoint'] = $d_appraisal_point->getPointByThreeOptions($appraisal_manager['appraisal_manager_id'], $val['score_id'], explode(',',$appraisal_manager['examiner_user_id'])[0]);
            $appraisal_score[$key]['examinerPoint'] = $d_appraisal_point->getPointByThreeOptions($appraisal_manager['appraisal_manager_id'], $val['score_id'], explode(',',$appraisal_manager['examiner_user_id'])[1]);
//            echo $appraisal_score[$key]['examinerPoint'][0]['kpi_detail'];
//            echo $appraisal_score[$key]['examineePoint'][0]['kpi_detail'];
            array_push($examiner_point, $appraisal_score[$key]['examinerPoint'][0]['point']);
        }
        $sum_point = 0;
        for($i=0; $i<sizeof($examiner_point); $i++){
            $sum_point += $examiner_point[$i];
        }
        $this->result_avg = number_format($sum_point/sizeof($examiner_point),1);
        $this->examinee_user = $examinee_user;
        $this->examiner_user = $examiner_user;
        $this->appraisal_manager = $appraisal_manager;
        $this->appraisal_score = $appraisal_score;
        $this->display();
    }

    public function confirm(){
        $appraisal_manager_id = intval($_GET['id']);
        $d_appraisal_manager = D('AppraisalManager');
        $d_appraisal_point = D('AppraisalPoint');
        $temp_appraisal_manager = $d_appraisal_manager->getAppraisalManId($appraisal_manager_id);
        if($temp_appraisal_manager['status'] == 5){
            //修改考核状态为主管评分状态
            $data['appraisal_manager_id'] = $appraisal_manager_id;
            $data['status'] = 3;
            $d_appraisal_manager->editAppraisalManager($data);
            //修改对应的is_point为已评分状态
            $temp['is_point'] = 1;
            $temp['examiner_user_id'] = session('user_id');
            $temp['appraisal_manager_id'] = $appraisal_manager_id;
            $d_appraisal_point->where(array('examiner_user_id'=>$temp['examiner_user_id'], 'appraisal_manager_id'=>$temp['appraisal_manager_id']))->save($temp);
            alert('success', '确认成功！', U('hrm/appraisalmanager/index'));
        }elseif($temp_appraisal_manager['status'] == 6){
            $data['appraisal_manager_id'] = $appraisal_manager_id;
            $data['status'] = 4;
            $d_appraisal_manager->editAppraisalManager($data);
            //修改对应的is_point为已评分状态
            $temp['is_point'] = 1;
            $temp['appraisal_manager_id'] = $appraisal_manager_id;
            $d_appraisal_point->where(array('appraisal_manager_id'=>$temp['appraisal_manager_id']))->save($temp);
            alert('success', '确认成功，进入待汇总状态！', U('hrm/appraisalmanager/index'));
        }
    }

    public function editPoint(){
        $appraisal_manager_id = $_REQUEST['id'];
        if(!empty($appraisal_manager_id)){
            $d_appraisal_manager = D('AppraisalManager');
            $d_appraisal_point = D('AppraisalPoint');

            if($this->isPost()){
                $appraisal_manager = $d_appraisal_manager->getAppraisalManagerById($appraisal_manager_id);
                foreach($appraisal_manager['template']['score'] as $val){
                    $temp['appraisal_manager_id'] = $appraisal_manager_id;
                    $temp['point'] = $_POST['point'][$val['score_id']];
                    $temp['comment'] = $_POST['comment'][$val['score_id']];
                    $temp['examinee_user_id'] = $_POST['examinee_user_id'];
                    $temp['examiner_user_id'] = session('user_id');
                    $temp['score_id'] = $val['score_id'];
                    $temp['is_point'] = 0;
                    if(!is_numeric($temp['point']) || $temp['point'] > $val['high_scope']){
                        alert('error', "【 ".$val['name']." 】".'份数格式不正确！', $_SERVER['HTTP_REFERER']);
                    }
                    $d_appraisal_point->where(array('examiner_user_id'=>$temp['examiner_user_id'], 'appraisal_manager_id'=>$temp['appraisal_manager_id'], 'score_id'=>$temp['score_id']))->save($temp);
                }
                alert('success', '编辑成功！', U('hrm/appraisalpoint/index'));
            }else{
                $appraisal_manager = $d_appraisal_manager->getAppraisalManagerById($appraisal_manager_id);
                $have_point_user = $d_appraisal_point->havePoint(session('user_id'), $appraisal_manager_id);
                if(sizeOf($have_point_user) == sizeOf($appraisal_manager['examinee_user'])){
                    alert('error', '您已为该考核表打过分！', U('hrm/appraisalpoint/index'));
                }
                $point_detail = $d_appraisal_point->getPointByIdAndIsPoint($appraisal_manager_id, 1);
                $this->pointdetail = $point_detail;
                $this->have_point_user = $have_point_user;
                $this->appraisalmanager = $appraisal_manager;
            }
        }else{
            alert('error', '参数错误！', U('hrm/appraisalpoint/index'));
        }
        $this->alert = parseAlert();
        $this->display();
    }
}