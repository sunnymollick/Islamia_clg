<form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div id="status"></div>
    {{method_field('PATCH')}}

    <div class="form-row">

        <div class="form-group col-md-12 col-sm-12">
            <label for="">Session Name <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $session->name }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>
        <div class="form-group col-md-4">
            <label for=""> Status </label><br/>
            <input type="radio" name="status" class="flat-green"
                   value="1" {{ ( $session->status == 1 ) ? 'checked' : '' }} /> Active
            <input type="radio" name="status" class="flat-green"
                   value="0" {{ ( $session->status == 0 ) ? 'checked' : '' }}/> In Active
        </div>

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

    $('input[type="radio"].flat-green').iCheck({
        radioClass: 'iradio_flat-green'
    });
    $('.button-submit').click(function () {
        // route name and record id
        ajax_submit_update('sessions', "{{ $session->id }}")
    });




</script>
