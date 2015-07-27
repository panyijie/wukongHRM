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
		<div class="row-table-title">编辑请假条</div>
		<div class="row-table-body">
			<form class="form-horizontal " action="<?php echo U('hrm/leave/edit');?>" method="post">
				<input type="hidden" name="id" value="<?php echo ($leave["leave_id"]); ?>"/>
				<p class="form-title">编辑请假条&nbsp;&nbsp;<a href="javascript:history.go(-1);">返回</a></p>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">请假人</label>
                    <div class="col-sm-3">
                        <?php echo ($leave["maker_user_name"]); ?>
                    </div>
				</div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">交接人</label>
                    <div class="col-sm-3">
                        <input type="hidden" name="make_user_id" id="make_user_id" value="<?php echo ($leave["maker_user_id"]); ?>" />
                        <input type="hidden" name="user_id" id="from_user_id" value="<?php echo ($leave["entrust_user_id"]); ?>" />
                        <input class="form-control" type="text" name="user_name" id="from_name" readonly="true" value="<?php echo ($leave["entrust_user_name"]); ?>"/>
                    </div>
                </div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">类型</label>
                    <input type="hidden" id="leave_category_id" value="<?php echo ($leave["leave_category_id"]); ?>" />
					<div class="col-sm-3">
						<select id="leave_select"  class="form-control" name="leave_category_id">
						</select>
					</div>
                    <label for="name" class="col-sm-2 control-label">剩余年假</label>
                    <div class="col-sm-2">
                        <input class="form-control" value="<?php echo ($annual_leave); ?>" type="text" name="annual_leave" id="input_annual_leave_day" readonly="true"/>
                    </div>
                    <label for="name" class="col-sm-1" style="margin-left: -30px">天</label>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">开始时间</label>
					<div class="col-sm-2">
                        <input type="hidden" name="start_time" id="start_time_post" value="" />
                        <input type="hidden" id="start_time_id" value="<?php echo (date('Y-m-d H:i:s',$leave["start_time"])); ?>" />
						<input class="form-control" type="text" id="d4311" onFocus="WdatePicker({maxDate:$('#d4312').val(),minDate:'%y-%M-%d', dateFmt:'yyyy-MM-dd'})" value=""/>
					</div>
                    <div class="col-sm-2">
                        <select class="form-control" id="start_leave_time" style="margin-left: -30px" name="leave_date_time">
                            <option value="0" selected="selected">选择时间</option>
                            <option value="1">早上 9:00</option>
                            <option value="2">中午 12:00</option>
                            <option value="3">晚上 6:00</option>
                        </select>
                    </div>
					<label for="name" class="col-sm-1 control-label">结束时间</label>
					<div class="col-sm-2">
                        <input type="hidden" name="end_time" id="end_time_post" value="" />
                        <input type="hidden" id="end_time_id" value="<?php echo (date('Y-m-d H:i:s',$leave["end_time"])); ?>" />
						<input class="form-control" type="text" id="d4312" onFocus="WdatePicker({minDate:$('#d4311').val(),maxDate:'2020-10-01',dateFmt:'yyyy-MM-dd'})" value=""/>
					</div>
                    <div class="col-sm-2">
                        <select class="form-control" id="end_leave_time" style="margin-left: -30px" name="leave_date_time">
                            <option value="0" selected="selected">选择时间</option>
                            <option value="1">早上 9:00</option>
                            <option value="2">中午 12:00</option>
                            <option value="3">晚上 6:00</option>
                        </select>
                    </div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">计算结果</label>
					<div class="col-sm-3">
                        <input type="hidden" name="leave_days" id="leave_days" value="" />
                        <span id="time_day"></span>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">填写人</label>
					<div class="col-sm-3">
						<?php echo ($leave["maker_user_name"]); ?>
					</div>
				</div>
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">请假原因</label>
					<div class="col-sm-8">
						<textarea name="content" class="col-sm-6 form-control" style="min-height:150px;"><?php echo ($leave["content"]); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"></label>
					<div class="col-sm-3">
						<input name="submit" class="btn btn-primary" type="submit" value="保存"/>&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="button" class="btn" value="取消" onclick="javascript:history.go(-1);"/>
					</div>
				</div>
			</form>	
		</div>
	</div>
