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
<style type="text/css">
    .summary-title{
        width: 100%;
        height: 35px;
        text-align: center;
        margin: 20px 0 0 0;
        font: 25px bolder;

    }
</style>
<div class="body-right">
    <div class="row-table">
        <div class="row-table-title">绩效考核详情</div>
        <div class="row-table-body form-horizontal">
            <p class="form-title">
                绩效考核详情&nbsp;&nbsp;
                <a href="<?php echo U('hrm/appraisalmanager/index');?>">返回</a>&nbsp;&nbsp;
            </p>
            <div class="form-group">
                <div class="summary-title"><?php echo ($appraisal_manager["name"]); ?></div>
            </div>
            <div class="form-group">
                <div class="col-sm-3" style="text-align: center">
                    考核责任人：<?php echo ($examinee_user["name"]); ?>
                </div>
                <div class="col-sm-3" style="text-align: center">
                    考核主管：<?php echo ($examiner_user["name"]); ?>
                </div>
                <div class="col-sm-2" style="text-align: center">
                    考核得分：<?php echo ($result_avg); ?>
                </div>
                <div class="col-sm-4" style="text-align: center">
                    时间段：<?php echo (date('Y-m-d',$appraisal_manager["start_time"])); ?>&nbsp;~&nbsp;<?php echo (date('Y-m-d',$appraisal_manager["end_time"])); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12" id="itembox">
                    <table class="table table-bordered">
                        <tr>
                            <?php if(is_array($appraisal_score)): $i = 0; $__LIST__ = $appraisal_score;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$score_name): $mod = ($i % 2 );++$i;?><td width="33%" colspan="2"><?php echo ($score_name["name"]); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tr>
                        <tr>
                            <?php if(is_array($appraisal_score)): $i = 0; $__LIST__ = $appraisal_score;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$score_description): $mod = ($i % 2 );++$i;?><td colspan="2"><?php echo ($score_description["description"]); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tr>
                        <tr class="j_kpi-detail">
                            <?php if(is_array($appraisal_score)): $i = 0; $__LIST__ = $appraisal_score;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$score_examinee_point): $mod = ($i % 2 );++$i;?><td class="col-sm-1" style="vertical-align: middle">考评细则</td>
                                <td>
                                    <input type="hidden" value="<?php echo ($score_examinee_point['examineePoint'][0]["kpi_detail"]); ?>"/>
                                </td><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tr>
                        <tr>
                            <td colspan="2">自我评价</td>
                            <td colspan="2">自我评价</td>
                            <td colspan="2">自我评价</td>
                        </tr>
                        <tr>
                            <?php if(is_array($appraisal_score)): $i = 0; $__LIST__ = $appraisal_score;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$score_examinee_point): $mod = ($i % 2 );++$i;?><td class="col-sm-1">评分</td>
                                <td><?php echo ($score_examinee_point['examineePoint'][0]["point"]); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tr>
                        <tr>
                            <?php if(is_array($appraisal_score)): $i = 0; $__LIST__ = $appraisal_score;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$score_examinee_point): $mod = ($i % 2 );++$i;?><td class="col-sm-1">自我评价</td>
                                <td><?php echo ($score_examinee_point['examineePoint'][0]["comment"]); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tr>
                        <tr>
                            <td colspan="2">主管评价</td>
                            <td colspan="2">主管评价</td>
                            <td colspan="2">主管评价</td>
                        </tr>
                        <tr>
                            <?php if(is_array($appraisal_score)): $i = 0; $__LIST__ = $appraisal_score;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$score_examiner_point): $mod = ($i % 2 );++$i;?><td class="col-sm-1">评分</td>
                                <td><?php echo ($score_examiner_point['examinerPoint'][0]["point"]); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tr>
                        <tr>
                            <?php if(is_array($appraisal_score)): $i = 0; $__LIST__ = $appraisal_score;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$score_examiner_point): $mod = ($i % 2 );++$i;?><td class="col-sm-1">主管评价</td>
                                <td><?php echo ($score_examiner_point['examinerPoint'][0]["comment"]); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<script type="text/javascript">
    /**
     * 得分详细
     **/
    $(".detail_results").click(function(){
        var id = $(this).attr('rel');
        var uid = $(this).attr('value');
        $('#alert').modal({
            show:true,
            remote:"<?php echo U('hrm/appraisalpoint/detailResults','id=');?>"+id+'&uid='+uid
        });
    });

    $(document).ready(function(){
        var kpiDetail = $('.j_kpi-detail');
        var childNum = kpiDetail.children().length;
        for(var i=1; i<childNum; i=i+2){
            var str = ":eq(" + i + ")";
            var kpiArr = kpiDetail.children(str).children(":eq(0)").val().split("$$");
            var kpiStr = "";
            for(var j=0; j<kpiArr.length-1; j++){
                kpiStr += "<p style='text-align: left'>" + (j+1) + "." + kpiArr[j] + "</p>";
            }
            kpiDetail.children(str).append(kpiStr);
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