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
		<div class="row-table-title">绩效考核评分</div>
		<div class="row-table-body form-horizontal">
			<form method="post" action="<?php echo U('hrm/appraisalpoint/edit');?>">
				<input type="hidden" name="id" value="<?php echo ($appraisalmanager["appraisal_manager_id"]); ?>" />
				<p class="form-title">
					绩效考核评分&nbsp;&nbsp;
					<a href="javascript:void(0);" onclick="close_page()">退出</a>
					<input type="submit" style="margin-top: 7px" class="pull-right btn btn-primary btn-xs" value="提交">
				</p>
				<!-- CSS用了内嵌样式，待修改 -->
				<div class="form-group">
					<div class="col-sm-12" style="text-align:center;font-size: 20px;margin-top: 15px;"><b><?php echo ($appraisalmanager["name"]); ?></b></div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-3 control-label">启动时间：<?php echo (date('Y-m-d',$appraisalmanager["start_time"])); ?></label>
					<label for="name" class="col-sm-3 control-label">截止时间：<?php echo (date('Y-m-d',$appraisalmanager["end_time"])); ?></label>
					<label for="name" class="col-sm-2 control-label">类型：<?php echo ($appraisalmanager["template"]["category"]["name"]); ?></label>
					<label for="name" class="col-sm-3 control-label">
						考核对象：
						<select name="examinee_user_id">
							<?php if(is_array($appraisalmanager['examinee_user'])): $i = 0; $__LIST__ = $appraisalmanager['examinee_user'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(!in_array($vo['user_id'], $have_point_user)): ?><option value="<?php echo ($vo['user_id']); ?>"><?php echo ($vo["name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</label>
				</div>
                <?php if('3' == $appraisalmanager['status']): ?><div class="form-group">
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <tr>
                                    <?php if(is_array($appraisalmanager['template']['score'])): $i = 0; $__LIST__ = $appraisalmanager['template']['score'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><td colspan="2" width="33%"><?php echo ($vo["name"]); ?></td>
                                        <input class="j_score-id" value="<?php echo ($vo["score_id"]); ?>" type="hidden"/><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tr>
                                <tr>
                                    <?php if(is_array($appraisalmanager['template']['score'])): $i = 0; $__LIST__ = $appraisalmanager['template']['score'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><td class="col-sm-1" style="vertical-align: middle">测试项简介</td>
                                        <td style="vertical-align: middle;text-align: left"><?php echo ($vo["description"]); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tr>
                                <tr class="j_tr-control">
                                    <?php if(is_array($appraisalmanager['template']['score'])): $i = 0; $__LIST__ = $appraisalmanager['template']['score'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><td class="col-sm-1" style="vertical-align: middle">详细指标</td>
                                        <td class="kpi-detail<?php echo ($vo["score_id"]); ?>" style="text-align: left; vertical-align: middle">
                                            <input type="hidden" value="<?php echo ($vo["kpiDetail"]); ?>"/>
                                        </td><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tr>
                                <tr>
                                    <?php if(is_array($pointdetail)): $i = 0; $__LIST__ = $pointdetail;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><td class="col-sm-1" style="vertical-align: middle">自评得分</td>
                                        <td style="vertical-align: middle;"><?php echo ($vo["point"]); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tr>
                                <tr>
                                    <?php if(is_array($pointdetail)): $i = 0; $__LIST__ = $pointdetail;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><td class="col-sm-1" style="vertical-align: middle">自评陈述</td>
                                        <td style="vertical-align: middle;"><?php echo ($vo["comment"]); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tr>
                                <tr>
                                    <?php if(is_array($appraisalmanager['template']['score'])): $i = 0; $__LIST__ = $appraisalmanager['template']['score'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><td class="col-sm-1" style="vertical-align: middle">主管评分</td>
                                        <td style="vertical-align: middle;"><input type="text" name="point[<?php echo ($vo["score_id"]); ?>]" style="width: 100px; height: 30px; margin-bottom: 8px;" /></td><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tr>
                                <tr>
                                    <?php if(is_array($pointdetail)): $i = 0; $__LIST__ = $pointdetail;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><td class="col-sm-1" style="vertical-align: middle">主管评述</td>
                                        <td style="vertical-align: middle;">
                                            <textarea cols="25" style="height: 300px; margin: 0px 0px 10px 15px" class="form-control" name="comment[<?php echo ($vo["score_id"]); ?>]"></textarea>
                                        </td><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tr>
                            </table>
                        </div>
                    </div>
                <?php else: ?>
				<div class="form-group">
					<div class="col-sm-12" id="itembox">
						<table class="table table-bordered j_table">
							<tr>
								<td class="col-sm-1">考核内容</td>
								<td class="col-sm-1">考核简介</td>
                                <td class="col-sm-2">考核细则</td>
								<td class="col-sm-1">标准分</td>
								<td class="col-sm-1">评分范围</td>
								<td class="col-sm-1">得分</td>
								<td class="col-sm-2">评语</td>
							</tr>
							<?php if(is_array($appraisalmanager['template']['score'])): $i = 0; $__LIST__ = $appraisalmanager['template']['score'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td style="vertical-align: middle">
                                    <?php echo ($vo["name"]); ?>
                                    <input class="j_score-id" value="<?php echo ($vo["score_id"]); ?>" type="hidden"/>
                                </td>
								<td style="vertical-align: middle"><?php echo ($vo["description"]); ?></td>
                                <td class="kpi-detail<?php echo ($vo["score_id"]); ?>" style="text-align: left; vertical-align: middle">
                                    <input type="hidden" value="<?php echo ($vo["kpiDetail"]); ?>"/>
                                </td>
								<td style="vertical-align: middle"><?php echo ($vo["standard_score"]); ?></td>
								<td style="vertical-align: middle"><?php echo ($vo["low_scope"]); ?>&nbsp;至&nbsp;<?php echo ($vo["high_scope"]); ?></td>
								<td style="vertical-align: middle"><input type="text" name="point[<?php echo ($vo["score_id"]); ?>]" class="form-control" /></td>
								<td style="vertical-align: middle"><textarea cols="25" style="height: 300px; margin: 0px 0px 10px 15px" class="form-control" name="comment[<?php echo ($vo["score_id"]); ?>]"></textarea></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
						</table>
					</div>
				</div><?php endif; ?>
			</form>
		</div>
	</div>
</div>
<div class="clear"></div>
<script type="text/javascript">
	function close_page(){
		if(confirm('确定要关闭页面，退出本次打分吗？')){
			window.close();
		}
	}

    $(document).ready(function(){
        var scoreId = parseInt($(".j_score-id").val());
        var trNum = ($(".j_table").children().children().length-2) + scoreId;
        for(var i=scoreId; i<=trNum; i++){
            var kpiClass = ".kpi-detail" + i;
            var kpiDetailArr = $(kpiClass).children(":eq(0)").val().split("$$");
            var kpiDetail = "";
            for(var j=0; j<kpiDetailArr.length-1; j++){
                if(kpiDetailArr[j] != "^^"){
                    kpiDetail += "<p>" + (j+1) + "." + kpiDetailArr[j].split("^^")[0] + "</p>";
                    kpiDetail += "<p style='color: red; margin-top: -9px;'>(考核标准:" + kpiDetailArr[j].split("^^")[1] + ")</p>";
                }else{
                    kpiDetail += "无";
                }

            }
            $(kpiClass).append(kpiDetail);
        }


        var tr = $('.j_tr-control');
        var tdNum = tr.children().length/2;
        for(var k=scoreId; k<scoreId+tdNum; k++){
            var strClass = ".kpi-detail" + k;
            var kpiDetailArr = $(strClass).children(":eq(0)").val().split("$$");
            var kpiDetail = "";
            for(var l=0; l<kpiDetailArr.length-1; l++){
                kpiDetail += "<p>" + (l+1) + "." + kpiDetailArr[l].split("^^")[0] + "</p>";
                kpiDetail += "<p style='color: red; margin-top: -9px;'>(考核标准:" + kpiDetailArr[l].split("^^")[1] + ")</p>";
            }
            $(strClass).append(kpiDetail);
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