</div>
<div class="clear"></div>
<script>
	/**
	 * 选择员工
	 **/
    $('#from_name').click(function(){
        $('#alert').modal({
            show:true,
            remote:'<?php echo U("core/user/getfromuserrindex");?>'
        });
    });


    /**
     * select框选择（如果年假为0就不显示年假这一项）
     **/

    if($('#input_annual_leave_day').val() == 0){
        var selectHtml = "<option value='1' selected='selected'>事假</option>";
        selectHtml += "<option value='2'>病假</option><option value='4'>其他</option>";
        $('#leave_select').append(selectHtml);
    }else{
        var selectHtml = "<option value='1' selected='selected'>事假</option>";
        selectHtml += "<option value='2'>病假</option><option value='3'>年假</option><option value='4'>其他</option>";
        $('#leave_select').append(selectHtml);
    }

    $('#leave_select').val($('#leave_category_id').val());

    /**
     * 获取请假的开始时间和结束时间并对相应的时间进行显示上处理
     **/
    var startDate = $('#start_time_id').val().substring(0,10);
    var endDate = $('#end_time_id').val().substring(0,10);
    var startTime = $('#start_time_id').val().substring(11,19);
    var endTime = $('#end_time_id').val().substring(11,19);
    $('#d4311').val(startDate);
    $('#d4312').val(endDate);

    var timeJudge = function(time){
        if(time == "06:00:00"){
            return 1;
        }else if(time == "12:00:00"){
            return 2;
        }else if(time == "18:00:00"){
            return 3;
        }else{
            return 0;
        }
    };
    $('#start_leave_time').val(timeJudge(startTime));
    $('#end_leave_time').val(timeJudge(endTime));

    /**
     * 时间计算处理
     **/
    var getLeaveHour = function(){
        var start_time = $('#d4311').val();
        var end_time = $('#d4312').val();
        var start_leave_time = $('#start_leave_time').val();
        var end_leave_time = $('#end_leave_time').val();
        if(start_leave_time == 1){
            start_time += " 6:00:00";
        }else if(start_leave_time == 2){
            start_time += " 12:00:00";
        }else if(start_leave_time == 3){
            start_time += " 18:00:00";
        }

        if(end_leave_time == 1){
            end_time += " 6:00:00";
        }else if(end_leave_time == 2){
            end_time += " 12:00:00";
        }else if(end_leave_time == 3){
            end_time += " 18:00:00";
        }

        if('' != start_time && '' != end_time){
            temp_start_int = (new Date(start_time)).valueOf();
            temp_start_str = temp_start_int.toString();
            unix_start_time = temp_start_str.substring(0,10);
            temp_end_int = (new Date(end_time)).valueOf();
            temp_end_str = temp_end_int.toString();
            unix_end_time = temp_end_str.substring(0,10);
            unix_time = unix_end_time - unix_start_time;

            time_day = parseInt(unix_time/86400);
            time_hours = parseInt(unix_time/3600);

            if((time_hours <= 0 || '0' == start_leave_time || '0' == end_leave_time)){
                $("#leave_submit_input").attr('disabled', true);
                $('#time_day').css('color','red').html('请正确选择请假时间');
            }else if((time_hours == 12 && '3' == start_leave_time && '1' == end_leave_time)){
                $("#leave_submit_input").attr('disabled', true);
                $('#time_day').css('color','red').html('这是正常下班时间,不用请假');
            }else if(time_hours > 0 && start_leave_time != 0 && end_leave_time != 0){
                $("#leave_submit_input").attr('disabled',false);
                var leave_day = parseInt(time_hours/24);
                if(time_hours%24 == 6){
                    leave_day += 0.5;
                }else if(time_hours%24 == 12){
                    leave_day += 1;
                }else if(time_hours == 18){
                    leave_day += 0.5;
                }
                $('#time_day').css('color','black').html('共请假'+ leave_day + '天');
            }
            $('#start_time_post').val(unix_start_time);
            $('#end_time_post').val(unix_end_time);
            $('#leave_days').val(leave_day);
        }
    };

    window.onload = getLeaveHour();

    $('#d4312').bind('blur',getLeaveHour);

    $('#start_leave_time').bind('blur',getLeaveHour);

    $('#end_leave_time').bind('blur',getLeaveHour);

    $('#d4311').bind('blur',getLeaveHour);
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