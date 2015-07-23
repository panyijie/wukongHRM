<?php if (!defined('THINK_PATH')) exit();?><div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel"><?php echo ($position_info["name"]); ?>权限编辑</h4>
	</div>
	<form class="form"  action="<?php echo U('core/user/editcontrol');?>" method="post">
		<div class="modal-body form-horizontal">
			<ul class="nav nav-tabs">
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$g): $mod = ($i % 2 );++$i;?><li class="<?php if(($i) == "1"): ?>active<?php endif; ?>"><a href="#<?php echo ($key); ?>" data-toggle="tab"><?php echo C('APP_GROUP_NAME.'.strtolower($key));?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			<div class="tab-content">
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$g): $mod = ($i % 2 );++$i;?><div class="tab-pane <?php if(($i) == "1"): ?>active<?php endif; ?>" id="<?php echo ($key); ?>">
					<table class="table table-striped">
						<tbody>
							<?php if(is_array($g)): $i = 0; $__LIST__ = $g;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><tr>
								<td align="right"><?php echo ($module_name[$key]); ?><input type="checkbox" name="check_all"  rel="<?php echo ($key); ?>" class="check_all"/></td>
								<td width="80%">
									<?php if(is_array($m)): $i = 0; $__LIST__ = $m;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$a): $mod = ($i % 2 );++$i; echo ($a["name"]); ?><input type="checkbox" class="<?php echo ($a["m"]); ?>" name="control_arr[]" <?php if(in_array($a['control_id'], $position_info['control_ids'])){ echo 'checked="checked"';} ?>  value="<?php echo ($a["control_id"]); ?>"/>&nbsp;&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>
		<div class="modal-footer">
			<input type="hidden" name="position_id" value="<?php echo ($position_info["position_id"]); ?>" />
			<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
			<input type="submit" class="btn btn-primary" value="保存" />
		</div>
	</form>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$(".check_all").click(function(){
			var rel = $(this).attr('rel');
			$("input[class='"+rel+"']").prop('checked', $(this).prop("checked"));
		});
	});
</script>