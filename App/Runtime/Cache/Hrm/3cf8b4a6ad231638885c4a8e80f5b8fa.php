<?php if (!defined('THINK_PATH')) exit();?><div class="modal-dialog">
	<div class="modal-content">
		<form action="<?php echo U('hrm/structure/editDepartment');?>" method="post" >
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">编辑部门</h4>
		</div>
		<div class="modal-body form-horizontal">
				<div class="form-group">
					<label class="col-sm-4 control-label" for="name">部门名称</label>
					<div class="col-sm-6">
						<input id="name" class="form-control" type="text" name="name" value="<?php echo ($info["name"]); ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label" for="name">上级部门</label>
					<div class="col-sm-6">
						<select name="parent_id" class="form-control">
							<option value="0">请选择部门</option>
						<?php if(is_array($department_list)): $i = 0; $__LIST__ = $department_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["department_id"]); ?>" <?php if($info['parent_id'] == $vo['department_id']): ?>selected="selected"<?php endif; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label" for="name">部门描述</label>
					<div class="col-sm-6">
						<textarea class="form-control" rows="2" name="description"><?php echo ($info["description"]); ?></textarea>
					</div>
				</div>
		</div>
		<div class="modal-footer">
			<input type="hidden" name="department_id" value="<?php echo ($info["department_id"]); ?>">
			<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
			<input type="submit" class="btn btn-primary" value="保存" />
		</div>
		</form>
	</div>
</div>