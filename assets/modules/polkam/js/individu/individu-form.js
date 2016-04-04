jQuery(function ($) {
    // ============== MODALS TO CREATE ENTITY ==========================
    // INDIVIDU
    $('#individu-modal-form .btn-primary').click(function (e) {
        var form = $('#individu-modal-form form')
                //serialize the form, except those in hidden template
                , h = form.find(":input:not(.template :input)").serialize();
        // process the form
        if (true)
            $.ajax({
                type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                url: base_url + 'individu/submit', // the url where we want to POST
                data: h, // our data object
                dataType: 'json', // what type of data do we expect back from the server
                encode: true
            })
                    // using the done promise callback
                    .done(function (data) {
                        //reset and close modal
                        form[0].reset();
                        //reset expandable
                        form.find('.btn-delete').click();
                        $('#individu-modal-form').modal('hide');
                    });
    });

    // ORGANISASI
    $('#organisasi-modal-form .btn-primary').click(function (e) {
        //serialize the form
        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: base_url + 'organisasi/post', // the url where we want to POST
            data: $('#organisasi-modal-form form').serialize(), // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
                // using the done promise callback
                .done(function (data) {

                    // log data to the console so we can see
                    console.log(data);

                    // here we will handle errors and validation messages
                });
        //reset and close modal
        $('#organisasi-modal-form form')[0].reset();
        $('#organisasi-modal-form').modal('hide');
    });
    // SEKOLAH
    $('#sekolah-modal-form .btn-primary').click(function (e) {
        //serialize the form
        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: base_url + 'sekolah/post', // the url where we want to POST
            data: $('#sekolah-modal-form form').serialize(), // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
                // using the done promise callback
                .done(function (data) {

                    // log data to the console so we can see
                    console.log(data);

                    // here we will handle errors and validation messages
                });
        //reset and close modal
        $('#sekolah-modal-form form')[0].reset();
        $('#sekolah-modal-form').modal('hide');
    });
    // LAPAS
    $('#lapas-modal-form .btn-primary').click(function (e) {
        //serialize the form
        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: base_url + 'lapas/post', // the url where we want to POST
            data: $('#lapas-modal-form form').serialize(), // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
                // using the done promise callback
                .done(function (data) {

                    // log data to the console so we can see
                    console.log(data);

                    // here we will handle errors and validation messages
                });
        //reset and close modal
        $('#lapas-modal-form form')[0].reset();
        $('#lapas-modal-form').modal('hide');
    });
    // NONTEROR
    $('#nonteror-modal-form .btn-primary').click(function (e) {
        //serialize the form
        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: base_url + 'nonteror/post', // the url where we want to POST
            data: $('#nonteror-modal-form form').serialize(), // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
                // using the done promise callback
                .done(function (data) {

                    // log data to the console so we can see
                    console.log(data);

                    // here we will handle errors and validation messages
                });
        //reset and close modal
        $('#nonteror-modal-form form')[0].reset();
        $('#nonteror-modal-form').modal('hide');
    });
    // TEROR
    $('#teror-modal-form .btn-primary').click(function (e) {
        //serialize the form
        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: base_url + 'teror/post', // the url where we want to POST
            data: $('#teror-modal-form form').serialize(), // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
                // using the done promise callback
                .done(function (data) {

                    // log data to the console so we can see
                    console.log(data);

                    // here we will handle errors and validation messages
                });
        //reset and close modal
        $('#teror-modal-form form')[0].reset();
        $('#teror-modal-form').modal('hide');
    });
    // FAMILY
    $('#family-modal-form .btn-primary').click(function (c) {
        $('#family-modal-form').modal('hide');
        //insert new row di keluarga
        var template = $('.fam-template');
        var clone = template.clone();
        clone.insertBefore(template).removeClass('hide fam-template');
        //ganti nama field
        var selected = $('#fam-field').val();
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
                    '<input class="form-control date-picker" name="married_date[]" type="text" data-date-format="dd/mm/yyyy">' +
                    '<span class="input-group-addon">' +
                    '<i class="fa fa-calendar bigger-110"></i>' +
                    '</span></div>');
            date.find('input').datepicker({
                autoclose: true,
                format: "dd/mm/yyyy",
                todayHighlight: true
            })
                    //show datepicker when clicking on the icon
                    .next().on(ace.click_event, function () {
                $(this).prev().focus();
            });
            clone.find('.input-group')
                    .after(date);
        }


    });
    // EXPANDABLE FIELDS
    //handle "hapus" button
    $('.template-group').on(ace.click_event, '.btn-delete', function () {
        $(this).parents('.form-template').first().remove();
    })
    $('span.plus').on(ace.click_event, function () {
        //find template
        var template = $(this).parents('.widget-main').find('.template');
        var clone = template.clone()
                .removeClass('template hide')
                .insertBefore($(this).parents('.form-group').first());
        //initiate jquery plugins/UI
        clone.find('.input-daterange').datepicker({autoclose: true,
            format: "dd/mm/yyyy"});
        clone.find('.monthpicker').datepicker({
            autoclose: true,
            format: "mm-yyyy",
            startView: "months",
            minViewMode: "months"
        });
        clone.find('.organisasi-select2').select2(organisasi_select_config)
        clone.find('.lapas-select2').select2(lapas_select_config)
        clone.find('.sekolah-select2').select2(sekolah_select_config)
        clone.find('.nonteror-select2').select2(nonteror_select_config);
        clone.find('.teror-select2').select2(teror_select_config);
        clone.find('.month-picker')
                .datepicker({
                    autoclose: true,
                    format: "dd/mm/yyyy",
                    todayHighlight: true
                })
                //show datepicker when clicking on the icon
                .next().on(ace.click_event, function () {
            $(this).prev().focus();
        })
        clone.find('.date-picker')
                .datepicker({
                    autoclose: true,
                    format: "dd/mm/yyyy",
                    todayHighlight: true
                })
                //show datepicker when clicking on the icon
                .next().on(ace.click_event, function () {
            $(this).prev().focus();
        })
    })
    // RIWAYAT PENDIDIKAN
    $('.input-daterange').datepicker({autoclose: true,
        format: "dd/mm/yyyy"});
    $('#edu-widget').on('change', '.edu-edge', function () {
        var select = $(this);
        var row = $('<div class="form-group">' +
                '<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Sebagai </label>' +
                '<div class="col-sm-9"></div>' +
                '</div>');
        //convert to number
        var val = +select.val();
        switch (val) {
            case 22:
                //mudir
                break;
            case 23:
                //pendiri
                //tambah info : sumber dana
                break;
            case 24:
                //pengajar
                //tambah info : subjek yang diajar
                row.find('label').text('Subjek');
                row.find('.col-sm-9').append('<input type="text" class="addition input-sm form-control" name="edu_end[]" />');
                row.insertBefore(select.parents('.form-group').first())
                break;
            case 51:
                //santri/murid
                break;
            case 52:
                //staf
                //tambah info : posisi
                break;
            default:
                alert('def')

        }
    });


    //popover
    $('[data-rel=popover]').popover({container: 'body'});
    //create datepicker
    $('.date-picker').datepicker({
        autoclose: true,
        format: "dd/mm/yyyy",
        todayHighlight: true
    })
            //show datepicker when clicking on the icon
            .next().on(ace.click_event, function () {
        $(this).prev().focus();
    });
    $('.time-picker').timepicker({
        minuteStep: 1,
        showSeconds: true,
        showMeridian: false
    }).next().on(ace.click_event, function () {
        $(this).prev().focus();
    });

    //create wysiwyg editor
    $('.wysiwyg-editor').css({'height': '200px'}).ace_wysiwyg({
        toolbar:
                [
                    'bold',
                    'italic',
                    'strikethrough',
                    null,
                    'insertunorderedlist',
                    'insertorderedlist',
                    null,
                    'foreColor',
                    null,
                    'backColor'
                ],
        speech_button: false
    });

    // AUTO COMPLETES
    // input type di autocomplete ini akan auto-add jika bukan reference
    //individu
    $('select.individu-select2').select2(individu_select_config);

    //masjid

    $('.masjid-autocomplete').autocomplete(masjid_autocomplete_config);
    //lapas

    $('.lapas-autocomplete').autocomplete(lapas_autocomplete_config);
    //jaringan
    var network_autocomplete_config = {
        source: base_url + "network/search",
        minLength: 4,
        create: function (e) {
            $(this).next('.ui-helper-hidden-accessible').remove();
        },
        select: function (e, ui) {
            $(this).data('reference_id', ui.item.id);
        }
    };
    $('.network-autocomplete').autocomplete(network_autocomplete_config);

    //PLUS button adding new field
    $('#family-plus span').on(ace.click_event, function () {
        //kasih opsi pasangan, saudara dan anak
        console.log('sesuatu');
    });

    //when the form is submitted, add additional hidden from wysiwyg
    $('#individu_form').on('submit', function (e) {
        //delete all hidden templates
        $(this).find('.template.hide').remove();
        //REPLACE AUTOCOMPLETE WITH ID
        var ac_inputs = $(this).find('input.ui-autocomplete-input');
        ac_inputs.each(function (i) {
            var id = $(this).data('reference_id');
            if (id) {
                $(this).val(id);
            }
        });


        //refresh csrf from csrf hidden form, in case it's already changed
        var csrf = $(this).find('input[name="' + $('#csrfform :hidden').attr('name') + '"]')
        csrf.val($('#csrfform :hidden').val())

//        e.preventDefault();
    });

});
function formatIndividuList(individu) {
    if (individu.loading)
        return individu.text;

    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + individu.individu_name + "</div>";

    if (individu.alias) {
        markup += "<div class='select2-result-repository__description'>Alias : " + individu.alias + "</div>";
    }

    markup += "<div class='select2-result-repository__statistics'>" +
            "<div class='select2-result-repository__forks'>TTL : " + individu.born_place + ', ' + individu.born_date + "</div>" +
            "</div>" +
            "</div></div>";

    return markup;
}

