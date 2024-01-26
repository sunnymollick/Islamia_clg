<form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation"
      novalidate>
    <div id="status"></div>
    <div class="container">
        <div>
            <div class="form-group col-sm-12">
                <label for="name">Income Head<span style="color: red;">*</span></label>
                <select type="text" class="form-control" id="name" name="income_head_id" required>
                    <option value="" selected disabled>Select </option>
                    @foreach($incomeHeads as $incomeHead)
                    <option value="{{ $incomeHead->id }}">{{ $incomeHead->name  }}</option>
                    @endforeach
                </select>
                <span id="error_income_head_id" class="has-error"></span>
            </div>

            <div class="form-group col-sm-12">
                <label for="std_class">class<span style="color:red;">*</span></label>
                <select type="text" class="form-control" id="std_class" name="std_class_id" required>
                    <option value="" selected disabled>Select </option>
                    @foreach($stdClasses as $stdClass)
                    <option value="{{ $stdClass->id }}">{{ $stdClass->name  }}</option>
                    @endforeach
                    <option value="all">All</option>
                </select>
                <span id="error_std_class_id" class="has-error"></span>
            </div>

            <div class="form-group col-sm-12">
                <label for="amount">Amount <span style="color:red;">*</span></label>
                <input type="number" class="form-control" id="amount" name="amount" required>
                <span id="error_amount" class="has-error"></span>
            </div>

            <div class="modal-footer" style="background-color: white; border:none">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success button-submit"
                        data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Save
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {

        $('#loader').hide();

        $('#create').validate({
            rules: {
                income_head_id: {
                    required: true
                },
                std_class_id: {
                    required: true
                },
                amount: {
                    required: true
                },

            },
            // Messages for form validation
            messages: {
                income_head_id: {
                    required: 'Enter  name'
                },
                std_class_id: {
                    required: 'Enter class name'
                },
                amount: {
                    required: 'Enter fees'
                },

            },
            submitHandler: function (form) {

                var myData = new FormData($("#create")[0]);
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                myData.append('_token', CSRF_TOKEN);

                $.ajax({
                    url: 'educational-fees',
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
                            $('#my_modal_sm').modal('hide'); 
                            $('body').plainOverlay('hide');// hide bootstrap modal

                        } else if (data.type === 'error') {
                            if (data.errors) {
                                $.each(data.errors, function (key, val) {
                                    $('#error_' + key).html(val);
                                });
                            }
                            $("#status").html(data.message);
                            $('#loader').hide();
                            $(".button-submit").prop('disabled', false); 
                            $('body').plainOverlay('hide');

                        }
                    }
                });
            }
        });  

    });
</script>
