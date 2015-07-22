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
		<div class="row-table-title">考勤日报表</div>
		<div class="row-table-body">
			<p class="form-title">考勤日报表
				<form name="form1"  action="<?php echo U('hrm/attendancesheet/daily');?>" method="post">
					<div class="form-inline">
						选择对象:<input type="text" name="user_name" class="form-control" id="to_name" value="<?php echo ($_POST['user_name']); ?>" placeHolder="支持模糊搜索..."/>
						<a href="javascript:void(0);"><img src="__PUBLIC__/img/search.png" width="25px" id="user_search" /></a>
						<input type="checkbox" name="status[]" checked="checked" value="1"/>在职&nbsp;&nbsp;
						<input type="checkbox" name="status[]" checked="checked" value="2"/>离职&nbsp;&nbsp;
						<input type="checkbox" name="status[]" checked="checked" value="3"/>退休&nbsp;&nbsp;
						日期:
						<input type="text" name="start_time" class="form-control" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" value="<?php echo (($_POST['start_time'])?($_POST['start_time']): date('Y-m-d')); ?>"/>&nbsp;&nbsp;
						工作状态:
						<input type="checkbox" name="work_status[]" checked="checked" value="0"/>正常&nbsp;&nbsp;
						<input type="checkbox" name="work_status[]" checked="checked" value="1"/>休假&nbsp;&nbsp;
						<input type="checkbox" name="work_status[]" checked="checked" value="2"/>出差&nbsp;&nbsp;
						<input type="checkbox" name="work_status[]" checked="checked" value="3"/>请假&nbsp;&nbsp;
						<input type="checkbox" name="work_status[]" checked="checked" value="4"/>调休&nbsp;&nbsp;
						<span><input type="submit" class="btn btn-primary" value="查询"/></span>
					</div>
				</form>
			</p>
			<?php if(empty($daily)): ?><div>---暂无数据---</div>
			<?php else: ?>
			<form class="form-horizontal " id="form1"  method="post">
				<table class="table" style="margin-bottom:0px;">
					<tbody>
						<tr>
							<th>姓名</th>
							<th>日期</th>
							<th>应上</th>
							<th>应下</th>
							<th>实上</th>
							<th>实下</th>
							<th>状态</th>
						</tr>
						<?php if(is_array($daily)): $i = 0; $__LIST__ = $daily;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td><?php echo ($vo["name"]); ?></td>
							<td><?php echo ($_POST['start_time']); ?></td>
							<td><?php echo (date('H:i',$vo["working_shift"]["start_time"])); ?></td>
							<td><?php echo (date('H:i',$vo["working_shift"]["end_time"])); ?></td>
							<td>
								<?php if(is_array($vo['punch'])): $i = 0; $__LIST__ = $vo['punch'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i; if('0' == $sub['type']): echo (date('H:i',$sub["create_time"])); endif; endforeach; endif; else: echo "" ;endif; ?>
							</td>
							<td>
								<?php if(is_array($vo['punch'])): $i = 0; $__LIST__ = $vo['punch'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i; if('1' == $sub['type']): echo (date('H:i',$sub["create_time"])); endif; endforeach; endif; else: echo "" ;endif; ?>
							</td>
							<td>
								<?php if('0' == $vo['work_status']): ?>正常
								<?php elseif('1' == $vo['work_status']): ?>
									休假
								<?php elseif('2' == $vo['work_status']): ?>
									出差
								<?php elseif('3' == $vo['work_status']): ?>
									请假
								<?php elseif('4' == $vo['work_status']): ?>
									调休
								<?php else: ?>
									<span style="color:#999;">休息</span><?php endif; ?>
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
	$('#user_search').click(function(){
		$('#alert').modal({
			show:true,
			remote:'<?php echo U("core/user/getuserrindex","self=1");?>'
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