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
	<div class="row-col">
		<div class="row-table">
			<div class="row-table-title">日程日历</div>
			<div class="row-table-body">
				<div class="row-body">
					<div id="date1" class="cdate">
						<a id="preMonth" title="上一年"><img src="__PUBLIC__/img/calendar_n1.png"></a>
						<a id="preYear" title="上一月"><img src="__PUBLIC__/img/calendar_n2.png"></a>
						<span class="selectDate">
							<span class="selectY"></span>年<span class="selectM"></span>月
						</span>
						<a id="nextYear" title="下一月"><img src="__PUBLIC__/img/calendar_p2.png"></a>
						<a id="nextMonth" title="下一年"><img src="__PUBLIC__/img/calendar_p1.png"></a>
					</div>
					<table id="calTable1" class="calTable">
						<thead>
							<tr>
								<th>日</th>
								<th>一</th>
								<th>二</th>
								<th>三</th>
								<th>四</th>
								<th>五</th>
								<th>六</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							</tr>
							<tr>
								<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							</tr>
							<tr>
								<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							</tr>
							<tr>
								<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							</tr>
							<tr>
								<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							</tr>
							<tr>
								<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
							</tr>
						</tbody>
					</table>
				</div>
				<script type="text/javascript">
					new Calendar("calTable1","date1",<?php echo date('Y');?>,<?php echo date('m');?>,'<?php echo U("core/event/ajaxmonth");?>');
				</script>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<div class="row-col">
		<?php echo W('Announcement');?>
	</div>
	<div class="clear"></div>
	<div class="row-col">
		<?php echo W('Message');?>
	</div>
	<div class="row-col">
		<div class="row-table">
			<div class="row-table-title">悟空HRM系统开发团队</div>
			<div class="row-table-body">
				<pre>当前版本：<?php echo C(VERSION);?> 发布时间：<?php echo C(RELEASE);?>

版权所有：郑州卡卡罗特软件科技有限公司
总 策 划：郭松超
开发与支持团队：郭松超、许浩光、张洋洋、史俊涛
UI 设计：葛芊芊
官方网站：http://www.5kcrm.com/
官方论坛：http://bbs.5kcrm.com/</pre>
				<div class="clear"></div>
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