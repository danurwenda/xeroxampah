
<div class="row">
    <div class="col-xs-12">
        <h3 class="header smaller lighter blue">Pengajian</h3>
        <h4>
            <a class="btn btn-white btn-default btn-round" href="<?php echo site_url('pengajian/add');?>">
                <i class="ace-icon fa fa-plus-circle blue"></i>Tambah
            </a>
            <span class="btn btn-white btn-default btn-round btn-merge disabled" data-toggle="modal" data-target="#pengajian-modal-form">
                 <i class="ace-icon fa fa-flask red"></i>Merge
            </span>
            <span class="btn btn-white btn-default btn-round disabled" id="clear-merge">
                <i class="ace-icon fa fa-times red2"></i>Clear
            </span>
        </h4>
        <!--<div class="clear"></div>-->

        <!-- <div class="table-responsive"> -->

        <!-- <div class="dataTables_borderWrap"> -->
        <div>
            <table id="pengajian-table" class="table table-striped table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th></th>
                        <th>Topik</th>
                        <th>Rumah</th>
                        <th>Masjid</th>
                        <th>School</th>
                        <th>Lokasi lain</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<div id="pengajian-modal-form" class="modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger">Merge Pengajian</h4>
            </div>

            <div class="modal-body">
                <form class="form-horizontal">
                    <input type="hidden" name="keep"/>
                    <input type="hidden" name="discard"/>
                    <div class="row">
                        <div class="col-md-5 col-md-offset-1 center">
                            <span> Simpan </span>
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round" id="swapall">
                                <i class="ace-icon fa fa-exchange red"></i>
                            </span>
                        </div>
                        <div class="col-md-5 center">
                            <span> Hapus </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <!-- Label -->
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Label </label>
                        </div>
                        <div class="col-md-5 merge-1">
                            <!-- Label -->
                            <input type="text" class="form-control" name="label" nm="label" />
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round swaprow">
                                <i class="ace-icon fa fa-exchange green"></i>
                            </span>
                        </div>
                        <div class="col-md-5 merge-2">
                            <!-- Label -->
                            <input type="text" class="form-control" nm="label"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <!-- Nama -->
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Topik </label>
                        </div>
                        <div class="col-md-5 merge-1">
                            <!-- Nama -->
                            <input type="text" class="form-control" name="topik" nm="topik" />
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round swaprow">
                                <i class="ace-icon fa fa-exchange green"></i>
                            </span>
                        </div>
                        <div class="col-md-5 merge-2">
                            <!-- Nama -->
                            <input type="text" class="form-control" nm="topik"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <!-- Kotakab -->
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Rumah </label>
                        </div>
                        <div class="col-md-5 merge-1">
                            <!-- Kotakab -->
                            <select style="width: 100%" class="form-control individu-select2 select2" name="rumah"></select>
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round swaprow">
                                <i class="ace-icon fa fa-exchange green"></i>
                            </span>
                        </div>
                        <div class="col-md-5 merge-2">
                            <select style="width: 100%" class="form-control individu-select2 select2"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <!-- Kotakab -->
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Masjid </label>
                        </div>
                        <div class="col-md-5 merge-1">
                            <!-- Kotakab -->
                            <select style="width: 100%" class="form-control masjid-select2 select2" name="masjid"></select>
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round swaprow">
                                <i class="ace-icon fa fa-exchange green"></i>
                            </span>
                        </div>
                        <div class="col-md-5 merge-2">
                            <select style="width: 100%" class="form-control masjid-select2 select2"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <!-- Kotakab -->
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> School </label>
                        </div>
                        <div class="col-md-5 merge-1">
                            <!-- Kotakab -->
                            <select style="width: 100%" class="form-control school-select2 select2" name="school"></select>
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round swaprow">
                                <i class="ace-icon fa fa-exchange green"></i>
                            </span>
                        </div>
                        <div class="col-md-5 merge-2">
                            <select style="width: 100%" class="form-control school-select2 select2"></select>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-1">
                            <!-- Nama -->
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Lokasi Lain </label>
                        </div>
                        <div class="col-md-5 merge-1">
                            <!-- Nama -->
                            <input type="text" class="form-control" name="lokasi" nm="lokasi" />
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round swaprow">
                                <i class="ace-icon fa fa-exchange green"></i>
                            </span>
                        </div>
                        <div class="col-md-5 merge-2">
                            <!-- Nama -->
                            <input type="text" class="form-control" nm="lokasi"/>
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
                    Merge
                </button>
            </div>
        </div>
    </div>
</div>

<div class="fade" id="row-actions">
    <div class="hidden-sm hidden-xs action-buttons">
        <a class="blue view" href="#" data-toggle="modal" data-target="#modal-form" data-action="view">
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
echo js_asset('pengajian/pengajian-table.js', 'polkam');
?>
<!-- PAGE CONTENT ENDS -->