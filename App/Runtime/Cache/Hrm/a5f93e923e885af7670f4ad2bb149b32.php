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
		<div class="row-table-title">培训项目</div>
		<div class="row-table-body">
			<p class="form-title"><a class="pull-right btn btn-primary btn-xs" href='<?php echo U("hrm/train/addtrainpro");?>'>新建项目</a>项目列表</p>
			<table class="table" style="margin-bottom:0px;">
				<form action="<?php echo U('hrm/train/deletetrainpro');?>" method="post">
				<tbody>
					<tr>
						<th><input type="checkbox" id="check_all"/></th>
						<th>项目名称</th>
						<th>培训类型</th>
						<th>主办单位</th>
						<th>负责人</th>
						<th>培训地点</th>
						<th>培训机构</th>
						<th>开始时间</th>
						<th>结束时间</th>
						<th>培训天数</th>
						<th>培训预算</th>
						<th>状态</th>
						<th>操作</th>
					</tr>
					<?php if(is_array($trainprolist)): $i = 0; $__LIST__ = $trainprolist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td><input type="checkbox" name="train_pro_id[]" value="<?php echo ($vo["train_pro_id"]); ?>" class="check_list"></td>
						<td><a href="<?php echo U('hrm/train/viewtrainpro','id='.$vo['train_pro_id']);?>"><?php echo ($vo["name"]); ?></a></td>
						<td><?php if($vo["train_type"] == 1): ?>职业技能<?php elseif($vo["train_type"] == 2): ?>职业素养<?php elseif($vo["train_type"] == 3): ?>业务知识<?php elseif($vo["train_type"] == 4): ?>岗位技能<?php endif; ?></td>
						<td><?php echo ($vo["organizers"]); ?></td>
						<td><?php echo ($vo["username"]); ?></td>
						<td><?php echo ($vo["address"]); ?></td>
						<td><?php echo ($vo["org"]); ?></td>
						<td><?php echo (date('Y-m-d',$vo["start_time"])); ?></td>
						<td><?php echo (date('Y-m-d',$vo["end_time"])); ?></td>
						<td><?php echo ($vo["day"]); ?></td>
						<td><?php echo ($vo["money"]); ?></td>
						<td><?php if($vo["train_status"] == 1): ?>未开始<?php elseif($vo["train_status"] == 2): ?>进行中<?php endif; ?></td>
						<td><a href="<?php echo U('hrm/train/edittrainpro','id='.$vo['train_pro_id']);?>">编辑</a>&nbsp;|&nbsp;<a href="<?php echo U('hrm/train/deletetrainpro','id='.$vo['train_pro_id']);?>">删除</a></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
				<tfoot>
					<tr>
						<td><input type="submit" value="删除" class="btn btn-primary btn-xs"></td>
						<td colspan="12"><?php echo ($page); ?><div class="clear"></div></td>
					</tr>
				</tfoot>
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