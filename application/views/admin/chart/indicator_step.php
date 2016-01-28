<div class="step-pane" data-step="1">
    <div class="col-xs-12">
        <!-- #section:elements.tab.position -->
        <div class="tabbable tabs-left">
            <form id="indicator-selection">
                <ul class="nav nav-tabs" id="myTab3">
                    <!-- level 1 indikator ini cuma 44 dan 53 --> 
                    <?php foreach ($indikators as $i) { ?>
                        <li>
                            <a data-toggle="tab" href="#i<?php echo $i->indikator_id; ?>">
                                <i class="pink ace-icon fa fa-tachometer bigger-110"></i>
                                <?php echo $i->indikator_name; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>

                <div class="tab-content">
                    <!-- foreach lvl 1 indikator -->
                    <?php foreach ($indikators as $i) { ?>
                        <div id="i<?php echo $i->indikator_id ?>" class="tab-pane in">
                            <!-- daftar lvl 2 indikator -->
                            <?php foreach ($i->children as $l2) { ?>
                                <div class="radio">
                                    <label>
                                        <input name="selected_lv2" type="radio" class="ace" value="<?php echo $l2->indikator_id; ?>">
                                        <span class="lbl"><?php echo $l2->indikator_name; ?></span>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </form>
        </div>
        <!-- /section:elements.tab.position -->
    </div>
</div>
<script>
    $(function () {
        var validator = $('#indicator-selection').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            onkeyup: false,
            onsubmit: false,
            onfocusout: false,
            onclick: false,
            rules: {
                selected_lv2: {
                    required: true
                }
            },
            messages: {
                selected_lv2: "Please choose parent indicator"
            },
            highlight: function (e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },
            success: function (e) {
                $(e).closest('.form-group').removeClass('has-error');//.addClass(has-info);
                $(e).remove();
            },
            errorPlacement: function (error, element) {
                if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                    var controls = element.closest('div[class*="col-"]');
                    if (controls.find(':checkbox,:radio').length > 1)
                        controls.append(error);
                    else
                        error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                }
                else if (element.is('.select2')) {
                    error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
                }
                else if (element.is('.chosen-select')) {
                    error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                }
                else
                    error.insertAfter(element.parent());
            },
            submitHandler: function (form) {
            },
            invalidHandler: function (form) {
            }
        });
        var $wizard = $('#fuelux-wizard-container')
                .on('actionclicked.fu.wizard', function (e, info) {
                    if (info.step == 1) {
                        //make sure ada indikator lvl 1 selected
                        if ($('#indicator-selection').valid()) {
                            //apa sih yang selected
                            var selected = $("input:radio[name=selected_lv2]:checked").val();
                            //fetch charts for selected indicator
                            //to be displayed on the next wizard step
                            $.getJSON('get_chart/' + selected, function (d) {
                                //by default semua list dianggap kosong
                                $('#selectable>li').html('Select to create chart');
                                $.each(d, function (i, e) {
                                    var position = e.position;
                                    var judul = e.title;
                                    var $li = $('#selectable>li[position=' + position + ']');
                                    //title                            
                                    $li.html('<h5>' + judul + '</h5>');
                                    //indicators              
                                    var $ul = $('<ul/>');
                                    $.each(e.series, function (id, el) {
                                        $('<li/>')
                                                .data('iid', el.indikator_id)
                                                .html(el.indikator_name)
                                                .appendTo($ul);
                                    });
                                    $ul.appendTo($li);
                                });
                            });
                            //fetch subindicators of selected indicator
                            //to be displayed on the next 2 step
                            //check datatable, destroy if exist
                            if ($.fn.dataTable.isDataTable('#indicator-table')) {
                                $('#indicator-table').DataTable().clear().destroy();
                            }
                            //disable selectable when fetching inserting row into table
                            $("#selectable").selectable("option", "disabled", true);
                            $.getJSON('get_json_children/1/' + selected, function (valueds) {

                                var $table = $('#indicator-table tbody');
                                //clear all row
                                $table.html('');
                                $.each(valueds, function (i, e) {
                                    var row = $('<tr/>', {
                                        id: 'row' + i
                                    }).data('iid', e.indikator_id);
                                    $('<td/>', {
                                        class: 'in-name'
                                    }).html(e.indikator_name).appendTo(row);
                                    $('<td/>').html(e.unit).appendTo(row);
                                    $('<td/>').html(e.name).appendTo(row);
                                    $('<td/>').html(e.last_value).appendTo(row);
                                    $('<td/>').html(e.last_update).appendTo(row);
                                    row.appendTo($table)
                                })
                                //all done, enable selectable
                                $("#selectable").selectable('enable');
                            })
                            //add non-valued indicator to be linked to chart header
                            $.getJSON('get_json_children/0/' + selected, function (n) {
                                var $header = $('#header_target');
                                //clear all option except default option (nolink)
                                $header.find('option').not('.nolink').remove();
                                //add options to dropdown
                                $.each(n, function (i, e) {
                                    $('<option/>', {
                                        value: e.indikator_id
                                    })
                                            .data('source',e.source)
                                            .html(e.indikator_name)
                                            .appendTo('#header_target')
                                })
                                //event listener on change, we update text and source
                                $header.change(function(){
                                    $('#header_text').val($header.find('option:selected').text())
                                    $('#sub_text').val($header.find('option:selected').data('source'))
                                })
                            })
                        } else {
                            e.preventDefault()
                        }
                    }
                });
    });
</script>