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
        <h3 class="header smaller lighter blue"><?php echo isset($edit_id) ? 'Ubah' : 'Tambah'; ?> Masjid</h3>
        <div class="row">
            <?php echo form_open('masjid', ['class' => 'form-horizontal', 'role' => 'form', 'id' => 'masjid_form']); ?>
            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Nama :</label>

                <div class="col-xs-12 col-sm-9">
                    <div class="clearfix">
                        <input type="text" name="masjid_name" id="masjid_name" class="col-xs-12 col-sm-6" />
                    </div>
                </div>
            </div>

            <!--<div class="space-2"></div>-->

            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="password">Alamat :</label>

                <div class="col-xs-12 col-sm-9">
                    <div class="clearfix">
                        <input type="text" name="address" id="address" class="col-xs-12 col-sm-4" />
                    </div>
                </div>
            </div>

            <!--<div class="space-2"></div>-->

            <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="kotakab">Kota:</label>

                <div class="col-xs-12 col-sm-9">
                    <div class="clearfix">
                        <select style="width: 100%" class="form-control kotakab-select2" name="kotakab"></select>
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


<?php
echo js_asset('jquery.validate.js', 'ace');
echo js_asset('masjid/masjid-form.js', 'polkam');
if (isset($edit_id)) {
    echo js_asset('masjid/masjid-load.js', 'polkam');
    ?>
    <!--load data and populate form-->
    <script>
        $(window).load(function () {
            load_masjid(<?php echo $edit_id; ?>);
        });
    </script>
    <?php
}
?>

<!-- PAGE CONTENT ENDS -->