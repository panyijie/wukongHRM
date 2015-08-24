<?php if (!defined('THINK_PATH')) exit();?><div class="row-table">
	<div class="row-table-title"><a href="javascript:void(0);" class="close text-hide">移除</a><a href="javascript:void(0);" class="close edit text-hide ">编辑</a>未读信息</div>
	<div class="row-table-body">
		<div class="clear"></div>
		<table class="table">
			<tbody>
				<tr>
					<th>标题</th>
					<th>发件人</th>
					<th>日期</th>
				</tr>
				<?php if(is_array($message_list)): $i = 0; $__LIST__ = $message_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td><a href="<?php echo U('core/message/view','id='.$vo['message_id']);?>"><?php echo ($vo["title"]); ?></a></td>
					<td><?php echo ($vo["name"]); ?></td>
					<td><?php echo (date("Y-m-d",$vo["send_time"])); ?></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
	</div>
</div>