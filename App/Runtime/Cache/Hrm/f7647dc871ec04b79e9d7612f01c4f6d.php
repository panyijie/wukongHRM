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
    .form-group-left{
        float: left;
        width: 130px;
        padding-left: 50px;
        margin-right: 10px;
    }

    .form-group-button{
        margin-top: -10px;
    }

    .form-group-button input{
        width: 30px;
        height: 30px;
        border-radius: 15px;
        border: none;
        outline: none;
        margin:10px 0 0 6px;
        color: #FFFFFF;
        background-color: #745fff;
        /*background-color: #744ae0;*/
    }

    .form-group-button input:hover{

        background-color: #744ae0;
    }

    .form-group-right{
        width: 700px;
        height: auto;
        min-height: 60px;
        padding:0 10px;
        float: left;
    }

    .form-group-right-child{
        padding: 5px 0 10px 0;
        border-top: 1px solid #cccccc;
    }

    .form-group-right-child-fir{
        padding-bottom: 10px;
    }
    .form-group-right input{
        width: 600px;
        height: 30px;
        padding-left: 5px;
        margin-top: 5px;
    }

    hr{
        margin: 20px 20px 0 0;
    }
</style>
<div class="body-right">
    <div class="row-table">
        <div class="row-table-title">详细KPI制定</div>
        <div class="row-table-body">
            <form class="form-horizontal" id="J_submit_form" action="<?php echo U('hrm/appraisalmanager/getDetailAsk');?>" method="post">
                <input type="hidden" class="j_managerId" name="managerId" value="<?php echo ($managerId); ?>" />
                <input type="hidden" class="j_numLen" name="numLen" value="" />
                <p class="form-title">
                    详细KPI制定&nbsp;&nbsp;<a href="javascript:history.go(-1);">返回</a>&nbsp;&nbsp;
                </p>
                <div class="j_form-group">
                    <?php if(is_array($scoreList)): $i = 0; $__LIST__ = $scoreList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="form-group">
                            <div class="form-group-left">
                                <div style="text-align: center"><?php echo ($vo); ?></div>
                                <div class="form-group-button">
                                    <input class="j_input-plus" type="button" value="+"/>
                                    <input class="j_input-minus" type="button" value="-"/>
                                </div>
                            </div>
                            <div class="form-group-right">
                                <div class="form-group-right-child-fir">
                                    <div><span>考核条目：</span><input name="form-group-right" placeholder="此处填写详细KPI计划，左边按钮可加减计划条目"/></div>
                                    <div><span>衡量标准：</span><input name="form-group-right" placeholder="对应条目的衡量标准"/></div>
                                </div>
                            </div>
                            <div style="clear: both"></div>
                            <hr/>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-3">
                        <input class="btn btn-primary j_submit" type="button" value="确定"/>&nbsp;&nbsp;&nbsp;&nbsp;
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
        $(".j_form-group").children(j).append('<div class="j_description'+ (i+1) +'"><input type="hidden" name="description'+ (i+1) +'"/></div>');
    }
    $(".j_numLen").val(voLen);

    $('.j_input-plus').click(function(){
        $(this).parent().parent().next().append('<div class="form-group-right-child"><div><span>考核条目：</span><input name="form-group-right" placeholder="此处填写详细KPI计划，左边按钮可加减计划条目"/></div><div><span>衡量标准：</span><input name="form-group-right" placeholder="对应条目的衡量标准"/></div></div>');
    });

    $('.j_input-minus').click(function(){
        var inputNum = $(this).parent().parent().next().children().length;
        if(inputNum <= 1){
            alert("至少保留一项KPI条目");
        }else{
            $(this).parent().parent().next().children()[inputNum-1].remove();
        }
    });

    $(".j_submit").click(function(){
        var formGroup = $(".j_form-group");
        var formNum = formGroup.children().length;
        for(var i=0; i<formNum; i++){
            var str = ":eq(" + i + ")";
            var inputNum = formGroup.children(str).children(":eq(1)").children().length;
            var desClassName = ".j_description" + (i+1);
            var desStr = "";
            console.log(inputNum);
            for(var j=0; j<inputNum; j++){
                var inputStr = ":eq(" + j + ")";
                var inputVal = formGroup.children(str).children(":eq(1)").children(inputStr).children(":eq(0)").children(":eq(1)").val() + "^^" + formGroup.children(str).children(":eq(1)").children(inputStr).children(":eq(1)").children(":eq(1)").val();
                console.log(inputVal);
                if(inputVal == "" || inputVal == null){
                    continue;
                }else{
                    desStr += inputVal + "$$";
                }
            }
            $(desClassName).children(":eq(0)").val(desStr);
        }
        $("#J_submit_form").submit();
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