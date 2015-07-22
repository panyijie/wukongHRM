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
		<div class="row-table-title">添加班次</div>
		<div class="row-table-body">
			<form class="form-horizontal " action="<?php echo U('hrm/workingshift/add');?>" method="post">
				<p class="form-title">添加班次&nbsp;&nbsp;<a href="javascript:history.go(-1);">返回</a></p>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">班次名称</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="name" />
					</div>
					<label for="name" class="col-sm-2 control-label">类型</label>
					<div class="col-sm-3">
						<select class="form-control" name="type">
							<option value="0" selected="selected">标准工作制</option>
							<option value="1">周期工作制</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">开始时间</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="start_time" onclick="WdatePicker({dateFmt:'HH:mm'})" />
					</div>
					<label for="name" class="col-sm-2 control-label">结束时间</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="end_time" onclick="WdatePicker({dateFmt:'HH:mm'})" />
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">工作日</label>
					<div class="col-sm-8">
						<input type="checkbox" name="working_days[]" value="1" checked="checked" />&nbsp;周一&nbsp;&nbsp;
						<input type="checkbox" name="working_days[]" value="2" checked="checked"/>&nbsp;周二&nbsp;&nbsp;
						<input type="checkbox" name="working_days[]" value="3" checked="checked"/>&nbsp;周三&nbsp;&nbsp;
						<input type="checkbox" name="working_days[]" value="4" checked="checked"/>&nbsp;周四&nbsp;&nbsp;
						<input type="checkbox" name="working_days[]" value="5" checked="checked"/>&nbsp;周五&nbsp;&nbsp;
						<input type="checkbox" name="working_days[]" value="6" />&nbsp;周六&nbsp;&nbsp;
						<input type="checkbox" name="working_days[]" value="7" />&nbsp;周日
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">描述</label>
					<div class="col-sm-5">
						<textarea name="description" class="form-control" style="min-height:100px;"></textarea>
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