<?php
/**
 *
 * 请假 模型
 * author：悟空HR
 **/
class LeaveModel extends Model{
	/**
	 * 获取分页请假数据
	 **/
	public function getLeave($p, $where){
		if(!empty($where['user_name'])){
			$user_id = M('user')->where(array('name'=>array('eq', $where['user_name'])))->getField('user_id');
			$where['user_id'] = array('like', '%'.$user_id.'%');
			unset($where['user_name']);
		}
		import('@.ORG.Page');
		$count = $this->where($where)->count();
		$Page = new Page($count,15);
		$show  = $Page->show();
		$leavelist = $this->where($where)->order('create_time desc')->page($p.',15')->select();
		$d_user = D('User');
		$d_leave_category = D('LeaveCategory');
		foreach($leavelist as $key=>$val){
			$str_user_name = '';

			//请假人
			$userArr = array_filter(explode(',',$val['user_id']));
			foreach($userArr as $v){
				$user = $d_user->getUserInfo(array('user_id'=>$v));
				$str_user_name .= $user['name'];
			}
            $leavelist[$key]['user_id'] = $val['user_id'];
            $leavelist[$key]['user_name'] = $str_user_name;

            //委托人（expand）
            $user = $d_user->getUserInfo(array('user_id'=>$val['entrust_user_id']));
            $leavelist[$key]['entrust_user_name'] = $user['name'];

			//填写人
			$user = $d_user->getUserInfo(array('user_id'=>$val['maker_user_id']));
			$leavelist[$key]['maker_user_name'] = $user['name'];
            $leavelist[$key]['annual_leave'] = $user['annual_leave'];

			//请假类型
			$leavelist[$key]['category_name'] = $d_leave_category->where(array('leave_category_id'=>$val['leave_category_id']))->getField('name');
			$leavelist[$key]['category_id'] = $val['leave_category_id'];
			//审核
			if(0 == $val['status']){
				$leavelist[$key]['status_name'] = '处理中';
			}elseif(1 == $val['status']){
				$leavelist[$key]['status_name'] = '已通过';
			}else{
				$leavelist[$key]['status_name'] = '未通过';
			}
			//天数
			$leavelist[$key]['leave_days'] = $val['leave_days'];
            $leavelist[$key]['start_time'] = date('Y-m-d H:i:s',$val['start_time']);
            $leavelist[$key]['end_time'] = date('Y-m-d H:i:s',$val['end_time']);
            $leavelist[$key]['start_time'] = (substr($leavelist[$key]['start_time'],11,8) == '06:00:00')?substr($leavelist[$key]['start_time'],0,11).'09:00:00':$leavelist[$key]['start_time'];
            $leavelist[$key]['end_time'] = (substr($leavelist[$key]['end_time'],11,8) == '06:00:00')?substr($leavelist[$key]['end_time'],0,11).'09:00:00':$leavelist[$key]['end_time'];

//			$leavelist[$key]['leave_hours'] = intval($timediff/3600);
			
		}
		return array('page'=>$show ,'leavelist'=>$leavelist);
	}
	
	/**
	 * 添加请假条
	 **/
	public function addLeave($data){
		if(!empty($data)){
			//返回数据
			if($this->create($data)){
				return $this->add($data);
			}else{
				return false;
			}
		}
	}
	
	/** 
	 * 根据leave_id获取请假记录
	 **/
	public function getLeaveById($leave_id){
		$leave = $this->where('leave_id = %d', $leave_id)->find();
		$d_user = D('User');
		$d_leave_category = D('LeaveCategory');
		$str_user_name = '';
		//请假人
		$userArr = array_filter(explode(',',$leave['user_id']));
		foreach($userArr as $v){
			$user = $d_user->getUserInfo(array('user_id'=>$v));
			$str_user_name .= $user['name'];
		}
		$leave['user_name'] = $str_user_name;
        //委托人
        $entrustUser = $d_user->getUserInfo(array('user_id'=>$leave['entrust_user_id']));
        $leave['entrust_user_name'] = $entrustUser['name'];
		//填写人
		$user = $d_user->getUserInfo(array('user_id'=>$leave['maker_user_id']));
		$leave['maker_user_name'] = $user['name'];
		//请假类型
		$leave['category_name'] = $d_leave_category->where(array('leave_category_id'=>$leave['leave_category_id']))->getField('name');
		//审核
		if(0 == $leave['status']){
			$leave['status_name'] = '处理中';
		}elseif(1 == $leave['status']){
			$leave['status_name'] = '已通过';
		}else{
			$leave['status_name'] = '未通过';
		}
//		$timediff = $leave['end_time'] - $leave['start_time'];
		return $leave;
	}
	
	/** 
	 * 编辑请假条
	 **/
	public function editLeave($data){
		//返回数据
		if($this->create($data) && $this->save()){
			return true;
		}else{
			return false;
		}
	}
	
	/** 
	 * 删除请假条
	 * 如果$leave_id为数组，则批量删除；否则删除一条记录
	 **/
	public function deleteLeave($leave_id){
		if (is_array($leave_id)) {
			$leave_idArr = implode(',', $leave_id);
			if ($this->where(array('leave_id'=>array('in',$leave_idArr)))->delete()) {
				return true;
			}
		} else {
			$leave_id = intval($leave_id);
			if ($this->where(array('leave_id'=>$leave_id))->delete()) {
				return true;
			}
		}
		return false;
	}
	
	/** 
	 * 审核
	 * 如果$data为数组，如果$data['user_id']为数组，则批量审核，否则审核一条记录
	 **/
	public function auditingLeave($data){
		if (is_array($data['leave_id'])) {
			$leave_idStr = implode(',', $data['leave_id']);
			if ($this->create($data)) {
				if($this->where(array('leave_id'=>array('in',$leave_idStr)))->save($data)){
					return true;
				}
			}
		} else {
			if ($this->where(array('leave_id'=>$data['leave_id']))->save($data)) {
				return true;
			}
		}
		return false;
	}
	
	/** 
	 * 根据$time获取某月所有请假信息
	 * 
	 **/
	public function getLeaveInfoByTime($time){
		$condition['status'] = 1;
		$data1['start_time'] = array('lt', $time -1 );
		$data1['end_time'] = array('gt', $time -1 );
		$next_year = date('Y',$time)+1;
		$next_month = date('m',$time)+1;
		$month_time = date('m',$time) ==12 ? strtotime($next_year.'-01-01') : strtotime(date('Y',$time).'-'.$next_month.'-01');
		$data['start_time'] = array('between',array($time -1 ,$month_time));
		$data['_logic'] = 'or';
		$data['_complex'] = $data1;
		$condition['_complex'] = $data;
		
		$leave = $this->where($condition)->order('create_time desc')->select();
		return $leave;
	}

}