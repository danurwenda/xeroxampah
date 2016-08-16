
<div class="row">
    <div class="col-xs-12">
        <h3 class="header smaller lighter blue">Individu</h3>
        <h4>
            <a class="btn btn-white btn-default btn-round" href="<?php echo site_url('individu/add'); ?>">
                <i class="ace-icon fa fa-plus-circle blue"></i>Tambah
            </a>
            <span class="btn btn-white btn-default btn-round btn-merge disabled" data-toggle="modal" data-target="#individu-modal-form">
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
            <table id="individu-table" class="table table-striped table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th></th>
                        <th>Nama</th>
                        <th>Alias</th>
                        <th>Tempat, tanggal lahir</th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


<div id="individu-modal-form" class="modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger">Merge Individu</h4>
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
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama </label>
                        </div>
                        <div class="col-md-5 merge-1">
                            <!-- Nama -->
                            <input type="text" class="form-control" name="individu_name" nm="individu_name" />
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round swaprow">
                                <i class="ace-icon fa fa-exchange green"></i>
                            </span>
                        </div>
                        <div class="col-md-5 merge-2">
                            <!-- Nama -->
                            <input type="text" class="form-control" nm="individu_name"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">
                            <!-- Nama -->
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Alias </label>
                        </div>
                        <div class="col-md-5 merge-1">
                            <!-- Nama -->
                            <input type="text" class="form-control" name="alias" nm="alias" />
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round swaprow">
                                <i class="ace-icon fa fa-exchange green"></i>
                            </span>
                        </div>
                        <div class="col-md-5 merge-2">
                            <!-- Nama -->
                            <input type="text" class="form-control" nm="alias"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">

                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Suku/kwn </label>
                        </div>
                        <div class="col-md-5 merge-1">

                            <input type="text" class="form-control" name="nationality" nm="nationality" />
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round swaprow">
                                <i class="ace-icon fa fa-exchange green"></i>
                            </span>
                        </div>
                        <div class="col-md-5 merge-2">

                            <input type="text" class="form-control" nm="nationality"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">

                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> TTL </label>
                        </div>
                        <div class="col-md-5 merge-1">

                            <input type="text" class="form-control combofulldate" name="born_date" nm="born_date" data-format="YYYY-MM-DD" data-template="DD MMM YYYY" />
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round swaprow">
                                <i class="ace-icon fa fa-exchange green"></i>
                            </span>
                        </div>
                        <div class="col-md-5 merge-2">

                            <input type="text" class="form-control combofulldate" nm="born_date" data-format="YYYY-MM-DD" data-template="DD MMM YYYY">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">

                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                        </div>
                        <div class="col-md-5 merge-1">

                            <select style="width: 100%" class="form-control kotakab-select2 select2" nm="born_kotakab" name="born_kotakab"></select>
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round swaprow">
                                <i class="ace-icon fa fa-exchange green"></i>
                            </span>
                        </div>
                        <div class="col-md-5 merge-2">
                            <select style="width: 100%" class="form-control kotakab-select2 select2" nm="born_kotakab"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">

                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Alamat </label>
                        </div>
                        <div class="col-md-5 merge-1">

                            <input type="text" class="form-control" name="address" nm="address" />
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round swaprow">
                                <i class="ace-icon fa fa-exchange green"></i>
                            </span>
                        </div>
                        <div class="col-md-5 merge-2">

                            <input type="text" class="form-control" nm="address">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">

                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                        </div>
                        <div class="col-md-5 merge-1">

                            <select style="width: 100%" class="form-control kotakab-select2 select2" nm="address_kotakab" name="address_kotakab"></select>
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round swaprow">
                                <i class="ace-icon fa fa-exchange green"></i>
                            </span>
                        </div>
                        <div class="col-md-5 merge-2">
                            <select style="width: 100%" class="form-control kotakab-select2 select2" nm="address_kotakab"></select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-1">

                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Pendidikan Formal </label>
                        </div>
                        <div class="col-md-5 merge-1">
                            <select class="form-control" name="recent_edu" nm="recent_edu">
                                <option value=""></option>
                                <option value="0">SD atau lebih rendah</option>
                                <option value="1">SMP</option>
                                <option value="2">SMA</option>
                                <option value="3">Diploma</option>
                                <option value="4">S1</option>
                                <option value="5">S2</option>
                                <option value="6">S3 atau lebih tinggi</option>
                            </select>
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round swaprow">
                                <i class="ace-icon fa fa-exchange green"></i>
                            </span>
                        </div>
                        <div class="col-md-5 merge-2">
                            <select class="form-control" nm="recent_edu">
                                <option value=""></option>
                                <option value="0">SD atau lebih rendah</option>
                                <option value="1">SMP</option>
                                <option value="2">SMA</option>
                                <option value="3">Diploma</option>
                                <option value="4">S1</option>
                                <option value="5">S2</option>
                                <option value="6">S3 atau lebih tinggi</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">

                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> JenKel </label>
                        </div>
                        <div class="col-md-5 merge-1">
                            <select class="form-control" name="gender" nm="gender">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round swaprow">
                                <i class="ace-icon fa fa-exchange green"></i>
                            </span>
                        </div>
                        <div class="col-md-5 merge-2">
                            <select class="form-control" nm="gender">
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1">

                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Agama </label>
                        </div>
                        <div class="col-md-5 merge-1">
                            <select class="form-control" name="religion" nm="religion">
                                <option value="Islam">Islam</option>
                                <option value="Protestan">Protestan</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Budha">Budha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>
                        <div class="col-md-1 center">
                            <span class="btn btn-white btn-default btn-round swaprow">
                                <i class="ace-icon fa fa-exchange green"></i>
                            </span>
                        </div>
                        <div class="col-md-5 merge-2">
                            <select class="form-control" nm="religion" >
                                <option value="Islam">Islam</option>
                                <option value="Protestan">Protestan</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Budha">Budha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>
                    </div>

                    <div class="row widget-box collapsed">
                        <div class="widget-header">
                            <h4 class="widget-title">Hubungan dengan Lembaga Pendidikan</h4>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-down"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main"  id="edu-widget">
                                <div class="row">
                                    <div class="col-md-2">
                                        <!-- Nama -->
                                        <label class="control-label no-padding-right" for="form-field-1"> Swap all </label>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-2 center">
                                        <span class="btn btn-white btn-default btn-round swaprecord">
                                            <i class="ace-icon fa fa-exchange purple"></i>
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-6 merge-1 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                                <div class="col-sm-9">
                                                    <select class="edu-edge" data-placeholder="Pilih Relasi..." name="edu_edge[]">

                                                        <option value="22">Mudir/Pengasuh</option>
                                                        <option value="23">Pendiri</option>
                                                        <option value="24">Pengajar</option>                                    
                                                        <option value="51">Santri/Murid</option>                                    
                                                        <option value="52">Staf</option>                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group hide subjek attr">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Subjek </label>

                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Dukungan" class="form-control" name="edu_subjek[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tempat </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <select style="width: 100%" class="form-control school-select2" name="school_id[]"></select>

                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="input-sm form-control monthpicker " name="edu_start[]" />
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-exchange"></i>
                                                        </span>

                                                        <input type="text" class="monthpicker input-sm form-control" name="edu_end[]" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-delete btn-danger" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi Pendidikan </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-6 merge-2 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                                <div class="col-sm-9">
                                                    <select class="edu-edge" data-placeholder="Pilih Relasi..." nm="edu_edge[]">

                                                        <option value="22">Mudir/Pengasuh</option>
                                                        <option value="23">Pendiri</option>
                                                        <option value="24">Pengajar</option>                                    
                                                        <option value="51">Santri/Murid</option>                                    
                                                        <option value="52">Staf</option>                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group hide subjek attr">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Subjek </label>

                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Dukungan" class="form-control" nm="edu_subjek[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tempat </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <select style="width: 100%" class="form-control school-select2" nm="school_id[]"></select>

                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="input-sm form-control monthpicker " nm="edu_start[]" />
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-exchange"></i>
                                                        </span>

                                                        <input type="text" class="monthpicker input-sm form-control" nm="edu_end[]" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-delete btn-danger" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi Pendidikan </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row widget-box collapsed">
                        <div class="widget-header">
                            <h4 class="widget-title">Penangkapan</h4>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-down"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main"  id="tangkap-widget">
                                <div class="row">
                                    <div class="col-md-2">
                                        <!-- Nama -->
                                        <label class="control-label no-padding-right" for="form-field-1"> Swap all </label>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-2 center">
                                        <span class="btn btn-white btn-default btn-round swaprecord">
                                            <i class="ace-icon fa fa-exchange purple"></i>
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-6 merge-1 template-group">
                                        <div class="form-template template hide" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Lokasi </label>

                                                <div class="col-sm-9">
                                                    <input type="text" id="alias" placeholder="Lokasi Penangkapan" class="form-control" name="tangkap_lokasi[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input class="form-control combofulldate" id="tangkap_date" name="tangkap_date[]" type="text" data-format="YYYY-MM-DD" data-template="DD MMM YYYY" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-delete btn-danger" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="tangkap-plus">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Penangkapan </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-6 merge-2 template-group">
                                        <div class="form-template template hide" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Lokasi </label>

                                                <div class="col-sm-9">
                                                    <input type="text" id="alias" placeholder="Lokasi Penangkapan" class="form-control" nm="tangkap_lokasi[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input class="form-control combofulldate" id="tangkap_date" nm="tangkap_date[]" type="text" data-format="YYYY-MM-DD" data-template="DD MMM YYYY" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button type="button" class="btn btn-danger btn-delete">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="tangkap-plus">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Penangkapan </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row widget-box collapsed">
                        <div class="widget-header">
                            <h4 class="widget-title">Riwayat Penggunaan Nama</h4>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-down"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main"  id="nama-widget">
                                <div class="row">
                                    <div class="col-md-2">
                                        <!-- Nama -->
                                        <label class="control-label no-padding-right" for="form-field-1"> Swap all </label>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-2 center">
                                        <span class="btn btn-white btn-default btn-round swaprecord">
                                            <i class="ace-icon fa fa-exchange purple"></i>
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-6 merge-1 template-group">
                                        <div class="form-template template hide" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama </label>

                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Nama" class="form-control" name="old_name[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Lokasi </label>

                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Lokasi/Kelompok Penggunaan" class="form-control" name="lokasi_nama[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input class="form-control monthpicker" name="nama_date[]" type="text" data-date-format="mm-yyyy" />

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button type="button" class="btn btn-danger btn-delete">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="name-plus">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Nama </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-6 merge-2 template-group">
                                        <div class="form-template template hide" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama </label>

                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Nama" class="form-control" nm="old_name[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Lokasi </label>

                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Lokasi/Kelompok Penggunaan" class="form-control" nm="lokasi_nama[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input class="form-control monthpicker" nm="nama_date[]" type="text" data-date-format="mm-yyyy" />

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button type="button" class="btn btn-danger btn-delete">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="name-plus">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Nama </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row widget-box collapsed">
                        <div class="widget-header">
                            <h4 class="widget-title">Riwayat Pekerjaan</h4>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-down"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main"  id="job-widget">
                                <div class="row">
                                    <div class="col-md-2">
                                        <!-- Nama -->
                                        <label class="control-label no-padding-right" for="form-field-1"> Swap all </label>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-2 center">
                                        <span class="btn btn-white btn-default btn-round swaprecord">
                                            <i class="ace-icon fa fa-exchange purple"></i>
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-6 merge-1 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tempat </label>

                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Nama" class="form-control" name="job_place[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="monthpicker input-sm form-control" name="job_start[]" />
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-exchange"></i>
                                                        </span>

                                                        <input type="text" class="monthpicker input-sm form-control" name="job_end[]" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-danger btn-delete" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Pekerjaan </label>

                                            <div class="col-sm-9">
                                                <span class="plus input-group-addon">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-6 merge-2 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tempat </label>

                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Nama" class="form-control" nm="job_place[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="monthpicker input-sm form-control" nm="job_start[]" />
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-exchange"></i>
                                                        </span>

                                                        <input type="text" class="monthpicker input-sm form-control" nm="job_end[]" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-danger btn-delete" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Pekerjaan </label>

                                            <div class="col-sm-9">
                                                <span class="plus input-group-addon">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row widget-box collapsed">
                        <div class="widget-header">
                            <h4 class="widget-title">Riwayat Penahanan</h4>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-down"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main"  id="lapas-widget">
                                <div class="row">
                                    <div class="col-md-2">
                                        <!-- Nama -->
                                        <label class="control-label no-padding-right" for="form-field-1"> Swap all </label>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-2 center">
                                        <span class="btn btn-white btn-default btn-round swaprecord">
                                            <i class="ace-icon fa fa-exchange purple"></i>
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-6 merge-1 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Lapas </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <select style="width: 100%" class="form-control lapas-select2" name="lapas_id[]"></select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="monthpicker input-sm form-control" name="lapas_start[]" />
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-exchange"></i>
                                                        </span>

                                                        <input type="text" class="monthpicker input-sm form-control" name="lapas_end[]" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-danger btn-delete" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Penahanan </label>

                                            <div class="col-sm-9">
                                                <span class="plus input-group-addon">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-6 merge-2 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Lapas </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <select style="width: 100%" class="form-control lapas-select2" nm="lapas_id[]"></select>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="monthpicker input-sm form-control" nm="lapas_start[]" />
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-exchange"></i>
                                                        </span>

                                                        <input type="text" class="monthpicker input-sm form-control" nm="lapas_end[]" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-danger btn-delete" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Penahanan </label>

                                            <div class="col-sm-9">
                                                <span class="plus input-group-addon">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row widget-box collapsed">
                        <div class="widget-header">
                            <h4 class="widget-title">Kejahatan Teror</h4>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-down"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main"  id="teror-widget">
                                <div class="row">
                                    <div class="col-md-2">
                                        <!-- Nama -->
                                        <label class="control-label no-padding-right" for="form-field-1"> Swap all </label>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-2 center">
                                        <span class="btn btn-white btn-default btn-round swaprecord">
                                            <i class="ace-icon fa fa-exchange purple"></i>
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-6 merge-1 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                                <div class="col-sm-9">
                                                    <select class="teror-edge" data-placeholder="Pilih Relasi..." name="teror_edge[]">
                                                        <option value="25">Pemberi Perintah</option>
                                                        <option value="26">Perencana</option>
                                                        <option value="27">Pelaksana</option>                                    
                                                        <option value="28">Pemberi Dukungan</option>                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group hide dukungan attr">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Bentuk dukungan </label>

                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Dukungan" class="form-control" name="teror_dukungan[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kasus </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <select style="width: 100%" class="form-control teror-select2" name="teror[]" ></select>
                                                        <span class="input-group-addon" data-toggle="modal" data-target="#teror-modal-form">
                                                            <i class="fa fa-plus bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-delete btn-danger" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi Pengajian </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-6 merge-2 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                                <div class="col-sm-9">
                                                    <select class="teror-edge" data-placeholder="Pilih Relasi..." nm="teror_edge[]">
                                                        <option value="25">Pemberi Perintah</option>
                                                        <option value="26">Perencana</option>
                                                        <option value="27">Pelaksana</option>                                    
                                                        <option value="28">Pemberi Dukungan</option>                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group hide dukungan attr">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Bentuk dukungan </label>

                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Dukungan" class="form-control" nm="teror_dukungan[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kasus </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <select style="width: 100%" class="form-control teror-select2" nm="teror[]" ></select>
                                                        <span class="input-group-addon" data-toggle="modal" data-target="#teror-modal-form">
                                                            <i class="fa fa-plus bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-delete btn-danger" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi Pengajian </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row widget-box collapsed">
                        <div class="widget-header">
                            <h4 class="widget-title">Kejahatan Non-Teror</h4>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-down"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main"  id="nonteror-widget">
                                <div class="row">
                                    <div class="col-md-2">
                                        <!-- Nama -->
                                        <label class="control-label no-padding-right" for="form-field-1"> Swap all </label>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-2 center">
                                        <span class="btn btn-white btn-default btn-round swaprecord">
                                            <i class="ace-icon fa fa-exchange purple"></i>
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-6 merge-1 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                                <div class="col-sm-9">
                                                    <select class="nonteror-edge" data-placeholder="Pilih Relasi..." name="nonteror_edge[]">

                                                        <option value="29">Pemberi Perintah</option>
                                                        <option value="30">Perencana</option>
                                                        <option value="31">Pelaksana</option>                                    
                                                        <option value="32">Pemberi Dukungan</option>                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group hide dukungan attr">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Bentuk dukungan </label>

                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Dukungan" class="form-control" name="nonteror_dukungan[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kasus </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <select style="width: 100%" class="form-control nonteror-select2" name="nonteror[]" ></select>
                                                        <span class="input-group-addon" data-toggle="modal" data-target="#nonteror-modal-form">
                                                            <i class="fa fa-plus bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-delete btn-danger" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi Pengajian </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-6 merge-2 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                                <div class="col-sm-9">
                                                    <select class="nonteror-edge" data-placeholder="Pilih Relasi..." nm="nonteror_edge[]">

                                                        <option value="29">Pemberi Perintah</option>
                                                        <option value="30">Perencana</option>
                                                        <option value="31">Pelaksana</option>                                    
                                                        <option value="32">Pemberi Dukungan</option>                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group hide dukungan attr">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Bentuk dukungan </label>

                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Dukungan" class="form-control" nm="nonteror_dukungan[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kasus </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <select style="width: 100%" class="form-control nonteror-select2" nm="nonteror[]" ></select>
                                                        <span class="input-group-addon" data-toggle="modal" data-target="#nonteror-modal-form">
                                                            <i class="fa fa-plus bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-delete btn-danger" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi Pengajian </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row widget-box collapsed">
                        <div class="widget-header">
                            <h4 class="widget-title">Latihan Senjata</h4>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-down"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main"  id="latsen-widget">
                                <div class="row">
                                    <div class="col-md-2">
                                        <!-- Nama -->
                                        <label class="control-label no-padding-right" for="form-field-1"> Swap all </label>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-2 center">
                                        <span class="btn btn-white btn-default btn-round swaprecord">
                                            <i class="ace-icon fa fa-exchange purple"></i>
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-6 merge-1 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                                <div class="col-sm-9">
                                                    <select class="latsen-edge" data-placeholder="Pilih Relasi..." name="latsen_edge[]">
                                                        <option value="33">Pelatih</option>
                                                        <option value="34">Pemberi Perintah</option>
                                                        <option value="35">Perencana</option>
                                                        <option value="36">Pelaksana</option>                                    
                                                        <option value="37">Pemberi Dukungan</option>                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group hide dukungan attr">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Bentuk dukungan </label>

                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Dukungan" class="form-control" name="latsen_dukungan[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Latihan </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <select style="width: 100%" class="form-control latsen-select2" name="latsen[]" ></select>
                                                        <span class="input-group-addon" data-toggle="modal" data-target="#latsen-modal-form">
                                                            <i class="fa fa-plus bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-delete btn-danger" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi Pengajian </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-6 merge-2 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                                <div class="col-sm-9">
                                                    <select class="latsen-edge" data-placeholder="Pilih Relasi..." nm="latsen_edge[]">
                                                        <option value="33">Pelatih</option>
                                                        <option value="34">Pemberi Perintah</option>
                                                        <option value="35">Perencana</option>
                                                        <option value="36">Pelaksana</option>                                    
                                                        <option value="37">Pemberi Dukungan</option>                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group hide dukungan attr">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Bentuk dukungan </label>

                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Dukungan" class="form-control" nm="latsen_dukungan[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Latihan </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <select style="width: 100%" class="form-control latsen-select2" nm="latsen[]" ></select>
                                                        <span class="input-group-addon" data-toggle="modal" data-target="#latsen-modal-form">
                                                            <i class="fa fa-plus bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-delete btn-danger" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi Pengajian </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row widget-box collapsed">
                        <div class="widget-header">
                            <h4 class="widget-title">Latihan Non-Senjata</h4>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-down"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main"  id="latihan-widget">
                                <div class="row">
                                    <div class="col-md-2">
                                        <!-- Nama -->
                                        <label class="control-label no-padding-right" for="form-field-1"> Swap all </label>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-2 center">
                                        <span class="btn btn-white btn-default btn-round swaprecord">
                                            <i class="ace-icon fa fa-exchange purple"></i>
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-6 merge-1 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                                <div class="col-sm-9">
                                                    <select class="latihan-edge" data-placeholder="Pilih Relasi..." name="latihan_edge[]">
                                                        <option value="38">Pelatih</option>
                                                        <option value="39">Pemberi Perintah</option>
                                                        <option value="40">Perencana</option>
                                                        <option value="41">Pelaksana</option>                                    
                                                        <option value="42">Pemberi Dukungan</option>                                     
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group hide dukungan attr">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Bentuk dukungan </label>

                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Dukungan" class="form-control" name="latihan_dukungan[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Latihan </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <select style="width: 100%" class="form-control latihan-select2" name="latihan[]" ></select>
                                                        <span class="input-group-addon" data-toggle="modal" data-target="#latihan-modal-form">
                                                            <i class="fa fa-plus bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-delete btn-danger" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi Pengajian </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-6 merge-2 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                                <div class="col-sm-9">
                                                    <select class="latihan-edge" data-placeholder="Pilih Relasi..." nm="latihan_edge[]">
                                                        <option value="38">Pelatih</option>
                                                        <option value="39">Pemberi Perintah</option>
                                                        <option value="40">Perencana</option>
                                                        <option value="41">Pelaksana</option>                                    
                                                        <option value="42">Pemberi Dukungan</option>                                     
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group hide dukungan attr">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Bentuk dukungan </label>

                                                <div class="col-sm-9">
                                                    <input type="text" placeholder="Dukungan" class="form-control" nm="latihan_dukungan[]" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Latihan </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <select style="width: 100%" class="form-control latihan-select2" nm="latihan[]" ></select>
                                                        <span class="input-group-addon" data-toggle="modal" data-target="#latihan-modal-form">
                                                            <i class="fa fa-plus bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-delete btn-danger" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi Pengajian </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row widget-box collapsed">
                        <div class="widget-header">
                            <h4 class="widget-title">Riwayat Organisasi</h4>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-down"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main"  id="org-widget">
                                <div class="row">
                                    <div class="col-md-2">
                                        <!-- Nama -->
                                        <label class="control-label no-padding-right" for="form-field-1"> Swap all </label>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-2 center">
                                        <span class="btn btn-white btn-default btn-round swaprecord">
                                            <i class="ace-icon fa fa-exchange purple"></i>
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-6 merge-1 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                                <div class="col-sm-9">
                                                    <select data-placeholder="Pilih Relasi..." name="org_edge[]">

                                                        <option value="15">Anggota Aktif</option>
                                                        <option value="16">Anggota Biasa</option>
                                                        <option value="53">Anggota inti/Pengurus</option>
                                                        <option value="54">Muharrik/Pengurus Inti</option>
                                                        <option value="55">Pelaku Teror</option>
                                                        <option value="17">Amir</option>                                    
                                                        <option value="18">Komandan militer</option>                                    
                                                        <option value="19">Dewan Pimpinan/Pimpinan Wilayah</option>                                    
                                                        <option value="20">Pemberi dukungan permanen/rutin</option>                                    
                                                        <option value="20">Pemberi dukungan insidental</option>                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Organisasi </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <select style="width: 100%" class="form-control organisasi-select2" name="organisasi_id[]"></select>
                                                        <span class="input-group-addon" data-toggle="modal" data-target="#organisasi-modal-form">
                                                            <i class="fa fa-plus bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="monthpicker input-sm form-control" name="org_start[]" />
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-exchange"></i>
                                                        </span>

                                                        <input type="text" class="monthpicker input-sm form-control" name="org_end[]" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-delete btn-danger" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi Pengajian </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-6 merge-2 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                                <div class="col-sm-9">
                                                    <select data-placeholder="Pilih Relasi..." nm="org_edge[]">

                                                        <option value="15">Anggota Aktif</option>
                                                        <option value="16">Anggota Biasa</option>
                                                        <option value="53">Anggota inti/Pengurus</option>
                                                        <option value="54">Muharrik/Pengurus Inti</option>
                                                        <option value="55">Pelaku Teror</option>
                                                        <option value="17">Amir</option>                                    
                                                        <option value="18">Komandan militer</option>                                    
                                                        <option value="19">Dewan Pimpinan/Pimpinan Wilayah</option>                                    
                                                        <option value="20">Pemberi dukungan permanen/rutin</option>                                    
                                                        <option value="20">Pemberi dukungan insidental</option>                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Organisasi </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <select style="width: 100%" class="form-control organisasi-select2" nm="organisasi_id[]"></select>
                                                        <span class="input-group-addon" data-toggle="modal" data-target="#organisasi-modal-form">
                                                            <i class="fa fa-plus bigger-110"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input type="text" class="monthpicker input-sm form-control" nm="org_start[]" />
                                                        <span class="input-group-addon">
                                                            <i class="fa fa-exchange"></i>
                                                        </span>

                                                        <input type="text" class="monthpicker input-sm form-control" nm="org_end[]" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-delete btn-danger" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi Pengajian </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row widget-box collapsed">
                        <div class="widget-header">
                            <h4 class="widget-title">Kegiatan Pengajian</h4>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-down"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main"  id="pengajian-widget">
                                <div class="row">
                                    <div class="col-md-2">
                                        <!-- Nama -->
                                        <label class="control-label no-padding-right" for="form-field-1"> Swap all </label>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-2 center">
                                        <span class="btn btn-white btn-default btn-round swaprecord">
                                            <i class="ace-icon fa fa-exchange purple"></i>
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-6 merge-1 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                                <div class="col-sm-9">
                                                    <select class="pengajian-edge" data-placeholder="Pilih Relasi..." name="pengajian_edge[]">

                                                        <option value="57">Pendengar</option>
                                                        <option value="43">Guru/Ustadz</option>
                                                        <option value="44">Panitia/Mas'ul</option>                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Pengajian </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <select style="width: 100%" class="form-control pengajian-select2" name="pengajian_id[]"></select>

                                                    </div> </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-delete btn-danger" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi Pengajian </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-6 merge-2 template-group">
                                        <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                                <div class="col-sm-9">
                                                    <select class="pengajian-edge" data-placeholder="Pilih Relasi..." nm="pengajian_edge[]">

                                                        <option value="57">Pendengar</option>
                                                        <option value="43">Guru/Ustadz</option>
                                                        <option value="44">Panitia/Mas'ul</option>                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Pengajian </label>

                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <select style="width: 100%" class="form-control pengajian-select2" nm="pengajian_id[]"></select>

                                                    </div> </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                                <div class="col-sm-9">
                                                    <button class="btn btn-delete btn-danger" type="button">
                                                        <i class="ace-icon fa fa-remove bigger-110"></i>
                                                        Hapus
                                                    </button>
                                                    <button class="btn btn-swap btn-info" type="button">
                                                        <i class="ace-icon fa fa-exchange bigger-110"></i>
                                                        Pindah
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi Pengajian </label>

                                            <div class="col-sm-9">
                                                <span class="input-group-addon plus">
                                                    <i class="fa fa-plus bigger-110"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row widget-box collapsed">
                        <div class="widget-header">
                            <h4 class="widget-title">Data Keluarga</h4>

                            <div class="widget-toolbar">
                                <a href="#" data-action="collapse">
                                    <i class="ace-icon fa fa-chevron-down"></i>
                                </a>
                            </div>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main"  id="family-widget">
                                <div class="row">
                                    <div class="col-md-2">
                                        <!-- Nama -->
                                        <label class="control-label no-padding-right" for="form-field-1"> Swap all </label>
                                    </div>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-2 center">
                                        <span class="btn btn-white btn-default btn-round swaprecord">
                                            <i class="ace-icon fa fa-exchange purple"></i>
                                        </span>
                                    </div>
                                    <div class="col-md-5">
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-6 merge-1 template-group">
                                        <!-- AYAH -->
                                        <div class="form-group ayah">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Ayah </label>

                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <select style="width: 100%" id="father" class="form-control male-select2 select2" name="father" ></select>
                                                    <span class="input-group-addon ayah-swap fam-swap">
                                                        <i class="fa fa-exchange bigger-110"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- IBU -->
                                        <div class="form-group ibu">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Ibu </label>

                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <select style="width: 100%" id="mother" class="form-control female-select2 select2" name="mother" ></select>
                                                    <span class="input-group-addon fam-swap ibu-swap">
                                                        <i class="fa fa-exchange bigger-110"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group hide fam-template">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>

                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <select style="width: 100%" class="form-control"></select>
                                                    <span class="input-group-addon fam-swap">
                                                        <i class="fa fa-exchange bigger-110"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group family-plus">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi </label>

                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <select style="width: 100%" class="fam-field chosen-select" data-placeholder="Pilih Relasi...">

                                                        <option value="48">Saudara</option>
                                                        <option value="49">Pasangan</option>
                                                        <option value="50">Anak</option>                                    
                                                    </select>
                                                    <span class="input-group-addon fam-plus">
                                                        <i class="fa fa-plus bigger-110"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-6 merge-2 template-group">
                                        <!-- AYAH -->
                                        <div class="form-group ayah">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Ayah </label>

                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <select style="width: 100%" id="father" class="form-control male-select2 select2" nm="father" ></select>
                                                    <span class="input-group-addon ayah-swap">
                                                        <i class="fa fa-exchange bigger-110"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- IBU -->
                                        <div class="form-group ibu">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Ibu </label>

                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <select style="width: 100%" id="mother" class="form-control female-select2 select2" nm="mother" ></select>
                                                    <span class="input-group-addon ibu-swap">
                                                        <i class="fa fa-exchange bigger-110"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group hide fam-template">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>

                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <select style="width: 100%" class="form-control"></select>
                                                    <span class="input-group-addon fam-swap">
                                                        <i class="fa fa-exchange bigger-110"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group family-plus">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi </label>

                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <select style="width: 100%" class="chosen-select fam-field" data-placeholder="Pilih Relasi..." >

                                                        <option value="48">Saudara</option>
                                                        <option value="49">Pasangan</option>
                                                        <option value="50">Anak</option>                                    
                                                    </select>
                                                    <span class="input-group-addon fam-plus">
                                                        <i class="fa fa-plus bigger-110"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
echo js_asset('individu/individu-table.js', 'polkam');
?>
<!-- PAGE CONTENT ENDS -->