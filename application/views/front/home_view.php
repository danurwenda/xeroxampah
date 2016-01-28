<div id="main-content">
    <ul class="main">
        <!-- #menu: all other menus -->
        <?php
        foreach ($menus as $i) {           
            ?>
            <li class="small-icon">               
                <a href="<?php echo site_url($i->alias); ?>">
                    <?php echo image_asset('menu_logo/' . $i->icon, 'polkam', ['alt' => $i->display_name]) ?>
                    <div class="small-icon-textdiv">
                        <span class="small-icon-text"><?php echo $i->display_name; ?></span>
                    </div>
                </a>
            </li>
        <?php } ?>
    </ul>
    <div class="clear">
    </div>
</div>