function formatIndividuSelection(repo) {
    return repo.individu_name || repo.alias;
}
var individu_select_config = {
    ajax: {
        url: base_url + "individu/search",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                term: params.term, // search term
                page: params.page
            };
        },
        processResults: function (data, params) {
            return {
                results: data
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) {
        return markup;
    },
    minimumInputLength: 1,
    templateResult: formatIndividuList,
    templateSelection: formatIndividuSelection
};
function formatNonTerorList(nt) {
    if (nt.loading)
        return nt.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + nt.pidana + ' ' + nt.korban + "</div>";

    if (nt.nilai) {
        markup += "<div class='select2-result-repository__description'>Nilai : " + nt.nilai + "</div>";
    }

    markup += "<div class='select2-result-repository__statistics'>" +
            "<div class='select2-result-repository__forks'>" + nt.tempat + ', ' + nt.tanggal + "</div>" +
            "</div>" +
            "</div></div>";

    return markup;
}

function formatNonTerorSelection(nt) {
    return nt.pidana + ' ' + nt.korban;
}
var nonteror_select_config = {
    ajax: {
        url: base_url + "nonteror/search",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                term: params.term, // search term
                page: params.page
            };
        },
        processResults: function (data, params) {
            return {
                results: data
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) {
        return markup;
    },
    minimumInputLength: 1,
    templateResult: formatNonTerorList,
    templateSelection: formatNonTerorSelection
};
function formatTerorList(nt) {
    if (nt.loading)
        return nt.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + nt.serangan + ' ' + nt.sasaran + "</div>";



    markup += "<div class='select2-result-repository__statistics'>" +
            "<div class='select2-result-repository__forks'>" + nt.tempat + ', ' + nt.tanggal + "</div>" +
            "</div>" +
            "</div></div>";

    return markup;
}

