
<form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation"
      novalidate>
    <div id="status"></div>
    <div class="form-row">




        <div class="form-group col-md-12 col-sm-12">
            <label for="">Session<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>



        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-success button-submit"
                    data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Save
            </button>
        </div>
    </div>
</form>

<script>

    $('.button-submit').click(function () {
        // route name
        // ajax_submit_store('sessions')

        $('#create').validate({
            submitHandler: function (form) {
                var myData = new FormData($("#create")[0]);
                myData.append('_token', CSRF_TOKEN);

                swal({
                    title: "Are you sure to submit?",
                    text: "Submit Form",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, Submit!"
                }, function () {
                    $.ajax({
                        url: 'sessions',
                        type: 'POST',
                        data: myData,
                        dataType: 'json',
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            if(data.type === 'success') {
                                $('#myModal').modal('hide');
                                swal("Done!", "It was succesfully done!", "success");
                                reload_table();
                            } else if (data.type === 'error') {
                                if(data.errors) {
                                    $.each(data.errors, function ( key, val) {
                                        $('#error_' + key).html(val);
                                    });
                                }
                                $("#status").html(data.message);
                                swal("Error sending!", "Please fix the errors", "error");
                            }
                        }
                    })
                })
            }
        })
    });


</script>
