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
        <style type="text/css">
            .col-sm-3{
                margin-top: 7px;
            }
        </style>
<div class="body-right">
	<div class="row-table">
		<div class="row-table-title">添加绩效考核模板</div>
		<div class="row-table-body">
			<form class="form-horizontal" action="<?php echo U('hrm/appraisaltemplate/add');?>" method="post">
				<p class="form-title">
					添加绩效考核模板&nbsp;&nbsp;<a href="javascript:history.go(-1);">返回</a>&nbsp;&nbsp;
				</p>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">模板名称</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="name" />
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">类型</label>
					<div class="col-sm-3">
						<select class="form-control" name="category_id">
							<?php if(is_array($template_category)): $i = 0; $__LIST__ = $template_category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["category_id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">创建人</label>
					<div class="col-sm-3">
						<?php echo ($creator_user_name); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">更多说明</label>
					<div class="col-sm-8" style="margin-top: 10px">
						<textarea name="description" class="form-control" cols="80" style="min-height:150px;"></textarea>
					</div>
				</div>
				<p class="form-title">
					考核内容
				</p>
				<div class="form-group">
					<label for="insurance_type" class="col-sm-2 control-label">考核详细</label>
					<div class="col-sm-9" id="itembox">
						<table class="table table-bordered">
							<tr>
								<td>名称</td>
								<td>标准分</td>
								<td>评分范围</td>
								<td>评分细则</td>
								<td width="1%"><input style="margin-left: 15px" type="button" id="additem" class="btn btn-primary btn-xs" value="+" /></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-3">
						<input name="submit" class="btn btn-primary" type="submit" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="button" class="btn" value="取消" onclick="javascript:history.go(-1);"/>
					</div>
				</div>
			</form>	
		</div>
	</div>
</div>
<div class="clear"></div>
<script>
	/**
	 * 添加绩效考核评分细则
	**/
	$(function(){
		var num = 1;
		$('#additem').click(function(){
			var str = '<tr><td>';
			str += '<input type="text" name="score_name['+num+']"/></td><td><input  type="text" name="standard_score['+num+']"/></td><td><input type="text" name="low_scope['+num+']" />&nbsp;至&nbsp;<input type="text" name="high_scope['+num+']" /></td><td><textarea name="score_description['+num+']" /></td><td width="1%"><input type="button"  style="margin-left: 15px" class="btn btn-primary btn-xs deleteitem" value="-" /></td></tr>';
			$(this).parent().parent().parent().append(str);
			num++;
		});
		$('#itembox').on('click','.deleteitem',function(){
			$(this).parent().parent().remove();
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