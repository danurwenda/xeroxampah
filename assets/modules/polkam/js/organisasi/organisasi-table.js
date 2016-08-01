jQuery(function ($) {
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
    $('#organisasi-table').on('change', '.merge-cb', function (e) {
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
    $('#organisasi-modal-form').on('show.bs.modal', function (e) {
        $('#organisasi-table').find('tr > td:nth-child(2) input:checkbox:checked').each(function () {
            selected.push($(this).val())
        })
        //put selected ids in the form
        var form = $(this).find('form');
        form.find('input:hidden[name=keep]').val(selected[0]);
        form.find('input:hidden[name=discard]').val(selected[1]);
        //populate modal form with selected ids
        var modal = $(this)
                //tarik data dari db
                , fields = ['name', 'daerah', 'label']; //bisa gini soalnya semuanya tag input
        $.getJSON(base_url + 'organisasi/get/' + selected[0], function (data) {
            fields.forEach(function (v, i) {
                modal.find('.merge-1 input[nm="' + v + '"]').val(data[v]);
            })
        });
        $.getJSON(base_url + 'organisasi/get/' + selected[1], function (data) {
            fields.forEach(function (v, i) {
                modal.find('.merge-2 input[nm="' + v + '"]').val(data[v]);
            })
        });
    })
    $('#organisasi-modal-form .btn-primary').click(function (e) {
        var form = $('#organisasi-modal-form form')
                //serialize the form
                , h = form.serialize();
        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: base_url + 'organisasi/merge', // the url where we want to POST
            data: h, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
                // using the done promise callback
                .done(function (data) {
                    //reset and close modal
                    form[0].reset();
                    $('#organisasi-modal-form').modal('hide');
                    resetSelection()

                });
    })
    function swapRow($row) {
        //input type input, swap val
        var val1 = $row.find('.merge-1').find('input')
        var val2 = $row.find('.merge-2').find('input')
        var vv1 = val1.val()
        val1.val(val2.val())
        val2.val(vv1)
        //input type select, swap option
        var sel1 = $row.find('.merge-1').find('select')
        var sel2 = $row.find('.merge-2').find('select')
        val1 = sel1.val()
        val2 = sel2.val()
        var opt1 = sel1.find('option');
        var opt2 = sel2.find('option');
        sel1.empty().append(opt2).val(val2)
        sel2.empty().append(opt1).val(val1)
    }
    //swap all
    $('#swapall').click(function (evt) {
        //swap content
        var modal = $('#organisasi-modal-form');
        modal.find('form .row').each(function (i, v) {
            swapRow($(this))
        })
    })
    //swap per row
    $('.swaprow').click(function (e) {
        var row = $(this).closest('.row');
        swapRow(row)
    })
    var table = $('#organisasi-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'organisasi/dt',
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
        columns: [
            {
                "searchable": false,
                "orderable": false,
                data: null
            },
            //checkbox
            {
                "className": 'center',
                "searchable": false,
                "orderable": false,
                data: 'organisasi_id',
                render: renderCheckbox
            },
            {data: 'name'}, //nama organisasi
            {
                data: 'daerah'
            },
            {
                //actions
                width: '100px',
                data: 'organisasi_id',
                searchable: false,
                render: function (d, t, f, m) {
                    return $('#row-actions').html();
                }
            }
        ]
    });
    //biar kolom angka ga ikut ke sort
    table.on('order.dt search.dt draw.dt', function () {
        var start = table.page.info().start;
        table.column(0, {order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = start + i + 1;
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
    //action for 'edit' button
    $(document).on(ace.click_event, '.action-buttons a.edit', function (e) {
// popup warning
        var rowID = $(this).closest('tr').attr('id').substr(4);
        var win = window.open(base_url + 'organisasi/edit/' + rowID, '_blank');
        win.focus();
    });
    //action for 'view' button
    $(document).on(ace.click_event, '.action-buttons a.view', function (e) {
// popup warning
        var rowID = $(this).closest('tr').attr('id').substr(4);
        var win = window.open(base_url + 'graph/organisasi/' + rowID, '_blank');
        win.focus();
    });
});