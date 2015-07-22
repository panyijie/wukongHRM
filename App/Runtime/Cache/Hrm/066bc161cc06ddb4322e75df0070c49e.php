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
		<div class="row-table-title">绩效考核报表</div>
		<div class="row-table-body">
			<form class="form-inline" action="<?php echo U('hrm/report/appraisal');?>" method="post">
				考核表<select class="form-control" name="appraisal_manager_id">
				<option value="0">--选择考核表--</option>
				<?php if(is_array($appraisal)): $i = 0; $__LIST__ = $appraisal;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["appraisal_manager_id"]); ?>" <?php if($_POST['appraisal_manager_id'] == $vo['appraisal_manager_id']): ?>selected="selected"<?php endif; ?> ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>&nbsp;&nbsp;
				员工<input class="form-control" id="to_name" name="user_name" value="<?php echo ($_POST['user_name']); ?>" type="text"/><input id="to_user_id" value="<?php echo ($_POST['user_id']); ?>" type="hidden" name="user_id"/>
				&nbsp;&nbsp;<input type="submit" value="搜索" class="btn btn-primary btn-xs"/>
			</form>
			<div>
				<?php if($appraisal_manager): ?><table class="table table-bordered">
					<tr>
						<td>考核对象</td>
						<td>岗位</td>
						<td>考核表</td>
						<td>分数</td>
						<td>操作</td>
					</tr>
					<?php if(is_array($appraisal_manager['examinee_user'])): $i = 0; $__LIST__ = $appraisal_manager['examinee_user'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($vo["name"]); ?></td>
						<td><?php echo ($vo["department_name"]); ?> > <?php echo ($vo["position_name"]); ?></td>
						<td><?php echo ($appraisal_manager["name"]); ?></td>
						<td><?php echo ($vo["sum_point"]); ?></td>
						<td><a href="javascript:void(0);" rel="<?php echo ($appraisal_manager['appraisal_manager_id']); ?>" value="<?php echo ($vo['user_id']); ?>" class="detail_results">详细</a></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</table>
				<script type="text/javascript">
					$(function(){
						$(".detail_results").click(function(){
							var id = $(this).attr('rel');
							var uid = $(this).attr('value');
							$('#alert').modal({
								show:true,
								remote:"<?php echo U('hrm/appraisalpoint/detailResults','id=');?>"+id+'&uid='+uid
							});
						});
					});
				</script>
				<?php elseif($appraisalmanager && $appraisalmanager): ?>
				<table class="table table-bordered">
					<tr>
						<td>考核内容名称</td>
						<td>得分</td>
					</tr>
					<?php if(is_array($appraisalmanager['template']['score'])): $i = 0; $__LIST__ = $appraisalmanager['template']['score'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($vo["name"]); ?></td>
						<td><?php echo ($preSocreAvgPoint[$vo['score_id']]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					<tr>
						<td>总计</td>
						<td><?php echo array_sum($preSocreAvgPoint);?></td>
					</tr>
				</table>
				<?php elseif($userappraisallist): ?>
					<table class="table table-bordered">
					<tr>
						<td>考核表</td>
						<td>得分</td>
					</tr>
					<?php if(is_array($userappraisallist)): $i = 0; $__LIST__ = $userappraisallist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($vo["appraisal_manager"]["name"]); ?></td>
						<td><?php echo ($vo["sum_point"]); ?></td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</table>
				<?php else: ?>
					--暂无数据--<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
$(function(){
	$('#to_name').click(function(){
		$('#alert').modal({
			show:true,
			remote:"<?php echo U('core/user/getuserrindex');?>"
		}); 
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