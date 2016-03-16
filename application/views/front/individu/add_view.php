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
        <h3 class="header smaller lighter blue"><?php echo isset($edit_id)?'Ubah':'Tambah';?> Individu</h3>
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
                        <input type="text" id="name" placeholder="Nama Individu" class="form-control" name="name" />
                    </div>
                </div>

                <!-- TEMPAT LAHIR -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1-1"> Tempat lahir </label>

                    <div class="col-sm-9">
                        <input type="text" id="born_place" placeholder="Tempat lahir" class="form-control" name="born_place" />
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



                <!-- SPOUSE -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Istri </label>

                    <div class="col-sm-9">
                        <input type="text" id="wife" placeholder="Istri" class="form-control individu-autocomplete" name="wife" />
                    </div>
                </div>
                <!-- CHILDREN -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Anak </label>

                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" placeholder="Anak" class="form-control individu-autocomplete expandable" name="children[]" />
                            <span class="input-group-addon">
                                <i class="fa fa-plus bigger-110"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- PESANTREN -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Pesantren </label>

                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" placeholder="Pesantren" class="form-control pesantren-autocomplete expandable" name="pesantren[]" />
                            <span class="input-group-addon">
                                <i class="fa fa-plus bigger-110"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="space-4"></div>

                <!-- EDUKASI FORMAL -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Riwayat Pendidikan Formal</label>

                    <div class="col-sm-9">
                        <!-- #section:plugins/input.tag-input -->
                        <div class="wysiwyg-editor" id="formaledu-editor"></div>

                        <!-- /section:plugins/input.tag-input -->
                    </div>
                </div>
                <!-- RIWAYAT PEKERJAAN -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Riwayat Pekerjaan</label>

                    <div class="col-sm-9">
                        <!-- #section:plugins/input.tag-input -->
                        <div class="wysiwyg-editor" id="job-editor"></div>

                        <!-- /section:plugins/input.tag-input -->
                    </div>
                </div>
                <!-- ORGANISASI -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Riwayat Organisasi</label>

                    <div class="col-sm-9">
                        <!-- #section:plugins/input.tag-input -->
                        <div class="wysiwyg-editor" id="organisasi-editor"></div>

                        <!-- /section:plugins/input.tag-input -->
                    </div>
                </div>

                <!-- MASJID -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Masjid </label>

                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" placeholder="Masjid" class="form-control masjid-autocomplete expandable" name="masjid[]" />
                            <span class="input-group-addon">
                                <i class="fa fa-plus bigger-110"></i>
                            </span>
                        </div>
                    </div>
                </div>



                <!-- TINDAK PIDANA -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Tindak Pidana</label>

                    <div class="col-sm-9">
                        <!-- PENANGKAPAN -->
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Penangkapan</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input class="form-control date-picker" id="tangkap_date" name="tangkap_date" type="text" data-date-format="dd/mm/yyyy" />
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                            </div>
                        </div>
                        <!-- DAKWAAN -->
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Dakwaan</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input class="form-control date-picker" id="dakwa_date" name="dakwa_date" type="text" data-date-format="dd/mm/yyyy" />
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                            </div>
                            <input type="text" id="dakwaan_pasal" placeholder="Pasal" class="form-control" name="dakwaan_pasal" />
                        </div>
                        <!-- TUNTUTAN -->
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Tuntutan</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input class="form-control date-picker" id="tuntut_date" name="tuntut_date" type="text" data-date-format="dd/mm/yyyy" />
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                            </div>
                            <input type="text" id="tuntutan_pasal" placeholder="Pasal" class="form-control" name="tuntutan_pasal" />
                            <input type="text" id="tuntutan_pidana" placeholder="Pidana" class="form-control" name="tuntutan_pidana" />
                        </div>
                        <!-- VONIS -->
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Vonis</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input class="form-control date-picker" id="vonis_date" name="vonis_date" type="text" data-date-format="dd/mm/yyyy" />
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                            </div>
                            <input type="text" id="vonis_pasal" placeholder="Pasal" class="form-control" name="vonis_pasal" />
                            <input type="text" id="vonis_pidana" placeholder="Pidana" class="form-control" name="vonis_pidana" />
                        </div>
                    </div>
                </div>
                <!-- EKSEKUSI -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Eksekusi</label>

                    <div class="col-sm-9">
                        <!-- TANGGAL MULAI -->
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Tanggal</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input class="form-control date-picker" id="jail_date" name="jail_date" type="text" data-date-format="dd/mm/yyyy" />
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                            </div>
                        </div>
                        <!-- LAPAS -->
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Lapas</label>
                        <div class="col-sm-9">
                            <input type="text" id="lapas" placeholder="Lapas" class="form-control lapas-autocomplete" name="lapas" />
                        </div>
                        <!-- TANGGAL BEBAS -->
                        <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Bebas</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input class="form-control date-picker" id="bebas_date" name="bebas_date" type="text" data-date-format="dd/mm/yyyy" />
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RELASI -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Relasi</label>

                    <div class="col-sm-9">
                        <!-- #section:plugins/input.tag-input -->
                        <div class="wysiwyg-editor" id="relasi-editor"></div>
                        <!-- /section:plugins/input.tag-input -->
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
                <!-- AYAH -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Ayah </label>

                    <div class="col-sm-9">
                        <input type="text" id="father" placeholder="Ayah" class="form-control individu-autocomplete" name="father" />
                    </div>
                </div>
                <!-- IBU -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Ibu </label>

                    <div class="col-sm-9">
                        <input type="text" id="mother" placeholder="Ibu" class="form-control individu-autocomplete" name="mother" />
                    </div>
                </div>
                <!-- SAUDARA -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Saudara </label>

                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" placeholder="Saudara" class="form-control expandable individu-autocomplete" name="sibling[]" />
                            <span class="input-group-addon">
                                <i class="fa fa-plus bigger-110"></i>
                            </span>
                        </div>
                    </div>

                </div>

                <div class="space-4"></div>

                <!-- PENDIDIKAN NON-FORMAL -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Riwayat Pendidikan Non-formal</label>

                    <div class="col-sm-9">
                        <!-- #section:plugins/input.tag-input -->
                        <div class="wysiwyg-editor" id="nonformaledu-editor"></div>

                        <!-- /section:plugins/input.tag-input -->
                    </div>
                </div>

                <!-- PENDIDIKAN MILITER -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Pendidikan Militer/Paramiliter</label>

                    <div class="col-sm-9">
                        <!-- #section:plugins/input.tag-input -->
                        <div class="wysiwyg-editor" id="military-editor"></div>

                        <!-- /section:plugins/input.tag-input -->
                    </div>
                </div>



                <!-- PENGENALAN THD RADIKAL -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Pengenalan thd Gerakan Radikal</label>

                    <div class="col-sm-9">
                        <!-- #section:plugins/input.tag-input -->
                        <div class="wysiwyg-editor" id="radikal-editor"></div>

                        <!-- /section:plugins/input.tag-input -->
                    </div>
                </div>
                <!-- MAJLIS -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Majlis Taklim </label>

                    <div class="col-sm-9">
                        <input type="text" id="majlis" placeholder="Majlis Ta'lim" class="form-control" name="majlis" />
                    </div>
                </div>
                <!-- PERISTIWA TEROR -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Peristiwa Teror</label>

                    <div class="col-sm-9">
                        <!-- #section:plugins/input.tag-input -->
                        <div class="wysiwyg-editor" id="teror-editor"></div>

                        <!-- /section:plugins/input.tag-input -->
                    </div>
                </div>

                <!-- PERBUATAN -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-tags">Perbuatan</label>

                    <div class="col-sm-9">
                        <!-- #section:plugins/input.tag-input -->
                        <div class="wysiwyg-editor" id="perbuatan-editor"></div>

                        <!-- /section:plugins/input.tag-input -->
                    </div>
                </div>

                <!-- JARINGAN -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jaringan Teror </label>

                    <div class="col-sm-9">
                        <input type="text" id="jaringan" placeholder="Jaringan Teror" class="form-control network-autocomplete" name="jaringan" />
                    </div>
                </div>

                <!-- STRATA -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Strata dalam Kelompok </label>

                    <div class="col-sm-9">
                        <input type="text" id="strata" placeholder="Ideolog/Militan/dll" class="form-control" name="strata" />
                    </div>
                </div>

                <!-- KOOPERASI -->
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sikap Pasca Pidana </label>

                    <div class="col-sm-9">
                        <div class="checkbox">
                            <label>
                                <input name="kooperatif" type="checkbox" class="ace" value="1"/>
                                <span class="lbl"> Kooperatif</span>
                            </label>
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


<?php
echo js_asset('jquery.dataTables.js', 'ace');
echo js_asset('jquery.dataTables.bootstrap.js', 'ace');
echo js_asset('bootbox.js', 'ace');
echo js_asset('jquery.hotkeys.js', 'ace');
echo js_asset('bootstrap-wysiwyg.js', 'ace');
echo js_asset('date-time/bootstrap-datepicker.js', 'ace');
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