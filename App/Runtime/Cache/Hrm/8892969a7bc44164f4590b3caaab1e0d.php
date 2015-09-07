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
<script src="__PUBLIC__/js/datepicker/WdatePicker.js"></script>
<div class="body-right">
	<div class="row-table">
		<div class="row-table-title">启用模板</div>
		<div class="row-table-body">
			<form class="form-horizontal" action="<?php echo U('hrm/appraisalmanager/enableTemplate');?>" method="post">
				<input type="hidden" name="id" value="<?php echo ($template_id); ?>" />
				<p class="form-title">
					启用模板&nbsp;&nbsp;<a href="javascript:history.go(-1);">返回</a>&nbsp;&nbsp;
				</p>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">绩效考核名称</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="name" />
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">模板</label>
					<div class="col-sm-3">
						<input type="hidden" name="appraisal_template_id" id="dialog_template_id" value=""/>
						<input class="form-control" type="text" name="appraisal_template_name" id="dialog_template_name"/>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">负责人</label>
					<div class="col-sm-3">
						<input type="hidden" name="executor_id" id="dialog_user_id" value="<?php echo session('user_id');?>"/>
                        <?php echo session('name');?>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">启用日期</label>
					<div class="col-sm-3">
						<?php echo (date('Y-m-d',$start_time)); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">截止日期</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="end_time" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"/>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">考核对象</label>
					<div class="col-sm-3">
						<input type="hidden" name="examinee_user_id" id="to_user_id" value=""/>
						<input class="form-control" type="text" name="examinee_user_name" id="to_name" value=""/>
					</div>
				</div>
				<!--<div class="form-group">-->
					<!--<label for="name" class="col-sm-2 control-label">评分对象</label>-->
					<!--<div class="col-sm-3">-->
						<!--<input type="hidden" name="examiner_user_id" id="str_user_id" value=""/>-->
						<!--<input class="form-control" type="text" name="examiner_user_name" id="str_user_name" value=""/>-->
					<!--</div>-->
				<!--</div>-->
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-3">
						<input name="submit" class="btn btn-primary" type="submit" value="确定"/>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="button" class="btn" value="取消" onclick="javascript:history.go(-1);"/>
					</div>
				</div>
			</form>	
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
	/**
	 * 选择模板
	 * 
	 **/
	$('#dialog_template_name').click(function(){
		$('#alert').modal({
			show:true,
			remote:'<?php echo U("hrm/appraisaltemplate/templateListDialog");?>'
		});
	});
	
	/**
	 * 负责人
	 * 
	 **/
	$('#dialog_user_name').click(function(){
		$('#alert').modal({
			show:true,
			remote:'<?php echo U("core/user/getSubUserDialog", "self=1");?>'
		});
	});
	
	/**
	 * 选择评分人和考核对象
	 * 
	 **/
	$("#to_name").click(function(){
		$('#alert').modal({
			show:true,
			remote:'<?php echo U("core/user/getuserindex");?>'
		});
	});
	$("#str_user_name").click(function(){
		$('#alert').modal({
			show:true,
			remote:'<?php echo U("hrm/appraisalmanager/getUserListDialog");?>'
		});
	});
	
	/**
	 * 全选
	 **/
	$("#check_all").click(function(){
		$("input[class='check_list']").prop('checked',$(this).prop('checked'));
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