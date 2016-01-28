<div id="main-content">
    <ul class="main">
        <!-- #menu: all other menus -->
        <?php
        foreach ($indikators as $i) {
            //compute alerts from $i->leaves
            $redAlert = [];
            $yellowAlert = [];
            foreach ($i->leaves as $l) {
                //check whether its latest value surpasses any threshold
                //threshold comes in the form of array
                if ($l->latest_val > json_decode($l->threshold_vals)[0]) {
                    //red
                    $redAlert[] = $l;
                } else if ($l->latest_val > $l->forecast) {
                    //yellow
                    $yellowAlert[] = $l;
                }
            }
            $alertAll = array_merge($redAlert, $yellowAlert);
            ?>
            <li class="small-icon">
                <?php if (count($alertAll) > 0) { ?>
                    <ul class="warning">
                        <li>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="ace-icon fa <?php echo count($redAlert) > 0 ? 'red' : 'orange'; ?> fa-exclamation-triangle icon-animated-vertical">
                                </i>
                                <span class="badge badge-<?php echo count($redAlert) > 0 ? 'important' : 'warning'; ?>"><?php echo count($alertAll); ?></span>
                            </a>

                            <ul class="dropdown-menu-left dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                                <li class="dropdown-header">
                                    <i class="ace-icon fa fa-exclamation-triangle">
                                    </i>
                                    <?php echo count($alertAll); ?> Alerts
                                </li>

                                <li class="dropdown-content">
                                    <ul class="dropdown-menu dropdown-navbar navbar-pink">
                                        <?php foreach ($redAlert as $ralert) { ?>
                                            <li>
                                                <a href="<?php echo site_url('indikator/' . $ralert->indikator_id) ?>">
                                                    <div class="clearfix">
                                                        <span class="pull-left">
                                                            <i class="btn btn-xs no-hover btn-danger fa fa-exclamation-triangle"></i>
                                                            <?php echo $ralert->indikator_name; ?>
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php } foreach ($yellowAlert as $yalert) { ?>
                                            <li>
                                                <a href="<?php echo site_url('indikator/' . $yalert->indikator_id) ?>">
                                                    <div class="clearfix">
                                                        <span class="pull-left">
                                                            <i class="btn btn-xs no-hover btn-yellow fa fa-exclamation-triangle"></i>
                                                            <?php echo $yalert->indikator_name; ?>
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <?php } ?>

                <a href="<?php echo site_url('strategic/' . $i->indikator_id); ?>">
                    <?php echo image_asset('indikator_logo/' . $i->imgname, 'polkam', ['alt' => $i->indikator_name]) ?>
                    <div class="small-icon-textdiv">
                        <span class="small-icon-text"><?php echo $i->indikator_name; ?></span>
                    </div>
                </a>
            </li>
        <?php } ?>
    </ul>
    <div class="clear">
    </div>
</div>
