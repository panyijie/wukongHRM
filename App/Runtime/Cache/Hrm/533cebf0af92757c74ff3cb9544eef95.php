<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<title><?php echo C('defaultinfo.name');?> - Powered By 悟空HRM</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="description" content=""/>
		<meta name="author" content="悟空HRM"/>
		<link rel="shortcut icon" href="__PUBLIC__/ico/favicon.png"/>
		<link rel="stylesheet" href="__PUBLIC__/css/bootstrap.css">
		<link rel="stylesheet" href="__PUBLIC__/css/hrms.css">
		<script src="__PUBLIC__/js/jquery.min.js"></script>
		<script src="__PUBLIC__/js/bootstrap.min.js"></script>
		<script src="__PUBLIC__/js/nongli.js"></script>
		<script src="__PUBLIC__/js/calendar.js"></script>
		<!--[if lt IE 9]>
		<script src="__PUBLIC__/js/html5shiv.min.js"></script>
		<script src="__PUBLIC__/js/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
<?php echo W('Navigation');?>
<div class="body-right">
	<div class="row-table">
		<div class="row-table-title">在线评分</div>
		<div class="row-table-body">
			<p class="form-title">在线评分</p>
			<?php if(empty($appraisalpoint) && empty(appraisalexaminerpoint)): ?><div>---暂无数据---</div>
			<?php else: ?>
			<form class="form-horizontal " id="form1"  method="post">
				<table class="table" style="margin-bottom:0px;">
					<tbody>
						<tr>
							<th>考核名称</th>
							<th>类型</th>
							<th>启用时间</th>
							<th>截止时间</th>
							<th>状态</th>
							<th>待评分人数</th>
							<th>操作</th>
						</tr>
						<?php if(is_array($appraisalpoint)): $i = 0; $__LIST__ = $appraisalpoint;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
							<td><a href="<?php echo U('hrm/appraisalmanager/view','id='.$vo['appraisal_manager_id']);?>" target="_blank"><?php echo ($vo["name"]); ?></a></td>
							<td><?php echo ($vo["template"]["category"]["name"]); ?></td>
							<td><?php echo (date('Y-m-d',$vo["start_time"])); ?></td>
							<td><?php echo (date('Y-m-d',$vo["end_time"])); ?></td>
							<td><?php echo ($vo["status_name"]); ?></td>
							<td><?php echo ($vo["not_appraisal_user_num"]); ?></td>
							<td>
								<a class="j_point-a" href="javascript:void(0)">评分</a>
                                <input type="hidden" value="<?php echo U('hrm/appraisalpoint/edit','id='.$vo['appraisal_manager_id']);?>"/>
                                <input type="hidden" value="<?php echo ($vo["session_user_name"]); ?>"/>
                                <input type="hidden" value="<?php echo ($vo["examiner_user_name"]); ?>"/>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        <?php if(is_array($appraisalexaminerpoint)): $i = 0; $__LIST__ = $appraisalexaminerpoint;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                <td><a href="<?php echo U('hrm/appraisalmanager/view','id='.$vo['appraisal_manager_id']);?>" target="_blank"><?php echo ($vo["name"]); ?></a></td>
                                <td><?php echo ($vo["template"]["category"]["name"]); ?></td>
                                <td><?php echo (date('Y-m-d',$vo["start_time"])); ?></td>
                                <td><?php echo (date('Y-m-d',$vo["end_time"])); ?></td>
                                <td><?php echo ($vo["status_name"]); ?></td>
                                <td><?php echo ($vo["not_appraisal_user_num"]); ?></td>
                                <td>
                                    <a class="j_point-a" href="javascript:void(0)">评分</a>
                                    <input type="hidden" value="<?php echo U('hrm/appraisalpoint/edit','id='.$vo['appraisal_manager_id']);?>"/>
                                    <input type="hidden" value="<?php echo ($vo["session_user_name"]); ?>"/>
                                    <input type="hidden" value="<?php echo ($vo["examiner_user_name"]); ?>"/>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        <?php if(is_array($appraisalpoint_1)): $i = 0; $__LIST__ = $appraisalpoint_1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                <td><a href="<?php echo U('hrm/appraisalmanager/view','id='.$vo['appraisal_manager_id']);?>" target="_blank"><?php echo ($vo["name"]); ?></a></td>
                                <td><?php echo ($vo["template"]["category"]["name"]); ?></td>
                                <td><?php echo (date('Y-m-d',$vo["start_time"])); ?></td>
                                <td><?php echo (date('Y-m-d',$vo["end_time"])); ?></td>
                                <td><?php echo ($vo["status_name"]); ?></td>
                                <td><?php echo ($vo["not_appraisal_user_num"]); ?></td>
                                <td>
                                    <a class="j_point-a" href="javascript:void(0)">编辑</a>&nbsp;|&nbsp;
                                    <a class="j_point-a" href="javascript:void(0)">确认</a>
                                    <input type="hidden" value="<?php echo U('hrm/appraisalpoint/edit','id='.$vo['appraisal_manager_id']);?>"/>
                                    <input type="hidden" value="<?php echo ($vo["session_user_name"]); ?>"/>
                                    <input type="hidden" value="<?php echo ($vo["examiner_user_name"]); ?>"/>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        <?php if(is_array($appraisalexaminerpoint_1)): $i = 0; $__LIST__ = $appraisalexaminerpoint_1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                <td><a href="<?php echo U('hrm/appraisalmanager/view','id='.$vo['appraisal_manager_id']);?>" target="_blank"><?php echo ($vo["name"]); ?></a></td>
                                <td><?php echo ($vo["template"]["category"]["name"]); ?></td>
                                <td><?php echo (date('Y-m-d',$vo["start_time"])); ?></td>
                                <td><?php echo (date('Y-m-d',$vo["end_time"])); ?></td>
                                <td><?php echo ($vo["status_name"]); ?></td>
                                <td><?php echo ($vo["not_appraisal_user_num"]); ?></td>
                                <td>
                                    <a class="j_point-a" href="javascript:void(0)">评分</a>
                                    <input type="hidden" value="<?php echo U('hrm/appraisalpoint/edit','id='.$vo['appraisal_manager_id']);?>"/>
                                    <input type="hidden" value="<?php echo ($vo["session_user_name"]); ?>"/>
                                    <input type="hidden" value="<?php echo ($vo["examiner_user_name"]); ?>"/>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="7" align="center"><?php echo ($page); ?><div class="clear"></div></td>
						</tr>
					</tfoot>
				</table>
			</form><?php endif; ?>
		</div>
	</div>
