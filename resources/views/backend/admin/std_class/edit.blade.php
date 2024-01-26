<form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div id="status"></div>
    {{method_field('PATCH')}}

    <div class="form-row">




        <div class="form-group col-md-6 col-sm-12">
            <label for="">Class Name <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $std_class->name }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">In digit <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="in_digit" name="in_digit" value="{{ $std_class->in_digit }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Has Optional Subject<span style="color: red;">*</span></label>
            <select name="has_optional" id="has_optional" class="form-control">
                <option value="1"
                    @php
                        if ($std_class->has_optional == 1){
                            echo "selected";
                        }
                    @endphp
                >YES</option>
                <option value="0"
                    @php
                        if ($std_class->has_optional == 0){
                            echo "selected";
                        }
                    @endphp
                >NO</option>
            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>





        <div class="form-group col-md-6">
            <label for=""> Status </label><br/>
            <input type="radio" name="status" class="flat-green"
                   value="1" {{ ( $std_class->status == 1 ) ? 'checked' : '' }} /> Active
            <input type="radio" name="status" class="flat-green"
                   value="0" {{ ( $std_class->status == 0 ) ? 'checked' : '' }}/> In Active
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
        ajax_submit_update('std_classes', "{{ $std_class->id }}")
    });




</script>
