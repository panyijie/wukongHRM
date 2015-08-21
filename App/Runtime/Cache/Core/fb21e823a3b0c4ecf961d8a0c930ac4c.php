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
        <style type="text/css">
            .col-sm-3{
                margin-top: 7px;
            }
        </style>
<div class="body-right">
	<div class="row-table">
		<div class="row-table-title">添加员工</div>
		<div class="row-table-body">
			<form class="form-horizontal " action="<?php echo U('core/user/addUser');?>" method="post">
				<input type="hidden" name="navigation_id" value="<?php echo ($navigation["navigation_id"]); ?>"/>
				<p class="form-title">添加员工&nbsp;&nbsp;<a href="javascript:history.go(-1);">返回</a></p>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">用户名</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="name" >
					</div>
				</div>
						<input class="form-control" value="123456" type="hidden" name="password">
				<div class="form-group">
					<label for="email" class="col-sm-2 control-label">邮箱</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="email" >
					</div>
				</div>
                <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">电话</label>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" name="telephone" >
                    </div>
                </div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">用户类别</label>
					<div class="col-sm-3">
						<select class="form-control" name="category_id">
							<option value="">请选择类别</option>
							<option value="1">管理员</option>
							<option value="2">员工</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">员工类型</label>
					<div class="col-sm-3">
						<select  name="type" class="form-control" >
							<?php if(is_array($type)): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($user['type'] == $key): ?>selected = "selected"<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">部门</label>
					<div class="col-sm-3">
						<select id="department" name="department_id" class="form-control" onchange="changeRoleContent(this.value)">
							<option value="">请选择部门</option>
							<?php if(is_array($department_list)): $i = 0; $__LIST__ = $department_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$temp): $mod = ($i % 2 );++$i;?><option value="<?php echo ($temp["department_id"]); ?>"><?php echo ($temp["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="name"  class="col-sm-2 control-label">岗位</label>
					<div class="col-sm-3">
						<select id="position" name="position_id" class="form-control">
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-3">
						<input name="submit" class="btn btn-primary" type="submit" value="添加"/>&nbsp;&nbsp;
						<input type="button" class="btn" value="取消" onclick="javascript:history.go(-1);"/>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
//	$(function(){
//		va = $('input[name="radio_type"]:checked').val();
//		if( va == 'email'){$('#password').hide();}else{$('#password').show();}
//		$('#email').click(
//			function(){
//				$('#password').hide();
//			}
//		);
//		$('#add').click(
//			function(){
//				$('#password').show();
//			}
//		);
//	});
	function changeRoleContent(department_id){
		if(department_id == ''){
			$("#position").html('');
		}else{
			$.ajax({
				type:'get',
				url:'<?php echo U("hrm/Structure/getDepartmentPosition","id=");?>'+department_id,
				async:false,
				success:function(data){
					if(data){
						options = '';
						$.each(data, function(k, v){
							options += '<option value="'+v.position_id+'">'+v.name+'</option>';
						});
						$("#position").html(options);
					}else{
						$("#position").html('');
					}
				},
				dataType:'json'
			});	
		}
	}
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