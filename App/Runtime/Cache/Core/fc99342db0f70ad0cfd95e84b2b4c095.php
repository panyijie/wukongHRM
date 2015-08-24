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
		<div class="row-table-title">员工列表</div>
		<div class="row-table-body">
			<p class="form-title">
				<a class="pull-right btn btn-primary btn-xs" href="<?php echo U('core/user/adduser');?>" style="margin-top: 7px">添加员工</a>
				<?php if(is_array($status_array)): $i = 0; $__LIST__ = $status_array;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($key == $status): echo ($vo); ?>&nbsp;&nbsp;&nbsp;<?php else: ?><a href='<?php echo U("core/user/index","status=$key");?>'><?php echo ($vo); ?></a>&nbsp;&nbsp;&nbsp;<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</p>
			<table class="table" style="margin-bottom:0px;">
				<tbody>
					<tr>
						<th>用户名</th>
						<th>性别</th>
						<th>部门 - 岗位</th>
						<th>员工状态</th>
						<th>员工类型</th>
						<th>手机</th>
						<th>Email</th>
						<th>操作</th>
					</tr>
					<?php if(is_array($userlist)): $i = 0; $__LIST__ = $userlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($vo["name"]); ?></td>
						<td><?php if($vo['sex'] == 1): ?>男<?php elseif($vo['sex'] == 2): ?>女<?php else: ?>未知<?php endif; ?></td>
						<td><?php echo ($vo["department_name"]); ?> - <?php echo ($vo["position_name"]); ?></td>
						<td><?php if($vo['status'] == 0): ?>未激活<?php elseif($vo['status'] == 1): ?>在职<?php elseif($vo['status'] == 2): ?>离职<?php else: ?>退休<?php endif; ?></td>
						<td><?php if($vo['type'] == 0): ?>试用期<?php elseif($vo['type'] == 1): ?>正式工<?php elseif($vo['type'] == 2): ?>实习生<?php else: ?>其他<?php endif; ?></td>
						<td><?php echo ($vo["telephone"]); ?></td>
						<td><?php echo ($vo["email"]); ?></td>
						<td>
							<a href="<?php echo U('core/user/editinfo','id='.$vo['user_id']);?>">编辑</a>
							<!--<a href="<?php echo U('hrm/staffcontract/index','user_id='.$vo['user_id']);?>">人事合同</a>&nbsp;|&nbsp;-->
							<!--<a href="<?php echo U('hrm/archives/view','user_id='.$vo['user_id']);?>">人事档案</a>&nbsp;|&nbsp;-->
							<!--<a href="javascript:void(0);" class="punch_in" rel="<?php echo ($vo["user_id"]); ?>" value="0">上班打卡</a>&nbsp;|&nbsp;-->
							<!--<a href="javascript:void(0);" class="punch_out" rel="<?php echo ($vo["user_id"]); ?>" value="1">下班打卡</a>-->
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="9"><?php echo ($page); ?><div class="clear"></div></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
	/**
	 * Ajax上班打卡
	 * 
	**/
	$('.punch_in').click(function(){
		var user_id = $(this).attr('rel');
		var punch_type = $(this).attr('value');

		$.ajax({
			type: "POST",
			dataType: "JSON",
			url: "<?php echo U('hrm/punch/add');?>",
			data: {user_id : user_id, punch_type : punch_type},
			success: function (data) {
				alert(data.info);
			},
			error: function(data) {
				alert(data.info);
			}
		});
	});
	
	/**
	 * Ajax下班打卡
	 * 
	**/
	$('.punch_out').click(function(){
		var user_id = $(this).attr('rel');
		var punch_type = $(this).attr('value');

		$.ajax({
			type: "POST",
			dataType: "JSON",
			url: "<?php echo U('hrm/punch/add');?>",
			data: {user_id : user_id, punch_type : punch_type},
			success: function (data) {
				alert(data.info);
			},
			error: function(data) {
				alert(data.info);
			}
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