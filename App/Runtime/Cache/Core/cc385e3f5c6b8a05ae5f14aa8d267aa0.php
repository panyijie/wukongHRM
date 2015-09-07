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
		<div class="row-table-title"><?php if($send == 0): ?>收件箱<?php else: ?><a href="<?php echo U('core/message/index');?>">收件箱</a><?php endif; ?>
				<?php if($send == 1): ?>发件箱<?php else: ?><a href="<?php echo U('core/message/index','send=1');?>">发件箱</a><?php endif; ?></div>
		<div class="row-table-body">
			<p class="form-title">
			<?php if($send == 1): ?>全部
			<?php else: ?>
				<a class="pull-right btn btn-primary btn-xs" href="<?php echo U('core/message/send');?>" style="margin-top: 7px">写信</a>
				<?php if($read == 1): ?>全部
					<a href="<?php echo U('core/message/index','read=0');?>">未读</a>
				<?php else: ?>
					<a href="<?php echo U('core/message/index');?>">全部</a>
					未读<?php endif; endif; ?>
			</p>
			<table class="table" style="margin-bottom:0px;">
				<form action="<?php echo U('core/message/delete');?>" method="post">
				<tbody>
					<tr>
						<th><input type="checkbox" id="check_all"/></th>
						<?php if($send == 1): ?><th>收件人</th>
						<?php else: ?>
						<th>发件人</th><?php endif; ?>
						<th>标题</th>
						<th>时间</th>
						<th>状态</th>
						<th>回复</th>
						</if>
						<th>操作</th>
					</tr>
					<?php if(is_array($messagelist)): $i = 0; $__LIST__ = $messagelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td><input type="checkbox" name="message_id[]" value="<?php echo ($vo["message_id"]); ?>" class="check_list"></td>
						<td><?php if($send == 1): echo ($vo["to_name"]); else: echo ($vo["name"]); endif; ?></td>
						<td><a href="<?php echo U('core/message/view','id='.$vo['message_id']);?>"><?php echo ($vo["title"]); ?></a></td>
						<td><?php echo (date('Y-m-d',$vo["send_time"])); ?></td>
						<td><?php if($vo['read_time'] == 0): ?>未读<?php else: ?>已读<?php endif; ?></td>
						<td><?php if($vo['status'] == 1 ): ?>已回复<?php elseif($send == 1): ?>未回复<?php else: ?><a href="<?php echo U('core/message/send','id='.$vo['message_id']);?>">回复</a><?php endif; ?></td>
						</if>
						<td><a href="<?php echo U('core/message/delete','id='.$vo['message_id']);?>">删除</a></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
				<tfoot>
					<tr>
						<td><input type="submit" value="删除" class="btn btn-primary btn-xs"></td>
						<td colspan="6"><?php echo ($page); ?><div class="clear"></div></td>
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