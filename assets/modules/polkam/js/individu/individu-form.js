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
                        form.find('.btn-delete:not(.template *)').click();
                        $('#individu-modal-form').modal('hide');
                    });
    });

    // PENGAJIAN
    $('#pengajian-modal-form .btn-primary').click(function (e) {
        //serialize the form
        // process the form
        var x = $('#pengajian-modal-form form').serialize();
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: base_url + 'pengajian/post', // the url where we want to POST
            data: x, // our data object
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
        $('#pengajian-modal-form form')[0].reset();
        $('#pengajian-modal-form').modal('hide');
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
    // SCHOOL
    $('#school-modal-form .btn-primary').click(function (e) {
        //serialize the form
        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: base_url + 'school/post', // the url where we want to POST
            data: $('#school-modal-form form').serialize(), // our data object
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
        $('#school-modal-form form')[0].reset();
        $('#school-modal-form').modal('hide');
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
        var x = $('#teror-modal-form form').serialize();
        console.log(x)
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: base_url + 'teror/post', // the url where we want to POST
            data: x, // our data object
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
    // LATIHAN
    $('#latihan-modal-form .btn-primary').click(function (e) {
        //serialize the form
        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: base_url + 'latihan/post', // the url where we want to POST
            data: $('#latihan-modal-form form').serialize(), // our data object
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
        $('#latihan-modal-form form')[0].reset();
        $('#latihan-modal-form').modal('hide');
    });
    // LATSEN
    $('#latsen-modal-form .btn-primary').click(function (e) {
        //serialize the form
        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: base_url + 'latsen/post', // the url where we want to POST
            data: $('#latsen-modal-form form').serialize(), // our data object
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
        $('#latsen-modal-form form')[0].reset();
        $('#latsen-modal-form').modal('hide');
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
                    '<input class="form-control combofulldate" name="married_date[]" type="text" data-format="YYYY-MM-DD" data-template="DD MMM YYYY" /></div>');
            date.find('input').combodate({
                minYear: 1950
            })
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
    })
    // RIWAYAT PENDIDIKAN
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
    $('#pengajian-modal-form .school-select2').select2(school_select_config)
    $('#pengajian-modal-form .masjid-select2').select2(masjid_select_config)

    //popover
    $('[data-rel=popover]').popover({container: 'body'});
    //combodate
    $('.combofulldate:not(.template *)').combodate();
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
    $('select.male-select2').select2(male_select_config);
    $('select.female-select2').select2(female_select_config);
    $('select.individu-select2').select2(individu_select_config);
    $('.modal .monthpicker').combodate({
        format: "YYYY-MM-DD",
        template: "MMM YYYY"
    });
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

    //when the form is submitted, add additional hidden from wysiwyg
    $('#individu_form').submit(function (e) {
//        e.preventDefault();
        //cek incomplete date
        $('.monthpicker+.combodate .year').each(function(i){
            //cek apakah ada yang cuma diisi tahunnya doank
            if($(this).val() && !$(this).prev().val()){
                $(this).prev().val(6).trigger('change');
            }
        });
        $('.combofulldate+.combodate .year').each(function(i){
            //cek apakah ini keisi tahunnya doank
            if($(this).val() && !$(this).prev().val()){
                $(this).prev().val(6).trigger('change');
            }
        });
        //delete all hidden templates
        $(this).find('.template.hide').remove();

        //refresh csrf from csrf hidden form, in case it's already changed
        var csrf = $(this).find('input[name="' + $('#csrfform :hidden').attr('name') + '"]')
        csrf.val($('#csrfform :hidden').val())

        console.log($(this).serializeArray());
    });

});
