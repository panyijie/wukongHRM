<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<title><?php echo C('defaultinfo.name');?> - Powered By 悟空HRM</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="description" content=""/>
		<meta name="author" content="悟空HRM"/>
		<link rel="shortcut icon" href="__PUBLIC__/ico/favicon.png"/>
		<link rel="stylesheet" href="__PUBLIC__/css/bootstrap.css">
		<link rel="stylesheet" href="__PUBLIC__/css/hrms.css">
		<script src="__PUBLIC__/js/jquery.min.js"></script>
		<script src="__PUBLIC__/js/bootstrap.min.js"></script>
		<script src="__PUBLIC__/js/nongli.js"></script>
		<script src="__PUBLIC__/js/calendar.js"></script>
		<!--[if lt IE 9]>
		<script src="__PUBLIC__/js/html5shiv.min.js"></script>
		<script src="__PUBLIC__/js/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
<?php echo W('Navigation');?>
<script src="__PUBLIC__/js/datepicker/WdatePicker.js"></script>
<div class="body-right">
	<div class="row-table">
		<div class="row-table-title">编辑请假条</div>
		<div class="row-table-body">
			<form class="form-horizontal " action="<?php echo U('hrm/leave/edit');?>" method="post">
				<input type="hidden" name="id" value="<?php echo ($leave["leave_id"]); ?>"/>
				<p class="form-title">编辑请假条&nbsp;&nbsp;<a href="javascript:history.go(-1);">返回</a></p>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">请假人</label>
					<div class="col-sm-3">
						<input type="hidden" name="user_id" id="str_user_id" value="<?php echo ($leave["user_id"]); ?>" />
						<input class="form-control" type="text" name="user_name" id="str_user_name" readonly="true" value="<?php echo ($leave["user_name"]); ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">类型</label>
					<div class="col-sm-3">
						<select class="form-control" name="leave_category_id">
							<option value="1" <?php if('1' == $leave['leave_category_id']): ?>selected="selected"<?php endif; ?>>事假</option>
							<option value="2" <?php if('2' == $leave['leave_category_id']): ?>selected="selected"<?php endif; ?>>病假</option>
							<option value="3" <?php if('3' == $leave['leave_category_id']): ?>selected="selected"<?php endif; ?>>出差</option>
							<option value="4" <?php if('4' == $leave['leave_category_id']): ?>selected="selected"<?php endif; ?>>婚假</option>
							<option value="5" <?php if('5' == $leave['leave_category_id']): ?>selected="selected"<?php endif; ?>>产假</option>
							<option value="6" <?php if('6' == $leave['leave_category_id']): ?>selected="selected"<?php endif; ?>>年假</option>
							<option value="7" <?php if('7' == $leave['leave_category_id']): ?>selected="selected"<?php endif; ?>>丧假</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">开始时间</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="start_time" id="d4311" onFocus="WdatePicker({maxDate:$('#d4312').val(),minDate:'%y-%M-%d %H:%m:%s', dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo (date('Y-m-d H:i:s',$leave["start_time"])); ?>"/>
					</div>
					<label for="name" class="col-sm-2 control-label">结束时间</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="end_time" id="d4312" onFocus="WdatePicker({minDate:$('#d4311').val(),maxDate:'2020-10-01',dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo (date('Y-m-d H:i:s',$leave["end_time"])); ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">计算结果</label>
					<div class="col-sm-3">
						共<span>0</span>天<span>8</span>小时
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">填写人</label>
					<div class="col-sm-3">
						<?php echo ($leave["maker_user_name"]); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">请假原因</label>
					<div class="col-sm-8">
						<textarea name="content" class="col-sm-6 form-control" style="min-height:150px;"><?php echo ($leave["content"]); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-3">
						<input name="submit" class="btn btn-primary" type="submit" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="button" class="btn" value="取消" onclick="javascript:history.go(-1);"/>
					</div>
				</div>
			</form>	
		</div>
	</div>
</div>
<div class="clear"></div>
<script>
	/**
	 * 选择员工
	 **/
	$('#str_user_name').click(function(){
		$('#alert').modal({
			show:true,
			remote:'<?php echo U("core/user/getSubUserCBDialog","self=1");?>'
		});
	});
</script>
<div class="modal fade" id="alert" tabindex="-1" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">提示信息</h4>
			</div>
			<div class="modal-body">
			<?php if(is_array($alert)): foreach($alert as $k=>$v): if(is_array($v)): foreach($v as $kk=>$vv): ?><div class="alert alert-<?php echo ($k); ?>">
					<?php echo ($vv); ?>
				</div><?php endforeach; endif; endforeach; endif; ?>
			</div>
		</div>
	</div>
</div>
<?php if(!empty($alert)): ?><script type="text/javascript">
	$('#alert').modal('show');
	var alert_n = setInterval('$("#alert").modal("hide")',1000);
	$('#alert').on('hide.bs.modal', function (e) {
		clearInterval(alert_n);
	});
</script><?php endif; ?>
		<!-- <div id="footer">
			<div class="container">
				<p class="text-muted credit">
					悟空HRM © 2013 <a href="http://www.ccds24.com" target="_blank">河南锐骑文化传播有限公司</a>版权所有
				</p>
			</div>
		</div> -->
	</body>
</html>