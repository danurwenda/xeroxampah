jQuery(function ($) {
    //init datatable
    var table = $('#nonteror-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'nonteror/dt',
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
        columns: [{
                "searchable": false,
                "orderable": false,
                data:null
            },
            {data: 'tempat'}, //nama nonteror
            {
                data: 'tanggal',
                searchable:false
            },
            {
                data: 'korban'
            },
            {
                //actions
                width: '100px',
                data: 'nonteror_id',
                searchable: false,
                render: function (d, t, f, m) {
                    return $('#row-actions').html();
                }
            }
        ]
    });//biar kolom angka ga ikut ke sort
    table.on('order.dt search.dt draw.dt', function () {
        var start = table.page.info().start;
        table.column(0, {order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = start+i+1;
        } );
    }).draw();
    //action for 'delete' button
    $(document).on(ace.click_event, '.action-buttons a.delete', function (e) {
        // popup warning
        var rowID = $(this).closest('tr').attr('id').substr(4);
        bootbox.confirm("Hapus?", function (result) {
            if (result) {
                $.ajax({
                    url: 'nonteror/' + rowID,
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
        var win = window.open(base_url + 'nonteror/edit/' + rowID, '_blank');
        win.focus();
    });
    //action for 'view' button
    $(document).on(ace.click_event, '.action-buttons a.view', function (e) {
        // popup warning
        var rowID = $(this).closest('tr').attr('id').substr(4);
        var win = window.open(base_url + 'graph/nonteror/' + rowID, '_blank');
        win.focus();
    });

});