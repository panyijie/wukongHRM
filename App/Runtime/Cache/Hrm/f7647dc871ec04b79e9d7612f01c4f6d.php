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
<script src="__PUBLIC__/js/datepicker/WdatePicker.js"></script>
<div class="body-right">
    <div class="row-table">
        <div class="row-table-title">详细KPI制定</div>
        <div class="row-table-body">
            <form class="form-horizontal" action="<?php echo U('hrm/appraisalmanager/getDetailAsk');?>" method="post">
                <input type="hidden" class="j_managerId" name="managerId" value="<?php echo ($managerId); ?>" />
                <input type="hidden" class="j_numLen" name="numLen" value="" />
                <p class="form-title">
                    详细KPI制定&nbsp;&nbsp;<a href="javascript:history.go(-1);">返回</a>&nbsp;&nbsp;
                </p>
                <div class="j_form-group">
                    <?php if(is_array($scoreList)): $i = 0; $__LIST__ = $scoreList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="form-group">
                            <label for="name" class="col-sm-2 control-label"><?php echo ($vo); ?></label>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-3">
                        <input name="submit" class="btn btn-primary" type="submit" value="确定"/>&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" class="btn" value="取消" onclick="javascript:history.go(-1);"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="clear"></div>
<script type="text/javascript">
    var voLen = $(".j_form-group").children().length;
    for(var i=0; i<voLen; i++){
        var j = ":eq("+ i + ")";
        $(".j_form-group").children(j).append('<div class="col-sm-8" style="margin-top: 10px"><textarea name="description'+ (i+1) +'" class="form-control" cols="80" style="min-height:150px;"></textarea></div>');
    }
    $(".j_numLen").val(voLen);
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