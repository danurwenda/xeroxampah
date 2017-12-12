jQuery(function ($) {
    // ============== MODALS TO CREATE ENTITY ==========================
    // KOTAKAB
    $('#kotakab-modal-form .btn-primary').click(function (e) {
        var form = $('#kotakab-modal-form form')
                //serialize the form, except those in hidden template
                , h = form.find(":input").serialize();
        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: base_url + 'kotakab/submit', // the url where we want to POST
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
                    $('#kotakab-modal-form').modal('hide');
                });
    });
    function formatKotakabList(org) {
        return org.kotakab
    }

    function formatKotakabSelection(org) {
        return org.kotakab||org.text;
    }
    var kotakab_select_config = {
        ajax: {
            url: base_url + "kotakab/search",
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
        minimumInputLength: 1, allowClear: true, placeholder: '',
        templateResult: formatKotakabList,
        templateSelection: formatKotakabSelection
    };
    $('select.kotakab-select2').select2(kotakab_select_config);
    $('.combofulldate').combodate();
    
    $('#latsen_form').validate({
        errorElement: 'div',
        errorClass: 'help-block',
        focusInvalid: false,
        ignore: "",
        highlight: function (e) {
            $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
        },
        success: function (e) {
            $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
            $(e).remove();
        },
        errorPlacement: function (error, element) {
            if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                var controls = element.closest('div[class*="col-"]');
                if (controls.find(':checkbox,:radio').length > 1)
                    controls.append(error);
                else
                    error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            } else if (element.is('.select2')) {
                error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
            } else if (element.is('.chosen-select')) {
                error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            } else
                error.insertAfter(element.parent());
        },
        
        invalidHandler: function (form) {
        },
        rules: {
            tempat: {
                required: true,
                minlength: 5
            },
            materi: {
                required: true,
                minlength: 4
            }
        },
    });

});
