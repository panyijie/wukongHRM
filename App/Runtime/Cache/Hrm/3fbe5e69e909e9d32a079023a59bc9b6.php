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
<script src="__PUBLIC__/js/datepicker/WdatePicker.js"></script>
<div class="body-right">
	<div class="row-table">
		<div class="row-table-title">添加调休</div>
		<div class="row-table-body">
			<form class="form-horizontal " action="<?php echo U('hrm/lieu/add');?>" method="post">
				<p class="form-title">添加调休&nbsp;&nbsp;<a href="javascript:history.go(-1);">返回</a></p>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">调休人</label>
					<div class="col-sm-3">
						<input type="hidden" name="user_id" id="to_user_id" value="" />
						<input class="form-control" type="text" name="to_name" id="to_name" value=""/>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">类型</label>
					<div class="col-sm-3">
						<select class="form-control" name="lieu_category_id">
							<option value="1" selected="selected">加班调休</option>
							<option value="2">年假调休</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">开始时间</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="start_time" id="d4311" onFocus="WdatePicker({maxDate:$('#d4312').val(),minDate:'%y-%M-%d %H:%m:%s', dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
					</div>
					<label for="name" class="col-sm-2 control-label">结束时间</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="end_time" id="d4312" onFocus="WdatePicker({minDate:$('#d4311').val(),maxDate:'2020-10-01',dateFmt:'yyyy-MM-dd HH:mm:ss'})" />
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">计算结果</label>
					<div class="col-sm-3">
						共<span id="time_day">0</span>天<span id="time_hours">0</span>小时
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">填写人</label>
					<div class="col-sm-3">
						<?php echo ($maker_user_name); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">调休原因</label>
					<div class="col-sm-8">
						<textarea name="content" class="col-sm-8 form-control" style="min-height:150px;"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-3">
						<input name="submit" class="btn btn-primary" type="submit" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="button" class="btn" value="取消" onclick="javascript:history.go(-1);"/>
					</div>
				</div>
			</form>	
		</div>
	</div>
</div>
<div class="clear"></div>
<script>
	/**
	 * 选择员工
	 **/
	$('#to_name').click(function(){
		$('#alert').modal({
			show:true,
			remote:'<?php echo U("core/user/getuserrindex");?>'
		});
	});
	
	/**
	 * 根据输入计算时差
	**/
	$('#d4312').blur(function(){
		var start_time = $('#d4311').val();
		var end_time = $('#d4312').val();
		if('' != start_time && '' != end_time){
			temp_start_int = (new Date(start_time)).valueOf();
			temp_start_str = temp_start_int.toString();
			unix_start_time = temp_start_str.substring(0,10);

			temp_end_int = (new Date(end_time)).valueOf();
			temp_end_str = temp_end_int.toString();
			unix_end_time = temp_end_str.substring(0,10);
			unix_time = unix_end_time - unix_start_time;
			
			time_day = parseInt(unix_time/86400);
			time_hours = parseInt(unix_time/3600);
			
			$('#time_day').html(time_day);
			$('#time_hours').html(time_hours);
		}
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