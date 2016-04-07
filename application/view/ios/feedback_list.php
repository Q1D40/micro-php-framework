<div class="content">

<div id="rightMain" class="col-md-12" role="main">
    <div class="alert alert-warning <?php if($error == ''):?>hide<?php else:?>fade in<?php endif;?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $error;?>
    </div>
    <form id="searchForm" role="form" action="" method="POST">
        <div class="row">
            <div class="col-md-2">
                <input type="text" name="startDate" class="form-control datetimepicker" value="<?php echo $startDate;?>">
            </div>
            <div class="col-md-2">
                <input type="text" name="endDate" class="form-control datetimepicker" value="<?php echo $endDate;?>">
            </div>

            <div class="col-md-2">
                <input type="text" name="content" class="form-control" placeholder="反馈意见" value="<?php echo $content;?>">
            </div>
            <div class="btn-group col-md-2">
                <button id="searchbtn" type="button" class="btn btn-primary">查询</button>
                <button id="newPageSearchBtn" type="button" class="btn btn-primary">在新页面查询</button>
            </div>
            <input type="hidden" id="actHidden" name="act" value="search">
            <input type="hidden" id="page" name="page" value="1">
        </div>
    </form>

    <div style="height: 30px;"></div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>日期</th>
            <th>联系方式</th>
            <th style="width: 600px;">反馈意见</th>
        </tr>
        </thead>
        <tbody>
            <?php if(is_array(@$feedbackList)):foreach(@$feedbackList as $feedback):?>
                <tr>
                    <td><?php echo date('Y-m-d H:i:s', $feedback['timeStamp']);?></td>
                    <td><?php echo $feedback['contact'];?></td>
                    <td><?php echo $feedback['content'];?></td>
                </tr>
            <?php endforeach;endif;?>
        </tbody>
    </table>

    <div style="height: 30px;"></div>

    <div class="form-inline">
        <ul class="pagination">
            <?php if(@$page['pre'] > 0):?>
                <li page="<?php echo @$page['pre'];?>"><a href="#">上一页</a></li>
            <?php else:?>
                <li class="disabled"><a href="#">上一页</a></li>
            <?php endif;?>

            <?php if(is_array(@$page['left'])):foreach(@$page['left'] as $row):?>
                <?php if(@$row == '...'):?>
                    <li class="disabled"><a href="#">...</a></li>
                <?php else:?>
                    <li page="<?php echo $row;?>"><a href="#"><?php echo $row;?></a></li>
                <?php endif;?>
            <?php endforeach;endif;?>

            <li class="active"><a href="#"><?php echo @$page['current'];?> <span class="sr-only">(current)</span></a></li>

            <?php if(is_array(@$page['right'])):foreach(@$page['right'] as $row):?>
                <?php if($row == '...'):?>
                    <li class="disabled"><a href="#">...</a></li>
                <?php else:?>
                    <li page="<?php echo $row;?>"><a href="#"><?php echo $row;?></a></li>
                <?php endif;?>
            <?php endforeach;endif;?>

            <?php if(@$page['next'] > 0):?>
                <li page="<?php echo @$page['next'];?>"><a href="#">下一页</a></li>
            <?php else:?>
                <li class="disabled"><a href="#">下一页</a></li>
            <?php endif;?>
        </ul>
        <input id="jumpPageTxt" type="text" class="form-control" placeholder="页" style="width:45px; position:relative;top:-33px;">
        <a id="jumpPageBtn" href="#" type="button" class="btn btn-danger" style="position:relative;top:-33px;">GO!</a>
        <span style="color:#999999; font-size:18px; position:relative;top:-30px;">共<?php echo $count;?>条 <?php echo $allPage;?>页</span>
    </div>

</div>

</div>

<script>
    $("#searchbtn").click(function(){
        $("#actHidden").val("search");
        $("#searchForm").attr("target", "_self")
        $("#searchForm").submit();
    });
    $("#newPageSearchBtn").click(function(){
        $("#actHidden").val("search");
        $("#searchForm").attr("target", "_blank")
        $("#searchForm").submit();
    });
    $("#exportBtn").click(function(){
        $("#actHidden").val("export");
        $("#searchForm").attr("target", "_blank")
        $("#searchForm").submit();
    });
    $(".pagination li").click(function(){
        if($(this).attr("class") != 'disabled' && $(this).attr("class") != 'active'){
            $("#page").val($(this).attr("page"));
            $("#searchForm").attr("target", "_self")
            $("#searchForm").submit();
        }
    });
    $("#jumpPageBtn").click(function(){
        $("#page").val($("#jumpPageTxt").val());
        $("#searchForm").attr("target", "_self")
        $("#searchForm").submit();
    });

</script>