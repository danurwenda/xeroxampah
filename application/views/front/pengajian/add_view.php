<?php
echo js_asset('jquery-ui.js', 'ace');
?>
<style>
    .ui-autocomplete{z-index: 3;}
    /*i'm sorry blind ppl*/
    .ui-helper-hidden-accessible { display:none; }
</style>
<div class="row">
    <div class="col-xs-12">
        <h3 class="header smaller lighter blue"><?php echo isset($edit_id) ? 'Ubah' : 'Tambah'; ?> Pengajian</h3>
        <div class="row">
            <?php echo form_open('pengajian', ['class' => 'form-horizontal', 'role' => 'form', 'id' => 'pengajian_form']); ?>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="topik">Topik :</label>

                <div class="col-xs-12 col-sm-9">
                    <div class="clearfix">
                        <input type="text" name="topik" id="topik" class="col-xs-12 col-sm-6" />
                    </div>
                </div>
            </div>

            <!--<div class="space-2"></div>-->

            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="masjid">Masjid :</label>

                <div class="col-xs-12 col-sm-9">
                    <div class="input-group">
                        <select style="width: 100%" class="form-control masjid-select2" name="masjid"></select>
                        <span class="input-group-addon" data-toggle="modal" data-target="#masjid-modal-form">
                            <i class="fa fa-plus bigger-110"></i>
                        </span>
                    </div> 
                </div>
            </div>

            <!--<div class="space-2"></div>-->

            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="pesantren">Pesantren :</label>

                <div class="col-xs-12 col-sm-9">
                    <div class="input-group">
                        <select style="width: 100%" class="form-control school-select2" name="pesantren"></select>
                        <span class="input-group-addon" data-toggle="modal" data-target="#school-modal-form">
                            <i class="fa fa-plus bigger-110"></i>
                        </span>
                    </div> 
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="topik">Lokasi :</label>

                <div class="col-xs-12 col-sm-9">
                    <div class="clearfix">
                        <input type="text" name="lokasi" id="lokasi" class="col-xs-12 col-sm-6" />
                    </div>
                </div>
            </div>
            <div class="clearfix form-actions col-xs-12 col-sm-12">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Submit
                    </button>
                </div>
            </div>
            </form>
        </div><!-- PAGE CONTENT ENDS -->

    </div>
</div>

<div id="masjid-modal-form" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger">Tambah Masjid</h4>
            </div>

            <div class="modal-body">
                <form class="row form-horizontal">
                    <div class="col-xs-12">
                        <!-- Name -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama </label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" />
                            </div>
                        </div>
                        <!-- Alamat -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Alamat </label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="address" />
                            </div>
                        </div>
                        <!-- Kota -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kota </label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="city" />
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-sm" data-dismiss="modal">
                    <i class="ace-icon fa fa-times"></i>
                    Cancel
                </button>

                <button class="btn btn-sm btn-primary">
                    <i class="ace-icon fa fa-check"></i>
                    Tambah
                </button>
            </div>
        </div>
    </div>
</div>

<div id="school-modal-form" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger">Tambah School</h4>
            </div>

            <div class="modal-body">
                <form class="row form-horizontal">
                    <div class="col-xs-12">
                        <!-- Name -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama </label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" />
                            </div>
                        </div>
                        <!-- Alamat -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Alamat </label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="address" />
                            </div>
                        </div>
                        <!-- Kota -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kota </label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="city" />
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-sm" data-dismiss="modal">
                    <i class="ace-icon fa fa-times"></i>
                    Cancel
                </button>

                <button class="btn btn-sm btn-primary">
                    <i class="ace-icon fa fa-check"></i>
                    Tambah
                </button>
            </div>
        </div>
    </div>
</div>


<?php
echo js_asset('jquery.validate.js', 'ace');
echo js_asset('pengajian/pengajian-form.js', 'polkam');
echo js_asset('pengajian/configs.js', 'polkam');
if (isset($edit_id)) {
    echo js_asset('pengajian/pengajian-load.js', 'polkam');
    ?>
    <!--load data and populate form-->
    <script>
        $(window).load(function () {
            load_pengajian(<?php echo $edit_id; ?>);
        });
    </script>
    <?php
}
?>

<!-- PAGE CONTENT ENDS -->