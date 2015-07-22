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
		<div class="row-table-title">加班管理</div>
		<div class="row-table-body">
			<p class="form-title">
				加班管理&nbsp;&nbsp;
				<a href="<?php echo U('hrm/overtime/category');?>">加班类型管理</a>
				<a href="<?php echo U('hrm/overtime/add');?>" class="pull-right btn btn-primary btn-xs" >添加</a>
				<form id="search_form" action="" method="get">
					<input type="hidden" name="g" value="hrm"/>
					<input type="hidden" name="m" value="overtime"/>
					<div class="form-inline" >
						<div class="form-group">
							<label for="search_user_name">员工姓名</label>
							<input type="text" class="form-control" id="search_user_name" name="search_user_name" />
						</div>&nbsp;&nbsp;
						<div class="form-group">
							<label for="search_status">状态</label>
							<select class="form-control" id="search_status" name="search_status">
								<option value="">全部</option>
								<option value="0">处理中</option>
								<option value="1">已通过</option>
								<option value="2">未通过</option>
							</select>
						</div>&nbsp;&nbsp;
						<div class="form-group">
							<label for="search_category">类型</label>
							<select class="form-control" id="search_category" name="search_category">
								<option value="">全部</option>
								<option value="1">正常加班</option>
								<option value="2">周末加班</option>
								<option value="3">法定节假日加班</option>
							</select>
						</div>&nbsp;&nbsp;
						<div class="form-group">
							<input type="text" class="form-control" id="search_start_time" name="search_start_time" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" placeholder="开始日期"/>&nbsp;-&nbsp;
							<input type="text" class="form-control" id="search_end_time" name="search_end_time" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" placeholder="结束日期"/>
						</div>
						<input type="button" class="btn search_btn" value="搜索" />
					</div>
				</form>
			</p>
			<?php if(empty($overtimelist)): ?><div>---暂无数据---</div>
			<?php else: ?>
			<form class="form-horizontal " id="form1"  method="post">
				<table class="table" style="margin-bottom:0px;">
					<tbody>
						<tr>
							<th><input type="checkbox" name="overtime_id[]" id="check_all"/></th>
							<th>加班人</th>
							<th>填写人</th>
							<th>状态</th>
							<th>加班类型</th>
							<th>加班时间</th>
							<th>天数</th>
							<th>小时</th>
							<th>结算方式</th>
							<th>计时费用(元)</th>
							<th>创建时间</th>
							<th>操作</th>
						</tr>
						<?php if(is_array($overtimelist)): $i = 0; $__LIST__ = $overtimelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td><input type="checkbox" name="id[]" class="check_list" value="<?php echo ($vo["overtime_id"]); ?>" /></td>
							<td><?php echo ($vo["user_name"]); ?></td>
							<td><?php echo ($vo["maker_user_name"]); ?></td>
							<td>
								<?php if('0' == $vo['status']): ?><span style="color:#F8971C"><?php echo ($vo["status_name"]); ?></span>
								<?php elseif('1' == $vo['status']): ?>
									<span style="color:#0EB930"><?php echo ($vo["status_name"]); ?></span>
								<?php else: ?>
									<span style="color:#FF3908;"><?php echo ($vo["status_name"]); ?></span><?php endif; ?>
							</td>
							<td><?php echo ($vo["category"]["name"]); ?></td>
							<td><?php echo (date('Y-m-d H:i',$vo["start_time"])); ?>&nbsp;至&nbsp;<?php echo (date('Y-m-d H:i',$vo["end_time"])); ?></td>
							<td><?php echo ($vo["overtime_days"]); ?></td>
							<td><?php echo ($vo["overtime_hours"]); ?></td>
							<td><?php echo ($vo["type_name"]); ?></td>
							<td><?php echo ($vo["overtime_payment"]); ?></td>
							<td><?php echo (date('Y-m-d H:i:s',$vo["create_time"])); ?></td>
							<td>
								<a href="<?php echo U('hrm/overtime/view','id='.$vo['overtime_id']);?>">查看</a>&nbsp;|&nbsp;
								<a href="<?php echo U('hrm/overtime/edit','id='.$vo['overtime_id']);?>">编辑</a>&nbsp;|&nbsp;
								<a href="<?php echo U('hrm/overtime/delete','id='.$vo['overtime_id']);?>">删除</a>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="12">
								<select name="status" id="select_status">
									<option value="0" selected="selected">审核中</option>
									<option value="1">已通过</option>
									<option value="2">未通过</option>
								</select>&nbsp;&nbsp;
								<input class="btn btn-primary btn-xs" type="submit" id="delete" value="删除"/>
							</td>
						</tr>
						<tr>
							<td colspan="12" align="center"><?php echo ($page); ?><div class="clear"></div></td>
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
			$("#form1").attr("action","<?php echo U('hrm/overtime/delete');?>");
			$("#form1").submit();
		}
	});
	/**
	 * 批量审核
	 **/
	$("#select_status").change(function(){
		if(confirm('确定要批量审核吗？')){
			$("#form1").attr("action","<?php echo U('hrm/overtime/auditing');?>");
			$("#form1").submit();
		}
	});
	
	$('#search_user_name').prop('value', '<?php echo ($_GET['search_user_name']); ?>');
	$('#search_status').prop('value', '<?php echo ($_GET['search_status']); ?>');
	$("#search_category option[value='<?php echo ($_GET['search_category']); ?>']").prop('selected', true);
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
			window.location.href="<?php echo U('hrm/overtime/index');?>";
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