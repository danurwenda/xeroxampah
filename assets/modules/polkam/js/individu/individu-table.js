function cloneTemplate(widget) {
    //find template
    var template = $(widget + ' .template');
    var clone = template.clone()
            .removeClass('template hide')
            .insertBefore($(widget + '>.form-group'));
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
    return clone;
}
jQuery(function ($) {
    // EXPANDABLE FIELDS
    //handle "hapus" button
    $('.template-group').on(ace.click_event, '.btn-delete', function () {
        $(this).parents('.form-template').first().remove();
    })
    $('span.plus').on(ace.click_event, function () {
        //find template
        var template = $(this).parents('.template-group').find('.template');
        var clone = template.clone()
                .removeClass('template hide')
                .insertBefore($(this).parents('.form-group').first());
        //initiate jquery plugins/UI
        clone.find('.combofulldate').combodate({maxYear: 2030});
        clone.find('.monthpicker').combodate({
            format: "YYYY-MM-DD", maxYear: 2030,
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
    //SELECTION
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
    $('#individu-table').on('change', '.merge-cb', function (e) {
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

    //LOAD DATA oon show
    $('#individu-modal-form').on('show.bs.modal', function (e) {
        //put selected ids in the form
        var form = $(this).find('form');
        form.find('input:hidden[name=keep]').val(selected[0]);
        form.find('input:hidden[name=discard]').val(selected[1]);
        //populate modal form with selected ids
        var modal = $(this)
                //tarik data dari db
                , inputs = ['individu_name', 'address', 'nationality', 'label', 'alias']
                , selects = ['gender', 'religion', 'recent_edu'];//bisa gini soalnya semuanya tag input
        $.getJSON(base_url + 'individu/get_cascade/' + selected[0], function (data) {
            inputs.forEach(function (v, i) {
                modal.find('.merge-1 input[nm="' + v + '"]').val(data[v]);
            })
            selects.forEach(function (v, i) {
                modal.find('.merge-1 select[nm="' + v + '"]').val(data[v]);
            })
            //kotakab ngisinya beda
            if (data.address_kotakab) {
                $.getJSON(base_url + 'kotakab/get/' + data.address_kotakab, function (kotakab) {
                    $('.merge-1 .kotakab-select2[nm="address_kotakab"]')
                            .empty() //empty select
                            .append($("<option/>") //add option tag in select
                                    .val(kotakab.kotakab_id) //set value for option to post it
                                    .text(kotakab.kotakab)) //set a text for show in select
                            .val(kotakab.kotakab_id) //select option of select2
                            .trigger("change"); //apply to select2
                })
            }
            if (data.born_kotakab) {
                $.getJSON(base_url + 'kotakab/get/' + data.born_kotakab, function (kotakab) {
                    $('.merge-1 .kotakab-select2[nm="born_kotakab"]')
                            .empty() //empty select
                            .append($("<option/>") //add option tag in select
                                    .val(kotakab.kotakab_id) //set value for option to post it
                                    .text(kotakab.kotakab)) //set a text for show in select
                            .val(kotakab.kotakab_id) //select option of select2
                            .trigger("change"); //apply to select2
                })
            }
            //PENDIDIKAN
            if (data.pendidikan) {
                $.each(data.pendidikan, function (i, v) {
                    //create clone from templates
                    var row = cloneTemplate('#edu-widget .merge-1');
                    //set values
                    if (v.prop) {
                        var prop = $.parseJSON(v.prop);
                        if (v.weight == 24 && prop.subjek) {
                            //subjek
                            row.find('.subjek').removeClass('hide')
                                    .find('input').val(prop.subjek);
                        }
                        if (prop.from) {
                            row.find('input[name="edu_start[]"]').combodate("setValue", new Date(prop.from));
                        }
                        if (prop.until) {
                            row.find('input[name="edu_end[]"]').combodate("setValue", new Date(prop.until));
                        }
                    }
                    row.find('.edu-edge').val(v.weight);
                    $.getJSON(base_url + 'school/get/' + v.target, function (f) {
                        row.find('.school-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.school_id) //set value for option to post it
                                        .text(f.school_name)) //set a text for show in select
                                .val(f.school_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
            }
            //tanggal ngisinya beda
            if (data.born_date) {
                $('.merge-1 input[nm="born_date"]').combodate('setValue', data.born_date);
            }
        });
        $.getJSON(base_url + 'individu/get_cascade/' + selected[1], function (data) {
            inputs.forEach(function (v, i) {
                modal.find('.merge-2 input[nm="' + v + '"]').val(data[v]);
            })
            selects.forEach(function (v, i) {
                modal.find('.merge-2 select[nm="' + v + '"]').val(data[v]);
            })
            //kotakab ngisinya beda
            if (data.address_kotakab) {
                $.getJSON(base_url + 'kotakab/get/' + data.address_kotakab, function (kotakab) {
                    $('.merge-2 .kotakab-select2[nm="address_kotakab"]')
                            .empty() //empty select
                            .append($("<option/>") //add option tag in select
                                    .val(kotakab.kotakab_id) //set value for option to post it
                                    .text(kotakab.kotakab)) //set a text for show in select
                            .val(kotakab.kotakab_id) //select option of select2
                            .trigger("change"); //apply to select2
                })
            }
            if (data.born_kotakab) {
                $.getJSON(base_url + 'kotakab/get/' + data.born_kotakab, function (kotakab) {
                    $('.merge-2 .kotakab-select2[nm="born_kotakab"]')
                            .empty() //empty select
                            .append($("<option/>") //add option tag in select
                                    .val(kotakab.kotakab_id) //set value for option to post it
                                    .text(kotakab.kotakab)) //set a text for show in select
                            .val(kotakab.kotakab_id) //select option of select2
                            .trigger("change"); //apply to select2
                })
            }
            //PENDIDIKAN
            if (data.pendidikan) {
                $.each(data.pendidikan, function (i, v) {
                    //create clone from templates
                    var row = cloneTemplate('#edu-widget .merge-2');
                    //set values
                    if (v.prop) {
                        var prop = $.parseJSON(v.prop);
                        if (v.weight == 24 && prop.subjek) {
                            //subjek
                            row.find('.subjek').removeClass('hide')
                                    .find('input').val(prop.subjek);
                        }
                        if (prop.from) {
                            row.find('input[name="edu_start[]"]').combodate("setValue", new Date(prop.from));
                        }
                        if (prop.until) {
                            row.find('input[name="edu_end[]"]').combodate("setValue", new Date(prop.until));
                        }
                    }
                    row.find('.edu-edge').val(v.weight);
                    $.getJSON(base_url + 'school/get/' + v.target, function (f) {
                        row.find('.school-select2')
                                .empty() //empty select
                                .append($("<option/>") //add option tag in select
                                        .val(f.school_id) //set value for option to post it
                                        .text(f.school_name)) //set a text for show in select
                                .val(f.school_id) //select option of select2
                                .trigger("change"); //apply to select2
                    })
                })
            }
            //tanggal ngisinya beda
            if (data.born_date) {
                $('.merge-2 input[nm="born_date"]').combodate('setValue', data.born_date);
            }
        });
    })
    $('#individu-modal-form .btn-primary').click(function (e) {
        var form = $('#individu-modal-form form')
                //serialize the form
                , h = form.serialize();
        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: base_url + 'individu/merge', // the url where we want to POST
            data: h, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
                // using the done promise callback
                .done(function (data) {
                    //reset and close modal
                    form[0].reset();
                    $('#individu-modal-form').modal('hide');
                    resetSelection()
                });
    })
    function swapRow($row) {
        //input type input, swap val
        var val1 = $row.find('.merge-1').find('input:not(.combofulldate)')
        var val2 = $row.find('.merge-2').find('input:not(.combofulldate)')
        var vv1 = val1.val()
        val1.val(val2.val())
        val2.val(vv1)
        //input type select, swap option
        var sel1 = $row.find('.merge-1').find('select:not(.day,.month,.year)')
        var sel2 = $row.find('.merge-2').find('select:not(.day,.month,.year)')
        val1 = sel1.val()
        val2 = sel2.val()
        var opt1 = sel1.find('option');
        var opt2 = sel2.find('option');
        if (sel1.hasClass('select2'))
            sel1.empty().append(opt2)
        if (sel2.hasClass('select2'))
            sel2.empty().append(opt1)
        sel1.val(val2)
        sel2.val(val1)
        if (sel1.hasClass('select2'))
            sel1.trigger('change')
        if (sel2.hasClass('select2'))
            sel2.trigger('change')
        //input type combodate, swap val
        var cdate1 = $row.find('.merge-1').find('.combofulldate')
        var cdate2 = $row.find('.merge-2').find('.combofulldate')
        val1 = cdate1.combodate('getValue')
        cdate1.combodate('setValue', cdate2.combodate('getValue'))
        cdate2.combodate('setValue', val1)
    }
    //swap all
    $('#swapall').click(function (evt) {
        //swap content
        var modal = $('#individu-modal-form');
        modal.find('form > .row:not(.widget-box)').each(function (i, v) {
            swapRow($(this))
        })
        modal.find('form > .row.widget-box').each(function (i, v) {
            $(this).find('.swaprecord').click()
        })
    })
    //swap per row
    $('.swaprow').click(function (e) {
        var row = $(this).closest('.row');
        swapRow(row)
    })
    //swap per tipe edge
    $('.swaprecord').click(function (e) {
        //naik ke row & pindah ke next row
        var swaprow = $(this).closest('.row').next()
        var merge1 = swaprow.children('.merge-1')
                , side1 = merge1.find('.form-template:not(.template)').detach()
        var merge2 = swaprow.children('.merge-2')
                , side2 = merge2.find('.form-template:not(.template)').detach()
        //tukar
        side1.insertBefore(merge2.children('.form-group'))
        side2.insertBefore(merge1.children('.form-group'))
    })
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
        order: [[1, 'asc']],
        //mapping nth-column to data source
        columns: [{
                "searchable": false,
                "orderable": false,
                data: null
            }, //checkbox
            {
                "className": 'center',
                "searchable": false,
                "orderable": false,
                data: 'individu_id',
                render: renderCheckbox
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
    table.on('order.dt search.dt draw.dt', function () {
        //biar kolom angka ga ikut ke sort
        var start = table.page.info().start;
        table.column(0, {order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = start + i + 1;
        });
        //kasih class 'selected' kalau row tersebut ada di array selected
        table.rows().every(function (rowIdx, tableLoop, rowLoop) {
            var datax = this.data();
            if (selected.indexOf(datax.individu_id) > -1)
                $(this.node()).addClass('selected')
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
        var win = window.open(base_url + 'individu/graph/' + rowID, '_blank');
        win.focus();
    });

});