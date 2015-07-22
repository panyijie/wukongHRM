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
		<div class="row-table-title">合同状态</div>
		<div class="row-table-body">
			<form class="form-horizontal " enctype="multipart/form-data" action="<?php echo U('core/setting/contractstatus');?>" method="post">
				<p class="form-title">合同状态设置&nbsp;&nbsp;<a href="javascript:history.go(-1);">返回</a></p>
				<div id="type_box">
					<?php if(is_array($contractstatus)): $i = 0; $__LIST__ = $contractstatus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="form-group">
						<label for="name" class="col-sm-2 control-label">名称<?php echo ($key); ?></label>
						<div class="col-sm-3">
							<input class="form-control" id="name" type="text" value="<?php echo ($vo); ?>" name="name[<?php echo ($key); ?>]">
						</div>
						<?php if($key > 3): ?><input type="button" class="btn btn-xs deletecontractstatus" value="[删除]" /><?php endif; ?>
					</div><?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-3">
						<input type="button" class="btn btn-primary" id="addcontractstatus" value="添加" />&nbsp;&nbsp;&nbsp;&nbsp;
						<input class="btn btn-primary" type="submit" value="保存"/>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
$(function(){
	$('#addcontractstatus').click(function(){
		var num = $('#type_box').children().length + 1;
		var str = '<div class="form-group"><label for="name" class="col-sm-2 control-label">名称'+num+'</label><div class="col-sm-3"><input class="form-control" id="name" type="text" value="" name="name['+num+']"></div>';
		if(num > 3){
			str+='<input type="button" class="btn btn-xs deletecontractstatus" value="[删除]" />';
		}
		str+='</div>';
		$('#type_box').append(str);
	});
	$('#type_box').on('click','.deletecontractstatus',function(){
		$(this).parent().remove();
	});
})
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