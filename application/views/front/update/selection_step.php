
<div class="step-pane" data-step="2">
    <h3 class="lighter block green">Enter the following information</h3>

    <?php echo form_open('', array('class' => "form-horizontal", 'id' => "selection-form")); ?>
    <div class="form-group" id="uploaded-files">
        <label for="radioFilename" class="col-xs-12 col-sm-3 control-label no-padding-right">Select sheet</label>

        <div class="col-xs-12 col-sm-5">
            <div class="control-group">
                <!-- recent uploaded files -->

            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="transposeCB" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right">Transpose</label>

        <div class="col-xs-12 col-sm-5">
            <div class="control-group">
                <div class="checkbox">
                    <label>
                        <input name="transposeCB" type="checkbox" class="ace" />
                        <span class="lbl"> check this if dates are arranged in a column instead of a row</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- /section:elements.form.input-state -->
    <div class="form-group">
        <label for="id-column" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right">Column of <span id="id-text">ID</span>s</label>

        <div class="col-xs-12 col-sm-5">
            <span class="block input-icon input-icon-right">
                <input type="text" id="id-column" name="id_column" class="width-100" placeholder="A" />
            </span>
        </div>
    </div>

    <div class="form-group">
        <label for="date-row" class="col-xs-12 col-sm-3 col-md-3 control-label no-padding-right">Row of <span id="date-text">date</span>s</label>

        <div class="col-xs-12 col-sm-5">
            <span class="block input-icon input-icon-right">
                <input type="text" id="date-row" name="date_row" class="width-100" placeholder="1" />
            </span>
        </div>
    </div>

    <div class="form-group">
        <label for="rows" class="col-xs-12 col-sm-3 control-label no-padding-right">Selected rows</label>

        <div class="col-xs-12 col-sm-5">
            <span class="block input-icon input-icon-right">
                <input type="text" id="rows" name="rows" class="width-100" placeholder="2-15" title="Mis. 2, 5-6, 14-17" data-placement="bottom" data-rel="tooltip" />
            </span>
        </div>
    </div>

    <div class="form-group">
        <label for="columns" class="col-xs-12 col-sm-3 control-label no-padding-right">Selected columns</label>

        <div class="col-xs-12 col-sm-5">
            <span class="block input-icon input-icon-right">
                <input type="text" id="columns" name="columns" class="width-100" placeholder="B-K" title="Mis. C, E-G" data-placement="bottom" data-rel="tooltip" />
            </span>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?php echo js_asset('spin.js', 'ace'); ?>
<script>
    var preview_data = null, $dummy_form = null;
    jQuery(function ($) {
        //listen to transpose CB event
        $('input[name="transposeCB"]').change(function () {
            //swap ID & date
            if (this.checked) {
                $('#date-text').text('ID');
                $('#id-text').text('date');
            } else {
                $('#date-text').text('date');
                $('#id-text').text('ID');
            }
        });

        $('[data-rel=tooltip]').tooltip({container: 'body'});

        var $wizard = $('#fuelux-wizard-container')
                .on('actionclicked.fu.wizard', function (e, info) {
                    if (info.step == 2) {
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
                                    preview_data = data.preview_data;
                                    //update hash for next usage
                                    $("#selection-form input[name='<?php echo $this->security->get_csrf_token_name(); ?>']").val(data.new_hash);
                                    //jump
                                    var wizard = $wizard.data('fu.wizard');
                                    //move to step 3
                                    wizard.currentStep = 3;
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
                .on('changed.fu.wizard', function (e, info) {
                    if ($(this).data('fu.wizard').selectedItem().step === 2) {
                        //reload daftar file using ajax
                        var $files = $('#uploaded-files .control-group');
                        //give loading circle to user
                        $files.html('<i class="ace-icon fa fa-spinner fa-spin orange bigger-125"></i>Loading recent files from server');
                        $.getJSON("upload/get_recent_uploaded", function (data) {
                            //prepare wrapper
                            var out = $('<div/>', {
                                "class": "col-xs-12"
                            }), inner = $('<div/>', {
                                "class": "tabbable tabs-left"
                            }), ul = $('<ul/>', {
                                "class": "nav nav-tabs"
                            }), content = $('<div/>', {
                                "class": "tab-content"
                            });
                            $.each(data, function (a, b) {
                                var name = b.file;
                                var nameForID = name.replace(/[. ]/g, '_');
                                $('<li><a data-toggle="tab" href="#' + nameForID + '">' + name + '</a></li>').appendTo(ul);
                                var sheetDiv = $('<div/>', {"id": nameForID, "class": "tab-pane"});
                                $.each(b.sheets, function (c, sheet) {
                                    //append radios to sheetDiv
                                    $('<div class="radio">'
                                            + '<label>'
                                            + '<input name="selected_file" type="radio" class="ace" value="' + name + '/' + sheet + '" />'
                                            + '<span class="lbl">' + sheet + '</span>'
                                            + '</label>'
                                            + '</div>').appendTo(sheetDiv);
                                });
                                sheetDiv.appendTo(content);
                            });
                            ul.appendTo(inner);
                            content.appendTo(inner);
                            inner.appendTo(out);
                            //replace $files
                            $files.html('');
                            out.appendTo($files);
                            //by default, select first radio
                            ul.find('li:first').addClass('active');
                            content.find('.tab-pane:first').addClass('in active');
                            $("input:radio[name=selected_file]:first").attr('checked', true);
                        });
                    }
                });
        var validator = $('#selection-form').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",
            onkeyup: false,
            onsubmit: false,
            onfocusout: false,
            onclick: false,
            rules: {
                selected_file: {
                    required: true
                },
                sheet: {
                    required: {
                        depends: function () {
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    },
                    remote: {
                        //make sure given sheet name is exist on selected file
                        url: "upload/check_sheet",
                        type: "post",
                        data: {
                            selected_file: function () {
                                return $("input:radio[name=selected_file]:checked").val();
                            }
                        }
                    }
                },
                id_column: {
                    //non-empty, alphabetic only
                    required: {
                        depends: function () {
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    },
                    lettersonly: true
                },
                rows: {
                    required: {
                        depends: function () {
                            $(this).val($(this).val().replace(/\s+/g, ''));
                            return true;
                        }
                    }},
                columns: {
                    required: {
                        depends: function () {
                            $(this).val($(this).val().replace(/\s+/g, ''));
                            return true;
                        }
                    }},
                date_row: {
                    //non-empty, numeric only
                    required: {
                        depends: function () {
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    },
                    number: true
                }
            },
            messages: {
                selected_file: "Please choose file",
                sheet: {
                    remote: 'Sheet not found on selected file'
                }
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
                } else if (element.is('.select2')) {
                    error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
                } else if (element.is('.chosen-select')) {
                    error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                } else
                    error.insertAfter(element.parent());
            },
            submitHandler: function (form) {
            },
            invalidHandler: function (form) {
            }
        });



    });
</script>

