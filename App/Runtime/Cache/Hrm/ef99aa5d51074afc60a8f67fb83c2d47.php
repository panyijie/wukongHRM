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
<link rel="stylesheet" href="__PUBLIC__/css/treeview/jquery.treeview.css" type="text/css">
<script type="text/javascript" src="__PUBLIC__/js/treeview/jquery.treeview.js"></script>
<script type="text/javascript" src="__PUBLIC__/js/treeview/jquery.treeview.edit.js"></script>
<script type="text/javascript">
	$(function() {
		$("#browser").treeview();
	})
</script>

<style type="text/css">
.ztree li span.button.add {margin-left:2px; margin-right: -1px; background-position:-144px 0; vertical-align:top; *vertical-align:middle}
</style>
<?php echo W('Navigation');?>
<div class="body-right">
	<div class="row-table">
		<div class="row-table-title">组织架构</div>
		<div class="row-table-body">
			<p class="form-title">
				<a class="pull-right btn btn-primary btn-xs" href="<?php echo U('hrm/structure/addposition');?>" style="margin-left:10px">添加岗位</a>
				<a class="pull-right btn btn-primary btn-xs" href="<?php echo U('hrm/structure/adddepartment');?>">添加部门</a>
				<a href="<?php echo U('hrm/structure/department');?>" >部门岗位图</a> | 
				上下级关系图
			</p>
			<p class="navbar-text"><?php echo ($tree_code); ?></p>
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
	$(function(){
		$(".treeview .file").hover(function(){
			rel = $(this).attr('rel');
			$('#control_file' + rel).show();
		},function(){
			rel = $(this).attr('rel');
			$('#control_file' + rel).hide();
		});
		$(".treeview .folder").hover(function(){
			rel = $(this).attr('rel');
			$('#control_folder' + rel).show();
		},function(){
			rel = $(this).attr('rel');
			$('#control_folder' + rel).hide();
		});
		$(".position_delete").click(function(){
			if(confirm("确定删除该岗位吗?")){
				id = $(this).attr('rel');
				window.location="<?php echo U('hrm/structure/deletePosition','id=');?>"+id;
			}
		});
		$('.control_edit').click(function(){
			position_id = $(this).attr('rel');
			$('#alert').modal({
			show:true,
			remote:'<?php echo U("core/user/editControl","id=");?>'+position_id
			});
		});
		$('.position_edit').click(function(){
			position_id = $(this).attr('rel');
			$('#alert').modal({
			show:true,
			remote:'<?php echo U("hrm/structure/editPosition","id=");?>'+position_id
			});
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