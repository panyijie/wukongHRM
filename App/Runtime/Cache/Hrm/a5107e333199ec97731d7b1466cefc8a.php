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
		<div class="row-table-title">员工档案列表</div>
		<div class="row-table-body">
			<p class="form-title">
				<a class="pull-right btn btn-primary btn-xs" href="<?php echo U('hrm/archives/add');?>">添加档案</a>员工档案列表
			</p>
			<table class="table" style="margin-bottom:0px;">
				<form action="<?php echo U('hrm/archives/delete');?>" method="post">
				<tbody>
					<tr>
						<th><input type="checkbox" id="check_all"/></th>
						<th>档案编号</th>
						<th>姓名</th>
						<th>性别</th>
						<th>出生日期</th>
						<th>婚姻状态</th>
						<th>工作年限</th>
						<th>操作</th>
					</tr>
					<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td><input type="checkbox" name="user_id[]" value="<?php echo ($vo["user_id"]); ?>" class="check_list"></td>
						<td><?php echo ($vo["archives_num"]); ?></td>
						<td><a href="<?php echo U('hrm/archives/view','user_id='.$vo['user_id']);?>"><?php echo ($vo["username"]); ?></a></td>
						<td><?php if($vo['sex'] == 1): ?>男<?php elseif($vo['sex'] == 2): ?>女<?php else: ?>未知<?php endif; ?></td>
						<td><?php echo (date("Y-m-d",$vo["birthday"])); ?></td>
						<td><?php if($vo['marital_status'] == 1): ?>已婚<?php elseif($vo['marital_status'] == 2): ?>未婚<?php else: ?>未知<?php endif; ?></td>
						<td><?php echo ($vo["length_work"]); ?></td>
						<td>
							<a href="<?php echo U('hrm/archives/edit','user_id='.$vo['user_id']);?>">编辑</a>&nbsp;|&nbsp;
							<a href="<?php echo U('hrm/archives/delete','user_id='.$vo['user_id']);?>">删除</a>
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
				<tfoot>
					<tr>
						<td><input type="submit" value="删除" class="btn btn-primary btn-xs"></td>
						<td colspan="7"><?php echo ($page); ?><div class="clear"></div></td>
					</tr>
				</tfoot>
				</form>
			</table>
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
$(function(){
	$("#check_all").click(function(){
		$("input[class='check_list']").prop('checked',$(this).prop('checked'));
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