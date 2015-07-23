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
		<div class="row-table-title">班次设置</div>
		<div class="row-table-body">
			<p class="form-title">班次设置<a href="<?php echo U('hrm/workingshift/add');?>" class="pull-right btn btn-primary btn-xs" >添加</a></p>
			<form id="search_form" action="" method="get">
				<input type="hidden" name="g" value="hrm"/>
				<input type="hidden" name="m" value="workingshift"/>
				<div class="form-inline" >
					<div class="form-group">
						<label for="name">班次名称</label>
						<input type="text" class="form-control" id="working_shift_name" name="working_shift_name" />
					</div>&nbsp;&nbsp;
					<div class="form-group">
						<label for="name">员工姓名</label>
						<input type="text" class="form-control" id="search_user_name" name="search_user_name" placeholder="请输入全称..."/>
					</div>&nbsp;&nbsp;
					<input type="button" class="btn search_btn" value="搜索" />
				</div>
			</form>
			<?php if(empty($shiftlist)): ?><div>---暂无数据---</div>
			<?php else: ?>
			<form class="form-horizontal " id="form1"  method="post">
				<table class="table" style="margin-bottom:0px;">
					<tbody>
						<tr>
							<th><input type="checkbox" name="working_shift_id[]" id="check_all"/></th>
							<th>班次名称</th>
							<th>班次类型</th>
							<th>工作时间</th>
							<th>工作日</th>
							<th>操作</th>
						</tr>
						<?php if(is_array($shiftlist)): $i = 0; $__LIST__ = $shiftlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td><input type="checkbox" name="id[]" class="check_list" value="<?php echo ($vo["working_shift_id"]); ?>" /></td>
							<td><a href="javascript:void(0);" class="working_shift_user" rel="<?php echo ($vo["working_shift_id"]); ?>"><?php echo ($vo["name"]); ?></a></td>
							<td><?php echo ($vo["typename"]); ?></td>
							<td><?php echo (date('H:i',$vo["start_time"])); ?>&nbsp;至&nbsp;<?php echo (date('H:i',$vo["end_time"])); ?></td>
							<td><?php echo ($vo["working_days_name"]); ?></td>
							<td>
								<a href="javascript:void(0);" class="shift_work" rel="<?php echo ($vo["working_shift_id"]); ?>">添加员工</a>&nbsp;|&nbsp;
								<a href="<?php echo U('hrm/workingshift/edit','id='.$vo['working_shift_id']);?>">编辑</a>&nbsp;|&nbsp;
								<a href="<?php echo U('hrm/workingshift/delete','id='.$vo['working_shift_id']);?>">删除</a>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="6">
								<input name="submit" class="btn btn-primary btn-xs" type="submit" id="delete" value="删除"/>
							</td>
						</tr>
						<tr>
							<td colspan="6" align="center"><?php echo ($page); ?><div class="clear"></div></td>
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
			$("#form1").attr("action","<?php echo U('hrm/workingshift/delete');?>");
			$("#form1").submit();
		}
	});
	
	/**
	 * 选择员工
	 **/
	$('.shift_work').click(function(){
		var working_shift_id = $(this).attr('rel');
		$('#alert').modal({
			show:true,
			remote:'<?php echo U("hrm/workingshift/getUserDialog","working_shift_id");?>'+working_shift_id
		});
	});
	
	/**
	 * 查看班次中的排版人员
	 **/
	$('.working_shift_user').click(function(){
		var working_shift_id = $(this).attr('rel');
		$('#alert').modal({
			show:true,
			remote:'<?php echo U("hrm/workingshift/workingShiftUserDialog","working_shift_id");?>'+working_shift_id
		});
	});
	
	$('#working_shift_name').prop('value', '<?php echo ($_GET['working_shift_name']); ?>');
	$('#search_user_name').prop('value', '<?php echo ($_GET['search_user_name']); ?>');
	
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
			window.location.href="<?php echo U('hrm/workingshift/index');?>";
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