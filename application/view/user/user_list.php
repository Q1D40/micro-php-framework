<div class="content">

<div id="rightMain" class="col-md-12" role="main">

    <a href="/user/user_add/" type="button" class="btn btn-success">+ 添加用户</a>

    <div style="height: 30px;"></div>

    <table class="table table-hover tbcloth">
        <thead>
        <tr>
            <th>用户名</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($userList as $user):?>
            <tr>
                <td><?php echo $user['userName'];?></td>
                <td><?php if($user['status'] == 1) echo '启用'; else echo '禁用' ;?></td>
                <td>
                    <a href="/user/user_edit/<?php echo $user['uid'];?>/">修改</a>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>



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