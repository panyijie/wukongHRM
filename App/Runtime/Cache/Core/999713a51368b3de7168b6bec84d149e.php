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
<div class="body-right">
	<div class="row-table">
		<div class="row-table-title">系统设置</div>
		<div class="row-table-body">
			<form class="form-horizontal " enctype="multipart/form-data" action="<?php echo U('core/setting/defaultinfo');?>" method="post">
				<p class="form-title">系统基本设置</p>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">系统名称</label>
					<div class="col-sm-3">
						<input class="form-control" id="name" type="text" value="<?php echo ($defaultinfo['name']); ?>" name="name">
					</div>
				</div>
				<div class="form-group">
					<label for="description" class="col-sm-2 control-label">系统描述</label>
					<div class="col-sm-3">
						<input class="form-control" id="description" type="text" value="<?php echo ($defaultinfo['description']); ?>" name="description">
					</div>
				</div>
				<div class="form-group">
					<label for="logo" class="col-sm-2 control-label">系统Logo</label>
					<div class="col-sm-3">
						<input type="file" id="logo" name="logo">(建议尺寸：200*50)<img style="height:50px;" src="<?php echo ($defaultinfo['logo']); ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="allow_file_type" class="col-sm-2 control-label">允许上传文件类型</label>
					<div class="col-sm-3">
						<input class="form-control" id="allow_file_type" type="text" value="<?php echo ($defaultinfo['allow_file_type']); ?>" name="allow_file_type"><span style="color:red;">* 类型间用逗号隔开,如：pdf,xls,doc,txt,jpg </span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-3">
						<input class="btn btn-primary" type="submit" value="保存"/>
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