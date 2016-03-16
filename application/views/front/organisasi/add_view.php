
<div class="row">
    <div class="col-xs-12">
        <h3 class="header smaller lighter blue">Tambah Organisasi</h3>
        <div class="row">
            <?php echo form_open('', ['class'=>'form-horizontal','role'=>'form','id'=>'leform']);?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sumber </label>

                                <div class="col-sm-9">
                                    <select class="chosen-select" data-placeholder="Pilih sumber" name="source_id" id="source_id">
                                        <?php foreach ($sources as $s) {
                                            echo '<option value="'.$s->source_id.'">'.$s->source_name.'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama </label>

                                <div class="col-sm-9">
                                    <input type="text" id="org_name" placeholder="Nama Organisasi" class="form-control" name="org_name" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Alamat </label>

                                <div class="col-sm-9">
                                    <input type="text" id="org_address" placeholder="Alamat" class="form-control" name="address" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Website </label>

                                <div class="col-sm-9">
                                    <input type="text" id="org_website" placeholder="Website" class="form-control" name="website" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Email </label>

                                <div class="col-sm-9">
                                    <input type="text" id="org_email" placeholder="Email" class="form-control" name="email" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Telepon </label>

                                <div class="col-sm-9">
                                    <input type="text" id="org_phone" placeholder="Phone" class="form-control" name="phone" />
                                </div>
                            </div>

                            <div class="space-4"></div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Deskripsi</label>

                                <div class="col-sm-9">
                                    <!-- #section:plugins/input.tag-input -->
                                    <div class="wysiwyg-editor" id="editor2"></div>

                                    <!-- /section:plugins/input.tag-input -->
                                </div>
                            </div>
                        
            <div class="clearfix form-actions col-xs-12 col-sm-12">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="button">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Submit
                    </button>
                </div>
            </div>
            </form>
        </div><!-- PAGE CONTENT ENDS -->

    </div>
</div>
<div class="fade" id="row-actions">
    <div class="hidden-sm hidden-xs action-buttons">
        <a class="blue" href="#" data-toggle="modal" data-target="#modal-form" data-action="view">
            <i class="ace-icon fa fa-search-plus bigger-130"></i>
        </a>
        <a class="green edit" href="#" data-toggle="modal" data-target="#modal-form" data-action="edit">
            <i class="ace-icon fa fa-pencil bigger-130"></i>
        </a>
        <a class="red delete" href="#">
            <i class="ace-icon fa fa-trash-o bigger-130"></i>
        </a>
    </div>
    <div class="hidden-md hidden-lg">
        <div class="inline position-relative">
            <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
            </button>
            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close action-buttons">
                <li>
                    <a href="#" class="tooltip-info" data-toggle="modal" data-target="#modal-form" data-action="view" data-rel="tooltip" title="View">
                        <span class="blue">
                            <i class="ace-icon fa fa-search-plus bigger-120"></i>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="tooltip-success edit" data-toggle="modal" data-target="#modal-form" data-action="edit" data-rel="tooltip" title="Edit">
                        <span class="green">
                            <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#" class="tooltip-error delete" data-rel="tooltip" title="Delete">
                        <span class="red">
                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>


<?php
echo js_asset('jquery.dataTables.js', 'ace');
echo js_asset('jquery.dataTables.bootstrap.js', 'ace');
echo js_asset('bootbox.js', 'ace');
echo js_asset('jquery.hotkeys.js', 'ace');
echo js_asset('bootstrap-wysiwyg.js', 'ace');
echo js_asset('date-time/bootstrap-datepicker.js', 'ace');
echo js_asset('individu.js', 'polkam');
?>
<!-- PAGE CONTENT ENDS -->