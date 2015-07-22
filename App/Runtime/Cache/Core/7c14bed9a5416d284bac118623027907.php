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
		<div class="row-table-title">个人资料</div>
		<div class="row-table-body">
			<form class="form-horizontal " action="<?php echo U('core/user/editinfo');?>" method="post">
				<input type="hidden" name="user_id" value="<?php echo ($user['user_id']); ?>"/>
				<p class="form-title">基本信息&nbsp;&nbsp;<a href="javascript:history.go(-1);">返回</a></p>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">用户名</label>
					<div class="col-sm-3">
						<?php if(session('?admin')): ?><input type="text" name="name" class="form-control" value="<?php echo ($user['name']); ?>"><?php else: echo ($user["name"]); endif; ?>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">用户类别</label>
					<div class="col-sm-3">
						<?php if(session('?admin')): ?><select class="form-control" name="category_id" id="category_id">
							<option value="0" <?php if(0 == $user['category_id']): ?>selected = "selected"<?php endif; ?>>员工</option>
							<option value="1" <?php if(1 == $user['category_id']): ?>selected = "selected"<?php endif; ?>>管理员</option>
						</select>
						<?php else: ?>
							<?php if($user['category_id'] == 1): ?>管理员<?php else: ?>员工<?php endif; endif; ?>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">部门</label>
					<div class="col-sm-3">
						<select id="department" name="department_id" class="form-control" onchange="changeRoleContent()">
							<option value="">请选择部门</option>
							<?php if(is_array($department_list)): $i = 0; $__LIST__ = $department_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$temp): $mod = ($i % 2 );++$i;?><option value="<?php echo ($temp["department_id"]); ?>" <?php if($user['department_id'] == $temp['department_id']): ?>selected = "selected"<?php endif; ?>><?php echo ($temp["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">岗位</label>
					<div class="col-sm-3">
						<select id="position_id" name="position_id" class="form-control" >
							<option value="">请选择岗位</option>
							<?php if(is_array($position_list)): $i = 0; $__LIST__ = $position_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$temp): $mod = ($i % 2 );++$i;?><option value="<?php echo ($temp["position_id"]); ?>" <?php if($user['position_id'] == $temp['position_id']): ?>selected = "selected"<?php endif; ?>><?php echo ($temp["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">员工状态</label>
					<div class="col-sm-3">
						<select  name="status" class="form-control" >
							<?php if(is_array($status)): $i = 0; $__LIST__ = $status;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($user['status'] == $key): ?>selected = "selected"<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
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
					<label for="name" class="col-sm-2 control-label">工作状态</label>
					<div class="col-sm-3">
						<select  name="work_status" class="form-control" >
							<?php if(is_array($work_status)): $i = 0; $__LIST__ = $work_status;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>" <?php if($user['work_status'] == $key): ?>selected = "selected"<?php endif; ?>><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">性别</label>
					<div class="col-sm-3">
						<label class="checkbox-inline"><input type="radio"  name="sex" value="1" <?php if($user['sex'] == 1): ?>checked="checked"<?php endif; ?>/>男</label>
						<label class="checkbox-inline"><input type="radio"  name="sex" value="2" <?php if($user['sex'] == 2): ?>checked="checked"<?php endif; ?>/>女</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">邮箱</label>
					<div class="col-sm-3">
						<input class="form-control" name="email" type="text" value="<?php echo ($user["email"]); ?>">
					</div>
				</div><div class="form-group">
					<label class="col-sm-2 control-label">手机</label>
					<div class="col-sm-3">
						<input class="form-control" name="telephone" type="text" value="<?php echo ($user["telephone"]); ?>">
					</div>
				</div><div class="form-group">
					<label class="col-sm-2 control-label">联系地址</label>
					<div class="col-sm-3">
						<textarea name="address" class="form-control" ><?php echo ($user["address"]); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-3">
						<input name="submit" class="btn btn-primary" type="submit" value="保存"/>&nbsp;&nbsp;<input type="button" class="btn" value="取消" onclick="javascript:history.go(-1);"/>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
	$(function(){
		$('#position_id').click(
			function(){
				department_id = $('#department').val();
				if(department_id == ''){
					alert('请先选择部门!');
				}
			}
		);
		
		$("#department option[value='<?php echo ($user['department_id']); ?>']").prop("selected", true);
		$("#position_id option[value='<?php echo ($user['position_id']); ?>']").prop("selected", true);
	});
	function changeRoleContent(){
		department_id = $('#department').val();
		if(department_id == ''){
			$("#position_id").html('');
		}else{
			$.ajax({
				type:'get',
				url:'<?php echo U("hrm/structure/getDepartmentPosition","id=");?>'+department_id,
				async:false,
				success:function(data){
					if(data){
						options = '';
						$.each(data, function(k, v){
							options += '<option value="'+v.position_id+'">'+v.name+'</option>';
						});
						$("#position_id").html(options);
					}else{
						$("#position_id").html('');
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