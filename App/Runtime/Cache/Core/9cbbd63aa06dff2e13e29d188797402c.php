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
		<div class="row-table-title">任务列表</div>
		<div class="row-table-body">
			<p class="form-title">
				全部任务<a class="pull-right btn btn-primary btn-xs" href="<?php echo U('core/task/add');?>">添加任务</a>
				<form id="search_form" action="" method="get">
					<input type="hidden" name="g" value="core"/>
					<input type="hidden" name="m" value="task"/>
					<div class="form-inline" >
						<div class="form-group">
							<label for="name">任务名称</label>
							<input type="text" class="form-control" id="search_name" name="search_name" />
						</div>&nbsp;&nbsp;
						<div class="form-group">
							<label for="level">等级</label>
							<select class="form-control" id="search_level" name="search_level">
								<option value="">全部</option>
								<option value="1">普通</option>
								<option value="2">紧急</option>
								<option value="3">闲时处理</option>
							</select>
						</div>&nbsp;&nbsp;
						<div class="form-group">
							<label for="status">状态</label>
							<select class="form-control" id="search_status" name="search_status">
								<option value="">全部</option>
								<option value="未开始">未开始</option>
								<option value="进行中">进行中</option>
								<option value="已处理">已处理</option>
								<option value="退还">退还</option>
							</select>
						</div>&nbsp;&nbsp;
						<div class="form-group">
							<input type="text" class="form-control" id="search_start_time" name="search_start_time" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" placeholder="开始日期"/>&nbsp;-&nbsp;
							<input type="text" class="form-control" id="search_end_time" name="search_end_time" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" placeholder="截止日期"/>
						</div>
						<input type="button" class="btn search_btn" value="搜索" />
					</div>
				</form>
			</p>
			<?php if(empty($tasklist)): ?><div>---暂无数据---</div>
			<?php else: ?>
			<form name="form1" id="form1" action="" method="post">
				<table class="table" style="margin-bottom:0px;">
					<tbody>
						<tr>
							<th><input type="checkbox" name="task_id[]" id="check_all"/></th>
							<th>任务主题</th>
							<th>主要执行人</th>
							<th>状态</th>
							<th>等级</th>
							<th>开始日期</th>
							<th>截止日期</th>
							<th>操作</th>
						</tr>
						<?php if(is_array($tasklist)): $i = 0; $__LIST__ = $tasklist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td><input type="checkbox" name="id[]" class="check_list" value="<?php echo ($vo["task_id"]); ?>" /></td>
							<td><a href="<?php echo U('core/task/view','id='.$vo['task_id']);?>"><?php echo ($vo["name"]); ?></td>
							<td><?php echo ($vo["executor_name"]); ?></td>
							<td><?php echo ($vo["status"]); ?></td>
							<td><?php if($vo['level'] == 1): ?>普通<?php elseif($vo['level'] == 2): ?>紧急<?php else: ?>闲时处理<?php endif; ?></td>
							<td><?php echo (date('Y-m-d H:i',$vo["start_time"])); ?></td>
							<td><?php echo (date('Y-m-d H:i',$vo["end_time"])); ?></td>
							<td>
								<a href="<?php echo U('core/task/edit','id='.$vo['task_id']);?>">编辑</a>&nbsp;|&nbsp;
								<a href="<?php echo U('core/task/delete','id='.$vo['task_id']);?>">删除</a>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
					<tfoot>
						<tr>
							<td>
								<input name="submit" class="btn btn-primary btn-xs" type="submit" id="delete" value="删除"/>
							</td>
							<td colspan="7" align="center"><?php echo ($page); ?><div class="clear"></div></td>
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
	 * 全选
	 **/
	$("#check_all").click(function(){
		$("input[class='check_list']").prop('checked',$(this).prop('checked'));
	});
	
	/**
	 * 批量删除
	 **/
	$("#delete").click(function(){
		if(confirm('确定要删除吗？')){
			$("#form1").attr("action","<?php echo U('core/task/delete');?>");
			$("#form1").submit();
		}
	});
	
	$("#search_name").prop('value', '<?php echo ($_GET['search_name']); ?>');
	$("#search_level option[value='<?php echo ($_GET['search_level']); ?>']").prop("selected", true);
	$("#search_status option[value='<?php echo ($_GET['search_status']); ?>']").prop("selected", true);
	$("#search_start_time").prop('value', '<?php echo ($_GET['search_start_time']); ?>');
	$("#search_end_time").prop('value', '<?php echo ($_GET['search_end_time']); ?>');
	
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
			window.location.href="<?php echo U('core/task/index');?>";
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