function cloneTemplate(widget) {
    //find template
    var template = $(widget + ' .template');
    var clone = template.clone()
            .removeClass('template hide')
            .insertBefore($(widget + '>.form-group'));
    //initiate jquery plugins/UI
    clone.find('.combofulldate').combodate();
    clone.find('.monthpicker').combodate({
        format: "YYYY-MM-DD",
        template: "MMM YYYY"
    });
    clone.find('.organisasi-select2').select2(organisasi_select_config)
    clone.find('.lapas-select2').select2(lapas_select_config)
    clone.find('.school-select2').select2(school_select_config)
    clone.find('.masjid-select2').select2(masjid_select_config)
    clone.find('.pengajian-select2').select2(pengajian_select_config)
    clone.find('.nonteror-select2').select2(nonteror_select_config);
    clone.find('.teror-select2').select2(teror_select_config);
    clone.find('.latsen-select2').select2(latsen_select_config);
    clone.find('.latihan-select2').select2(latihan_select_config);
    return clone;
}
jQuery(function ($) {
    // EXPANDABLE FIELDS
    // FAMILY
    function insertIndividuRow(clazz, edge) {
        //insert new row di keluarga
        var template = $('#family-widget ' + clazz).children('.fam-template');
        var clone = template.clone();
        clone.insertBefore(template).removeClass('hide fam-template');
        //ganti nama field
        var select = template.next().find('select')
        var text = select.find('option[value="' + edge + '"]').text();
        clone.find('label').html(text);
        select = clone.find('select')
                .attr(clazz === '.merge-1' ? 'name' : 'nm', 'relation_' + edge + '[]')
                //make it autocomplete
                .select2(individu_select_config);
        if (edge == 49) {
            //tambah field kapan nikah
            var date = $('<div class="input-group">' +
                    '<input class="form-control combofulldate" name="married_date[]" type="text" data-format="YYYY-MM-DD" data-template="DD MMM YYYY" /></div>');
            date.find('input').combodate({
                minYear: 1950
            })
            clone.find('.input-group')
                    .after(date);
            adjustGender(select)
        }
        return clone;
    }
    function adjustGender(select) {
        var g = $('#individu_form select[name="gender"]').val();
        select.select2('destroy')
        select.select2(g === 'Perempuan' ? male_select_config : female_select_config)
    }
    $('.fam-plus').click(function (c) {
        var select = $(this).prev(), selected = select.val();
        //insert new row di keluarga
        var clazz = $(this).closest('.family-plus').parent();
        if (clazz.hasClass('merge-1'))
            insertIndividuRow('.merge-1', selected)
        else if (clazz.hasClass('merge-2'))
            insertIndividuRow('.merge-2', selected)
//        var clone = template.clone();
//        clone.insertBefore(template).removeClass('hide fam-template');
//        //ganti nama field
//        var text = select.find('option[value="' + selected + '"]').text();
//        clone.find('label').html(text);
//        var select = clone.find('select')
//                .attr('name', 'relation_' + selected + '[]')
//                //make it autocomplete
//                .select2(individu_select_config);
//        if (selected == 49) {
//            //tambah field kapan nikah
//            var date = $('<div class="input-group">' +
//                    '<input class="form-control combofulldate" name="married_date[]" type="text" data-format="YYYY-MM-DD" data-template="DD MMM YYYY" /></div>');
//            date.find('input').combodate({
//                minYear: 1950
//            })
//            clone.find('.input-group')
//                    .after(date);
//            adjustGender(select);
//        }
    });
    //handle "hapus" button
    $('.template-group').on(ace.click_event, '.btn-delete', function () {
        $(this).parents('.form-template').first().remove();
    })

    $('span.plus').on(ace.click_event, function () {
        //find template
        var template = $(this).parents('.template-group').find('.template');
        var clone = template.clone()
                .removeClass('template hide')
                .insertBefore($(this).parents('.form-group').first());
        //initiate jquery plugins/UI
        clone.find('.combofulldate').combodate({maxYear: 2030});
        clone.find('.monthpicker').combodate({
            format: "YYYY-MM-DD", maxYear: 2030,
            template: "MMM YYYY"
        });
        clone.find('.organisasi-select2').select2(organisasi_select_config)
        clone.find('.lapas-select2').select2(lapas_select_config)
        clone.find('.school-select2').select2(school_select_config)
        clone.find('.masjid-select2').select2(masjid_select_config)
        clone.find('.pengajian-select2').select2(pengajian_select_config)
        clone.find('.nonteror-select2').select2(nonteror_select_config);
        clone.find('.teror-select2').select2(teror_select_config);
        clone.find('.latsen-select2').select2(latsen_select_config);
        clone.find('.latihan-select2').select2(latihan_select_config);
    })
    //SELECTION
    var selected = [];
    //init datatable
    function renderCheckbox(id) {
        return '<label class="position-relative">' +
                '<input ' + (selected.indexOf(id) > -1 ? 'checked' : '') + ' type="checkbox" class="ace merge-cb" value=' + id + ' />'
                + '<span class="lbl"></span>'
                + '</label>';
    }
    function updateButtons() {
        //compute the number of checked
        if (selected.length > 0) {
            //enable clear
            $('#clear-merge').removeClass('disabled')
        } else {
            $('#clear-merge').addClass('disabled')
        }
        if (selected.length == 2) {
            //enable merge button
            $('.btn-merge').removeClass('disabled')
        } else {
            //disable merge button
            $('.btn-merge').addClass('disabled')
        }
    }
    function resetSelection() {
        selected = []
        //redraw the table
        table.ajax.reload(null, false)
        updateButtons()
    }
    //listen to merge-cb event
    $('#individu-table').on('change', '.merge-cb', function (e) {
        var toSelect = $(this).closest('tr').toggleClass('selected').hasClass('selected'),
                val = $(this).val();
        if (toSelect) {
            //add to selected
            selected.push(val)
        } else {
            //remove from selected
            var index = selected.indexOf(val);
            if (index > -1) {
                selected.splice(index, 1);
            }
        }
        updateButtons()
    });
    function resetModal() {
        //hapus form -template
        $('form .form-template:not(.template)').remove()
        //form element yang biasa
        $('form')[0].reset()
        //select2
        $('form select.select2').val('').trigger('change')
        //tanggal (yang di luar template)
        $('form [nm="born_date"]').combodate('setValue', null)
        //select-select individu bekas sebelumnya jika ada
        $('#family-widget .template-group').children(':not(.ayah,.ibu,.fam-template,.family-plus)').remove()
        //un-collapse semua chevron
        $('.widget-box').widget_box('hide')
    }
    //LOAD DATA oon show
    $('#individu-modal-form').on('show.bs.modal', function (e) {
        resetModal()
        //put selected ids in the form
        var form = $(this).find('form');
        form.find('input:hidden[name=keep]').val(selected[0]);
        form.find('input:hidden[name=discard]').val(selected[1]);
        //populate modal form with selected ids
        var modal = $(this)
                //tarik data dari db
                , inputs = ['individu_name', 'address', 'nationality', 'label', 'alias']
                , selects = ['gender', 'religion', 'recent_edu'];//bisa gini soalnya semuanya tag input
        $.getJSON(base_url + 'individu/get_cascade/' + selected[0], function (data) {
            inputs.forEach(function (v, i) {
                modal.find('.merge-1 input[nm="' + v + '"]').val(data[v]);
            })
            selects.forEach(function (v, i) {
                modal.find('.merge-1 select[nm="' + v + '"]').val(data[v]);
            })
            //kotakab ngisinya beda
            if (data.address_kotakab) {
                $.getJSON(base_url + 'kotakab/get/' + data.address_kotakab, function (kotakab) {
                    $('.merge-1 .kotakab-select2[nm="address_kotakab"]')
                            .empty() //empty select
                            .append($("<option/>") //add option tag in select
                                    .val(kotakab.kotakab_id) //set value for option to post it
                                    .text(kotakab.kotakab)) //set a text for show in select
                            .val(kotakab.kotakab_id) //select option of select2
                            .trigger("change"); //apply to select2
                })
            }
            if (data.born_kotakab) {
                $.getJSON(base_url + 'kotakab/get/' + data.born_kotakab, function (kotakab) {
                    $('.merge-1 .kotakab-select2[nm="born_kotakab"]')
                            .empty() //empty select
                            .append($("<option/>") //add option tag in select
                                    .val(kotakab.kotakab_id) //set value for option to post it
                                    .text(kotakab.kotakab)) //set a text for show in select
                            .val(kotakab.kotakab_id) //select option of select2
                            .trigger("change"); //apply to select2
                })
            }
            var prop = $.parseJSON(data.properties);
            if (prop) {
                var row;
                //RIWAYAT NAMA
                if (prop.namas.length) {
                    $.each(prop.namas, function (i, v) {
                        //create clone
                        row = cloneTemplate('#nama-widget .merge-1');
                        //set values
                        row.find('input[name="old_name[]"]').val(v.nama);
                        row.find('input[name="lokasi_nama[]"]').val(v.location);
                        row.find('input[name="nama_date[]"]').combodate("setValue", new Date(v.time));
                    });
                    //collapse widgetbox
                    row.parents('.widget-box').first().widget_box('show');
                }
                //RIWAYAT PEKERJAAN
                if (prop.jobs.length) {
                    $.each(prop.jobs, function (i, v) {
                        //create clone
                        row = cloneTemplate('#job-widget .merge-1');
                        //set values
                        row.find('input[name="job_place[]"]').val(v.job);
                        row.find('input[name="job_end[]"]').combodate("setValue", new Date(v.until));
                        row.find('input[name="job_start[]"]').combodate("setValue", new Date(v.from));
                    });
                    //collapse widgetbox
                    row.parents('.widget-box').first().widget_box('show');
                }
                //RIWAYAT PENANGKAPAN
                if (prop.tangkaps.length) {
                    $.each(prop.tangkaps, function (i, v) {
                        //create clone
                        row = cloneTemplate('#tangkap-widget .merge-1');
                        //set values
                        row.find('input[name="tangkap_lokasi[]"]').val(v.location);
                        row.find('input[name="tangkap_date[]"]').combodate("setValue", new Date(v.date));
                    });
                    //collapse widgetbox
                    row.parents('.widget-box').first().widget_box('show');
                }
            }

            //PENDIDIKAN
            if (data.pendidikan.length) {
                var row;
                $.each(data.pendidikan, function (i, v) {
                    //create clone from templates
                    row = cloneTemplate('#edu-widget .merge-1');
                    //set values
                    if (v.prop) {
                        var prop = $.parseJSON(v.prop);
                        if (v.weight == 24 && prop.subjek) {
                            //subjek
                            row.find('.subjek').removeClass('hide')
                                    .find('input').val(prop.subjek);
                        }
                        if (prop.from) {
                            row.find('input[name="edu_start[]"]').combodate("setValue", new Date(prop.from));
                        }
                        if (prop.until) {
                            row.find('input[name="edu_end[]"]').combodate("setValue", new Date(prop.until));
                        }
                    }
                    row.find('.edu-edge').val(v.weight);
                    $.getJSON(base_url + 'school/get/' + v.target, function (f) {
                        row.find('.school-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.school_id) //set value for option to post it
                                        .text(f.school_name)) //set a text for show in select
                                .val(f.school_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
                //collapse widgetbox
                row.parents('.widget-box').first().widget_box('show');
            }
            //ORGANISASI
            if (data.organisasi.length) {
                var row;
                $.each(data.organisasi, function (i, v) {
                    //create clone from templates
                    row = cloneTemplate('#org-widget .merge-1');
                    //set values
                    if (v.prop) {
                        var prop = $.parseJSON(v.prop);
                        if (prop.from) {
                            row.find('input[name="org_start[]"]').combodate("setValue", new Date(prop.from));
                        }
                        if (prop.until) {
                            row.find('input[name="org_end[]"]').combodate("setValue", new Date(prop.until));
                        }
                    }
                    row.find('[name="org_edge[]"]').val(v.weight);
                    $.getJSON(base_url + 'organisasi/get/' + v.target, function (f) {
                        row.find('.organisasi-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.organisasi_id) //set value for option to post it
                                        .text(f.name + ', ' + f.daerah)) //set a text for show in select
                                .val(f.organisasi_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
                //collapse widgetbox
                row.parents('.widget-box').first().widget_box('show');
            }
            //LAPAS
            if (data.lapas.length) {
                var row;
                $.each(data.lapas, function (i, v) {
                    //create clone from templates
                    row = cloneTemplate('#lapas-widget .merge-1');
                    //set values
                    if (v.prop) {
                        var prop = $.parseJSON(v.prop);
                        if (prop.from) {
                            row.find('input[name="lapas_start[]"]').combodate("setValue", new Date(prop.from));
                        }
                        if (prop.until) {
                            row.find('input[name="lapas_end[]"]').combodate("setValue", new Date(prop.until));
                        }
                    }
                    $.getJSON(base_url + 'lapas/get/' + v.target, function (f) {
                        row.find('.lapas-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.lapas_id) //set value for option to post it
                                        .text(f.name)) //set a text for show in select
                                .val(f.lapas_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
                //collapse widgetbox
                row.parents('.widget-box').first().widget_box('show');
            }
            //TEROR
            if (data.teror.length) {
                var row;
                $.each(data.teror, function (i, v) {
                    //create clone from templates
                    row = cloneTemplate('#teror-widget .merge-1');
                    //set values
                    row.find('[name="teror_edge[]"]').val(v.weight);
                    $.getJSON(base_url + 'teror/get/' + v.target, function (f) {
                        row.find('.teror-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.teror_id) //set value for option to post it
                                        .text(f.serangan + ' ' + f.sasaran)) //set a text for show in select
                                .val(f.teror_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
                //collapse widgetbox
                row.parents('.widget-box').first().widget_box('show');
            }
            //LATSEN
            if (data.latsen.length) {
                var row;
                $.each(data.latsen, function (i, v) {
                    //create clone from templates
                    row = cloneTemplate('#latsen-widget .merge-1');
                    //set values
                    row.find('[name="latsen_edge[]"]').val(v.weight);
                    var prop = $.parseJSON(v.prop);
                    if (v.weight == 37 && prop.dukungan) {
                        //dukungan
                        row.find('.dukungan').removeClass('hide')
                                .find('input').val(prop.dukungan);
                    }
                    $.getJSON(base_url + 'latsen/get/' + v.target, function (f) {
                        row.find('.latsen-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.latsen_id) //set value for option to post it
                                        .text(f.materi + ' ' + f.tempat)) //set a text for show in select
                                .val(f.latsen_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
                //collapse widgetbox
                row.parents('.widget-box').first().widget_box('show');
            }
            //LATIHAN
            if (data.latihan.length) {
                var row;
                $.each(data.latihan, function (i, v) {
                    //create clone from templates
                    row = cloneTemplate('#latihan-widget .merge-1');
                    //set values
                    row.find('[name="latihan_edge[]"]').val(v.weight);
                    var prop = $.parseJSON(v.prop);
                    if (v.weight == 37 && prop.dukungan) {
                        //dukungan
                        row.find('.dukungan').removeClass('hide')
                                .find('input').val(prop.dukungan);
                    }
                    $.getJSON(base_url + 'latihan/get/' + v.target, function (f) {
                        row.find('.latihan-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.latihan_id) //set value for option to post it
                                        .text(f.materi + ' ' + f.tempat)) //set a text for show in select
                                .val(f.latihan_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
                //collapse widgetbox
                row.parents('.widget-box').first().widget_box('show');
            }
            //NONTEROR
            if (data.nonteror.length) {
                var row;
                $.each(data.nonteror, function (i, v) {
                    //create clone from templates
                    row = cloneTemplate('#nonteror-widget .merge-1');
                    //set values
                    row.find('[name="nonteror_edge[]"]').val(v.weight);
                    var prop = $.parseJSON(v.prop);
                    if (v.weight == 37 && prop.dukungan) {
                        //dukungan
                        row.find('.dukungan').removeClass('hide')
                                .find('input').val(prop.dukungan);
                    }
                    $.getJSON(base_url + 'nonteror/get/' + v.target, function (f) {
                        row.find('.nonteror-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.nonteror_id) //set value for option to post it
                                        .text(f.pidana + ' ' + f.korban)) //set a text for show in select
                                .val(f.nonteror_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
                //collapse widgetbox
                row.parents('.widget-box').first().widget_box('show');
            }
            //PENGAJIAN
            if (data.pengajian.length) {
                var row;
                $.each(data.pengajian, function (i, v) {
                    //create clone from templates
                    row = cloneTemplate('#pengajian-widget .merge-1');
                    //set values
                    row.find('[name="pengajian_edge[]"]').val(v.weight);
                    var prop = $.parseJSON(v.prop);
                    if (v.weight == 37 && prop.dukungan) {
                        //dukungan
                        row.find('.dukungan').removeClass('hide')
                                .find('input').val(prop.dukungan);
                    }
                    $.getJSON(base_url + 'pengajian/get/' + v.target, function (f) {
                        row.find('.pengajian-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.pengajian_id) //set value for option to post it
                                        .text(f.topik + ' di ' + f.lokasi)) //set a text for show in select
                                .val(f.pengajian_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
                //collapse widgetbox
                row.parents('.widget-box').first().widget_box('show');
            }

            //KELUARGA
            if (data.father) {
                $.getJSON(base_url + 'individu/get/' + data.father, function (f) {
                    var father = $('.merge-1 select[name="father"]');
                    father.empty() //empty select
                            .append($("<option/>") //add option tag in select
                                    .val(f.individu_id) //set value for option to post it
                                    .text(f.individu_name)) //set a text for show in select
                            .val(f.individu_id) //select option of select2
                            .trigger("change"); //apply to select2
                    father.parents('.widget-box').first().widget_box('show');
                });
            }
            if (data.mother) {
                $.getJSON(base_url + 'individu/get/' + data.mother, function (f) {
                    var mother = $('.merge-1 select[name="mother"]')
                    mother.empty() //empty select
                            .append($("<option/>") //add option tag in select
                                    .val(f.individu_id) //set value for option to post it
                                    .text(f.individu_name)) //set a text for show in select
                            .val(f.individu_id) //select option of select2
                            .trigger("change"); //apply to select2
                    mother.parents('.widget-box').first().widget_box('show');
                });
            }
            if (data.pasangan.length) {
                var row;
                $.each(data.pasangan, function (i, v) {
                    $.getJSON(base_url + 'individu/get/' + v.pasangan, function (f) {
                        row = insertIndividuRow('.merge-1', 49);
                        if (v.prop) {
                            row.find('.combofulldate').combodate("setValue", new Date($.parseJSON(v.prop).from));
                        }
                        row.find('select.form-control')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.individu_id) //set value for option to post it
                                        .text(f.individu_name)) //set a text for show in select
                                .val(f.individu_id) //select option of select2
                                .trigger("change"); //apply to select2
                    });
                });
                row.parents('.widget-box').first().widget_box('show');
            }
            if (data.saudara.length) {
                var row;
                $.each(data.saudara, function (i, v) {
                    $.getJSON(base_url + 'individu/get/' + v, function (f) {
                        row = insertIndividuRow('.merge-1', 48);
                        row.find('select')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.individu_id) //set value for option to post it
                                        .text(f.individu_name)) //set a text for show in select
                                .val(f.individu_id) //select option of select2
                                .trigger("change"); //apply to select2
                    });
                });
                row.parents('.widget-box').first().widget_box('show');
            }
            if (data.anak.length) {
                var row;
                $.each(data.anak, function (i, v) {
                    $.getJSON(base_url + 'individu/get/' + v, function (f) {
                        row = insertIndividuRow('.merge-1', 50);
                        row.find('select')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.individu_id) //set value for option to post it
                                        .text(f.individu_name)) //set a text for show in select
                                .val(f.individu_id) //select option of select2
                                .trigger("change"); //apply to select2
                    });
                });
                row.parents('.widget-box').first().widget_box('show');
            }
            //tanggal ngisinya beda
            if (data.born_date) {
                $('.merge-1 input[nm="born_date"]').combodate('setValue', data.born_date);
            }
        });
        $.getJSON(base_url + 'individu/get_cascade/' + selected[1], function (data) {
            inputs.forEach(function (v, i) {
                modal.find('.merge-2 input[nm="' + v + '"]').val(data[v]);
            })
            selects.forEach(function (v, i) {
                modal.find('.merge-2 select[nm="' + v + '"]').val(data[v]);
            })
            //kotakab ngisinya beda
            if (data.address_kotakab) {
                $.getJSON(base_url + 'kotakab/get/' + data.address_kotakab, function (kotakab) {
                    $('.merge-2 .kotakab-select2[nm="address_kotakab"]')
                            .empty() //empty select
                            .append($("<option/>") //add option tag in select
                                    .val(kotakab.kotakab_id) //set value for option to post it
                                    .text(kotakab.kotakab)) //set a text for show in select
                            .val(kotakab.kotakab_id) //select option of select2
                            .trigger("change"); //apply to select2
                })
            }
            if (data.born_kotakab) {
                $.getJSON(base_url + 'kotakab/get/' + data.born_kotakab, function (kotakab) {
                    $('.merge-2 .kotakab-select2[nm="born_kotakab"]')
                            .empty() //empty select
                            .append($("<option/>") //add option tag in select
                                    .val(kotakab.kotakab_id) //set value for option to post it
                                    .text(kotakab.kotakab)) //set a text for show in select
                            .val(kotakab.kotakab_id) //select option of select2
                            .trigger("change"); //apply to select2
                })
            }
            var prop = $.parseJSON(data.properties);
            if (prop) {
                var row;
                //RIWAYAT NAMA
                if (prop.namas.length) {
                    $.each(prop.namas, function (i, v) {
                        //create clone
                        row = cloneTemplate('#nama-widget .merge-2');
                        //set values
                        row.find('input[nm="old_name[]"]').val(v.nama);
                        row.find('input[nm="lokasi_nama[]"]').val(v.location);
                        row.find('input[nm="nama_date[]"]').combodate("setValue", new Date(v.time));
                    });
                    row.parents('.widget-box').first().widget_box('show');
                }
                //RIWAYAT PEKERJAAN
                if (prop.jobs.length) {
                    $.each(prop.jobs, function (i, v) {
                        //create clone
                        row = cloneTemplate('#job-widget .merge-2');
                        //set values
                        row.find('input[nm="job_place[]"]').val(v.job);
                        row.find('input[nm="job_end[]"]').combodate("setValue", new Date(v.until));
                        row.find('input[nm="job_start[]"]').combodate("setValue", new Date(v.from));
                    });
                    row.parents('.widget-box').first().widget_box('show');
                }
                //RIWAYAT PENANGKAPAN
                if (prop.tangkaps.length) {
                    $.each(prop.tangkaps, function (i, v) {
                        //create clone
                        row = cloneTemplate('#tangkap-widget .merge-2');
                        //set values
                        row.find('input[nm="tangkap_lokasi[]"]').val(v.location);
                        row.find('input[nm="tangkap_date[]"]').combodate("setValue", new Date(v.date));
                    });
                    row.parents('.widget-box').first().widget_box('show');
                }
            }
            //PENDIDIKAN
            if (data.pendidikan.length) {
                var row;
                $.each(data.pendidikan, function (i, v) {
                    //create clone from templates
                    row = cloneTemplate('#edu-widget .merge-2');
                    //set values
                    if (v.prop) {
                        var prop = $.parseJSON(v.prop);
                        if (v.weight == 24 && prop.subjek) {
                            //subjek
                            row.find('.subjek').removeClass('hide')
                                    .find('input').val(prop.subjek);
                        }
                        if (prop.from) {
                            row.find('input[nm="edu_start[]"]').combodate("setValue", new Date(prop.from));
                        }
                        if (prop.until) {
                            row.find('input[nm="edu_end[]"]').combodate("setValue", new Date(prop.until));
                        }
                    }
                    row.find('.edu-edge').val(v.weight);
                    $.getJSON(base_url + 'school/get/' + v.target, function (f) {
                        row.find('.school-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.school_id) //set value for option to post it
                                        .text(f.school_name)) //set a text for show in select
                                .val(f.school_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
                row.parents('.widget-box').first().widget_box('show');
            }
            //ORGANISASI
            if (data.organisasi.length) {
                var row;
                $.each(data.organisasi, function (i, v) {
                    //create clone from templates
                    row = cloneTemplate('#org-widget .merge-2');
                    //set values
                    if (v.prop) {
                        var prop = $.parseJSON(v.prop);
                        if (prop.from) {
                            row.find('input[nm="org_start[]"]').combodate("setValue", new Date(prop.from));
                        }
                        if (prop.until) {
                            row.find('input[nm="org_end[]"]').combodate("setValue", new Date(prop.until));
                        }
                    }
                    row.find('[nm="org_edge[]"]').val(v.weight);
                    $.getJSON(base_url + 'organisasi/get/' + v.target, function (f) {
                        row.find('.organisasi-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.organisasi_id) //set value for option to post it
                                        .text(f.name + ', ' + f.daerah)) //set a text for show in select
                                .val(f.organisasi_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
                row.parents('.widget-box').first().widget_box('show');
            }
            //LAPAS
            if (data.lapas.length) {
                var row;
                $.each(data.lapas, function (i, v) {
                    //create clone from templates
                    row = cloneTemplate('#lapas-widget .merge-2');
                    //set values
                    if (v.prop) {
                        var prop = $.parseJSON(v.prop);
                        if (prop.from) {
                            row.find('input[nm="lapas_start[]"]').combodate("setValue", new Date(prop.from));
                        }
                        if (prop.until) {
                            row.find('input[nm="lapas_end[]"]').combodate("setValue", new Date(prop.until));
                        }
                    }
                    $.getJSON(base_url + 'lapas/get/' + v.target, function (f) {
                        row.find('.lapas-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.lapas_id) //set value for option to post it
                                        .text(f.name)) //set a text for show in select
                                .val(f.lapas_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
                row.parents('.widget-box').first().widget_box('show');
            }
            //TEROR
            if (data.teror.length) {
                var row;
                $.each(data.teror, function (i, v) {
                    //create clone from templates
                    row = cloneTemplate('#teror-widget .merge-2');
                    //set values
                    row.find('[nm="teror_edge[]"]').val(v.weight);
                    $.getJSON(base_url + 'teror/get/' + v.target, function (f) {
                        row.find('.teror-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.teror_id) //set value for option to post it
                                        .text(f.serangan + ' ' + f.sasaran)) //set a text for show in select
                                .val(f.teror_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
                row.parents('.widget-box').first().widget_box('show');
            }
            //LATSEN
            if (data.latsen.length) {
                var row;
                $.each(data.latsen, function (i, v) {
                    //create clone from templates
                    row = cloneTemplate('#latsen-widget .merge-2');
                    //set values
                    row.find('[nm="latsen_edge[]"]').val(v.weight);
                    var prop = $.parseJSON(v.prop);
                    if (v.weight == 37 && prop.dukungan) {
                        //dukungan
                        row.find('.dukungan').removeClass('hide')
                                .find('input').val(prop.dukungan);
                    }
                    $.getJSON(base_url + 'latsen/get/' + v.target, function (f) {
                        row.find('.latsen-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.latsen_id) //set value for option to post it
                                        .text(f.materi + ' ' + f.tempat)) //set a text for show in select
                                .val(f.latsen_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
                row.parents('.widget-box').first().widget_box('show');
            }
            //LATIHAN
            if (data.latihan.length) {
                var row;
                $.each(data.latihan, function (i, v) {
                    //create clone from templates
                    row = cloneTemplate('#latihan-widget .merge-2');
                    //set values
                    row.find('[nm="latihan_edge[]"]').val(v.weight);
                    var prop = $.parseJSON(v.prop);
                    if (v.weight == 37 && prop.dukungan) {
                        //dukungan
                        row.find('.dukungan').removeClass('hide')
                                .find('input').val(prop.dukungan);
                    }
                    $.getJSON(base_url + 'latihan/get/' + v.target, function (f) {
                        row.find('.latihan-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.latihan_id) //set value for option to post it
                                        .text(f.materi + ' ' + f.tempat)) //set a text for show in select
                                .val(f.latihan_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
                row.parents('.widget-box').first().widget_box('show');
            }
            //NONTEROR
            if (data.nonteror.length) {
                var row;
                $.each(data.nonteror, function (i, v) {
                    //create clone from templates
                    row = cloneTemplate('#nonteror-widget .merge-2');
                    //set values
                    row.find('[nm="nonteror_edge[]"]').val(v.weight);
                    var prop = $.parseJSON(v.prop);
                    if (v.weight == 37 && prop.dukungan) {
                        //dukungan
                        row.find('.dukungan').removeClass('hide')
                                .find('input').val(prop.dukungan);
                    }
                    $.getJSON(base_url + 'nonteror/get/' + v.target, function (f) {
                        row.find('.nonteror-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.nonteror_id) //set value for option to post it
                                        .text(f.pidana + ' ' + f.korban)) //set a text for show in select
                                .val(f.nonteror_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
                row.parents('.widget-box').first().widget_box('show');
            }
            //PENGAJIAN
            if (data.pengajian.length) {
                var row;
                $.each(data.pengajian, function (i, v) {
                    //create clone from templates
                    row = cloneTemplate('#pengajian-widget .merge-2');
                    //set values
                    row.find('[nm="pengajian_edge[]"]').val(v.weight);
                    var prop = $.parseJSON(v.prop);
                    if (v.weight == 37 && prop.dukungan) {
                        //dukungan
                        row.find('.dukungan').removeClass('hide')
                                .find('input').val(prop.dukungan);
                    }
                    $.getJSON(base_url + 'pengajian/get/' + v.target, function (f) {
                        row.find('.pengajian-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.pengajian_id) //set value for option to post it
                                        .text(f.topik + ' di ' + f.lokasi)) //set a text for show in select
                                .val(f.pengajian_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
                row.parents('.widget-box').first().widget_box('show');
            }
//KELUARGA
            if (data.father) {
                $.getJSON(base_url + 'individu/get/' + data.father, function (f) {
                    var row = $('.merge-2 select[nm="father"]');
                    row.empty() //empty select
                            .append($("<option/>") //add option tag in select
                                    .val(f.individu_id) //set value for option to post it
                                    .text(f.individu_name)) //set a text for show in select
                            .val(f.individu_id) //select option of select2
                            .trigger("change"); //apply to select2
                    row.parents('.widget-box').first().widget_box('show');
                });
            }
            if (data.mother) {
                $.getJSON(base_url + 'individu/get/' + data.mother, function (f) {
                    var row = $('.merge-2 select[nm="mother"]')
                    row.empty() //empty select
                            .append($("<option/>") //add option tag in select
                                    .val(f.individu_id) //set value for option to post it
                                    .text(f.individu_name)) //set a text for show in select
                            .val(f.individu_id) //select option of select2
                            .trigger("change"); //apply to select2
                    row.parents('.widget-box').first().widget_box('show');
                });
            }
            if (data.pasangan.length) {
                var row;
                $.each(data.pasangan, function (i, v) {
                    $.getJSON(base_url + 'individu/get/' + v.pasangan, function (f) {
                        row = insertIndividuRow('.merge-2', 49);
                        if (v.prop) {
                            row.find('.combofulldate').combodate("setValue", new Date($.parseJSON(v.prop).from));
                        }
                        row.find('select.form-control')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.individu_id) //set value for option to post it
                                        .text(f.individu_name)) //set a text for show in select
                                .val(f.individu_id) //select option of select2
                                .trigger("change"); //apply to select2
                    });
                });
                row.parents('.widget-box').first().widget_box('show');
            }
            if (data.saudara.length) {
                var row;
                $.each(data.saudara, function (i, v) {
                    $.getJSON(base_url + 'individu/get/' + v, function (f) {
                        row = insertIndividuRow('.merge-2', 48);
                        row.find('select')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.individu_id) //set value for option to post it
                                        .text(f.individu_name)) //set a text for show in select
                                .val(f.individu_id) //select option of select2
                                .trigger("change"); //apply to select2
                    });
                });
                row.parents('.widget-box').first().widget_box('show');
            }
            if (data.anak.length) {
                var row;
                $.each(data.anak, function (i, v) {
                    $.getJSON(base_url + 'individu/get/' + v, function (f) {
                        row = insertIndividuRow('.merge-2', 50)
                        row.find('select')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.individu_id) //set value for option to post it
                                        .text(f.individu_name)) //set a text for show in select
                                .val(f.individu_id) //select option of select2
                                .trigger("change"); //apply to select2
                    });
                });
                row.parents('.widget-box').first().widget_box('show');
            }

            //tanggal ngisinya beda
            if (data.born_date) {
                $('.merge-2 input[nm="born_date"]').combodate('setValue', data.born_date);
            }
        });
    })
    $('#individu-modal-form .btn-primary').click(function (e) {
        var form = $('#individu-modal-form form')
                //serialize the form, except those in hidden template
                , h = form.find(":input:not(.template :input)").serialize();
        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: base_url + 'individu/merge', // the url where we want to POST
            data: h, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
                // using the done promise callback
                .done(function (data) {
                    //reset and close modal
                    form[0].reset();
                    $('#individu-modal-form').modal('hide');
                    resetSelection()
                });
    })
    function swapRow($row) {
        //input type input, swap val
        var val1 = $row.find('.merge-1').find('input:not(.combofulldate)')
        var val2 = $row.find('.merge-2').find('input:not(.combofulldate)')
        var vv1 = val1.val()
        val1.val(val2.val())
        val2.val(vv1)
        //input type select, swap option
        var sel1 = $row.find('.merge-1').find('select:not(.day,.month,.year)')
        var sel2 = $row.find('.merge-2').find('select:not(.day,.month,.year)')
        val1 = sel1.val()
        val2 = sel2.val()
        var opt1 = sel1.find('option');
        var opt2 = sel2.find('option');
        if (sel1.hasClass('select2'))
            sel1.empty().append(opt2)
        if (sel2.hasClass('select2'))
            sel2.empty().append(opt1)
        sel1.val(val2)
        sel2.val(val1)
        if (sel1.hasClass('select2'))
            sel1.trigger('change')
        if (sel2.hasClass('select2'))
            sel2.trigger('change')
        //input type combodate, swap val
        var cdate1 = $row.find('.merge-1').find('.combofulldate')
        var cdate2 = $row.find('.merge-2').find('.combofulldate')
        val1 = cdate1.combodate('getValue')
        cdate1.combodate('setValue', cdate2.combodate('getValue'))
        cdate2.combodate('setValue', val1)
    }
    //swap all
    $('#swapall').click(function (evt) {
        //swap content
        var modal = $('#individu-modal-form');
        modal.find('form > .row:not(.widget-box)').each(function (i, v) {
            swapRow($(this))
        })
        modal.find('form > .row.widget-box').each(function (i, v) {
            $(this).find('.swaprecord').click()
        })
    })
    //swap per row
    $('.swaprow').click(function (e) {
        var row = $(this).closest('.row');
        swapRow(row)
    })
    //swap per tipe edge
    $('.swaprecord').click(function (e) {
        //naik ke row & pindah ke next row
        var swaprow = $(this).closest('.row').next()
        var merge1 = swaprow.children('.merge-1')
                , side1 = merge1.find('.form-template:not(.template)').detach()
        var merge2 = swaprow.children('.merge-2')
                , side2 = merge2.find('.form-template:not(.template)').detach()
        //change attribute nm and name
        side1.find('[name]').each(function (i, e) {
            var name = $(this).attr('name');
            $(this).attr('nm', name);
            $(this).removeAttr('name')
        })
        side2.find('[nm]').each(function (i, e) {
            var name = $(this).attr('nm');
            $(this).attr('name', name);
            $(this).removeAttr('nm')
        })
        //tukar
        side1.insertBefore(merge2.children('.form-group'))
        side2.insertBefore(merge1.children('.form-group'))
    })
    //swap per edge
    $('.template-group').on(ace.click_event, '.btn-swap', function (e) {
        //naik sampai form-template
        var ft = $(this).closest('.form-template'),
                template_group = ft.parent()
        if (template_group.hasClass('merge-1')) {
            //ganti semua attribute [name=x] menjadi [nm=x]
            ft.find('[name]').each(function (i, e) {
                var name = $(this).attr('name');
                $(this).attr('nm', name);
                $(this).removeAttr('name')
            })
            //cabut dari merge-1
            ft.detach()
            //pindah ke merge-2
            ft.prependTo(template_group.siblings('.merge-2'))
        } else if (template_group.hasClass('merge-2')) {
            //ganti semua attribute [nm=x] menjadi [name=x]
            ft.find('[nm]').each(function (i, e) {
                var name = $(this).attr('nm');
                $(this).attr('name', name);
                $(this).removeAttr('nm')
            })
            //cabut dari merge-1
            ft.detach()
            //pindah ke merge-2
            ft.prependTo(template_group.siblings('.merge-1'))
        }
    })

    //TODO : khusus keluarga ada special handling
    $('.ayah-swap').click(function (e) {
        //naik sampai ketemu template group
        var tg = $(this).closest('.template-group')
                , ig = $(this).parent(),
                parig = ig.parent(),
                select = $(this).prevAll('select'),
                merge_x = tg.siblings(),
                ig_x = merge_x.find('.ayah .input-group'),
                parig_x = ig_x.parent(),
                select_x = ig_x.children('select')
        //ganti semua attribute [name=x] menjadi [nm=x]
        if (tg.hasClass('merge-1')) {
            var name = select.attr('name');
            select.attr('nm', name);
            select.removeAttr('name');
            name = select_x.attr('nm');
            select_x.attr('name', name);
            select_x.removeAttr('nm');
        } else if (tg.hasClass('merge-2')) {
            var name = select_x.attr('name');
            select_x.attr('nm', name);
            select_x.removeAttr('name');
            name = select.attr('nm');
            select.attr('name', name);
            select.removeAttr('nm');
        }
        //swap igs
        ig.detach().appendTo(parig_x)
        ig_x.detach().appendTo(parig)
    })
    $('.ibu-swap').click(function (e) {
        //naik sampai ketemu template group
        var tg = $(this).closest('.template-group')
                , ig = $(this).parent(),
                parig = ig.parent(),
                select = $(this).prevAll('select'),
                merge_x = tg.siblings(),
                ig_x = merge_x.find('.ibu .input-group'),
                parig_x = ig_x.parent(),
                select_x = ig_x.children('select')
        //ganti semua attribute [name=x] menjadi [nm=x]
        if (tg.hasClass('merge-1')) {
            var name = select.attr('name');
            select.attr('nm', name);
            select.removeAttr('name');
            name = select_x.attr('nm');
            select_x.attr('name', name);
            select_x.removeAttr('nm');
        } else if (tg.hasClass('merge-2')) {
            var name = select_x.attr('name');
            select_x.attr('nm', name);
            select_x.removeAttr('name');
            name = select.attr('nm');
            select.attr('name', name);
            select.removeAttr('nm');
        }
        //swap igs
        ig.detach().appendTo(parig_x)
        ig_x.detach().appendTo(parig)
    })
    $('#family-widget').on(ace.click_event, '.fam-swap:not(.ayah-swap,.ibu-swap)', function (e) {
        //pindahin ke sebelah
        var fg = $(this).closest('.form-group'),
                //naik sampai template-group
                tg = fg.closest('.template-group'),
                tgx = tg.siblings()
        if (tg.hasClass('merge-1')) {
            //name --> nm
            fg.find('[name]').each(function (i, e) {
                var name = $(this).attr('name')
                $(this).attr('nm', name)
                $(this).removeAttr('name')
            })
        } else if (tg.hasClass('merge-2')) {
            //nm --> name
            fg.find('[nm]').each(function (i, e) {
                var name = $(this).attr('nm')
                $(this).attr('name', name)
                $(this).removeAttr('nm')
            })
        }
        var lc = tgx.children('.fam-template');
        fg.detach().insertBefore(lc)
    })
    $('#family-widget .swaprecord').click(function (e) {
        $('#family-widget .form-group:not(.fam-template) .fam-swap').click()
    })
    //init datatable
    var table = $('#individu-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'individu/dt',
            type: 'POST',
            data: function (d) {
                d[$('#csrfform :hidden').attr('name')] = $('#csrfform :hidden').val()
            },
            dataSrc: function (d) {
                $('#csrfform :hidden').val(d[$('#csrfform :hidden').attr('name')])
                return d.data;
            }
        },
        order: [[1, 'asc']],
        //mapping nth-column to data source
        columns: [{
                "searchable": false,
                "orderable": false,
                data: null
            }, //checkbox
            {
                "className": 'center',
                "searchable": false,
                "orderable": false,
                data: 'individu_id',
                render: renderCheckbox
            },
            {data: 'individu_name'}, //nama individu
            {
                data: 'alias'
            },
            {
                data: 'born_date',
                searchable: false,
                render: function (d, t, f, m) {
                    var formatted = f.kotakab || '';
                    if (d) {
                        var date = new Date(d);
                        formatted += ', ' + date.getDate() + '-' + (1 + date.getMonth()) + '-' + date.getFullYear();
                    }
                    return formatted;
                }
            },
            {
                //actions
                width: '100px',
                data: 'individu_id',
                searchable: false,
                render: function (d, t, f, m) {
                    return $('#row-actions').html();
                }
            }
        ]
    });
    table.on('order.dt search.dt draw.dt', function () {
        //biar kolom angka ga ikut ke sort
        var start = table.page.info().start;
        table.column(0, {order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = start + i + 1;
        });
        //kasih class 'selected' kalau row tersebut ada di array selected
        table.rows().every(function (rowIdx, tableLoop, rowLoop) {
            var datax = this.data();
            if (selected.indexOf(datax.individu_id) > -1)
                $(this.node()).addClass('selected')
        });
    }).draw();
    //clear selected
    $('#clear-merge').click(function (e) {
        resetSelection()
    })
    //action for 'delete' button
    $(document).on(ace.click_event, '.action-buttons a.delete', function (e) {
        // popup warning
        var rowID = $(this).closest('tr').attr('id').substr(4);
        bootbox.confirm("Hapus?", function (result) {
            if (result) {
                $.ajax({
                    url: 'individu/' + rowID,
                    type: 'DELETE',
                    success: function (r) {
                        //reload table
                        table.ajax.reload(null, false);
                    }
                });
            }
        });

    });
    //action for 'edit' button
    $(document).on(ace.click_event, '.action-buttons a.edit', function (e) {
        // popup warning
        var rowID = $(this).closest('tr').attr('id').substr(4);
        var win = window.open(base_url + 'individu/edit/' + rowID, '_blank');
        win.focus();
    });
    //action for 'view' button
    $(document).on(ace.click_event, '.action-buttons a.view', function (e) {
        // popup warning
        var rowID = $(this).closest('tr').attr('id').substr(4);
        var win = window.open(base_url + 'individu/graph/' + rowID, '_blank');
        win.focus();
    });

});