<div class="content">

<div id="rightMain" class="col-md-12" role="main">

    <div class="btn-group">
   <?php if($pPermission['name'] != ''):?>
    <a href="/user/permission_list/<?php echo $pPermission['pid'];?>" type="button" class="btn btn-default">
        <span class="glyphicon glyphicon-arrow-left"></span> 返回
    </a>
    <?php endif;?>
    <a href="/user/permission_add/<?php echo $pPermission['id'];?>" type="button" class="btn btn-success">+ 添加菜单</a>
    </div>

    <div style="height: 30px;"></div>

    <b>父级：</b><?php if($pPermission['name'] == ''){ echo '顶级'; }else{ echo $pPermission['name'];}?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <b>level：</b><?php echo $pPermission['level'] + 1;?>

    <div style="height: 30px;"></div>

    <table class="table table-hover tbcloth">
        <thead>
        <tr>
            <th>名称</th>
            <th>URL</th>
            <th>状态</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($permissionList)):foreach($permissionList as $permission):?>
            <tr>
                <td><?php echo $permission['name'];?></td>
                <td><?php echo $permission['url'];?></td>
                <td><?php if($permission['status'] == 1) echo '启用'; else echo '禁用' ;?></td>
                <td><?php echo $permission['sort'];?></td>
                <td>
                    <a href="/user/permission_edit/<?php echo $permission['id'];?>/">修改</a>
                    <?php if(($pPermission['level'] + 1) < 4):?>
                    <a href="/user/permission_list/<?php echo $permission['id'];?>/">下级</a>
                    <?php endif;?>
                </td>
            </tr>
        <?php endforeach;endif;?>
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