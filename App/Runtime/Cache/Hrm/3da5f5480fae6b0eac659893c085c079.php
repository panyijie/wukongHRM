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
		<div class="row-table-title">考勤月报表</div>
		<div class="row-table-body">
			<p class="form-title">考勤月报表
				<form name="form1" action="<?php echo U('hrm/attendancesheet/monthly');?>" method="post">
					<div class="form-inline">
						选择对象:<input type="text" name="user_name" class="form-control" id="to_name" value="<?php echo ($_POST['user_name']); ?>" placeHolder="支持模糊搜索..."/>
						<a href="javascript:void(0);"><img src="__PUBLIC__/img/search.png" width="25px" id="user_search" /></a>
						<input type="checkbox" name="status[]" checked="checked" value="1"/>在职&nbsp;&nbsp;
						<input type="checkbox" name="status[]" checked="checked" value="2"/>离职&nbsp;&nbsp;
						<input type="checkbox" name="status[]" checked="checked" value="3"/>退休&nbsp;&nbsp;
						日期:
						<input type="text" name="start_time" class="form-control" onclick="WdatePicker({dateFmt:'yyyy-MM'})" value="<?php echo (($_POST['start_time'])?($_POST['start_time']): date('Y-m')); ?>"/>&nbsp;&nbsp;
						<span><input type="submit" class="btn btn-primary" value="查询"/></span>
					</div>
				</form>
			</p>
			<?php if(empty($monthly)): ?><div>---暂无数据---</div>
			<?php else: ?>
			<form class="form-horizontal " id="form1"  method="post">
				<table class="table" style="margin-bottom:0px;">
					<tbody>
						<tr>
							<th>姓名</th>
							<th>月份</th>
							<th>请假</th>
							<th>加班</th>
							<th>调休</th>
							<th>应上</th>
						</tr>
						<?php if(is_array($monthly)): $i = 0; $__LIST__ = $monthly;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td><?php echo ($vo["name"]); ?></td>
							<td><?php echo ($_POST['start_time']); ?></td>
							<td>
								<a href="javascript:void(0);" class="show_tips" data-content="事假：<?php echo ($vo["leave_casual_counts"]); ?>次<br />病假：<?php echo ($vo["leave_sick_counts"]); ?>次<br />出差：<?php echo ($vo["leave_business_counts"]); ?>次<br />婚假：<?php echo ($vo["leave_marry_counts"]); ?>次<br />产假：<?php echo ($vo["leave_maternity_counts"]); ?>次<br />年假：<?php echo ($vo["leave_annual_counts"]); ?>次<br />丧假：<?php echo ($vo["leave_funeral_counts"]); ?>次<br />累计：<?php echo ($vo["leave_all_hours"]); ?>小时"><?php echo ($vo["leave_all_counts"]); ?>次</a>
							</td>
							<td>
								<a href="javascript:void(0);" class="show_tips" data-content="正常加班：<?php echo ($vo["overtime_normal_counts"]); ?><br />周末加班：<?php echo ($vo["overtime_weekends_counts"]); ?><br />节假日加班：<?php echo ($vo["overtime_holiday_counts"]); ?><br />累计：<?php echo ($vo["overtime_all_hours"]); ?>小时"><?php echo ($vo["overtime_all_counts"]); ?>次</a>
							</td>
							<td>
								<a href="javascript:void(0);" class="show_tips" data-content="加班调休：<?php echo ($vo["lieu_overtime_counts"]); ?><br />年假调休：<?php echo ($vo["lieu_annual_counts"]); ?><br />累计：<?php echo ($vo["lieu_all_hours"]); ?>小时"><?php echo ($vo["lieu_all_counts"]); ?>次</a>
							</td>
							<td><?php echo ($vo["should_work_hours"]); ?>小时</td>
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
	$('#user_search').click(function(){
		$('#alert').modal({
			show:true,
			remote:'<?php echo U("core/user/getuserrindex","self=1");?>'
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