<div class="content">

<div id="rightMain" class="col-md-12" role="main">
    <div class="alert alert-warning <?php if($error == ''):?>hide<?php else:?>fade in<?php endif;?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <?php echo $error;?>
    </div>

    <a href="/user/user_list/" type="button" class="btn btn-default col-md-1">
        <span class="glyphicon glyphicon-arrow-left"></span> 返回
    </a>
    <div style="height: 50px;"></div>

    <form method="post" class="form-horizontal" role="form">
        <div class="form-group">
        <div class="col-md-4">
            <input type="text" name="userName" class="form-control" placeholder="用户名" value="<?php echo @$user['userName'];?>">
        </div>
        <div class="col-md-4">
            <input type="text" name="passWord" autoComplete="off" class="form-control" placeholder="密码" value="">
        </div>
        <div class="col-md-4">
            <input type="checkbox" class="switch myswitch" data-on="success" data-off="danger" name="status" value="1" <?php if(@$user['status'] == 1):?>checked<?php endif;?> />
        </div>
        </div>

        <div class="form-group">
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary form-control">保存</button>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <nav class="nav">
                        <ul class="metisFolder">
                            <li>
                                <a href="#">
                                    菜单
                                </a>
                                <?php foreach($permissionTree as $l1):?>
                                    <ul class="collapse in">
                                        <li>
                                            <a href="#" style="display:inline-block;"><?php echo $l1['name'];?></a>
                                            <input type="checkbox" class="switch switch-mini myswitch" name="permission[]" value="<?php echo $l1['id'];?>" <?php if(in_array($l1['id'], $user['permission'])):?>checked<?php endif;?> />
                                            <?php foreach($l1['sub'] as $l2):?>
                                                <ul class="collapse in">
                                                    <li>
                                                        <a href="#" style="display:inline-block;"><?php echo $l2['name'];?></a>
                                                        <input type="checkbox" class="switch switch-mini myswitch" name="permission[]" value="<?php echo $l2['id'];?>" <?php if(in_array($l2['id'], $user['permission'])):?>checked<?php endif;?> />
                                                        <?php foreach($l2['sub'] as $l3):?>
                                                            <ul class="collapse in">
                                                                <li>
                                                                    <a href="#" style="display:inline-block;"><?php echo $l3['name'];?></a>
                                                                    <input type="checkbox" class="switch switch-mini myswitch" name="permission[]" value="<?php echo $l3['id'];?>" <?php if(in_array($l3['id'], $user['permission'])):?>checked<?php endif;?> />
                                                                    <?php foreach($l3['sub'] as $l4):?>
                                                                        <ul class="collapse in">
                                                                            <li>
                                                                                <a href="#" style="display:inline-block;"><?php echo $l4['name'];?></a>
                                                                                <input type="checkbox" class="switch switch-mini myswitch" name="permission[]" value="<?php echo $l4['id'];?>" <?php if(in_array($l4['id'], $user['permission'])):?>checked<?php endif;?> />
                                                                            </li>
                                                                        </ul>
                                                                    <?php endforeach;?>
                                                                </li>
                                                            </ul>
                                                        <?php endforeach;?>
                                                    </li>
                                                </ul>
                                            <?php endforeach;?>
                                        </li>
                                    </ul>
                                <?php endforeach;?>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

    </form>
</div>

</div>