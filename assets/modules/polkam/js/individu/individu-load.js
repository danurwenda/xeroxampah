function load_individu(id) {
    $.getJSON(base_url + 'individu/get_cascade/' + id, function (data) {
        $('#individu_form').append($('<input/>', {type: 'hidden', name: 'individu_id', value: data.individu_id}));

        $('#individu_form input[name="individu_name"]').val(data.individu_name);
        $('#individu_form input[name="religion"]').val(data.religion);
        $('#individu_form select[name="gender"]').val(data.gender);
        $('#individu_form input[name="alias"]').val(data.alias);
        //add selected city if any and select it in dropdown
        if (data.born_kotakab) {
            $.getJSON(base_url + 'kotakab/get/' + data.born_kotakab, function (kotakab) {
                $('#individu_form select[name="born_kotakab"]')
                        .empty() //empty select
                        .append($("<option/>") //add option tag in select
                                .val(kotakab.kotakab_id) //set value for option to post it
                                .text(kotakab.kotakab)) //set a text for show in select
                        .val(kotakab.kotakab_id) //select option of select2
                        .trigger("change"); //apply to select2
            })
        }
        if (data.address_kotakab) {
            $.getJSON(base_url + 'kotakab/get/' + data.address_kotakab, function (kotakab) {
                $('#individu_form select[name="address_kotakab"]')
                        .empty() //empty select
                        .append($("<option/>") //add option tag in select
                                .val(kotakab.kotakab_id) //set value for option to post it
                                .text(kotakab.kotakab)) //set a text for show in select
                        .val(kotakab.kotakab_id) //select option of select2
                        .trigger("change"); //apply to select2
            })
        }
        if(data.born_date)
        $('#individu_form input[name="born_date"]').combodate("setValue", new Date(data.born_date));
        $('#individu_form input[name="nationality"]').val(data.nationality);
        $('#individu_form input[name="address"]').val(data.address);
        $('#individu_form select[name="recent_edu"]').val(data.recent_edu);
        var prop = $.parseJSON(data.properties);
        if(prop){
        //RIWAYAT NAMA
        if (prop.namas) {
            $.each(prop.namas, function (i, v) {
                //create clone
                var row = cloneTemplate('#nama-widget');
                //set values
                row.find('input[name="old_name[]"]').val(v.nama);
                row.find('input[name="lokasi_nama[]"]').val(v.location);
                row.find('input[name="nama_date[]"]').combodate("setValue", new Date(v.time));
            });
        }
        //RIWAYAT PEKERJAAN
        if (prop.jobs) {
            $.each(prop.jobs, function (i, v) {
                //create clone
                var row = cloneTemplate('#job-widget');
                //set values
                row.find('input[name="job_place[]"]').val(v.job);
                row.find('input[name="job_end[]"]').combodate("setValue", new Date(v.until));
                row.find('input[name="job_start[]"]').combodate("setValue", new Date(v.from));
            });
        }
        //RIWAYAT PENANGKAPAN
        if (prop.tangkaps) {
            $.each(prop.tangkaps, function (i, v) {
                //create clone
                var row = cloneTemplate('#tangkap-widget');
                //set values
                row.find('input[name="tangkap_lokasi[]"]').val(v.location);
                row.find('input[name="tangkap_date[]"]').combodate("setValue", new Date(v.date));
            });
        }}
        // KELUARGA
        //ayah
        if (data.father) {
            $.getJSON(base_url + 'individu/get/' + data.father, function (f) {
                $('select[name="father"]')
                        .empty() //empty select
                        .append($("<option/>") //add option tag in select
                                .val(f.individu_id) //set value for option to post it
                                .text(f.individu_name)) //set a text for show in select
                        .val(f.individu_id) //select option of select2
                        .trigger("change"); //apply to select2
            });
        }
        if (data.mother) {
            $.getJSON(base_url + 'individu/get/' + data.mother, function (f) {
                $('select[name="mother"]')
                        .empty() //empty select
                        .append($("<option/>") //add option tag in select
                                .val(f.individu_id) //set value for option to post it
                                .text(f.individu_name)) //set a text for show in select
                        .val(f.individu_id) //select option of select2
                        .trigger("change"); //apply to select2
            });
        }
        if (data.pasangan) {
            $.each(data.pasangan, function (i, v) {
                $.getJSON(base_url + 'individu/get/' + v.pasangan, function (f) {
                    var row = insertIndividuRow(49);
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
        }
        if (data.bap) {
            $.each(data.bap, function (i, v) {
               var row = cloneTemplate('#bap-widget');
               //ubah input file menjadi link download
               row.find('input[type=file]').parent().empty()
                       .append("<a href='"+base_url+"uploads/"+v+"' >"+v+"</a>");
               //dan kasih special handling buat tombol hapus
               row.find('button').click(function(){
                   //mark for deletion (but don't delete now)
                   $('#individu_form').append($('<input/>', {type: 'hidden', name: 'deleted_bap[]', value: v}));
               });
            });
        }
        if (data.saudara) {
            $.each(data.saudara, function (i, v) {
                $.getJSON(base_url + 'individu/get/' + v, function (f) {
                    insertIndividuRow(48).find('select')
                            .empty() //empty select
                            .append($("<option/>") //add option tag in select
                                    .val(f.individu_id) //set value for option to post it
                                    .text(f.individu_name)) //set a text for show in select
                            .val(f.individu_id) //select option of select2
                            .trigger("change"); //apply to select2
                });

            });
        }
        if (data.anak) {
            $.each(data.anak, function (i, v) {
                $.getJSON(base_url + 'individu/get/' + v, function (f) {
                    insertIndividuRow(50).find('select')
                            .empty() //empty select
                            .append($("<option/>") //add option tag in select
                                    .val(f.individu_id) //set value for option to post it
                                    .text(f.individu_name)) //set a text for show in select
                            .val(f.individu_id) //select option of select2
                            .trigger("change"); //apply to select2
                });

            });
        }
        //PENDIDIKAN
        if (data.pendidikan) {
            $.each(data.pendidikan, function (i, v) {
                //create clone from templates
                var row = cloneTemplate('#edu-widget');
                //set values
                if (v.prop) {
                    var prop = $.parseJSON(v.prop);
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
                                    .text(f.name)) //set a text for show in select
                            .val(f.school_id) //select option of select2
                            .trigger("change"); //apply to select2
                })
            })
        }
        //ORGANISASI
        if (data.organisasi) {
            $.each(data.organisasi, function (i, v) {
                //create clone from templates
                var row = cloneTemplate('#org-widget');
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
        }
        //LAPAS
        if (data.lapas) {
            $.each(data.lapas, function (i, v) {
                //create clone from templates
                var row = cloneTemplate('#lapas-widget');
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
        }
        //TEROR
        if (data.teror) {
            $.each(data.teror, function (i, v) {
                //create clone from templates
                var row = cloneTemplate('#teror-widget');
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
        }
        //LATSEN
        if (data.latsen) {
            $.each(data.latsen, function (i, v) {
                //create clone from templates
                var row = cloneTemplate('#latsen-widget');
                //set values
                row.find('[name="latsen_edge[]"]').val(v.weight);
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
        }
        //LATIHAN
        if (data.latihan) {
            $.each(data.latihan, function (i, v) {
                //create clone from templates
                var row = cloneTemplate('#latihan-widget');
                //set values
                row.find('[name="latihan_edge[]"]').val(v.weight);
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
        }
        //NONTEROR
        if (data.nonteror) {
            $.each(data.nonteror, function (i, v) {
                //create clone from templates
                var row = cloneTemplate('#nonteror-widget');
                //set values
                row.find('[name="nonteror_edge[]"]').val(v.weight);
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
        }
        //PENGAJIAN
        if (data.pengajian) {
            $.each(data.pengajian, function (i, v) {
                //create clone from templates
                var row = cloneTemplate('#pengajian-widget');
                //set values
                row.find('[name="pengajian_edge[]"]').val(v.weight);
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
        }
    });
}

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

function insertIndividuRow(selected) {
    //insert new row di keluarga
    var template = $('.fam-template');
    var clone = template.clone();
    clone.insertBefore(template).removeClass('hide fam-template');
    //ganti nama field
    var text = $('#fam-field option[value="' + selected + '"]').text();
    clone.find('label')
            .html(text);
    clone.find('select')
            .attr('name', 'relation_' + selected + '[]')
            //make it autocomplete
            .select2(individu_select_config);
    if (selected == 49) {
        //tambah field kapan nikah
        var date = $('<div class="input-group">' +
                '<input class="form-control combofulldate" name="married_date[]" type="text" data-format="YYYY-MM-DD" data-template="DD MMM YYYY" /></div>');
        date.find('input').combodate({
            minYear: 1950
        })
        clone.find('.input-group')
                .after(date);
    }
    return clone;
}