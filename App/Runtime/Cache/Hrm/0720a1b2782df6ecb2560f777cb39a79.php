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
		<div class="row-table-title">绩效考核详情</div>
		<div class="row-table-body form-horizontal">
			<p class="form-title">
				绩效考核详情&nbsp;&nbsp;
				<a href="javascript:history.go(-1);">返回</a>&nbsp;&nbsp;
			</p>
			<div class="form-group">
				<div class="col-sm-12" id="itembox">
					<table class="table table-bordered">
						<tr>
							<td>考核对象</td>
							<td>岗位</td>
							<td>考核表</td>
							<td>分数</td>
							<td>操作</td>
						</tr>
						<?php if(is_array($appraisal['examinee_user'])): $i = 0; $__LIST__ = $appraisal['examinee_user'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td><?php echo ($vo["name"]); ?></td>
							<td><?php echo ($vo["department_name"]); ?> > <?php echo ($vo["position_name"]); ?></td>
							<td><?php echo ($appraisal["name"]); ?></td>
							<td><?php echo ($vo["sum_point"]); ?></td>
							<td><a href="javascript:void(0);" rel="<?php echo ($appraisal['appraisal_manager_id']); ?>" value="<?php echo ($vo['user_id']); ?>" class="detail_results">详细</a></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
	/**
	 * 得分详细
	 **/
	$(".detail_results").click(function(){
		var id = $(this).attr('rel');
		var uid = $(this).attr('value');
		$('#alert').modal({
			show:true,
			remote:"<?php echo U('hrm/appraisalpoint/detailResults','id=');?>"+id+'&uid='+uid
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