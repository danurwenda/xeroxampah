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
        <h3 class="header smaller lighter blue"><?php echo isset($edit_id) ? 'Ubah' : 'Tambah'; ?> Individu</h3>
        <div class="row">
            <?php echo form_open('individu/submit', ['class' => 'form-horizontal', 'role' => 'form', 'id' => 'individu_form']); ?>
            <div class="col-xs-6 col-sm-6">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sumber </label>

                    <div class="col-sm-9">
                        <select class="chosen-select" data-placeholder="Pilih sumber" name="source_id" id="source_id">
                            <?php
                            foreach ($sources as $s) {
                                echo '<option value="' . $s->source_id . '">' . $s->source_name . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- NAMA -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama </label>

                    <div class="col-sm-9">
                        <input type="text" id="name" placeholder="Nama Individu" class="form-control" name="individu_name" />
                    </div>
                </div>

                <!-- TEMPAT LAHIR -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tempat lahir </label>

                    <div class="col-sm-9">
                        <input type="text" id="tangkap_place" placeholder="Tempat lahir" class="form-control" name="born_place" />
                    </div>
                </div>

                <!-- NATIONALITY -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Suku/Kwn </label>

                    <div class="col-sm-9">
                        <input type="text" id="nationality" placeholder="Suku/Kewarganegaraan" class="form-control" name="nationality" />
                    </div>
                </div>





                <!-- RECENT EDUCATION -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Pendidikan </label>

                    <div class="col-sm-9">
                        <input type="text" id="recentedu" placeholder="Pendidikan Terakhir" class="form-control" name="recent_edu" />
                    </div>
                </div>
            </div>

            <div class="col-xs-6 col-sm-6">
                <!-- RELIGION -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Agama </label>

                    <div class="col-sm-9">
                        <input type="text" id="religion" placeholder="Agama" class="form-control" name="religion" />
                    </div>
                </div>

                <!-- ALIAS -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Alias </label>

                    <div class="col-sm-9">
                        <input type="text" id="alias" placeholder="Alias" class="col-xs-11" name="alias" />
                        <span class="help-button" data-rel="popover" data-trigger="hover" data-placement="left" data-content="Jika ada lebih dari satu alias, pisahkan dengan koma." title="Alias">?</span>
                    </div>
                </div>

                <!-- TANGGAL LAHIR -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal lahir </label>

                    <div class="col-sm-9">
                        <div class="input-group">
                            <input class="form-control date-picker" id="born_date" name="born_date" type="text" data-date-format="dd/mm/yyyy" />
                            <span class="input-group-addon">
                                <i class="fa fa-calendar bigger-110"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- ADDRESS -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Alamat </label>

                    <div class="col-sm-9">
                        <input type="text" id="address" placeholder="Tempat tinggal" class="form-control" name="address" />
                    </div>
                </div>


                <!-- RECENT JOB -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Pekerjaan </label>

                    <div class="col-sm-9">
                        <input type="text" id="recentjob" placeholder="Pekerjaan Terakhir" class="form-control" name="recent_job" />
                    </div>
                </div>
            </div>
            <!-- LEFT COLUMN -->
            <div class="col-sm-6">
                <div class="widget-box collapsed">
                    <div class="widget-header">
                        <h4 class="widget-title">Penangkapan</h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-down"></i>
                            </a>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Lokasi </label>

                                <div class="col-sm-9">
                                    <input type="text" id="alias" placeholder="Lokasi Penangkapan" class="form-control" name="lokasi_tangkap" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal </label>

                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input class="form-control date-picker" id="tangkap_date" name="tangkap_date" type="text" data-date-format="dd/mm/yyyy" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- /section:custom/file-input.filter -->
                        </div>
                    </div>
                </div>

                <div class="widget-box collapsed">
                    <div class="widget-header">
                        <h4 class="widget-title">Riwayat Penggunaan Nama</h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-down"></i>
                            </a>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main template-group">
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
                                            <input class="form-control date-picker" id="tangkap_date" name="nama_date[]" type="text" data-date-format="dd/mm/yyyy" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar bigger-110"></i>
                                            </span>
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

                <div class="widget-box collapsed">
                    <div class="widget-header">
                        <h4 class="widget-title">Riwayat Pekerjaan</h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-down"></i>
                            </a>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main template-group">
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
                                        <div class="input-daterange input-group">
                                            <input type="text" class="input-sm form-control" name="job_start[]" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-exchange"></i>
                                            </span>

                                            <input type="text" class="input-sm form-control" name="job_end[]" />
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
                <div class="widget-box collapsed">
                    <div class="widget-header">
                        <h4 class="widget-title">Kejahatan Teror</h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-down"></i>
                            </a>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main template-group">
                            <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
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
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                    <div class="col-sm-9">
                                        <select data-placeholder="Pilih Relasi..." name="teror_edge[]">

                                            <option value="25">Pemberi Perintah</option>
                                            <option value="26">Perencana</option>
                                            <option value="27">Pelaksana</option>                                    
                                            <option value="28">Pemberi Dukungan</option>                                    
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                    <div class="col-sm-9">
                                        <button class="btn btn-danger btn-delete" type="button">
                                            <i class="ace-icon fa fa-remove bigger-110"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Catatan </label>

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
            <!-- RIGHT COLUMN -->
            <div class="col-sm-6">
                <div class="widget-box collapsed">
                    <div class="widget-header">
                        <h4 class="widget-title">Data Keluarga</h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-down"></i>
                            </a>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main">
                            <!-- AYAH -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Ayah </label>

                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <select style="width: 100%" id="father" class="form-control individu-select2" name="father" ></select>
                                        <span class="input-group-addon" data-toggle="modal" data-target="#individu-modal-form">
                                            <i class="fa fa-plus bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- IBU -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Ibu </label>

                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <select style="width: 100%" id="mother" class="form-control individu-select2" name="mother" ></select>
                                        <span class="input-group-addon" data-toggle="modal" data-target="#individu-modal-form">
                                            <i class="fa fa-plus bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group hide fam-template">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Ibu </label>

                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <select style="width: 100%" class="form-control"></select>
                                        <span class="input-group-addon" data-toggle="modal" data-target="#individu-modal-form">
                                            <i class="fa fa-plus bigger-110"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="family-plus">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Relasi </label>

                                <div class="col-sm-9">
                                    <a href="#family-modal-form" role="button" class="blue" data-toggle="modal">
                                        <span class="input-group-addon">
                                            <i class="fa fa-plus bigger-110"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget-box collapsed">
                    <div class="widget-header">
                        <h4 class="widget-title">Hubungan dengan Lembaga Pendidikan</h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-down"></i>
                            </a>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main template-group"  id="edu-widget">
                            <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tempat </label>

                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Nama" class="form-control" name="edu_place[]" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal </label>

                                    <div class="col-sm-9">
                                        <div class="input-daterange input-group">
                                            <input type="text" class="input-sm form-control" name="edu_start[]" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-exchange"></i>
                                            </span>

                                            <input type="text" class="input-sm form-control" name="edu_end[]" />
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                    <div class="col-sm-9">
                                        <select class="edu-select" data-placeholder="Pilih Relasi..." name="edu-edge[]">

                                            <option value="22">Mudir/Pengasuh</option>
                                            <option value="23">Pendiri</option>
                                            <option value="24">Pengajar</option>                                    
                                            <option value="51">Santri/Murid</option>                                    
                                            <option value="52">Staf</option>                                    
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                    <div class="col-sm-9">
                                        <button class="btn btn-delete btn-danger" type="button">
                                            <i class="ace-icon fa fa-remove bigger-110"></i>
                                            Hapus
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
                <div class="widget-box collapsed" >
                    <div class="widget-header">
                        <h4 class="widget-title">Riwayat Organisasi</h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-down"></i>
                            </a>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main template-group">
                            <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Organisasi </label>

                                    <div class="col-sm-9">
                                        <select style="width: 100%" class="form-control organisasi-select2 ui-autocomplete-input" name="org_id[]" ></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal </label>

                                    <div class="col-sm-9">
                                        <div class="input-daterange input-group">
                                            <input type="text" class="input-sm form-control" name="org_start[]" />
                                            <span class="input-group-addon">
                                                <i class="fa fa-exchange"></i>
                                            </span>

                                            <input type="text" class="input-sm form-control" name="org_end[]" />
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                    <div class="col-sm-9">
                                        <select data-placeholder="Pilih Relasi..." name="org_edge[]">

                                            <option value="15">Anggota Baiat</option>
                                            <option value="16">Anggota non-Baiat</option>
                                            <option value="17">Amir</option>                                    
                                            <option value="18">Komandan militer</option>                                    
                                            <option value="19">Dewan Pimpinan/Pimpinan Wilayah</option>                                    
                                            <option value="20">Pemberi dukungan permanen/rutin</option>                                    
                                            <option value="20">Pemberi dukungan insidental</option>                                    
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                    <div class="col-sm-9">
                                        <button class="btn btn-danger btn-delete" type="button">
                                            <i class="ace-icon fa fa-remove bigger-110"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Riwayat Organisasi </label>

                                <div class="col-sm-9">
                                    <span class="input-group-addon plus">
                                        <i class="fa fa-plus bigger-110"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget-box collapsed">
                    <div class="widget-header">
                        <h4 class="widget-title">Kejahatan Non Teror</h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse">
                                <i class="ace-icon fa fa-chevron-down"></i>
                            </a>
                        </div>
                    </div>

                    <div class="widget-body">
                        <div class="widget-main template-group">
                            <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
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
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                    <div class="col-sm-9">
                                        <select data-placeholder="Pilih Relasi..." name="nonteror_edge[]">

                                            <option value="29">Pemberi Perintah</option>
                                            <option value="30">Perencana</option>
                                            <option value="31">Pelaksana</option>                                    
                                            <option value="32">Pemberi Dukungan</option>                                    
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                    <div class="col-sm-9">
                                        <button class="btn btn-danger btn-delete" type="button">
                                            <i class="ace-icon fa fa-remove bigger-110"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Catatan </label>

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
<div id="nonteror-modal-form" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger">Tambah Event Kejahatan NonTeror</h4>
            </div>

            <div class="modal-body">
                <form class="row form-horizontal">
                    <div class="col-xs-12">
                        <!-- Tempat -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Lokasi event </label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="tempat" />
                            </div>
                        </div>
                        <!-- Tanggal -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tanggal </label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" placeholder="Tanggal Kejadian" class="form-control date-picker" name="date" />
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>     
                                </div>
                            </div>
                        </div>
                        <!-- Waktu -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Waktu </label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="time-picker form-control" name="time" />
                                    <span class="input-group-addon">
                                        <i class="fa fa-clock-o bigger-110"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Jenis Pidana -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jenis Pidana </label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="pidana" />
                            </div>
                        </div>
                        <!-- Korban -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Korban </label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="korban" />
                            </div>
                        </div>
                        <!-- Kerugian -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kerugian </label>

                            <div class="col-sm-9">
                                <input type="text" class=" form-control" name="nilai" />
                            </div>
                        </div>
                        <!-- Motif -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Motif </label>

                            <div class="col-sm-9">
                                <input type="text" class=" form-control" name="motif" />
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
<div id="teror-modal-form" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger">Tambah Event Kejahatan Teror</h4>
            </div>

            <div class="modal-body">
                <form class="row form-horizontal">
                    <div class="col-xs-12">
                        <!-- Tempat -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Lokasi event </label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="tempat" />
                            </div>
                        </div>
                        <!-- Tanggal -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tanggal </label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" placeholder="Tanggal Kejadian" class="form-control date-picker" name="date" />
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar bigger-110"></i>
                                    </span>     
                                </div>
                            </div>
                        </div>
                        <!-- Waktu -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Waktu </label>

                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="time-picker form-control" name="time" />
                                    <span class="input-group-addon">
                                        <i class="fa fa-clock-o bigger-110"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Model Serangan -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Model Serangan </label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="serangan" />
                            </div>
                        </div>
                        <!-- Sasaran -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sasaran </label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="sasaran" />
                            </div>
                        </div>
                        <!-- Motif -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Motif </label>

                            <div class="col-sm-9">
                                <input type="text" class=" form-control" name="motif" />
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

<div id="individu-modal-form" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger">Tambah Individu</h4>
            </div>

            <div class="modal-body">
                <form class="row form-horizontal">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama </label>

                            <div class="col-sm-9">
                                <input type="text" placeholder="Nama Individu" class="form-control" name="individu_name" />
                            </div>
                        </div>
                        <!-- RECENT JOB -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Pekerjaan </label>

                            <div class="col-sm-9">
                                <input type="text" id="recentjob" placeholder="Pekerjaan Terakhir" class="form-control" name="recent_job" />
                            </div>
                        </div>
                        <div class="widget-box collapsed" >
                            <div class="widget-header">
                                <h4 class="widget-title">Riwayat Organisasi</h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="ace-icon fa fa-chevron-down"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main template-group">
                                    <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Organisasi </label>

                                            <div class="col-sm-9">
                                                <select style="width: 100%" class="form-control organisasi-select2 ui-autocomplete-input" name="org_id[]" ></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tanggal </label>

                                            <div class="col-sm-9">
                                                <div class="input-daterange input-group">
                                                    <input type="text" class="input-sm form-control" name="org_start[]" />
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-exchange"></i>
                                                    </span>

                                                    <input type="text" class="input-sm form-control" name="org_end[]" />
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                            <div class="col-sm-9">
                                                <select data-placeholder="Pilih Relasi..." name="org_edge[]">

                                                    <option value="15">Anggota Baiat</option>
                                                    <option value="16">Anggota non-Baiat</option>
                                                    <option value="17">Amir</option>                                    
                                                    <option value="18">Komandan militer</option>                                    
                                                    <option value="19">Dewan Pimpinan/Pimpinan Wilayah</option>                                    
                                                    <option value="20">Pemberi dukungan permanen/rutin</option>                                    
                                                    <option value="20">Pemberi dukungan insidental</option>                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                            <div class="col-sm-9">
                                                <button class="btn btn-danger btn-delete" type="button">
                                                    <i class="ace-icon fa fa-remove bigger-110"></i>
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Riwayat Organisasi </label>

                                        <div class="col-sm-9">
                                            <span class="input-group-addon plus">
                                                <i class="fa fa-plus bigger-110"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget-box collapsed">
                            <div class="widget-header">
                                <h4 class="widget-title">Kejahatan Teror</h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="ace-icon fa fa-chevron-down"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main template-group">
                                    <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
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
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                            <div class="col-sm-9">
                                                <select data-placeholder="Pilih Relasi..." name="teror_edge[]">

                                                    <option value="25">Pemberi Perintah</option>
                                                    <option value="26">Perencana</option>
                                                    <option value="27">Pelaksana</option>                                    
                                                    <option value="28">Pemberi Dukungan</option>                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                            <div class="col-sm-9">
                                                <button class="btn btn-danger btn-delete" type="button">
                                                    <i class="ace-icon fa fa-remove bigger-110"></i>
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Catatan </label>

                                        <div class="col-sm-9">
                                            <span class="plus input-group-addon">
                                                <i class="fa fa-plus bigger-110"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget-box collapsed">
                            <div class="widget-header">
                                <h4 class="widget-title">Kejahatan Non Teror</h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse">
                                        <i class="ace-icon fa fa-chevron-down"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main template-group">
                                    <div class="hide form-template template" style="margin-bottom:5px;padding:10px;border:1px solid black;">
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
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>

                                            <div class="col-sm-9">
                                                <select data-placeholder="Pilih Relasi..." name="nonteror_edge[]">

                                                    <option value="29">Pemberi Perintah</option>
                                                    <option value="30">Perencana</option>
                                                    <option value="31">Pelaksana</option>                                    
                                                    <option value="32">Pemberi Dukungan</option>                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                                            <div class="col-sm-9">
                                                <button class="btn btn-danger btn-delete" type="button">
                                                    <i class="ace-icon fa fa-remove bigger-110"></i>
                                                    Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tambah Catatan </label>

                                        <div class="col-sm-9">
                                            <span class="plus input-group-addon">
                                                <i class="fa fa-plus bigger-110"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div></div>
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

<div id="family-modal-form" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="blue bigger">Tambah Relasi</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="form-field-select-3">Relasi Kekeluargaan</label>

                            <div>
                                <select class="chosen-select" data-placeholder="Pilih Relasi..." id="fam-field">

                                    <option value="48">Saudara</option>
                                    <option value="49">Pasangan</option>
                                    <option value="50">Anak</option>                                    
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
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
echo js_asset('jquery.dataTables.js', 'ace');
echo js_asset('jquery.dataTables.bootstrap.js', 'ace');
echo js_asset('bootbox.js', 'ace');
echo js_asset('jquery.hotkeys.js', 'ace');
echo js_asset('bootstrap-wysiwyg.js', 'ace');
echo css_asset('datepicker.css', 'ace');
echo js_asset('date-time/bootstrap-datepicker.js', 'ace');
echo css_asset('bootstrap-timepicker.css', 'ace');
echo js_asset('date-time/bootstrap-timepicker.js', 'ace');
echo js_asset('individu/individu-form.js', 'polkam');
if (isset($edit_id)) {
    echo js_asset('individu/individu-load.js', 'polkam');
    ?>
    <!--load data and populate form-->
    <script>
        $(window).load(function () {
            load_individu(<?php echo $edit_id; ?>);
        });
    </script>
    <?php
}
?>
<!-- PAGE CONTENT ENDS -->