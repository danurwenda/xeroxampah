jQuery(function ($) {
    //init datatable
    var table = $('#organisasi-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {url: 'organisasi/dt', type: 'POST'},
        order: [[0, 'desc']],
        //mapping nth-column to data source
        columns: [
            {data: 'org_name'}, //nama organisasi
            {data: 'address'}, //alamat
            {
                //long desc
                data: 'description',
                render: function (data, type, full, meta) {
                    return type === 'display' && data.length > 60 ?
                            '<span title="' + removeTags(data) + '">' + removeTags(data).substr(0, 58) + '...</span>' :
                            data;
                }
            },
            {
                //actions
                width: '100px',
                data: 'org_id',
                searchable: false,
                render: function (d, t, f, m) {
                    return $('#row-actions').html();
                }
            }
        ]
    });
    //action for 'delete' button
    $(document).on(ace.click_event, '.action-buttons a.delete', function (e) {
        // popup warning
        var rowID = $(this).closest('tr').attr('id').substr(4);
        bootbox.confirm("Hapus?", function (result) {
            if (result) {
                $.ajax({
                    url: 'organisasi/' + rowID,
                    type: 'DELETE',
                    success: function (r) {
                        //reload table
                        table.ajax.reload(null, false);
                    }
                });
            }
        });

    });
    //create wysiwyg editor
    $('#editor2').css({'height': '200px'}).ace_wysiwyg({
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

    //handle submit on add/edit
    $('#modal-form button.submit-button').click(function () {
        $('#modal-form').find('form').first().submit();
    })
    //when the form is submitted, add additional hidden from wysiwyg
    $('#modal-form').find('form').first().on('submit', function (e) {
        //put the editor's HTML into hidden_input and it will be sent to server along with other fields
        var id_field = $(this).find('input[name="description"]');
        if (id_field.length === 0) {
            //create
            id_field = $('<input type="hidden" name="description" />')
                    .appendTo(this);
        }
        id_field.val($('#editor2').html());
        //ajax submit form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: 'organisasi/post', // the url where we want to POST
            data: $(this).serialize(), // our data object
            //dataType: 'json', // what type of data do we expect back from the server
        }).done(function (data) {
            // using the done promise callback

            // log data to the console so we can see
            console.log(data);

            // here we will handle errors and validation messages

            // close the modal
            $('#modal-form').modal('hide');

            //reload table
            table.ajax.reload(null, false);
        });
        e.preventDefault();
    });
    function enableField(b) {
        var $form = $('#modal-form').find('form').first();
        // all standard input
        $form.find('input').prop('disabled', !b);
        // chosen
//        $form.find('.chosen-select').attr('disabled',!b).trigger('chosen:updated');
        // wysiwyg editor
        $form.find('#editor2').attr('contenteditable', $form.find('#editor2').prev().toggle(b).is(':visible'))
        //when fields are disabled, hide "save" button
        $('#modal-form').find('.submit-button').toggle(b);
    }
    //init form element on modal
    $('#modal-form').on('shown.bs.modal', function (e) {
        var modal = $(this);
        var leForm = modal.find('form')[0];
        var action = $(e.relatedTarget).data('action');
        if (action == 'add') {
            //reset form
            leForm.reset();
            $(leForm).find('#editor2').html('')
            //enable field
            enableField(true);
            //remove 'id' field, if any
            $(leForm).find('input[name="org_id"]').remove();
        } else {
            //query
            var org_id = $(e.relatedTarget).closest('tr').attr('id').substr(4);
            $.getJSON('organisasi/get/' + org_id, function (d) {
                //populate fields
                $(leForm).find('#source_id').val(d.source_id)
                $(leForm).find('#org_name').val(d.org_name)
                $(leForm).find('#org_address').val(d.address)
                $(leForm).find('#org_website').val(d.website)
                $(leForm).find('#org_email').val(d.email)
                $(leForm).find('#org_phone').val(d.phone)
                $(leForm).find('#editor2').html(d.description)
            })
            if (action == 'edit') {
                enableField(true)
                //add 'id' field
                var id_field = $(leForm).find('input[name="org_id"]');
                if (id_field.length == 0) {
                    //create
                    id_field = $('<input type="hidden" name="org_id" />')
                            .appendTo(leForm);
                }
                id_field.val(org_id);
            } else if (action == 'view') {
                enableField(false)
            }
        }
    })

});