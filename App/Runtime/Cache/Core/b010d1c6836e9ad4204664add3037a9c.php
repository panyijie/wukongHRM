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
								<td align="right"><?php echo ($module_name[$key]); ?><input type="checkbox" name="check_all"  rel="<?php echo ($key); ?>" class="check_all"/></td>
								<td width="80%">
									<?php if(is_array($m)): $i = 0; $__LIST__ = $m;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$a): $mod = ($i % 2 );++$i;?><input type="checkbox" name="control_name" class="<?php echo ($a["m"]); ?>" value="<?php echo ($a["control_id"]); ?>" <?php if(in_array($a['control_id'], $control_idsArr)): ?>checked="checked"<?php endif; ?>/>
										<span><?php echo ($a["name"]); ?></span>&nbsp;&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>
		<div class="modal-footer">
			<input type="submit" id="control_submit" class="btn btn-primary" value="确定" />
			<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
		</div>
	</div>
</div>
<script type="text/javascript">
	/**
	 * 全选
	 *
	 **/
	$(function(){
		$(".check_all").click(function(){
			var rel = $(this).attr('rel');
			$("input[class='"+rel+"']").prop('checked', $(this).prop("checked"));
		});
	});
	
	/**
	 * 将选择的值传递到上个界面
	 *
	 **/
	var item='';
	var control_name = "";
	$("#control_submit").click(function(){
		$("input:checkbox[name='control_name']:checked").each(function(index,e){
			if($("input:checkbox[name='control_name']:checked")){
				item += $(e).val() + ",";
			}
		});
		$("input[name='control_ids']").val(item);
		
		
		$("input:checkbox[name='control_name']:checked").each(function(index,e){
			if("input:checkbox[name='control_name']:checked"){
				control_name += $(e).next().html() + ","; 
			}
		});
		$("input[name='control_name']").val(control_name);
		$('#alert').modal('hide');
	});
</script>