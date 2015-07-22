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
		<div class="row-table-title">菜单设置</div>
		<div class="row-table-body">
			<p class="form-title">菜单设置<a href="<?php echo U('core/navigation/add');?>" class="pull-right btn btn-primary btn-xs" >添加</a></p>
			<form class="form-horizontal " id="form1"  method="post">
			<table class="table">
				<?php if(empty($navigation)): ?><tr><td>---暂无数据---</td></tr>
				<?php else: ?>
				<tbody>
					<tr>
						<th width="5%"><input type="checkbox" name="check_all" id="check_all" /></th>
						<th width="10%">排序</th>
						<th width="30%">名称</th>
						<th width="30%">描述</th>
						<th width="10%">默认显示</th>
						<th width="10%">操作</th>
					</tr>
				<?php if(is_array($navigation)): $i = 0; $__LIST__ = $navigation;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td><input type="checkbox" name="id[]" class="check_list" value="<?php echo ($vo["navigation_id"]); ?>"/></td>
						<td><input type="text" name="sort[<?php echo ($vo["navigation_id"]); ?>]" value="<?php echo ($vo["sort_id"]); ?>" style="width:30px;text-align:center;"></td>
						<td><a href="<?php echo U('core/navigation/edit','id='.$vo['navigation_id']);?>"><?php echo ($vo["name"]); ?></a></td>
						<td><?php echo ($vo["description"]); ?></td>
						<td><a href="<?php echo U($vo['control']['g'].'/'.$vo['control']['m'].'/'.$vo['control']['a']);?>" target="blank"><?php echo ($vo["control"]["name"]); ?></a></td>
						<td>
							<a href="<?php echo U('core/navigation/edit','id='.$vo['navigation_id']);?>">编辑</a>&nbsp;|&nbsp;
							<a href="<?php echo U('core/navigation/delete','id='.$vo['navigation_id']);?>">删除</a>
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				<tfoot>
					<tr>
						<td><button class="btn btn-primary btn-xs"  id="delete">删除</button></td>
						<td><button class="btn btn-primary btn-xs"  id="sort">排序</button></td>
						<td colspan="4">&nbsp;</td>
					</tr>
				</tfoot><?php endif; ?>
				</tbody>
			</table>
			</form>
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
	/**
	 * 全选
	 **/
	$("#check_all").click(function(){
		$("input[class='check_list']").prop('checked',$(this).prop('checked'));
	});
	
	/**
	 * 批量删除
	 **/
	$("#delete").click(function(){
		if(confirm('确定要删除吗？')){
			$("#form1").attr("action","<?php echo U('core/navigation/delete');?>");
			$("#form1").submit();
		}
	});
	
	/**
	 *
	 * 排序
	 **/
	$("#sort").click(function(){
		$("#form1").attr("action","<?php echo U('core/navigation/sorts');?>");
		$("#form1").submit();
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