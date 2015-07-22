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
		<div class="row-table-title">通讯录</div>
		<div class="row-table-body">
			<p class="form-title">
				<?php if($type==1): ?><a href="<?php echo U('core/message/addcontacts');?>" class="pull-right btn btn-primary btn-xs">添加</a><?php endif; ?>
				<?php if($type==0): ?>公共通讯录<?php else: ?><a href="<?php echo U('core/message/contacts');?>">公共通讯录</a><?php endif; ?>&nbsp;&nbsp;
				<?php if($type==1): ?>个人通讯录<?php else: ?><a href="<?php echo U('core/message/contacts','type=1');?>">个人通讯录</a><?php endif; ?>
			</p>
			<table class="table" style="margin-bottom:0px;">
				<?php if($type==1): ?><form action="<?php echo U('core/message/deletecontacts');?>" method="post"><?php endif; ?>
				<tbody>
					<tr>
						<?php if($type==1): ?><th><input type="checkbox" id="check_all"/></th><?php endif; ?>
						<th>姓名</th>
						<th>性别</th>
						<?php if($type==0): ?><th>部门 - 岗位</th>
						<th>员工状态</th>
						<th>员工类型</th>
						<th>工作状态</th><?php endif; ?>
						<th>手机</th>
						<th>Email</th>
						<th>联系地址</th>
						<?php if($type==1): ?><th>备注</th><?php endif; ?>
						<th>操作</th>
					</tr>
					<?php if(is_array($userlist)): $i = 0; $__LIST__ = $userlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<?php if($type==1): ?><td><input type="checkbox" name="mycontacts_id[]" value="<?php echo ($vo["mycontacts_id"]); ?>" class="check_list"></td><?php endif; ?>
						<td><?php echo ($vo["name"]); ?></td>
						<td><?php if($vo['sex'] == 1): ?>男<?php elseif($vo['sex'] == 2): ?>女<?php else: ?>未知<?php endif; ?></td>
						<?php if($type==0): ?><td><?php echo ($vo["department_name"]); ?> - <?php echo ($vo["position_name"]); ?></td>
						<td><?php if($vo['status'] == 0): ?>未激活<?php elseif($vo['sex'] == 1): ?>在职<?php elseif($vo['sex'] == 2): ?>离职<?php else: ?>退休<?php endif; ?></td>
						<td><?php if($vo['type'] == 0): ?>试用期<?php elseif($vo['sex'] == 1): ?>正式工<?php elseif($vo['sex'] == 2): ?>临时工<?php else: ?>其他<?php endif; ?></td>
						<td><?php if($vo['type'] == 0): ?>正常<?php elseif($vo['sex'] == 1): ?>休假<?php elseif($vo['sex'] == 2): ?>出差<?php else: ?>其他<?php endif; ?></td><?php endif; ?>
						<td><?php echo ($vo["telephone"]); ?></td>
						<td><?php echo ($vo["email"]); ?></td>
						<td><?php echo ($vo["address"]); ?></td>
						<?php if($type==1): ?><td><?php echo ($vo["description"]); ?></td><?php endif; ?>
						<td>
							<?php if($type==1): ?><a href="<?php echo U('core/message/editcontacts','id='.$vo['mycontacts_id']);?>">编辑</a>&nbsp;&nbsp;
							<a href="<?php echo U('core/message/deletecontacts','id='.$vo['mycontacts_id']);?>">删除</a>
							<?php else: ?>
							<a href="<?php echo U('core/message/send','user_id='.$vo['user_id']);?>">发送站内信</a><?php endif; ?>
							</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
				<tfoot>
					<tr>
						<?php if($type==1): ?><td><input type="submit" value="删除" class="btn btn-primary btn-xs"></td>
						<td colspan="7"><?php echo ($page); ?><div class="clear"></div></td>
						<?php else: ?>
						<td colspan="10"><?php echo ($page); ?><div class="clear"></div></td><?php endif; ?>
						
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