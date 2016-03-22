jQuery(function ($) {

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
        clone.find('.organisasi-autocomplete').autocomplete(organisasi_autocomplete_config)
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
    $('#edu-widget').on('change', '.edu-select', function () {
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
                alert('mudir')
                break;
            case 23:
                //pendiri
                //tambah info : sumber dana
                alert('pendiri')
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
                alert('santri')
                break;
            case 52:
                //staf
                //tambah info : posisi
                alert('staf')
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
    $('select.individu-autocomplete').select2(individu_select_config);


    //organisasi

    $('.organisasi-autocomplete').autocomplete(organisasi_autocomplete_config);
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

    //PLUS button adding new row
    $('.expandable').next().on(ace.click_event, function () {
        var input_group = $(this).parents('div.input-group').first();
        expandInputGroup(input_group);
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
function formatIndividu(individu) {
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
    templateResult: formatIndividu,
    templateSelection: formatIndividuSelection
};
var organisasi_autocomplete_config = {
    source: base_url + "organisasi/search",
    minLength: 4,
    create: function (e) {
        $(this).next('.ui-helper-hidden-accessible').remove();
    },
    select: function (e, ui) {
        $(this).data('reference_id', ui.item.org_id);
    }
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
function expandInputGroup(input_group) {
    var group = input_group.parent();
    var clone = input_group.clone();
    var minus = $('<i class="fa fa-minus bigger-110"></i>').on(ace.click_event, function () {
        $(this).parents('div.input-group').first().remove();
    });
    clone.find('.input-group-addon').empty().append(minus);
    //bersih2 value
    var input = clone.find('input');
    input.each(function (i) {
        if ($(this).hasClass('individu-autocomplete')) {
            $(this).autocomplete(individu_autocomplete_config);
        } else if ($(this).hasClass('organisasi-autocomplete')) {
            $(this).autocomplete(organisasi_autocomplete_config);
        } else if ($(this).hasClass('masjid-autocomplete')) {
            $(this).autocomplete(masjid_autocomplete_config);
        }
    });
    input.val('');

    //append
    clone.appendTo(group);
    return input;
}
    