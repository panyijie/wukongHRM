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
		<div class="row-table-title">绩效考核模板管理</div>
		<div class="row-table-body">
			<p class="form-title">
				绩效考核模板管理&nbsp;&nbsp;
				<a href="<?php echo U('hrm/appraisaltemplate/category');?>">模板类型管理</a>
				<a href="<?php echo U('hrm/appraisaltemplate/add');?>" class="pull-right btn btn-primary btn-xs" style="margin-top: 7px" >添加</a>
			</p>
			<?php if(empty($templatelist)): ?><div>---暂无数据---</div>
			<?php else: ?>
			<form class="form-horizontal " id="form1"  method="post">
				<table class="table" style="margin-bottom:0px;">
					<tbody>
						<tr>
							<th><input type="checkbox" name="appraisal_template_id[]" id="check_all"/></th>
							<th>模板名称</th>
							<th>模板类型</th>
							<th>创建时间</th>
							<th>创建人</th>
							<th>操作</th>
						</tr>
						<?php if(is_array($templatelist)): $i = 0; $__LIST__ = $templatelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td><input type="checkbox" name="id[]" class="check_list" value="<?php echo ($vo["appraisal_template_id"]); ?>" /></td>
							<td><a href="<?php echo U('hrm/appraisaltemplate/view','id='.$vo['appraisal_template_id']);?>"><?php echo ($vo["name"]); ?></a></td>
							<td><?php echo ($vo["category"]["name"]); ?></td>
							<td><?php echo (date('Y-m-d H:i:s',$vo["create_time"])); ?></td>
							<td><?php echo ($vo["creator_user_name"]); ?></td>
							<td>
								<a href="<?php echo U('hrm/appraisaltemplate/view','id='.$vo['appraisal_template_id']);?>">查看</a>&nbsp;|&nbsp;
								<a href="<?php echo U('hrm/appraisaltemplate/edit','id='.$vo['appraisal_template_id']);?>">编辑</a>&nbsp;|&nbsp;
								<a href="<?php echo U('hrm/appraisaltemplate/delete','id='.$vo['appraisal_template_id']);?>">删除</a>
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
			$("#form1").attr("action","<?php echo U('hrm/appraisaltemplate/delete');?>");
			$("#form1").submit();
		}
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