</div>
<div class="clear"></div>
        <script type="text/javascript">
            var pointA = $('.j_point-a');
            pointA.click(function(){
                if(pointA.next().next().val() == pointA.next().next().next().val().split(',')[1] && pointA.parent().prev().prev().html() == "被考核者评分中"){
                    alert("被考核者评分中,请等候被考核者自评完毕后再进行评分");
                }else{
                    window.location.href = pointA.next().val();
                }
            });
        </script>
<div class="modal fade" id="alert" tabindex="-1" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">提示信息</h4>
			</div>
			<div class="modal-body">
			<?php if(is_array($alert)): foreach($alert as $k=>$v): if(is_array($v)): foreach($v as $kk=>$vv): ?><div class="alert alert-<?php echo ($k); ?>">
					<?php echo ($vv); ?>
				</div><?php endforeach; endif; endforeach; endif; ?>
			</div>
		</div>
	</div>
</div>
<?php if(!empty($alert)): ?><script type="text/javascript">
	$('#alert').modal('show');
	var alert_n = setInterval('$("#alert").modal("hide")',1000);
	$('#alert').on('hide.bs.modal', function (e) {
		clearInterval(alert_n);
	});
</script><?php endif; ?>
		<!-- <div id="footer">
			<div class="container">
				<p class="text-muted credit">
					悟空HRM © 2013 <a href="http://www.ccds24.com" target="_blank">河南锐骑文化传播有限公司</a>版权所有
				</p>
			</div>
		</div> -->
	</body>
</html>