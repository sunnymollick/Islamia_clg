<form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div id="status"></div>
    {{method_field('PATCH')}}

    <div class="form-row">

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Class</label>
            <select name="std_class_id" id="std_class_id" class="form-control">
                <option value="" disabled>Select Class</option>

                @foreach ($std_classes as $std_class)
                <option value="{{ $std_class->id }}" {{$section->std_class_id==$std_class->id? 'selected':''}}>{{ $std_class->name }}</option>
                @endforeach


            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-6 col-sm-12">
            <label for="">Section Name <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $section->name }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-12 col-sm-12">
            <label for="">Identification Number <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="identification_number" name="identification_number" value="{{ $section->identification_number }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-4">
            <label for=""> Status </label><br/>
            <input type="radio" name="status" class="flat-green"
                   value="1" {{ ( $section->status == 1 ) ? 'checked' : '' }} /> Active
            <input type="radio" name="status" class="flat-green"
                   value="0" {{ ( $section->status == 0 ) ? 'checked' : '' }}/> In Active
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
        ajax_submit_update('sections', "{{ $section->id }}")
    });




</script>
