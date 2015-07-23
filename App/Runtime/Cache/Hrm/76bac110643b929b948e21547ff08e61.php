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
		<div class="row-table-title">员工打卡</div>
		<div class="row-table-body">
			<p class="form-title">员工打卡
				<a href="javascript:void(0);" id="import_punch" class="pull-right btn btn-primary btn-xs" style="margin-left:10px;">导入</a>
				<a href="javascript:void(0);" id="export_punch" class="pull-right btn btn-primary btn-xs" >导出</a>
			</p>
			<form id="search_form" action="" method="get">
				<input type="hidden" name="g" value="hrm"/>
				<input type="hidden" name="m" value="punch"/>
				<div class="form-inline" >
					<div class="form-group">
						<label for="search_user_name">员工姓名</label>
						<input type="text" class="form-control" id="search_user_name" name="search_user_name" />
					</div>&nbsp;&nbsp;
					<div class="form-group">
						<label for="search_type">类型</label>
						<select class="form-control" id="search_type" name="search_type">
							<option value="">全部</option>
							<option value="0">上班</option>
							<option value="1">下班</option>
						</select>
					</div>&nbsp;&nbsp;
					<div class="form-group">
						<input type="text" class="form-control" id="search_start_time" name="search_start_time" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" placeholder="开始日期"/>&nbsp;-&nbsp;
						<input type="text" class="form-control" id="search_end_time" name="search_end_time" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" placeholder="结束日期"/>
					</div>
					<input type="button" class="btn search_btn" value="搜索" />
				</div>
			</form>
			<?php if(empty($punchlist)): ?><div>---暂无数据---</div>
			<?php else: ?>
				<table class="table" style="margin-bottom:0px;">
					<tbody>
						<tr>
							<th>姓名</th>
							<th>类型</th>
							<th>时间</th>
							<th>星期</th>
							<th>IP</th>
						</tr>
						<?php if(is_array($punchlist)): $i = 0; $__LIST__ = $punchlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td><?php echo ($vo["user_name"]); ?></td>
							<td><?php if('0' == $vo['type']): ?><span style="color:#F8971C"><?php echo ($vo["type_name"]); else: ?><span style="color:#0EB930"><?php echo ($vo["type_name"]); endif; ?></td>
							<td><?php echo (date('Y-m-d H:i',$vo["create_time"])); ?></td>
							<td><?php echo ($vo["week"]); ?></td>
							<td><?php echo ($vo["from_ip"]); ?></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="4" align="center"><?php echo ($page); ?><div class="clear"></div></td>
						</tr>
					</tfoot>
				</table><?php endif; ?>
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
	/**
	 * 导出打卡
	 **/
	$('#export_punch').click(function(){
		if(confirm('确定要导出打卡记录吗？')){
			location.href="<?php echo U('hrm/punch/exportPunch');?>";
		}
	});
	
	/**
	 * 导入打卡
	 **/
	$('#import_punch').click(function(){
		$('#alert').modal({
			show:true,
			remote:'<?php echo U("hrm/punch/importPunchDialog");?>'
		});
	});
	
	$('#search_user_name').prop('value', '<?php echo ($_GET['search_user_name']); ?>');
	$("#search_type option[value='<?php echo ($_GET['search_type']); ?>']").prop('selected', true);
	$('#search_start_time').prop('value', '<?php echo ($_GET['search_start_time']); ?>');
	$('#search_end_time').prop('value', '<?php echo ($_GET['search_end_time']); ?>');
	
	/**
	 * 单击提交搜索表单
	 * 双击清空搜索项
	 **/
	$(function(){
		var TimeFn = null;
		$('.btn.search_btn').click(function () {
			clearTimeout(TimeFn);
			TimeFn = setTimeout(function(){
				$('#search_form').submit();
			},300);
		});
		
		$('.btn.search_btn').dblclick(function () {
			clearTimeout(TimeFn);
			window.location.href="<?php echo U('hrm/punch/index');?>";
		})
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