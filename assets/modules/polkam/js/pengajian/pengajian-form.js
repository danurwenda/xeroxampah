jQuery(function ($) {
    //select2
    $('.masjid-select2').select2(masjid_select_config);
    $('.school-select2').select2(school_select_config);
    console.log('ikeh init')
    // MASJID
    $('#masjid-modal-form .btn-primary').click(function (e) {
        //serialize the form
        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: base_url + 'masjid', // the url where we want to POST
            data: $('#masjid-modal-form form').serialize(), // our data object
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
        $('#masjid-modal-form form')[0].reset();
        $('#masjid-modal-form').modal('hide');
    });
    // SCHOOL
    $('#school-modal-form .btn-primary').click(function (e) {
        //serialize the form
        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: base_url + 'school', // the url where we want to POST
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
    $('#pengajian_form').validate({
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
            topik: {
                required: true,
                minlength: 5
            }
        },
    });

});
