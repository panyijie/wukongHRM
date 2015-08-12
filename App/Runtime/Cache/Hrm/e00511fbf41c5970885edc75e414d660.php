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
		<div class="row-table-title">绩效考核模板详情</div>
		<div class="row-table-body form-horizontal">
			<p class="form-title">
				绩效考核模板详情&nbsp;&nbsp;
				<a href="<?php echo U('hrm/appraisaltemplate/edit','id='.$appraisal_template['appraisal_template_id']);?>">编辑</a>&nbsp;&nbsp;
				<a href="javascript:history.go(-1);">返回</a>&nbsp;&nbsp;
				<a href="<?php echo U('hrm/appraisaltemplate/index');?>">返回上级</a>&nbsp;&nbsp;
			</p>
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">模板名称</label>
				<div class="col-sm-3"><?php echo ($appraisal_template["name"]); ?></div>
			</div>
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">类型</label>
				<div class="col-sm-3"><?php echo ($appraisal_template["category"]["name"]); ?></div>
			</div>
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">创建人</label>
				<div class="col-sm-3"><?php echo ($appraisal_template["creator_user_name"]); ?></div>
			</div>
			<div class="form-group">
				<label for="name" class="col-sm-2 control-label">更多说明</label>
				<div class="col-sm-8" style="margin-top: 7px">
					<pre name="description" class="col-sm-8"style="min-height:150px;"><?php echo ($appraisal_template["description"]); ?></pre>
				</div>
			</div>
			<p class="form-title">
				考核内容
			</p>
			<div class="form-group">
				<label for="insurance_type" class="col-sm-2 control-label">考核详细</label>
				<div class="col-sm-9" id="itembox" style="margin-top: 10px">
					<table class="table table-bordered">
						<tr>
							<td>名称</td>
							<td>标准分</td>
							<td>评分范围</td>
							<td>评分细则</td>
						</tr>
						<?php if(is_array($appraisal_template['score'])): $i = 0; $__LIST__ = $appraisal_template['score'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td><?php echo ($vo["name"]); ?></td>
							<td><?php echo ($vo["standard_score"]); ?></td>
							<td><?php echo ($vo["low_scope"]); ?>&nbsp;至&nbsp;<?php echo ($vo["high_scope"]); ?></td>
							<td><?php echo ($vo["description"]); ?></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</table>
				</div>
			</div>
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
		<!-- <div id="footer">
			<div class="container">
				<p class="text-muted credit">
					悟空HRM © 2013 <a href="http://www.ccds24.com" target="_blank">河南锐骑文化传播有限公司</a>版权所有
				</p>
			</div>
		</div> -->
	</body>
</html>