<div class="sidebar">
    <div class="sidebar-nav">
        <?php $leftMenu = View::leftMenu($userInfo['permission'], $url);?>
        <?php foreach($leftMenu as $menu3):?>
        <ul class="metisMenu">
            <li class="active">
                <a href="#"><?php echo $menu3['name'];?><span class="glyphicon arrow"></span></a>
                <ul>
                    <?php foreach($menu3['sub'] as $menu4):?>
                        <li><a <?php if($menu4['url'] == $url):?>style="color: #ffffff;"<?php endif;?> href="<?php echo $menu4['url'];?>"><?php echo $menu4['name'];?></a></li>
                    <?php endforeach;?>
                </ul>
            </li>
        </ul>
        <?php endforeach;?>
    </div>
</div>