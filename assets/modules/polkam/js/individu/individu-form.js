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
        clone.find('input')
                .attr('placeholder', text)
                .attr('name', 'relation_' + selected + '[]')
                //make it autocomplete
                .autocomplete(individu_autocomplete_config)
                .autocomplete("instance")._renderItem = function (ul, item) {
            var li = $("<li>");
            if (item.label) {
                li.append(item.label);
            }
            if (item.born_date) {
                var bd = new Date(item.born_date);
                li.append(
                        "<br>Lahir :" +
                        item.born_place + ', ' + bd.getDate() + '-' + (bd.getMonth() + 1) + '-' + bd.getYear()
                        );
            }
            li.appendTo(ul);
            return li;
        };
        if (selected == 49) {
            //tambah field kapan nikah
            var date = $('<div class="input-group">' +
                    '<input class="form-control date-picker" id="born_date" name="born_date" type="text" data-date-format="dd/mm/yyyy">' +
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
    // RIWAYAT PENGGUNAAN NAMA & RIWAYAT ORGANISASI
    //handle "hapus" button
    $('.template-group').on(ace.click_event, '.btn-delete', function () {
        $(this).parents('.form-template').first().remove();
    })
    $('span.plus').on(ace.click_event, function () {
        //find template
        var template = $(this).parents('.widget-main').find('.template');
        var clone = template.clone()
                .removeClass('template hide')
                .insertAfter(template);
        clone.find('.input-daterange').datepicker({autoclose: true});
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
    $('.input-daterange').datepicker({autoclose: true});    
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

    $('.individu-autocomplete').autocomplete(individu_autocomplete_config);
    $('.individu-autocomplete').each(function (i) {
        $(this).autocomplete("instance")._renderItem = function (ul, item) {
            var li = $("<li>");
            if (item.label) {
                li.append(item.label);
            }
            if (item.born_date) {
                var bd = new Date(item.born_date);
                li.append(
                        "<br>Lahir :" +
                        item.born_place + ', ' + bd.getDate() + '-' + (bd.getMonth() + 1) + '-' + bd.getYear()
                        );
            }
            li.appendTo(ul);
            return li;
        };
    })
    //pesantren

    $('.pesantren-autocomplete').autocomplete(pesantren_autocomplete_config);
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
        //put the editor's HTML into hidden_input and it will be sent to server along with other fields
        //formal education
        var formaledu = $(this).find('input[name="formaledu"]');
        if (formaledu.length === 0) {
            //create
            formaledu = $('<input type="hidden" name="formaledu" />')
                    .appendTo(this);
        }
        formaledu.val($('#formaledu-editor').html());
        //nonformal education
        var nonformaledu = $(this).find('input[name="nonformaledu"]');
        if (nonformaledu.length === 0) {
            //create
            nonformaledu = $('<input type="hidden" name="nonformaledu" />')
                    .appendTo(this);
        }
        //nonformal education
        var military = $(this).find('input[name="military"]');
        if (military.length === 0) {
            //create
            military = $('<input type="hidden" name="military" />')
                    .appendTo(this);
        }
        military.val($('#military-editor').html());
        //riwayat organisasi
        var organisasi = $(this).find('input[name="organisasi"]');
        if (organisasi.length === 0) {
            //create
            organisasi = $('<input type="hidden" name="organisasi" />')
                    .appendTo(this);
        }
        organisasi.val($('#organisasi-editor').html());
        //riwayat job
        var job = $(this).find('input[name="job"]');
        if (job.length === 0) {
            //create
            job = $('<input type="hidden" name="job" />')
                    .appendTo(this);
        }
        job.val($('#job-editor').html());
        //riwayat radikal
        var radikal = $(this).find('input[name="radikal"]');
        if (radikal.length === 0) {
            //create
            radikal = $('<input type="hidden" name="radikal" />')
                    .appendTo(this);
        }
        radikal.val($('#radikal-editor').html());
        //riwayat teror
        var teror = $(this).find('input[name="teror"]');
        if (teror.length === 0) {
            //create
            teror = $('<input type="hidden" name="teror" />')
                    .appendTo(this);
        }
        teror.val($('#teror-editor').html());
        //riwayat perbuatan
        var perbuatan = $(this).find('input[name="perbuatan"]');
        if (perbuatan.length === 0) {
            //create
            perbuatan = $('<input type="hidden" name="perbuatan" />')
                    .appendTo(this);
        }
        perbuatan.val($('#perbuatan-editor').html());
        //riwayat relasi
        var relasi = $(this).find('input[name="relasi"]');
        if (relasi.length === 0) {
            //create
            relasi = $('<input type="hidden" name="relasi" />')
                    .appendTo(this);
        }
        relasi.val($('#relasi-editor').html());

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
    });

});
var individu_autocomplete_config = {
    source: base_url + "individu/search",
    minLength: 4,
    create: function (e) {
        $(this).next('.ui-helper-hidden-accessible').remove();
    },
    select: function (e, ui) {
        $(this).data('reference_id', ui.item.individu_id);
    }
};
var pesantren_autocomplete_config = {
    source: base_url + "school/search",
    minLength: 4,
    create: function (e) {
        $(this).next('.ui-helper-hidden-accessible').remove();
    },
    select: function (e, ui) {
        $(this).data('reference_id', ui.item.id);
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
        } else if ($(this).hasClass('pesantren-autocomplete')) {
            $(this).autocomplete(pesantren_autocomplete_config);
        } else if ($(this).hasClass('masjid-autocomplete')) {
            $(this).autocomplete(masjid_autocomplete_config);
        }
    });
    input.val('');

    //append
    clone.appendTo(group);
    return input;
}
    