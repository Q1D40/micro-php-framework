<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta charset="utf-8">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title><?php echo $title?></title>
<link rel="icon" href="/public/img/icon_32.png" type="image/x-icon">
<link rel='stylesheet' href='/public/bootstrap/css/bootstrap.min.css' />
<link rel='stylesheet' href='/public/bootstrap/css/bootstrap-datetimepicker.min.css' />
<link rel='stylesheet' href='/public/bootstrap/css/bootstrap-select.min.css' />
<link rel='stylesheet' href='/public/bootstrap/css/bootstrap-switch.min.css' />
<link rel='stylesheet' href='/public/bootstrap/css/tablecloth.css' >
<link rel='stylesheet' href='/public/bootstrap/css/prettify.css' >
<link rel='stylesheet' href='/public/bootstrap/css/bootstrap-combobox.css' >
<link rel='stylesheet' href='/public/bootstrap/css/metisMenu.min.css' >
<link rel='stylesheet' href='/public/css/main.css' />
<script src="/public/js/jquery-1.9.1.min.js"></script>
</head>
<body>


<div class="navbar navbar-inverse navbar-fixed-top">

    <div class="container">

        <div class="navbar-header">
            <a href="/user/welcome" class="navbar-brand" style="background:url(/public/img/logo_50.png) no-repeat;" onMouseover="shake(this,'onmouseout');">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
        </div>

    <div id="bs-example-navbar-collapse-8" class="collapse navbar-collapse">
        <?php $menuLine = View::menuLine($userInfo['permission'], @$url);?>
        <?php $topMenu = View::topMenu($userInfo['permission']);?>
        <?php foreach($topMenu as $menu1):?>
        <ul class="nav navbar-nav">
            <li class="dropdown <?php if($menuLine['m1']['id'] == $menu1['id']):?>active<?php endif;?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php if(@$menuLine['m1']['id'] == $menu1['id']):?><?php echo @$menuLine['m2']['name'];?><?php else:?><?php echo $menu1['name'];?><?php endif;?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php foreach($menu1['sub'] as $menu2):?>
                    <li><a href="<?php echo $menu2['url'];?>"><?php echo $menu2['name'];?></a></li>
                    <?php endforeach;?>
                </ul>
            </li>
        </ul>
        <?php endforeach;?>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown active">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $userInfo['userName'];?><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#" data-toggle="modal" data-target="#cant">修改密码</a></li>
                    <li><a href="/user/logout">登出</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</div>

<div id="cant" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">提示</h4>
            </div>
            <div class="modal-body">
                <h3><p style="text-align:center;">此功能暂未开放&hellip;</p></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php if(defined('DEBUG')):?>
    <div class="navbar-fixed-top" style="height: 5px; background: red;"></div>
<?php endif;?>
