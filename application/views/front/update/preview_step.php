<div class="step-pane" data-step="3">
    <div id="preview"  style="overflow-x: hidden;height:400px;width:100%;"></div>
</div>
<?php
echo js_asset('hot.js', 'polkam');
echo css_asset('handsontable.full.min.css', 'polkam');
?>
<script>
    jQuery(function ($) {
        var preview = null;
        var $wizard = $('#fuelux-wizard-container')
                .on('changed.fu.wizard', function (e, info) {
                    if ($(this).data('fu.wizard').selectedItem().step === 3) {
                        //render excel using params from previous step
                        if (preview_data !== null) {
                            //sudah ada data
                            if (preview !== null) {
                                preview.destroy();
                            }
                            preview = new Handsontable(
                                    document.getElementById('preview'),
                                    {
                                        colHeaders: true,
                                        rowHeaders: true,
//                                        stretchH: 'all',
                                        readOnly: true,
                                        contextMenu: false,
                                    }
                            );
                            preview.setDataAtCell(preview_data);
                        }
                    }
                });
    });
</script>