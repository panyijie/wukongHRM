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
<script src="__PUBLIC__/js/chart/highcharts.js"></script>
<script src="__PUBLIC__/js/chart/exporting.js"></script>
<div class="body-right">
	<div class="row-table">
		<div class="row-table-title">人力结构</div>
		<div class="row-table-body">
			<p class="form-title">
				人力结构
			</p>
			<p class="form-title">
				<input id="sex" type="radio" value="sex" name="field" checked="checked" ><label for="sex">性别</label>
				<input id="birthday" type="radio" value="birthday" name="field" ><label for="birthday">年龄</label>
				<input id="education" type="radio" value="education" name="field" ><label for="education">学历</label>
				<input id="degree" type="radio" value="degree" name="field" ><label for="degree">学位</label>
				<input id="ygsf" type="radio" value="ygsf" name="field" ><label for="ygsf">身份</label>
				<input id="marital_status" type="radio" value="marital_status" name="field" ><label for="marital_status">婚姻状况</label>
				<input id="partisan" type="radio" value="partisan" name="field" ><label for="partisan">政治面貌</label>
				<input id="health" type="radio" value="health" name="field" ><label for="health">健康状况</label>
				<input id="work_date" type="radio" value="work_date" name="field" ><label for="work_date">工作年限</label>
			</p>
			<ul class="nav nav-tabs">
				<li><a href="#table_source" data-toggle="tab">表格</a></li>
				<li class="active"><a href="#pie" data-toggle="tab">图形</a></li>
			</ul>
				 
			<div class="tab-content">
				<div id="table_source" class="tab-pane"></div>
				<div id="pie" class="tab-pane active"><div id="canvas_source" style="min-width: 310px; width: 500px; min-height: 400px; margin: 0 auto"></div></div>
			</div>
			
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
function getreport(field){
	$.get('<?php echo U("hrm/report/archivesajax","field=");?>'+field,function(info){
		if(info){
			$('#canvas_source').highcharts({
				chart: {
					type: 'pie',
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: info[0]
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.y}</b>',
					percentageDecimals: 1
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							color: '#000000',
							connectorColor: '#000000',
							formatter: function() {
								return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
							}
						},
						showInLegend: true
					}
				},
				series: new Array(info[1])
			});
		}else{
			alert('未找到数据')
		}
	},'json');
	$.get('<?php echo U("hrm/report/archivestable","field=");?>'+field,function(info){
		$("#table_source").html(info);
	},'html');
}
$(function(){
	$("input[name='field']").change(function(){
		getreport($('input[name="field"]:checked').val());
	});
	var default_field = $('input[name="field"]:checked').val()?$('input[name="field"]:checked').val():'sex';
	getreport(default_field);
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