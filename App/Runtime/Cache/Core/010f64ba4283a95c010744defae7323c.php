<?php if (!defined('THINK_PATH')) exit();?><div class="navbar-logo">
	<a href="<?php echo U('core/index/index');?>"><img class="img-responsive" src="<?php echo C('defaultinfo.logo');?>" alt="悟空HRMS"></a>
</div>
<div class="nav-top">
	<ul class="list-unstyled navbar-bg">
		<?php if(is_array($navigation)): $i = 0; $__LIST__ = $navigation;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li <?php if(in_array($info['control_id'],$vo['control_ids'])): ?>class="active"<?php endif; ?> >
				<a href="<?php echo ($vo['default_control']['url']); ?>"><?php echo ($vo["name"]); ?></a>
			</li><?php endforeach; endif; else: echo "" ;endif; ?>
		
	</ul>
	<ul class="list-unstyled pull-right navbar-bg navbar-none">
		<li>
			<?php echo session('name');?>, <span>您有<a href="<?php echo U('core/message/index');?>"><span id="message_tips">0</span></a>条新消息</span><span id="message_audio" style="display:none;"></span>
		</li>
		<li>
			<a href="<?php echo U('core/user/logout');?>">[退出]</a>
		</li>
	</ul>
	<div class="clear"></div>
</div>
<div class="bread-box">
	<div class="pull-right top-date" id="top-date"></div>
	<ul class="list-unstyled breadcrumb-hear">
		<li></li>
		<li><?php echo C('APP_GROUP_NAME.'.strtolower(GROUP_NAME));?></li>
		<li><?php echo ($module[strtolower(MODULE_NAME)]); ?></li>
		<li class="active"><?php echo ($control[$info['control_id']]['name']); ?></li>
	</ul>
</div>
<script type="text/javascript">
	$(function(){
		var nongli = drawCld(<?php echo date('Y,m,d');?>);
		$('#top-date').html(nongli.sYear+'年'+nongli.sMonth+'月'+nongli.sDay+'日星期'+nongli.week+'&nbsp;&nbsp;农历'+(nongli.isLeap?'闰 ':'')+nongli.lMonth+'月'+nongli.lDay+(nongli.solarTerms?'【'+nongli.solarTerms+'】':''));
	});
</script>
<div class="body-left" id="accordion">
	<?php if(is_array($navigation)): $i = 0; $__LIST__ = $navigation;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="panel nav-left">
		<div class="collapse-title <?php if(!in_array($info['control_id'],$vo['control_ids'])): ?>collapsed<?php endif; ?>" data-toggle="collapse" data-parent="#accordion" data-target="#collapse<?php echo ($vo["navigation_id"]); ?>">
			<?php echo ($vo["name"]); ?>
		</div>
		<div id="collapse<?php echo ($vo["navigation_id"]); ?>" class="panel-collapse collapse-body <?php if(in_array($info['control_id'],$vo['control_ids'])): ?>in<?php else: ?>collapse<?php endif; ?>">
			<?php if(is_array($vo["controls"])): $i = 0; $__LIST__ = $vo["controls"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if($v['is_display'] == 1): ?><div class="left-col"><a href="<?php echo ($v['url']); ?>" is="<?php echo ($v); ?>"><?php echo ($v['name']); ?></a></div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
			<div class="clear"></div>
		</div>
	</div><?php endforeach; endif; else: echo "" ;endif; ?>
	<div id="calendar" class="row-table">
		<div class="row-table-title">日历</div>
		<div class="row-body">
			<div id="date" class="cdate">
				<a id="preMonth" title="上一年"><img src="__PUBLIC__/img/calendar_n1.png"></a>
				<a id="preYear" title="上一月"><img src="__PUBLIC__/img/calendar_n2.png"></a>
				<span class="selectDate">
					<span class="selectY"></span>年<span class="selectM"></span>月
				</span>
				<a id="nextYear" title="下一月"><img src="__PUBLIC__/img/calendar_p2.png"></a>
				<a id="nextMonth" title="下一年"><img src="__PUBLIC__/img/calendar_p1.png"></a>
			</div>
			<table id="calTable" class='calTable'>
				<thead>
					<tr>
						<th>日</th>
						<th>一</th>
						<th>二</th>
						<th>三</th>
						<th>四</th>
						<th>五</th>
						<th>六</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
					</tr>
					<tr>
						<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
					</tr>
					<tr>
						<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
					</tr>
					<tr>
						<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
					</tr>
					<tr>
						<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
					</tr>
					<tr>
						<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	new Calendar("calTable", "date", <?php echo date('Y');?>, <?php echo date('m');?>, '<?php echo U("core/task/ajaxmonth");?>');
	a = 1;
	function fn(){
		if(a == 1){
			$('#message_tips').css({color:'white'});
			a = 0;
		}else{
			$('#message_tips').css({color:'#F00'});
			a = 1;
		}
	}
	var myInterval;
	
	/**
	 * ajax提醒
	 **/
	function message_tips(){
		$.get("<?php echo U('core/message/tips');?>", function(data){
			if(data.message != $('#message_tips').html()){
				$('#message_tips').css({color:'#F00'});
				myInterval = setInterval(fn,1000);
				$("#message_audio").html("<audio id='ttsoundplayer'  autoplay='autoplay'><source src='__PUBLIC__/sound/Global.wav' type='audio/wav'></audio>");
			} else {
				$("#message_audio").html('');
				if(data.message == 0){
					$('#message_tips').css({color:'#000'});
					clearInterval(myInterval);
				}
			}
			$('#message_tips').html(data.message);
		},'json');
		setTimeout('message_tips()',5000);
	}
	message_tips();
</script>