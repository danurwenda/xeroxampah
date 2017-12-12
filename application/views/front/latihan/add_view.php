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
        <h3 class="header smaller lighter blue"><?php echo isset($edit_id) ? 'Ubah' : 'Tambah'; ?> Latihan Non Senjata</h3>
        <div class="row">
            <?php echo form_open('latihan', ['class' => 'form-horizontal', 'role' => 'form', 'id' => 'latihan_form']); ?>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Label :</label>

                <div class="col-xs-12 col-sm-9">
                    <div class="clearfix">
                        <input type="text" name="label" id="label" class="col-xs-12 col-sm-6" />
                    </div>
                </div>
            </div>
            <!-- Tempat -->
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Lokasi event </label>

                <div class="col-sm-9">
                    <div class="clearfix">
                        <input type="text" class="form-control" name="tempat" />
                        <div class="input-group">
                            <select style="width: 100%" class="form-control kotakab-select2" name="kotakab"></select>
                            <span class="input-group-addon" data-toggle="modal" data-target="#kotakab-modal-form">
                                <i class="fa fa-plus bigger-110"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tanggal -->
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sejak </label>

                <div class="col-sm-9">
                    <div class="clearfix">
                        <div class="input-group">
                            <input class="form-control combofulldate" name="sejak" type="text" data-format="YYYY-MM-DD" data-template="DD MMM YYYY" />

                        </div>
                    </div>
                </div>
            </div>
            <!-- Tanggal -->
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Hingga </label>

                <div class="col-sm-9">
                    <div class="clearfix">
                        <div class="input-group">
                            <input class="form-control combofulldate" name="hingga" type="text" data-format="YYYY-MM-DD" data-template="DD MMM YYYY" />

                        </div>
                    </div>
                </div>
            </div>
            <!-- Model Materi -->
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Materi </label>

                <div class="col-sm-9">
                    <div class="clearfix">
                        <textarea name="materi" class='autoExpand form-control' rows='1' data-min-rows='1'></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Motif -->
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Motif </label>

                <div class="col-sm-9">
                    <div class="clearfix">
                        <input type="text" class=" form-control" name="motif" />
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
<div id="kotakab-modal-form" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger">Tambah Kota</h4>
            </div>

            <div class="modal-body">
                <form class="row form-horizontal">
                    <div class="col-xs-12">
                        <!-- Kotakab -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kota/Kabupaten </label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="kotakab" />
                            </div>
                        </div>
                        <!-- Prov -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Provinsi </label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="prov" />
                            </div>
                        </div>
                        <!-- Negara -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Negara </label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="negara" />
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
echo js_asset('latihan/latihan-form.js', 'polkam');
if (isset($edit_id)) {
    echo js_asset('latihan/latihan-load.js', 'polkam');
    ?>
    <!--load data and populate form-->
    <script>
        $(window).load(function () {
            load_latihan(<?php echo $edit_id; ?>);
        });
    </script>
    <?php
}
?>

<!-- PAGE CONTENT ENDS -->