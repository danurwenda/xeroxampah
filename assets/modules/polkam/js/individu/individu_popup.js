jQuery(function ($) {
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
        order: [[0, 'desc']],
        //mapping nth-column to data source
        columns: [
            {data: 'name'}, //nama individu
            {data: 'network'}, //nama individu
            {
                data: 'born_date',
                render: function (d, t, f, m) {
                    var formatted = f.born_place || '';
                    if (d) {
                        var date = new Date(d);
                        formatted += ', ' + date.getDate() + '-' + (1+date.getMonth()) + '-' + date.getFullYear();
                    }
                    return formatted;
                }
            }, //nama individu
            {
                //long desc
                data: 'arrested',
                render: function (data, type, full, meta) {
                    return data;
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

    //handle submit on add/edit
    $('#modal-form button.submit-button').click(function () {
        $('#modal-form').find('form').first().submit();
    })
    //when the form is submitted, add additional hidden from wysiwyg
    $('#leform').on('submit', function (e) {
        //put the editor's HTML into hidden_input and it will be sent to server along with other fields
        //detention history
        var detention_history = $(this).find('input[name="detention_history"]');
        if (detention_history.length === 0) {
            //create
            detention_history = $('<input type="hidden" name="detention_history" />')
                    .appendTo(this);
        }
        detention_history.val($('#detention-editor').html());
        //detention status
        var detention_status = $(this).find('input[name="detention_status"]');
        if (detention_status.length === 0) {
            //create
            detention_status = $('<input type="hidden" name="detention_status" />')
                    .appendTo(this);
        }
        detention_status.val($('#status-editor').html());
        //education status
        var education = $(this).find('input[name="education"]');
        if (education.length === 0) {
            //create
            education = $('<input type="hidden" name="education" />')
                    .appendTo(this);
        }
        education.val($('#education-editor').html());
        //refresh csrf from csrf hidden form, in case it's already changed
        var csrf = $(this).find('input[name="' + $('#csrfform :hidden').attr('name') + '"]')
        csrf.val($('#csrfform :hidden').val())
        //ajax submit form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: 'individu/post', // the url where we want to POST
            data: $(this).serialize(), // our data object
            //dataType: 'json', // what type of data do we expect back from the server
        }).done(function (d) {
            console.log(d)
            // using the done promise callback
            d = JSON.parse(d)
            // renew csrf
            $('#csrfform :hidden').val(d[$('#csrfform :hidden').attr('name')])

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
        $form.find('.wysiwyg-editor').each(function () {
            $(this).attr('contenteditable', $(this).prev().toggle(b).is(':visible'))
        });
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
            $(leForm).find('.wysiwyg-editor').html('')
            //enable field
            enableField(true);
            //remove 'id' field, if any
            $(leForm).find('input[name="individu_id"]').remove();
        } else {
            //query
            var individu_id = $(e.relatedTarget).closest('tr').attr('id').substr(4);
            $.getJSON('individu/get/' + individu_id, function (d) {
                //populate fields
                $(leForm).find('#source_id').val(d.source_id)
                $(leForm).find('#name').val(d.name)
                $(leForm).find('#alias').val(d.alias)
                $(leForm).find('#affiliation').val(d.affiliation)
                $(leForm).find('#nationality').val(d.nationality)
                $(leForm).find('#family_conn').val(d.family_conn)
                $(leForm).find('#born_place').val(d.born_place)
                $(leForm).find('#born_date').datepicker('update', d.born_date ? new Date(d.born_date) : '')
                $(leForm).find('#detention-editor').html(d.detention_history)
                $(leForm).find('#status-editor').html(d.detention_status)
                $(leForm).find('#education-editor').html(d.education)
            })
            if (action == 'edit') {
                enableField(true)
                //add 'id' field
                var id_field = $(leForm).find('input[name="individu_id"]');
                if (id_field.length == 0) {
                    //create
                    id_field = $('<input type="hidden" name="individu_id" />')
                            .appendTo(leForm);
                }
                id_field.val(individu_id);
            } else if (action == 'view') {
                enableField(false)
            }
        }
    })

});