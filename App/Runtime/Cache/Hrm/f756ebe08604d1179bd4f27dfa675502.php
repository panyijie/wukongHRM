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
		<div class="row-table-title">绩效考核管理</div>
		<div class="row-table-body">
			<p class="form-title"><a href="<?php echo U('hrm/appraisalmanager/enableTemplate');?>" style="margin-top: 7px" class="pull-right btn btn-primary btn-xs">添加</a>绩效考核管理</p>
			<?php if(empty($managerlist)): ?><div>---暂无数据---</div>
			<?php else: ?>
			<form class="form-horizontal " id="form1"  method="post">
				<table class="table" style="margin-bottom:0px;">
					<tbody>
						<tr>
							<th><input type="checkbox" name="appraisal_manager_id[]" id="check_all"/></th>
							<th>名称</th>
							<th>模板名称</th>
							<th>启用时间</th>
							<th>截止时间</th>
							<th>负责人</th>
							<th>进度</th>
							<th>状态</th>
							<th>操作</th>
						</tr>
						<?php if(is_array($managerlist)): $i = 0; $__LIST__ = $managerlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td><input type="checkbox" name="id[]" class="check_list" value="<?php echo ($vo["appraisal_manager_id"]); ?>" /></td>
							<td><a href="<?php echo U('hrm/appraisalmanager/view','id='.$vo['appraisal_manager_id']);?>"><?php echo ($vo["name"]); ?></a></td>
							<td><a href="<?php echo U('hrm/appraisaltemplate/view','id='.$vo['template']['appraisal_template_id']);?>" target="_blank"><?php echo ($vo["template"]["name"]); ?></a></td>
							<td><?php echo (date('Y-m-d',$vo["start_time"])); ?></td>
							<td><?php echo (date('Y-m-d',$vo["end_time"])); ?></td>
							<td><?php echo ($vo["executor_user_name"]); ?></td>
							<td><?php echo ($vo["not_examin_examiner_num"]); ?>&nbsp;/&nbsp;<?php echo ($vo["total_examiner_num"]); ?></td>
							<td><?php echo ($vo["status_name"]); ?></td>
							<td>
								<?php if('4' == $vo['status']): ?><a href="<?php echo U('hrm/appraisalmanager/summary','appraisal_manager_id='.$vo['appraisal_manager_id']);?>" class="status_summary" title="汇总" rel="<?php echo ($vo['appraisal_manager_id']); ?>">汇总</a>&nbsp;|&nbsp;
								<?php elseif('2' == $vo['status']): ?>
									<a href="javascript:void(0);" class="status_reset" title="查看" rel="<?php echo ($vo['appraisal_manager_id']); ?>">查看</a>&nbsp;|&nbsp;<?php endif; ?>
                                <a href="<?php echo U('hrm/appraisalmanager/delete','id='.$vo['appraisal_manager_id']);?>">删除</a>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="7">
								<input class="btn btn-primary btn-xs" type="submit" id="delete" value="删除"/>
							</td>
						</tr>
						<tr>
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
			$("#form1").attr("action","<?php echo U('hrm/appraisalmanager/delete');?>");
			$("#form1").submit();
		}
	});
	
//	/**
//	 * 汇总
//	 **/
//	$(".status_summary").click(function(){
//		var appraisal_manager_id = $(this).attr('rel');
//		if(confirm('确定要汇总数据吗？')){
//			$('#alert').modal({
//				show:true,
//				remote:"<?php echo U('hrm/appraisalmanager/summary', 'appraisal_manager_id');?>"+appraisal_manager_id
//			});
//		}
//	});
	
	/**
	 * 撤销汇总
	 **/
	$(".status_reset").click(function(){
		var appraisal_manager_id = $(this).attr('rel');
        location.href = "<?php echo U('hrm/appraisalpoint/view', 'appraisal_manager_id');?>"+appraisal_manager_id;
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