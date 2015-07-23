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
<script charset="utf-8" src="__PUBLIC__/js/editor/kindeditor.js"></script>
<script charset="utf-8" src="__PUBLIC__/js/editor/lang/zh_CN.js"></script>
<script charset="utf-8" src="__PUBLIC__/js/jscolor/jscolor.js"></script>
<script>
	KindEditor.ready(function(K) {
			window.editor = K.create('#content', {
			uploadJson:"<?php echo U('core/file/editor');?>"
		});
	});
</script>
<div class="body-right">
	<div class="row-table">
		<div class="row-table-title">发布公告</div>
		<div class="row-table-body">
			<form class="form-horizontal " action="<?php echo U('core/announcement/add');?>" method="post">
				<p class="form-title">发布公告 &nbsp;&nbsp;<a href="javascript:history.go(-1);">返回</a></p>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">公告标题</label>
					<div class="col-sm-3">
						<input class="form-control color" type="text" name="title">
						<input type="hidden" name="color"  id="colorpad" value="000000"/>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">状态</label>
					<div class="col-sm-3">
						<input type="radio" name="status" value="1" checked="checked" />发布 &nbsp;&nbsp;
						<input type="radio" name="status" value="2"/>停用 &nbsp;&nbsp;
					</div>
					<label for="name" class="col-sm-2 control-label">顶置</label>
					<div class="col-sm-3">
						<input type="radio" name="set_top" value="0" checked="checked" />否 &nbsp;&nbsp;
						<input type="radio" name="set_top" value="1"/>是 &nbsp;&nbsp;
					</div>
				</div>		
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">通知部门</label>
					<div class="col-sm-8">
						<?php if(is_array($department_list)): $i = 0; $__LIST__ = $department_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="checkbox" name="department_id[]" checked="checked" value="<?php echo ($vo["department_id"]); ?>"/>&nbsp;<?php echo ($vo["name"]); ?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">公告内容</label>
					<div class="col-sm-8">
						<textarea id="content" name="content" style="width:800px;height:300px;"></textarea>
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