<?php if (!defined('THINK_PATH')) exit();?><div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel"><b>模板列表</b></h4>
		</div>
		<div class="modal-body form-horizontal">
			<table class="table table-striped">
				<thead>
					<tr>
						<td>选择</td>
						<td>名称</td>
						<td>类型</td>
						<td>创建人</td>
						<td>创建时间</td>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($templatelist)): $i = 0; $__LIST__ = $templatelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td><input type="radio" name="appraisal_template_id" value="<?php echo ($vo["appraisal_template_id"]); ?>" /></td>
							<td><?php echo ($vo["name"]); ?></td>
							<td><?php echo ($vo["category"]["name"]); ?></td>
							<td><?php echo ($vo["creator_user_name"]); ?></td>
							<td><?php echo (date('Y-m-d',$vo["create_time"])); ?></td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
			<div class="modal-footer">
				<input type="button" id="template_submit" class="btn btn-primary" value="确定" />
				<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	/**
	 * 
	 * 父页面通过设置ID： dialog_template_id 和 dialog_template_name 来接收数据
	 *
	 **/
	$('#template_submit').click(function(){
		var item = $("input:radio[name='appraisal_template_id']:checked").val();
		$("#dialog_template_id").val(item);
		var template_name = $('input:radio[name="appraisal_template_id"]:checked').parent().next().html();
		$("#dialog_template_name").val(template_name);
		$('#alert').modal('hide');
	});
</script>