<?php
echo js_asset('fuelux/fuelux.wizard.js', 'ace');
echo js_asset('jquery.validate.js', 'ace');
echo js_asset('additional-methods.js', 'ace');
echo js_asset('jquery.maskedinput.js', 'ace');
echo js_asset('select2.js', 'ace');
echo js_asset('bootbox.js', 'ace');
?>
<div id="fuelux-wizard-container">
    <div>
        <!-- #section:plugins/fuelux.wizard.steps -->
        <ul class="steps">
            <li data-step="1" class="active">
                <span class="step">1</span>
                <span class="title">Unggah berkas</span>
            </li>

            <li data-step="2">
                <span class="step">2</span>
                <span class="title">Pemilihan Data</span>
            </li>

            <li data-step="3">
                <span class="step">3</span>
                <span class="title">Preview</span>
            </li>

            <li data-step="4">
                <span class="step">4</span>
                <span class="title">Upload</span>
            </li>
        </ul>

        <!-- /section:plugins/fuelux.wizard.steps -->
    </div>

    <hr />

    <!-- #section:plugins/fuelux.wizard.container -->
    <div class="step-content pos-rel">

        <?php
        $this->load->view('front/update/upload_step');
        $this->load->view('front/update/selection_step');
        $this->load->view('front/update/preview_step');
        ?>
        <div class="step-pane" data-step="4">
            <div class="center">
                <h3 class="green">Ready</h3>
                Click submit to apply the change!
            </div>
        </div>
    </div>

    <!-- /section:plugins/fuelux.wizard.container -->
</div>

<hr />
<div class="wizard-actions">
    <!-- #section:plugins/fuelux.wizard.buttons -->
    <button class="btn btn-prev">
        <i class="ace-icon fa fa-arrow-left"></i>
        Prev
    </button>

    <button class="btn btn-success btn-next" data-last="Submit">
        Next
        <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
    </button>

    <!-- /section:plugins/fuelux.wizard.buttons -->
</div>

<script type="text/javascript">
    jQuery(function ($) {

        $(".select2").css('width', '200px').select2({allowClear: true})
                .on('change', function () {
                    $(this).closest('form').validate().element($(this));
                });

        var $wizard = $('#fuelux-wizard-container')
                .ace_wizard({
                    //step: 2 //optional argument. wizard will jump to step "2" at first
                    //buttons: '.wizard-actions:eq(0)'
                })
                .on('finished.fu.wizard', function (e) {
                    //submit form to update db
                    //append to dom before submit
                    //http://stackoverflow.com/questions/22036361/why-do-i-need-to-append-form-to-body
                    $dummy_form.appendTo('body').submit();
                });
    })
</script>
