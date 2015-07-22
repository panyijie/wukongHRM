<?php if (!defined('THINK_PATH')) exit();?><div class="row-table">
	<div class="row-table-title"><a href="javascript:void(0);" class="close text-hide">移除</a><a href="javascript:void(0);" class="close edit text-hide ">编辑</a>公告通知</div>
	<div class="row-table-body">
		<?php if($top_announcement): ?><table class="table" style="margin-bottom:0px;">
			<thead>
				<tr>
					<th>
						<img src="__PUBLIC__/img/set_top.gif" />&nbsp;&nbsp;
						<a href="<?php echo U('core/announcement/view','id='.$top_announcement['announcement_id']);?>">
							<span style="color:#<?php echo ($top_announcement["color"]); ?>;font-size:14px;">
								<?php echo ($top_announcement['title']); ?>
							</span>
						</a>
					</th>
				</tr>
			</thead>
		</table><?php endif; ?>
		<div class="clear"></div>
		<table class="table">
			<tbody>
				<tr>
					<th>标题</th>
					<th>发布人</th>
					<th>日期</th>
				</tr>
				<?php if(is_array($list_announcement)): $i = 0; $__LIST__ = $list_announcement;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td><a href="<?php echo U('core/announcement/view','id='.$vo['announcement_id']);?>" style="color:#<?php echo ($vo["color"]); ?>"><?php echo ($vo["title"]); ?></td>
					<td><?php echo ($vo["creator_user_name"]); ?></td>
					<td><?php echo (date("Y-m-d",$vo["create_time"])); ?></td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
	</div>
</div>