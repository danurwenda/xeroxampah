<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>
            <?php echo $title; ?>
        </title>

        <meta name="description" content="404 Error Page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <?php echo css_asset('bootstrap.css', 'ace'); ?>
        <?php echo css_asset('font-awesome.css', 'ace'); ?>

        <!-- page specific plugin styles -->

        <!-- text fonts -->
        <?php echo css_asset('ace-fonts.css', 'ace'); ?>

        <!-- ace styles -->
        <?php echo css_asset('ace.css', 'ace', ['class' => "ace-main-stylesheet", 'id' => "main-ace-style"]); ?>
        <!-- polkam styles -->
        <?php echo css_asset('polkam.css', 'polkam'); ?>
        <!-- inline styles related to this page -->

        <!--[if !IE]> -->
        <script type="text/javascript">
            window.jQuery || document.write("<script src='<?php echo js_asset_url('jquery.js', 'ace'); ?>'>" + "<" + "/script>");
            var base_url = '<?php echo base_url(); ?>';
        </script>

        <!-- <![endif]-->
        <!-- ace settings handler -->
        <?php echo js_asset('ace-extra.js', 'ace'); ?>
    </head>

    <body class="no-skin">
        <!-- #section:basics/navbar.layout -->
        <div id="navbar" class="navbar navbar-default">
            <script type="text/javascript">
                try {
                    ace.settings.check('navbar', 'fixed')
                } catch (e) {
                }
            </script>

            <div class="navbar-container" id="navbar-container">
                <!-- breadcrumbs-->
                <div class="breadcrumb-konten">
                    <a href="<?php echo site_url(); ?>" class="breadcrumb-left"> </a>
                    <div class="breadcrumb-mid">
                        <ul class="breadcrumb">
                            <?php echo $breadcrumb; ?>
                        </ul>
                    </div>
                    <div class="breadcrumb-right">
                    </div>
                </div>
                <!-- /.breadcrumb -->
                <!-- #section:basics/sidebar.mobile.toggle -->
                <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                    <span class="sr-only">Toggle sidebar</span>

                    <span class="icon-bar">
                    </span>

                    <span class="icon-bar">
                    </span>

                    <span class="icon-bar">
                    </span>
                </button>

                <!-- /section:basics/sidebar.mobile.toggle -->
                <div class="navbar-header pull-left">
                    <!-- #section:basics/navbar.layout.brand >
                    

                    <!-- /section:basics/navbar.layout.brand -->

                    <!-- #section:basics/navbar.toggle -->

                    <!-- /section:basics/navbar.toggle -->
                </div>
                <!-- #section:basics/navbar.dropdown -->
                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">
                        <?php
//                        print_r($topmenus);
                        foreach ($topmenus as $menu) {
                            if ($menu->module_id > 0) {
                                ?>
                                <li class="<?php echo $menu->module_name; ?>">
                                    <?php echo anchor($menu->module_name, ' ', array('title' => $menu->module_name)); ?>
                                </li>
                                <style>
                                    <?php echo ".ace-nav > li.$menu->module_name"; ?> a{
                                        background: url("<?php echo image_asset_url('menu_icon/' . $menu->icon, 'polkam'); ?>") 4px 2px no-repeat;
                                    }
                                    <?php echo ".ace-nav > li.$menu->module_name"; ?> a:hover{
                                        background: url("<?php echo image_asset_url('menu_icon/' . $menu->hover_icon, 'polkam'); ?>") 4px 2px no-repeat;
                                    }
                                </style>
                            <?php } else { ?>

                                <li class="infobox infobox-green">
                                    <a class="infobox-icon" href="<?php echo site_url('admin'); ?>">
                                        <i class="ace-icon fa fa-cogs" style="width: 42px;"></i>
                                    </a>
                                </li>
                            <?php }
                        }
                        ?>
                        <li class="logout"><?php echo anchor('auth/logout', ' ', array('title' => 'Keluar')); ?></li>
                    </ul>
                </div>

                <!-- /section:basics/navbar.dropdown -->
            </div>
            <!-- /.navbar-container -->
        </div>

        <!-- /section:basics/navbar.layout -->
        <div class="main-container" id="main-container">
            <script type="text/javascript">
                try {
                    ace.settings.check('main-container', 'fixed')
                } catch (e) {
                }
            </script>
            <!-- #section:basics/sidebar -->
            <div id="sidebar" class="sidebar                  responsive">
                <script type="text/javascript">
                    try {
                        ace.settings.check('sidebar', 'fixed')
                    } catch (e) {
                    }
                </script>

                <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                        <button class="btn btn-success">
                            <i class="ace-icon fa fa-signal"></i>
                        </button>

                        <button class="btn btn-info">
                            <i class="ace-icon fa fa-pencil"></i>
                        </button>

                        <!-- #section:basics/sidebar.layout.shortcuts -->
                        <button class="btn btn-warning">
                            <i class="ace-icon fa fa-users"></i>
                        </button>

                        <button class="btn btn-danger">
                            <i class="ace-icon fa fa-cogs"></i>
                        </button>

                        <!-- /section:basics/sidebar.layout.shortcuts -->
                    </div>

                    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                        <span class="btn btn-success"></span>

                        <span class="btn btn-info"></span>

                        <span class="btn btn-warning"></span>

                        <span class="btn btn-danger"></span>
                    </div>
                </div><!-- /.sidebar-shortcuts -->

                <ul class="nav nav-list">
                    <li class="">
                        <a href="<?php echo site_url('admin'); ?>">
                            <i class="menu-icon fa fa-tachometer"></i>
                            <span class="menu-text"> Dashboard </span>
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="<?php echo site_url('admin/grafik'); ?>">
                            <i class="menu-icon fa fa-desktop"></i>
                            <span class="menu-text"> 4 Panel Grafik </span>
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="" class="dropdown-toggle">
                            <i class="menu-icon fa fa-dropbox"></i>
                            <span class="menu-text"> Drop </span>

                            <b class="arrow fa fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>

                        <ul class="submenu">

                            <li class="">
                                <a href="<?php echo site_url('admin/grafik'); ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Buttons &amp; Icons
                                </a>

                                <b class="arrow"></b>
                            </li>
                            <li class="">
                                <a href="<?php echo site_url('admin/grafik'); ?>">
                                    <i class="menu-icon fa fa-caret-right"></i>
                                    Buttons &amp; Icons
                                </a>

                                <b class="arrow"></b>
                            </li>
                        </ul>
                    </li>
                </ul><!-- /.nav-list -->

                <!-- #section:basics/sidebar.layout.minimize -->
                <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
                </div>

                <!-- /section:basics/sidebar.layout.minimize -->
                <script type="text/javascript">
                    try {
                        ace.settings.check('sidebar', 'collapsed')
                    } catch (e) {
                    }
                </script>
            </div>

            <!-- /section:basics/sidebar -->
            <div class="main-content">
                <div class="main-content-inner">
                    <!-- #section:basics/content.breadcrumbs -->
                    <div class="breadcrumbs" id="breadcrumbs">
                        <script type="text/javascript">
                            try {
                                ace.settings.check('breadcrumbs', 'fixed')
                            } catch (e) {
                            }
                        </script>
                        <!-- #section:basics/content.searchbox -->
                        <div class="nav-search" id="nav-search">
                            <form class="form-search">
                                <span class="input-icon">
                                    <input type="text" placeholder="Search ..." class="typeahead nav-search-input" data-provide="typeahead" id="nav-search-input" autocomplete="off" />
                                    <i class="ace-icon fa fa-search nav-search-icon">
                                    </i>
                                </span>
                            </form>
                        </div>
                        <!-- /.nav-search -->

                        <!-- /section:basics/content.searchbox -->
                    </div>

                    <!-- /section:basics/content.breadcrumbs -->
                    <div class="page-content">
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
<?php echo $_content; ?>

                                <!-- PAGE CONTENT ENDS -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.page-content -->
                </div>
            </div>
            <!-- /.main-content -->           

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110">
                </i>
            </a>
        </div>
        <!-- /.main-container -->

        <!-- basic scripts -->



        <!--[if IE]>
