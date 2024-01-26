<form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation">

    <div id="status"></div>
    {{method_field('PATCH')}}
    <div class="container">
        <div>
            <div class="form-group col-sm-12">
                <label for="name">Name<span style="color: red;">*</span></label>
                <input type="text" class="form-control" id="name"  name="name" value="{{ $incomeHead->name }}"
                    placeholder="" required>
                <span id="error_name" class="has-error"></span>
            </div>

            <div class="modal-footer" style="background-color: white; border:none">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success button-submit"
                        data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Update
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#loader').hide();

        $('#edit').validate({
            rules: {
                name: {
                    required: true
                },
            },
            // Messages for form validation
            messages: {
                name: {
                    required: 'Enter  name'
                }
            },
            submitHandler: function (form) {

                var myData = new FormData($("#edit")[0]);
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                myData.append('_token', CSRF_TOKEN);
                $.ajax({
                    url: 'income-heads/' + '{{ $incomeHead->id }}' ,
                    type: 'POST',
                    data: myData,
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('body').plainOverlay('show');
                    },
                    success: function (data) {
                        if (data.type === 'success') {
                            notify_view(data.type, data.message);
                            reload_table();
                            $('#loader').hide();
                            $(".button-submit").prop('disabled', false); // disable button
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('#my_modal_sm').modal('hide'); // hide bootstrap modal
                            $('body').plainOverlay('hide');

                        } else if (data.type === 'error') {
                            if (data.errors) {
                                $.each(data.errors, function (key, val) {
                                    $('#error_' + key).html(val);
                                });
                            }
                            $("#status").html(data.message);
                            $('#loader').hide();
                            $(".button-submit").prop('disabled', false); // disable button
                            $('body').plainOverlay('hide');
                        }
                    }
                });
            }
        });  

    });
</script>