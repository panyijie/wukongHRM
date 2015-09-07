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
<style type="text/css">
    .col-sm-3{
        margin-top: 6px;
    }

    .export-select{
        margin: 6px 15px 0 0;
    }
</style>
<div class="body-right">
	<div class="row-table">
		<div class="row-table-title">导出请假信息</div>
		<div class="row-table-body">
			<form class="form-horizontal" method="post">
				<p class="form-title">导出请假信息设置&nbsp;&nbsp;<a href="javascript:history.go(-1);">返回</a></p>
				<div class="form-group" style="margin-top: 50px">
					<label for="name" class="col-sm-2 control-label">操作人</label>
                    <div class="col-sm-3">
                        <?php echo session('name');?>
                    </div>
				</div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">选择时间</label>
                    <div class="col-sm-3">
                        <input type="hidden" id="submit_start_time" name="search_start_time" value=""/>
                        <input type="hidden" id="submit_end_time" name="search_end_time" value=""/>
                        <select id="leave_select" class="form-control" name="leave_select">
                        </select>
                    </div>
                </div>
				<div class="form-group" style="margin-top: 50px;">
                    <input type="hidden" value="<?php echo ($leave[0]["start_time"]); ?>" id="leave_item"/>
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-3">
						<input name="submit" id="leave_submit_input" class="btn btn-primary" type="submit" value="导出"/>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="button" class="btn" value="取消" onclick="javascript:history.go(-1);"/>
					</div>
				</div>
			</form>	
		</div>
	</div>
<div class="clear"></div>
<script>
	/**
	 * 选择员工
	 **/
	$('#to_name').click(function(){
		$('#alert').modal({
			show:true,
			remote:'<?php echo U("core/user/getuserindex");?>'
		});
	});

    //js中时间戳转换成时间的函数
    function getLocalTime(nS) {
        return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
    }

    $(document).ready(function(){
        var originalTime = getLocalTime($("#leave_item").val()).substring(0,11).split('/');
        var timeNow = new Date();
        var yearNow = timeNow.getFullYear();
        var monthNow = timeNow.getMonth()+1;
        var fullMonth = 12;
        var selectHtml = "";
        if(originalTime[0] == yearNow){
            if(originalTime[1] == monthNow){
                $('#leave_select').append("<option value="+yearNow+"-"+monthNow+">"+yearNow+"-"+monthNow+"</option>");
            }else{

                while(originalTime[1]<=monthNow){
                    selectHtml += "<option value="+yearNow+"-"+monthNow+">"+yearNow+"-"+monthNow+"</option>";
                    monthNow--;
                }
                $('#leave_select').append(selectHtml);
            }
        }else{
            while(monthNow >=1){
                selectHtml += "<option value="+yearNow+"-"+monthNow+">"+yearNow+"-"+monthNow+"</option>";
                monthNow--;
            }
            while(originalTime[0]+1 <= yearNow-1){
                for(var i=12; i>=1; i--){
                    selectHtml += "<option value="+(yearNow-1)+"-"+i+">"+(yearNow-1)+"-"+i+"</option>";
                }
                yearNow--;
            }

            while(originalTime[1]<=fullMonth){
                selectHtml += "<option value="+originalTime[0]+"-"+fullMonth+">"+originalTime[0]+"-"+fullMonth+"</option>";
                fullMonth--;
            }
            $('#leave_select').append(selectHtml);
        }
    });


    $('#leave_submit_input').click(function(e){
        var leaveTime = $('#leave_select').val().split("-");
        var startLeave = [];
        startLeave.push(leaveTime[0]);
        if(leaveTime[1]<10){
            var startMonth = "0"+leaveTime[1];
            startLeave.push(startMonth);
            startLeave.push("01");
        }

        var endLeave = [];
        endLeave.push(leaveTime[0]);
        if(leaveTime[1]<10){
            leaveTime[1]++;
            var endMonth = "0"+leaveTime[1];
            endLeave.push(endMonth);
            endLeave.push("01");
        }

        $("#submit_start_time").val(startLeave.join("-"));
        $("#submit_end_time").val(endLeave.join("-"));
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