<script type="text/javascript">
window.jQuery || document.write("<script src='../assets/js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
        <script type="text/javascript">
            if ('ontouchstart' in document.documentElement)
                document.write("<script src='<?php echo js_asset_url('jquery.mobile.custom.js', 'ace'); ?>'>" + "<" + "/script>");
        </script>
<?php echo js_asset('bootstrap.js', 'ace'); ?>

        <!-- page specific plugin scripts -->
        <script type="text/javascript">/* typeahead on search box top right*/
            $(function () {
                $('#nav-search-input').typeahead({
                    source: function (query, process) {
                        return $.get(base_url + 'indikator/search?q=' + query, function (data) {
                            return process(JSON.parse(data));
                        });
                    },
                    displayText: function (i) {
                        return i.indikator_name;
                    },
                    afterSelect: function (i) {
                        location.href = base_url + 'indikator/' + i.indikator_id;
                    },
                    //                    updater: function (item) {
                    //when an item is selected from dropdown menu, focus back to input element
                    //                        $('#nav-search-input').focus();
                    //                        return item;
                    //                    }
                });
            });</script>

        <!-- ace scripts -->
        <?php echo js_asset('ace/elements.scroller.js', 'ace'); ?>
        <?php echo js_asset('ace/elements.colorpicker.js', 'ace'); ?>
        <?php echo js_asset('ace/elements.fileinput.js', 'ace'); ?>
        <?php // echo js_asset('ace/elements.typeahead.js', 'ace'); ?>
        <?php echo js_asset('ace/elements.wysiwyg.js', 'ace'); ?>
        <?php echo js_asset('ace/elements.spinner.js', 'ace'); ?>
        <?php echo js_asset('ace/elements.treeview.js', 'ace'); ?>
        <?php echo js_asset('ace/elements.wizard.js', 'ace'); ?>
        <?php echo js_asset('ace/elements.aside.js', 'ace'); ?>
        <?php echo js_asset('ace/ace.js', 'ace'); ?>
        <?php echo js_asset('ace/ace.ajax-content.js', 'ace'); ?>
        <?php echo js_asset('ace/ace.touch-drag.js', 'ace'); ?>
        <?php echo js_asset('ace/ace.sidebar.js', 'ace'); ?>
        <?php echo js_asset('ace/ace.sidebar-scroll-1.js', 'ace'); ?>
        <?php echo js_asset('ace/ace.submenu-hover.js', 'ace'); ?>
        <?php echo js_asset('ace/ace.widget-box.js', 'ace'); ?>
        <?php echo js_asset('ace/ace.settings.js', 'ace'); ?>
        <?php echo js_asset('ace/ace.settings-rtl.js', 'ace'); ?>
        <?php echo js_asset('ace/ace.settings-skin.js', 'ace'); ?>
        <?php echo js_asset('ace/ace.widget-on-reload.js', 'ace'); ?>
        <?php echo js_asset('typeahead.bs3.js', 'polkam'); ?>
        <?php // echo js_asset('polkam.js', 'polkam'); ?>
        <?php // echo js_asset('ace/ace.searchbox-autocomplete.js', 'ace');     ?>
        <!-- inline scripts related to this page -->
<?php echo js_asset('notify.min.js', 'polkam'); ?>

    </body>
</html>
