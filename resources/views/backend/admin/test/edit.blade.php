<form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div id="status"></div>
    {{method_field('PUT')}}

    <div class="form-row">


        <div class="form-group col-md-6 col-sm-12">
            <label for="">Test Name<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $test->name }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Test Email<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="code" name="email" value="{{ $test->email }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Phone<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="qualification" name="phone" value="{{ $test->phone }}"
                   placeholder="" required>
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




    $('#table_field').on('click', '#remove', function(){
        $(this).closest('tr').remove();

    });

    $('.button-submit').click(function () {
        // route name and record id
        ajax_submit_update('tests', "{{ $test->id }}")
    });




</script>
