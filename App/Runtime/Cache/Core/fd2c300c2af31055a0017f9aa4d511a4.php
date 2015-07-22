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
		<div class="row-table-title">公告管理</div>
		<div class="row-table-body">
			<p class="form-title">
				公告管理<a class="pull-right btn btn-primary btn-xs" href="<?php echo U('core/announcement/add');?>">发布公告</a>
				<form id="search_form" action="" method="get">
					<input type="hidden" name="g" value="core"/>
					<input type="hidden" name="m" value="announcement"/>
					<div class="form-inline" >
						<div class="form-group">
							标题&nbsp;
							<input type="text" class="form-control" id="search_title" name="search_title" />
						</div>&nbsp;&nbsp;
						<div class="form-group">
							内容&nbsp;
							<input type="text" class="form-control" id="search_content" name="search_content" />
						</div>&nbsp;&nbsp;
						<div class="form-group">
							发布人&nbsp;
							<input type="hidden" class="form-control" id="dialog_user_id" name="search_user_id" />
							<input type="text" class="form-control" id="dialog_user_name" name="search_user_name" />
						</div>&nbsp;&nbsp;
						<div class="form-group">
							状态&nbsp;
							<select class="form-control" id="search_status" name="search_status">
								<option value="">全部</option>
								<option value="1">发布中</option>
								<option value="2">停用</option>
							</select>
						</div>&nbsp;&nbsp;
						<div class="form-group">
							<input type="text" class="form-control" id="search_create_time" name="search_create_time" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" placeholder="发布时间"/>
						</div>
						<input type="button" class="btn search_btn" value="搜索" />
					</div>
				</form>
			</p>
			<?php if(empty($announcementlist)): ?><div>---暂无数据---</div>
			<?php else: ?>
			<form id="form1" action="" method="post">
				<table class="table" style="margin-bottom:0px;">
					<tbody>
						<tr>
							<th><input type="checkbox" id="check_all" /></th>
							<th>标题</th>
							<th>发布人</th>
							<th>发布时间</th>
							<th>状态</th>
							<th>置顶</th>
							<th>操作</th>
						</tr>
						<?php if(is_array($announcementlist)): $i = 0; $__LIST__ = $announcementlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td><input type="checkbox" class="check_list" name="id[]" value="<?php echo ($vo["announcement_id"]); ?>" /></td>
							<td><a href="<?php echo U('core/announcement/view','id='.$vo['announcement_id']);?>" style="color:#<?php echo ($vo["color"]); ?>"><?php echo ($vo["title"]); ?></a></td>
							<td><?php echo ($vo["creator_user_name"]); ?></td>
							<td><?php echo (date('Y-m-d H:i:s',$vo["create_time"])); ?></td>
							<td><?php echo ($vo["status_name"]); ?></td>
							<td><?php if('0' == $vo['set_top']): ?>否<?php elseif('1' == $vo['set_top']): ?>是<?php endif; ?></td>
							<td><a href="<?php echo U('core/announcement/edit','id='.$vo['announcement_id']);?>">编辑</a>&nbsp;|&nbsp;<a href="<?php echo U('core/announcement/delete','id='.$vo['announcement_id']);?>">删除</a></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
					<tfoot>
						<tr>
							<td><input class="btn btn-primary btn-xs" type="button" id="submit_delete" value="删除" /></td>
							<td colspan="6"><?php echo ($page); ?><div class="clear"></div></td>
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
	 */
	$("#check_all").click(function(){
		$("input[class='check_list']").prop('checked',$(this).prop('checked'));
	});
	
	/**
	 * 删除
	 */
	$("#submit_delete").click(function(){
		if(confirm('确认要删除么？')){
			$('#form1').attr('action', "<?php echo U('core/announcement/delete');?>");
			$('#form1').submit();
		}
	});
	
	/**
	 * 保留搜索项
	 */
	$("#search_title").prop('value', '<?php echo ($_GET['search_title']); ?>');
	$("#search_content").prop('value', '<?php echo ($_GET['search_content']); ?>');
	$("#dialog_user_name").prop('value', '<?php echo ($_GET['search_user_name']); ?>');
	$("#search_status").prop('value', '<?php echo ($_GET['search_status']); ?>');
	$("#search_create_time").prop('value', '<?php echo ($_GET['search_create_time']); ?>');
	
	$('#dialog_user_name').click(function(){
		$('#alert').modal({
				show:true,
				remote:'<?php echo U("core/user/getsubuserdialog", "self=1");?>'
			});
	});
	
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
			window.location.href="<?php echo U('core/announcement/index');?>";
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