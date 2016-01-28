<div class="step-pane" data-step="2" style="height: 300px">
    <h3 class="lighter block green">Select chart to config</h3>
    <div class="col-md-6 col-md-offset-3">
        <ol id="selectable" class="col-sm-7">
            <li class="ui-state-default" position="0"></li>
            <li class="ui-state-default" position="1"></li>
            <li class="ui-state-default" position="2"></li>
            <li class="ui-state-default" position="3"></li>
        </ol>
    </div>
</div>
<style>
    #feedback { font-size: 1.4em; }
    #selectable.ui-selectable-disabled{cursor: not-allowed;}
    #selectable .ui-selecting { background: #00b3ee; }
    #selectable .ui-selected { background: #46b8da; color: white; }
    #selectable { list-style-type: none; margin: 0; padding: 0; width: 450px; cursor:pointer; }
    #selectable>li { margin: 3px; padding: 1px; float: left; width: 45%; height: 100px;  border:1px solid black;}
</style>
<?php
echo js_asset('jquery-ui.js', 'ace');
echo css_asset('jquery-ui.css', 'ace');
?>
<script>
    $(function () {
        var selectedChart = -1;

        //check whether a chart is selected before advance to the next step
        var $wizard = $('#fuelux-wizard-container')
                .on('actionclicked.fu.wizard', function (e, info) {
                    if (info.step == 2) {
                        if (selectedChart < 0) {
                            alert('pilih dulu');
                            e.preventDefault();
                        }
                    }
                });
        //makes charts list selectable
        $("#selectable").selectable({
            //by default selection is disabled
            disabled: true,
            selected: function () {
                $(".ui-selected", this).each(function () {
                    selectedChart = $("#selectable li").index(this);
                });
                //prepare list of series from selected chart (if any)
                var indicators = $('.ui-selected', this).find('li');
                var placeholder = $('<li class="placeholder">Add your items here</li>');
                var $ol = $('#cart ol');
                //kosongkan yang ada
                $ol.empty();

                if (indicators.length > 0) {
                    indicators.each(function (i) {
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
                                placeholder.appendTo($ol);
                        }).append($('<i/>', {
                            class: 'ace-icon fa fa-trash-o bigger-130'
                        }));
                        $li
                                .data('iid', $(this).data('iid'))
                                .append($(this).text(), $delButton)
                                .appendTo($ol);
                    });
                } else {
                    //put placeholder
                    placeholder.appendTo($ol)
                }
                //force advance
                var wizard = $wizard.data('fu.wizard');
                //move to step 3
                wizard.currentStep = 3;
                wizard.setState();
            }
        });
    });
</script>

