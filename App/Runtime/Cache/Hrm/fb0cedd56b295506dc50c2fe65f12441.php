<?php if (!defined('THINK_PATH')) exit();?><div class="modal-dialog">
	<div class="modal-content">
		<form action="<?php echo U('hrm/structure/editPosition');?>" method="post" >
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">编辑岗位</h4>
		</div>
		<div class="modal-body form-horizontal">
			
				<div class="form-group">
					<label class="col-sm-4 control-label" for="name">岗位名称</label>
					<div class="col-sm-6">
						<input id="name" class="form-control" type="text" name="name" value="<?php echo ($position['name']); ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label" for="name">所属部门</label>
					<div class="col-sm-6">
						<select class="form-control" name="department_id" onchange="changeRoleContent(this.value)">
							<option value="0">请选择部门</option>
						<?php if(is_array($department_list)): $i = 0; $__LIST__ = $department_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["department_id"]); ?>" <?php if($position['department_id'] == $vo['department_id']): ?>selected="selected"<?php endif; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($vo["name"]); ?></option><br/><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label" for="name">上级岗位</label>
					<div class="col-sm-6">
						<select class="form-control" id="parent_id" name="parent_id">
							<option value="0">请选择岗位</option>
						<?php if(is_array($position_list)): $i = 0; $__LIST__ = $position_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["position_id"]); ?>" <?php if($position['parent_id'] == $vo['position_id']): ?>selected="selected"<?php endif; ?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label" for="name">编制人数</label>
					<div class="col-sm-6">
						<input id="name" class="form-control" type="text" name="plan_num" value="<?php echo ($position['plan_num']); ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label" for="name">在职人数</label>
					<div class="col-sm-6">
						<input id="name" class="form-control" type="text" name="real_num" value="<?php echo ($position["real_num"]); ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label" for="name">部门描述</label>
					<div class="col-sm-6">
						<textarea class="form-control" rows="2" name="description"><?php echo ($position["description"]); ?></textarea>
					</div>
				</div>
		</div>
		<div class="modal-footer">
			<input type="hidden" name="position_id" value="<?php echo ($position["position_id"]); ?>" />
			<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
			<input type="submit" class="btn btn-primary" value="保存" />
		</div>
		</form>
	</div>
</div>
<script type="text/javascript">
function changeRoleContent(department_id){
		if(department_id == ''){
			$("#parent_id").html('<option value="">请选择上级岗位</option>');
		}else{
			$.ajax({
				type:'get',
				url:'<?php echo U("hrm/structure/getPositionDepartment","id=");?>'+department_id,
				async:false,
				success:function(data){
					if(data){
						options = '<option value="">请选择上级岗位</option>';
						$.each(data, function(k, v){
							options += '<option value="'+v.position_id+'">'+v.name+'</option>';
						});
						$("#parent_id").html(options);
					}else{
						$("#parent_id").html('<option value="">请选择上级岗位</option>');
					}
				},
				dataType:'json'
			});		
		}
	}
</script>