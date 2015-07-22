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
		<div class="row-table-title">薪资报表</div>
		<div class="row-table-body">
			<p class="form-title">薪资报表</p>
			<form name="form1" action="<?php echo U('hrm/salary/monthly');?>" method="post">
				<div class="form-inline">
					选择对象:<input type="text" name="user_name" id="to_name" class="form-control" value="<?php echo (($_POST['user_name'])?($_POST['user_name']):'全部'); ?>"/>
					<input type="hidden" name="user_id" id="to_user_id" value="<?php echo ($_POST['user_id']); ?>"/>
					日期:
					<input type="text" name="start_time" class="form-control" onclick="WdatePicker({dateFmt:'yyyyMM'})" value="<?php echo (($_POST['start_time'])?($_POST['start_time']): date('Ym')); ?>"/>&nbsp;--&nbsp;<input type="text" name="end_time"  class="form-control" onclick="WdatePicker({dateFmt:'yyyyMM'})" value="<?php echo (($_POST['end_time'])?($_POST['end_time']): date('Ym')); ?>"/>&nbsp;&nbsp;
					<span><input type="submit" class="btn" value="查询"/></span>
				</div>
			</form>
			<?php if(empty($monthly)): ?><div>---暂无数据---</div>
			<?php else: ?>
			<form class="form-horizontal " id="form1"  method="post">
				<table class="table" style="margin-bottom:0px;">
					<tbody>
						<tr>
							<th>姓名</th>
							<th>薪资月份</th>
							<th>套帐名称</th>
							<th>实发薪资</th>
						</tr>
						<?php if(is_array($monthly)): $i = 0; $__LIST__ = $monthly;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td><?php echo ($vo["username"]); ?></td>
							<td><?php echo ($vo["month"]); ?></td>
							<td><?php echo ($vo["suit"]["name"]); ?></td>
							<td>
								<a href="javascript:void(0);" class="show_tips" data-content="
								<?php if(is_array($vo['suit']['items'])): foreach($vo['suit']['items'] as $k=>$v): $content = $v['item'].'content'; ?>
									<?php echo ($v['name']); ?>:<?php echo (($vo['items'][$v['item']])?($vo['items'][$v['item']]):0); ?>元, <?php echo ($vo['items'][$content]); ?><br /><?php endforeach; endif; ?>
								"><?php echo ($vo["money"]); ?>元</a>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="10" align="center"><?php echo ($page); ?><div class="clear"></div></td>
						</tr>
					</tfoot>
				</table>
			</form><?php endif; ?>
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
	/**
	 * 选择对象
	 **/
	$('#to_name').click(function(){
		$('#alert').modal({
			show:true,
			remote:'<?php echo U("core/user/getuserindex","self=1");?>'
		});
	});
	
	$('.show_tips').popover({
		html:true,
		trigger:'hover'
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