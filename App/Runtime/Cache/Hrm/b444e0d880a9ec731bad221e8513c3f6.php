<?php if (!defined('THINK_PATH')) exit();?><div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">绩效考核得分详情</h4>
		</div>
		<div class="modal-body form-horizontal">
			<table class="table table-bordered">
				<tr>
					<td>考核内容名称</td>
					<td>得分</td>
				</tr>
				<?php if(is_array($appraisalmanager['template']['score'])): $i = 0; $__LIST__ = $appraisalmanager['template']['score'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td><?php echo ($vo["name"]); ?></td>
					<td><?php echo ($preSocreAvgPoint[$vo['score_id']]); ?></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</table>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
		</div>
	</div>
</div>