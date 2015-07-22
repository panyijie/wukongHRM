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
		<div class="row-table-title">smtp设置</div>
		<div class="row-table-body">
			<form class="form-horizontal" action="<?php echo U('core/setting/smtp');?>" method="post">
				<p class="form-title">smtp基本配置信息&nbsp;&nbsp;(若不设置则无法使用密码找回功能)</p>
				<div class="form-group">
					<label for="address" class="col-sm-2 control-label">邮箱地址<span style="color:red;">*</span></label>
					<div class="col-sm-3">
						<input class="form-control" name="address" id="address" type="text" value="<?php echo ($smtp['MAIL_ADDRESS']); ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="smtp" class="col-sm-2 control-label">smtp服务器地址<span style="color:red;">*</span></label>
					<div class="col-sm-3">
						<input class="form-control" name="smtp" id="smtp" type="text" value="<?php echo ($smtp['MAIL_SMTP']); ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="loginName" class="col-sm-2 control-label">登录名<span style="color:red;">*</span></label>
					<div class="col-sm-3">
						<input class="form-control" name="loginName" id="loginName" type="text" value="<?php echo ($smtp['MAIL_LOGINNAME']); ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-sm-2 control-label">密码<span style="color:red;">*</span></label>
					<div class="col-sm-3">
						<input class="form-control" name="password" id="password" type="password" value="<?php echo ($smtp['MAIL_PASSWORD']); ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="test_email" class="col-sm-2 control-label">测试邮箱</label>
					<div class="col-sm-3">
						<input class="form-control" name="test_email" id="test_email" type="text"/>
					</div>
					<div class="col-sm-1">
						<input class="btn btn-mini" id="test" name="submit" type="button" value="测试">
					</div>
				</div>
				<p class="form-title">短信配置信息</p>
				<div class="form-group">
					<label for="uid" class="col-sm-2 control-label">短信接口用户名<span style="color:red;">*</span></label>
					<div class="col-sm-3">
						<input class="form-control" name="uid" id="uid" type="text" value="<?php echo ($sms['uid']); ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="passwd" class="col-sm-2 control-label">短信接口密码<span style="color:red;">*</span></label>
					<div class="col-sm-3">
						<input class="form-control" name="passwd" id="passwd" type="password" value="<?php echo ($sms['passwd']); ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="sign_name" class="col-sm-2 control-label">客户短信签名<span style="color:red;">*</span></label>
					<div class="col-sm-3">
						<input class="form-control" name="sign_name" id="sign_name" type="text" value="<?php echo ($sms['sign_name']); ?>"/>
					</div>
					<div class="col-sm-2">
						不超过8个字符
					</div>
				</div>
				<div class="form-group">
					<label for="sign_sysname" class="col-sm-2 control-label">内部通知短信签名<span style="color:red;">*</span></label>
					<div class="col-sm-3">
						<input class="form-control" name="sign_sysname" id="sign_sysname" type="text" value="<?php echo ($sms['sign_sysname']); ?>"/>
					</div>
					<div class="col-sm-2">
						不超过8个字符
					</div>
				</div>
				<div class="form-group">
					<label for="test_sms_phone" class="col-sm-2 control-label">测试手机</label>
					<div class="col-sm-3">
						<input class="form-control" name="test_sms_phone" id="test_sms_phone" type="text" />
					</div>
					<div class="col-sm-1">
						<input class="btn btn-mini" id="test_sms_btn" type="button" value="发送测试短信"/>
					</div>
				</div>
				<div class="form-group">
					<label for="test_sms_phone" class="col-sm-2 control-label"></label>
					<div class="col-sm-3">
						<input name="submit" class="btn btn-primary" type="submit" value="保存"/>
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
<script type="text/javascript">	
	$('#test').click(
		function(){
			address = $('#address').val();
			smtp = $('#smtp').val();
			name = $('#loginName').val();
			pw = $('#password').val();
			email = $('#test_email').val();
			if(address !='' & smtp !='' & name!='' & pw!='' & email!=''){
				$.post('<?php echo U("setting/smtp");?>',
				{   address:address,
					smtp:smtp,
					loginName:name,
					password:pw,
					test_email:email},
				function(data){
					alert(data.info);
				},
				'json');
			} else {
				alert('请填写完整信息!');
			}
		}
	);
	$('#test_sms_btn').click(
		function(){
			uid = $('#uid').val();
			passwd = $('#passwd').val();
			phone = $('#test_sms_phone').val();
			if(uid !='' & passwd !='' & phone !=''){
				$.post('<?php echo U("setting/smtp");?>',
				{   uid:uid,
					passwd:passwd,
					phone:phone},
				function(data){
					alert(data.info);
				},
				'json');
			} else {
				alert('请填写完整信息!');
			}
		}
	);
</script>
		<!-- <div id="footer">
			<div class="container">
				<p class="text-muted credit">
					悟空HRM © 2013 <a href="http://www.ccds24.com" target="_blank">河南锐骑文化传播有限公司</a>版权所有
				</p>
			</div>
		</div> -->
	</body>
</html>