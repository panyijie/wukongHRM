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
		<div class="row-table-title">编辑绩效考核模板</div>
		<div class="row-table-body">
			<form class="form-horizontal" action="<?php echo U('hrm/appraisaltemplate/edit');?>" method="post">
				<input type="hidden" name="id" value="<?php echo ($appraisal_template["appraisal_template_id"]); ?>"/>
				<p class="form-title">
					编辑绩效考核模板&nbsp;&nbsp;
					<a href="javascript:history.go(-1);">返回</a>&nbsp;&nbsp;
					<a href="<?php echo U('hrm/appraisaltemplate/index');?>">返回上级</a>&nbsp;&nbsp;
				</p>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">模板名称</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="name" value="<?php echo ($appraisal_template["name"]); ?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">类型</label>
					<div class="col-sm-3">
						<select class="form-control" name="category_id">
							<?php if(is_array($template_category)): $i = 0; $__LIST__ = $template_category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["category_id"]); ?>" <?php if($vo['category_id'] == $appraisal_template['category_id']): ?>selected="selected"<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">创建人</label>
					<div class="col-sm-3">
						<?php echo ($appraisal_template["creator_user_name"]); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">更多说明</label>
					<div class="col-sm-8">
						<textarea name="description" class="form-control" style="min-height:150px;"><?php echo ($appraisal_template["description"]); ?></textarea>
					</div>
				</div>
				<p class="form-title">
					考核内容
				</p>
				<div class="form-group">
					<label for="insurance_type" class="col-sm-2 control-label">考核详细</label>
					<div class="col-sm-9" id="itembox">
						<table class="table table-bordered">
							<tr>
							<td>名称</td>
							<td>标准分</td>
							<td>评分范围</td>
							<td>评分细则</td>
							<td width="1%"><input type="button" id="additem" class="btn btn-primary btn-xs" value="+" /></td>
							</tr>
							<?php if(is_array($appraisal_template['score'])): $i = 0; $__LIST__ = $appraisal_template['score'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td><a href="javascript:void(0);" title="编辑" class="edititem" rel="<?php echo ($vo["score_id"]); ?>"><?php echo ($vo["name"]); ?></a></td>
								<td><?php echo ($vo["standard_score"]); ?></td>
								<td><?php echo ($vo["low_scope"]); ?>&nbsp;至&nbsp;<?php echo ($vo["high_scope"]); ?></td>
								<td><?php echo ($vo["description"]); ?></td>
								<td><input type="button" class="btn btn-primary btn-xs deleteitem" rel="<?php echo ($vo["score_id"]); ?>" value="-"></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</table>
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
<script type="text/javascript">
	/**
	 * 添加考核内容
	 * 
	 **/
	$('#additem').click(function(){
		$('#alert').modal({
			show:true,
			remote:'<?php echo U("hrm/appraisaltemplate/addScoreDialog","appraisal_template_id=");?>'+<?php echo ($appraisal_template["appraisal_template_id"]); ?>
		});
	});
	
	/**
	 * 编辑考核内容
	 * 
	 **/
	$('.edititem').click(function(){
		var score_id = $(this).attr('rel');
		$('#alert').modal({
			show:true,
			remote:'<?php echo U("hrm/appraisaltemplate/editScoreDialog","score_id=");?>'+score_id
		});
	});
	
	/**
	 * 删除考核内容
	 * 
	 **/
	 $('.btn.btn-primary.btn-xs.deleteitem').click(function(){
		var score_id = $(this).attr('rel');
		if(confirm('确定要删除么？')){
			location.href = '<?php echo U("hrm/appraisaltemplate/deleteScore","score_id=");?>'+score_id;
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