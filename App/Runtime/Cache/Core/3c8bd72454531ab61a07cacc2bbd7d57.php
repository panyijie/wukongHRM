<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title><?php echo C('defaultinfo.name');?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content=""/>
    <meta name="author" content="悟空HRMS"/>
    <link rel="shortcut icon" href="__PUBLIC__/ico/favicon.png"/>
    <link rel="stylesheet" href="__PUBLIC__/css/bootstrap.css">
    <link rel="stylesheet" href="__PUBLIC__/css/hrms.css">
    <link rel="stylesheet" href="__PUBLIC__/css/User/login.css">
    <script src="__PUBLIC__/js/jquery.min.js"></script>
    <script src="__PUBLIC__/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
    <script src="__PUBLIC__/js/html5shiv.min.js"></script>
    <script src="__PUBLIC__/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="wrap" style="padding:0px;">
    <div class="login-logo"><img src="./Public/img/login-logo.png"></div>
    <div class="login-bg"></div>
    <div class="login-box">
        <div class="login-main">
            <form class="form-signin" role="form" action="<?php echo U('core/user/login');?>" method="post" >
                <p><input class="form-control" type="text" name="name" autofocus="" required="" placeholder="用户名"></p>
                <p><input class="form-control" type="password" name="password" required="" placeholder="密码"></p>
                    <p>
                        <label class="checkbox" style="color: #ffffff; font-weight: normal">
                            <input type="checkbox" name="autologin" >
                            三日内自动登录
                        </label>
                    </p>
                <p><button class="btn btn-primary" type="submit">登录</button></p>
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