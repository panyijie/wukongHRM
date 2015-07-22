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
		<div class="row-table-title">请假条详情</div>
		<div class="row-table-body">
			<form class="form-horizontal " action="<?php echo U('hrm/leave/add');?>" method="post">
				<p class="form-title">
					请假条详情&nbsp;&nbsp;<a href="<?php echo U('hrm/leave/edit','id='.$leave[leave_id]);?>">编辑</a>
					&nbsp;&nbsp;<a href="javascript:history.go(-1);">返回</a>
					<a href="javascript:void(0);" id="leave_pass" class="pull-right btn btn-primary btn-xs" >已通过</a>
					<a href="javascript:void(0);" id="leave_fail" class="pull-right btn btn-primary btn-xs" >未通过</a>
				</p>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">请假人</label>
					<div class="col-sm-3"><?php echo ($leave["user_name"]); ?></div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">类型</label>
					<div class="col-sm-3"><?php echo ($leave["category_name"]); ?></div>
					<label for="name" class="col-sm-2 control-label">状态</label>
					<div class="col-sm-3">
						<?php if('0' == $leave['status']): ?><span style="color:#F8971C"><?php echo ($leave["status_name"]); ?></span>
						<?php elseif('1' == $leave['status']): ?>
							<span style="color:#0EB930"><?php echo ($leave["status_name"]); ?></span>
						<?php else: ?>
							<span style="color:#FF3908;"><?php echo ($leave["status_name"]); ?></span><?php endif; ?>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">开始时间</label>
					<div class="col-sm-3"><?php echo (date('Y-m-d H:i:s',$leave["start_time"])); ?></div>
					<label for="name" class="col-sm-2 control-label">结束时间</label>
					<div class="col-sm-3"><?php echo (date('Y-m-d H:i:s',$leave["end_time"])); ?></div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">计算结果</label>
					<div class="col-sm-3">
						共<span><?php echo ($leave["leave_days"]); ?></span>天<span><?php echo ($leave["leave_hours"]); ?></span>小时
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
						<pre style="min-height:150px;"><?php echo ($leave["content"]); ?></pre>
					</div>
				</div>
			</form>	
		</div>
	</div>
</div>
<div class="clear"></div>
<script>
	/**
	 * 通过审核
	 **/
	$('#leave_pass').click(function(){
		if(confirm('确定要审核通过吗？')){
			location.href="<?php echo U('hrm/leave/auditing','id='.$leave['leave_id'].'&status=1');?>";
		}
	});
	
	/**
	 * 未通过审核
	 **/
	$('#leave_fail').click(function(){
		if(confirm('确定要未通审核过吗？')){
			location.href="<?php echo U('hrm/leave/auditing','id='.$leave['leave_id'].'&status=2');?>";
		}
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