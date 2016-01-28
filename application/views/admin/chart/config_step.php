<div class="step-pane" data-step="3">
    <div class="row">
        <h3 class="row header smaller lighter blue">
            <span class="col-xs-6"> Header </span><!-- /.col -->
        </h3>
        <div>
            <form class="form-horizontal" id="config-form">
                <div class="form-group">
                    <label for="header_target" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right">Title links to</label>

                    <div class="col-xs-12 col-sm-5">
                        <span class="block input-icon input-icon-right">
                            <select class="form-control" id="header_target" name="header_target">
                                <option value="0" class="nolink"></option>
                            </select>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="header_text" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right">Title text</label>

                    <div class="col-xs-12 col-sm-5">
                        <span class="block input-icon input-icon-right">
                            <input type="text" id="header_text" name="header_text" class="width-100" />
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="sub_text" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right">Subtitle text</label>

                    <div class="col-xs-12 col-sm-5">
                        <span class="block input-icon input-icon-right">
                            <input type="text" id="sub_text" name="sub_text" class="width-100" />
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <h3 class="row header smaller lighter blue">
                <span class="col-xs-6"> Indicators </span><!-- /.col -->
            </h3>

            <div>
                <table id="indicator-table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Satuan</th>
                            <th>Frekuensi</th>
                            <th>Nilai akhir</th>
                            <th>
                                <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                                Tanggal terakhir
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div><!-- /.col -->

        <div class="col-sm-6">
            <h3 class="row header smaller lighter blue">
                <span class="col-xs-6"> Drop here </span><!-- /.col -->
            </h3>
            <div id="cart" class="well well-sm"> 
                <ol>
                    <li class="placeholder">Add your items here</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<?php
echo js_asset('jquery.dataTables.js', 'ace');
echo js_asset('jquery.dataTables.bootstrap.js', 'ace');
?>
<script>
    $(function () {
        var $wizard = $('#fuelux-wizard-container')
                .on('actionclicked.fu.wizard', function (e, info) {
                    if (info.step == 3) {
                        if ($('#selection-form').valid()) {
                            //submit form using ajax
                            //put return data (array of array) to a global variable
                            //after done, jump to next step
                            $.ajax({
                                type: "POST",
                                url: 'upload/get_sheet_data',
                                data: $('#selection-form').serialize(),
                                dataType: 'json',
                                success: function (data) {
                                    //return value berupa array of [row,col,val]
                                    preview_data = data;
                                    //jump
                                    var wizard = $wizard.data('fu.wizard');
                                    //move to step 4
                                    wizard.currentStep = 4;
                                    wizard.setState();
                                    //create dummy form
                                    $dummy_form = $('<form/>', {
                                        action: "upload/submit",
                                        method: "POST"
                                    });
                                    //add serialized data from #selection-form
                                    $.each($('#selection-form').serializeArray(), function (a, b) {
                                        $dummy_form.append('<input type="hidden" name="' + b.name + '" value="' + b.value + '">');
                                    });
                                }
                            });
                        }
                        e.preventDefault();
                    }
                })
                .on('changed.fu.wizard', function () {
                    if ($(this).data('fu.wizard').selectedItem().step === 3) {
                        //initiate dataTable after all data is populated (from the 1st step of wizard)
                        //and after this step is loaded
                        if (!$.fn.dataTable.isDataTable('#indicator-table')) {
                            $('#indicator-table').dataTable({
                                paging: false,
                                scrollCollapse: true,
                                scrollY: '200px',
                                aaSorting: []//disable initial sorting
                            });
                        } else {
                            $('#indicator-table').DataTable().draw();
                        }
                        //make it draggable
                        $("#indicator-table tbody tr").draggable({
                            appendTo: "body",
                            cursorAt: {left: 5, top: 20},
                            helper: "clone",
                            start: function (e, ui) {
                                var name = $(this).find('.in-name').text();
                                $(ui.helper).data('iid', $(this).data('iid')).html(name)
                            }
                        });
                    }
                });

        $("#cart ol").droppable({
            activeClass: "ui-state-default",
            hoverClass: "ui-state-hover",
            accept: ":not(.ui-sortable-helper)",
            drop: function (event, ui) {
                var $ol = $(this);
                $ol.find(".placeholder").remove();
                var $li = $("<li/>", {
                    class: 'action-buttons'
                });
                var $delButton = $('<a/>', {
                    class: 'pull-right red'
                }).click(function () {
                    //remove $li from ol
                    $li.remove();
                    //check apakah list kosong, jika ya kasih placeholder
                    if ($ol.children('li').length < 1)
                        $('<li class="placeholder">Add your items here</li>').appendTo($ol);
                }).append($('<i/>', {
                    class: 'ace-icon fa fa-trash-o bigger-130'
                }));
                $li
                        .data('iid', ui.helper.data('iid'))
                        .append(ui.helper.text(), $delButton)
                        .appendTo($ol);
            }
        }).sortable({
            items: "li:not(.placeholder)",
            sort: function () {
                // gets added unintentionally by droppable interacting with sortable
                // using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
                $(this).removeClass("ui-state-default");
            }
        });
    });
</script>