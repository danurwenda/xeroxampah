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
                        <select style="width: 100%" class="form-control kotakab-select2" name="kotakab"></select>
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