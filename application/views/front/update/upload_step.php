<div class="step-pane" data-step="1">
    <div class="col-md-6 col-md-offset-3">
        <?php echo form_open_multipart('upload/do_upload', ['id' => 'fileform']); ?>
        <input  type="file" name="files[]" multiple id="file" />
        </form>
    </div>
</div>

<script type="text/javascript">
    jQuery(function ($) {


        var adaFile = false, file_input = $('#file'), upload_in_progress = false;
        file_input.ace_file_input({
            style: 'well',
            btn_choose: 'Drop files here or click to choose',
            btn_change: null,
            no_icon: 'ace-icon fa fa-cloud-upload',
            droppable: true,
            thumbnail: 'small'//large | fit
                    //,icon_remove:null//set null, to hide remove/reset button
            , before_change: function (files, dropped) {
                //Check an example below
                //or examples/file-upload.html
                adaFile = files.length > 0;
                return true;
            }, before_remove: function () {
                adaFile = false;
                return !upload_in_progress;
            },
            preview_error: function (filename, error_code) {
                //name of the file that failed
                //error_code values
                //1 = 'FILE_LOAD_FAILED',
                //2 = 'IMAGE_LOAD_FAILED',
                //3 = 'THUMBNAIL_FAILED'
                //alert(error_code);
            }
        }).on('change', function () {
            //console.log($(this).data('ace_input_files'));
            //console.log($(this).data('ace_input_method'));
        });
        var $form = $('#fileform');
        var ie_timeout = null;//a time for old browsers uploading via iframe


        var $wizard = $('#fuelux-wizard-container')
                .on('actionclicked.fu.wizard', function (e, info) {
                    if (info.step == 1) {
                        //cek ada outstanding upload apa engga

                        if (adaFile) {
                            e.preventDefault();
                            //upload dengan cara submit form
                            $form.submit();
                        }
                    }
                });

        $form.on('submit', function (e) {
            e.preventDefault();

            var files = file_input.data('ace_input_files');
            if (!files || files.length == 0)
                return false;//no files selected

            var deferred;
            if ("FormData" in window) {
                //for modern browsers that support FormData and uploading files via ajax
                //we can do >>> var formData_object = new FormData($form[0]);
                //but IE10 has a problem with that and throws an exception
                //and also browser adds and uploads all selected files, not the filtered ones.
                //and drag&dropped files won't be uploaded as well

                //so we change it to the following to upload only our filtered files
                //and to bypass IE10's error
                //and to include drag&dropped files as well
                formData_object = new FormData();//create empty FormData object

                //serialize our form (which excludes file inputs)
                $.each($form.serializeArray(), function (i, item) {
                    //add them one by one to our FormData 
                    formData_object.append(item.name, item.value);
                });
                //and then add files
                $form.find('input[type=file]').each(function () {
                    var field_name = $(this).attr('name');
                    //for fields with "multiple" file support, field name should be something like `myfile[]`

                    var files = $(this).data('ace_input_files');
                    if (files && files.length > 0) {
                        for (var f = 0; f < files.length; f++) {
                            formData_object.append(field_name, files[f]);
                        }
                    }
                });


                upload_in_progress = true;
                file_input.ace_file_input('loading', true);

                deferred = $.ajax({
                    url: $form.attr('action'),
                    type: $form.attr('method'),
                    processData: false, //important
                    contentType: false, //important
                    dataType: 'json',
                    data: formData_object
                            /**
                             ,
                             xhr: function() {
                             var req = $.ajaxSettings.xhr();
                             if (req && req.upload) {
                             req.upload.addEventListener('progress', function(e) {
                             if(e.lengthComputable) {	
                             var done = e.loaded || e.position, total = e.total || e.totalSize;
                             var percent = parseInt((done/total)*100) + '%';
                             //percentage of uploaded file
                             }
                             }, false);
                             }
                             return req;
                             },
                             beforeSend : function() {
                             },
                             success : function() {
                             }*/
                })
            } else {
                //for older browsers that don't support FormData and uploading files via ajax
                //we use an iframe to upload the form(file) without leaving the page

                deferred = new $.Deferred //create a custom deferred object

                var temporary_iframe_id = 'temporary-iframe-' + (new Date()).getTime() + '-' + (parseInt(Math.random() * 1000));
                var temp_iframe =
                        $('<iframe id="' + temporary_iframe_id + '" name="' + temporary_iframe_id + '" \
                                                                frameborder="0" width="0" height="0" src="about:blank"\
                                                                style="position:absolute; z-index:-1; visibility: hidden;"></iframe>')
                        .insertAfter($form)

                $form.append('<input type="hidden" name="temporary-iframe-id" value="' + temporary_iframe_id + '" />');

                temp_iframe.data('deferrer', deferred);
                //we save the deferred object to the iframe and in our server side response
                //we use "temporary-iframe-id" to access iframe and its deferred object

                $form.attr({
                    method: 'POST',
                    enctype: 'multipart/form-data',
                    target: temporary_iframe_id //important
                });

                upload_in_progress = true;
                file_input.ace_file_input('loading', true);//display an overlay with loading icon
                $form.get(0).submit();

                //if we don't receive a response after 30 seconds, let's declare it as failed!
                ie_timeout = setTimeout(function () {
                    ie_timeout = null;
                    temp_iframe.attr('src', 'about:blank').remove();
                    deferred.reject({'status': 'fail', 'message': 'Timeout!'});
                }, 30000);
            }


            ////////////////////////////
            //deferred callbacks, triggered by both ajax and iframe solution
            deferred
                    .done(function (result) {//success
                        //format of `result` is optional and sent by server
                        //in this example, it's an array of multiple results for multiple uploaded files
                        var message = '';
                        for (var i = 0; i < result.length; i++) {
                            if (result[i].status == 'OK') {
                                message += "File successfully saved. Thumbnail is: " + result[i].url
                            }
                            else {
                                message += "File not saved. " + result.message;
                            }
                            message += "\n";
                        }
//                        alert(message);
                        //reset form jika sudah keupload
                        $form.get(0).reset();
                        //jump wizard to the next step
                        var wizard = $wizard.data('fu.wizard');
                        //move to step 2
                        wizard.currentStep = 2;
                        wizard.setState();
                    })
                    .fail(function (result) {//failure
                        alert("There was an error");
                    })
                    .always(function () {//called on both success and failure
                        if (ie_timeout)
                            clearTimeout(ie_timeout)
                        ie_timeout = null;
                        upload_in_progress = false;
                        file_input.ace_file_input('loading', false);
                    });

            deferred.promise();
        });


        //when "reset" button of form is hit, file field will be reset, but the custom UI won't
        //so you should reset the ui on your own
        $form.on('reset', function () {
            $(this).find('input[type=file]').ace_file_input('reset_input_ui');
        });
    })
</script>

