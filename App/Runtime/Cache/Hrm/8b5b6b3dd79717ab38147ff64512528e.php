<?php if (!defined('THINK_PATH')) exit();?><div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">选择员工</h4>
		</div>
		<div class="modal-body form-horizontal">
			<table class="table" style="margin-bottom:0px;">
				<tbody>
					<tr>
						<th><input type="checkbox" id="checkall"></th>
						<th>用户名</th>
						<th>性别</th>
						<th>部门 - 岗位</th>
						<th>手机</th>
						<th>Email</th>
					</tr>
					<?php if(is_array($userlist)): $i = 0; $__LIST__ = $userlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td><input type="checkbox" name="to_user_id[]" value="<?php echo ($vo["user_id"]); ?>"></td>
						<td><?php echo ($vo["name"]); ?></td>
						<td><?php if($vo['sex'] == 1): ?>男<?php elseif($vo['sex'] == 2): ?>女<?php else: ?>未知<?php endif; ?></td>
						<td><?php echo ($vo["department_name"]); ?> - <?php echo ($vo["position_name"]); ?></td>
						<td><?php echo ($vo["telephone"]); ?></td>
						<td><?php echo ($vo["email"]); ?></td>
					<tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
			<input type="button" class="btn btn-primary" id="check_ed" value="确定" />
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('#check_ed').click(function(){
			str = '';
			name = '';
			$("input[name='to_user_id[]']:checked").each(function(){
				str+=$(this).val()+",";
				name+=$(this).parent().next().html()+",";
            })
			$('#str_user_name').val(name);
			$('#str_user_id').val(str);
			$('#alert').modal('hide');
		});
		$("#checkall").click(function(){
			$("input[name='to_user_id[]']").prop('checked', $(this).prop("checked"));
		});
	});
</script>