function formatTerorSelection(nt) {
    return nt.serangan + ' ' + nt.sasaran;
}
var teror_select_config = {
    ajax: {
        url: base_url + "teror/search",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                term: params.term, // search term
                page: params.page
            };
        },
        processResults: function (data, params) {
            return {
                results: data
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) {
        return markup;
    },
    minimumInputLength: 1,
    templateResult: formatTerorList,
    templateSelection: formatTerorSelection
};
function formatLapasList(l) {
    if (l.loading)
        return l.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + l.name + "</div>" +
            "</div></div>";

    return markup;
}

function formatLapasSelection(l) {
    return l.name;
}
var lapas_select_config = {
    ajax: {
        url: base_url + "lapas/search",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                term: params.term, // search term
                page: params.page
            };
        },
        processResults: function (data, params) {
            return {
                results: data
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) {
        return markup;
    },
    minimumInputLength: 1,
    templateResult: formatLapasList,
    templateSelection: formatLapasSelection
};
function formatOrganisasiList(org) {
    if (org.loading)
        return org.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + org.org_name + "</div>" +
            "</div></div>";

    return markup;
}

function formatOrganisasiSelection(org) {
    return org.org_name;
}
var organisasi_select_config = {
    ajax: {
        url: base_url + "organisasi/search",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                term: params.term, // search term
                page: params.page
            };
        },
        processResults: function (data, params) {
            return {
                results: data
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) {
        return markup;
    },
    minimumInputLength: 1,
    templateResult: formatOrganisasiList,
    templateSelection: formatOrganisasiSelection
};
function formatSekolahList(org) {
    if (org.loading)
        return org.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'>" + org.name + "</div>" +
            "</div></div>";

    return markup;
}

function formatSekolahSelection(org) {
    return org.name;
}
var sekolah_select_config = {
    ajax: {
        url: base_url + "sekolah/search",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                term: params.term, // search term
                page: params.page
            };
        },
        processResults: function (data, params) {
            return {
                results: data
            };
        },
        cache: true
    },
    escapeMarkup: function (markup) {
        return markup;
    },
    minimumInputLength: 1,
    templateResult: formatSekolahList,
    templateSelection: formatSekolahSelection
};
var masjid_autocomplete_config = {
    source: base_url + "masjid/search",
    minLength: 4,
    create: function (e) {
        $(this).next('.ui-helper-hidden-accessible').remove();
    },
    select: function (e, ui) {
        $(this).data('reference_id', ui.item.id);
    }
};
var lapas_autocomplete_config = {
    source: base_url + "lapas/search",
    minLength: 4,
    create: function (e) {
        $(this).next('.ui-helper-hidden-accessible').remove();
    },
    select: function (e, ui) {
        $(this).data('reference_id', ui.item.id);
    }
};