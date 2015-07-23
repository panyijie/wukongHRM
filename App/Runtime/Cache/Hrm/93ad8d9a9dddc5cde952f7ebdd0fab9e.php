<?php if (!defined('THINK_PATH')) exit();?><table class="table table-bordered table-striped">
	<tr>
		<?php if(is_array($table_header)): $i = 0; $__LIST__ = $table_header;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><th><?php echo ($vo); ?></th><?php endforeach; endif; else: echo "" ;endif; ?>
	</tr>
	<?php if(is_array($department)): $i = 0; $__LIST__ = $department;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
			<?php if(is_array($table_header)): foreach($table_header as $d=>$o): ?><td><?php if($d == 0): echo ($v["name"]); else: echo (($data[$v['department_id']][$d])?($data[$v['department_id']][$d]):"0"); endif; ?></td><?php endforeach; endif; ?>
		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>