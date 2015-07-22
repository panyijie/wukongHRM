<?php if (!defined('THINK_PATH')) exit();?><div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel"><b>操作列表</b></h4>
		</div>
		<div class="modal-body form-horizontal">
			<ul class="nav nav-tabs">
				<?php if(is_array($controlList)): $i = 0; $__LIST__ = $controlList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$g): $mod = ($i % 2 );++$i;?><li class="<?php if(($i) == "1"): ?>active<?php endif; ?>"><a href="#<?php echo ($key); ?>" data-toggle="tab"><?php echo C('APP_GROUP_NAME.'.strtolower($key));?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			<div class="tab-content">
				<?php if(is_array($controlList)): $i = 0; $__LIST__ = $controlList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$g): $mod = ($i % 2 );++$i;?><div class="tab-pane <?php if(($i) == "1"): ?>active<?php endif; ?>" id="<?php echo ($key); ?>">
					<table class="table table-striped">
						<tbody>
							<?php if(is_array($g)): $i = 0; $__LIST__ = $g;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($i % 2 );++$i;?><tr>
								<td align="right"><?php echo ($module_name[$key]); ?></td>
								<td width="80%">
									<?php if(is_array($m)): $i = 0; $__LIST__ = $m;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$a): $mod = ($i % 2 );++$i;?><input type="radio" name="control" value="<?php echo ($a["control_id"]); ?>" <?php if($default_display == $a['control_id']): ?>checked="checked"<?php endif; ?> />
										<span><?php echo ($a["name"]); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>
		<div class="modal-footer">
			<input type="submit" id="default_display_submit" class="btn btn-primary" value="确定" />
			<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
		</div>
	</div>
</div>
<script type="text/javascript">
	/**
	 * 将选择的值传递到上个界面
	 *
	 **/
	$('#default_display_submit').click(function(){
		var item = $("input:radio[name='control']:checked").val();
		$("input[name='default_display']").val(item);
		var control_name = $('input:radio[name="control"]:checked').next().html();
		$("input[name='default_display_name']").val(control_name);
		$('#alert').modal('hide');
	});
</script>