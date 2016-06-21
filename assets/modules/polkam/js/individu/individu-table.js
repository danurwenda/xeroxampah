jQuery(function ($) {
    //init datatable
    var oTable1 = $('#individu-table').DataTable({
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
        order: [[1, 'asc']],
        //mapping nth-column to data source
        columns: [
            {
                "searchable": false,
                "orderable": false,
                data:null
            },
            {data: 'individu_name'}, //nama individu
            {
                data: 'alias'
            },
            {
                data: 'born_date',
                searchable: false,
                render: function (d, t, f, m) {
                    var formatted = f.kotakab || '';
                    if (d) {
                        var date = new Date(d);
                        formatted += ', ' + date.getDate() + '-' + (1 + date.getMonth()) + '-' + date.getFullYear();
                    }
                    return formatted;
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
    //biar kolom angka ga ikut ke sort
    oTable1.on('order.dt search.dt draw.dt', function () {
        var start = oTable1.page.info().start;
        oTable1.column(0, {order:'applied'}).nodes().each( function (cell, i) {
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
                    url: 'individu/' + rowID,
                    type: 'DELETE',
                    success: function (r) {
                        //reload table
                        oTable1.ajax.reload(null, false);
                    }
                });
            }
        });

    });
    //action for 'edit' button
    $(document).on(ace.click_event, '.action-buttons a.edit', function (e) {
        // popup warning
        var rowID = $(this).closest('tr').attr('id').substr(4);
        var win = window.open(base_url + 'individu/edit/' + rowID, '_blank');
        win.focus();
    });
    //action for 'view' button
    $(document).on(ace.click_event, '.action-buttons a.view', function (e) {
        // popup warning
        var rowID = $(this).closest('tr').attr('id').substr(4);
        var win = window.open(base_url + 'graph/individu/' + rowID, '_blank');
        win.focus();
    });

});