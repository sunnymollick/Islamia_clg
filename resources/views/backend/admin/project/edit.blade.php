<form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div id="status"></div>
    {{method_field('PATCH')}}

    <div class="form-row">

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Company</label>
            <select name="client_id" id="client_id" class="form-control">
                <option value=""  selected disabled>Select Company</option>

                @foreach ($clients as $client)
                <option value="{{ $client->id }}" {{$project->client_id==$client->id? 'selected':''}}>{{ $client->name }}</option>
                @endforeach


            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-6 col-sm-12">
            <label for="">Project Name <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $project->name }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-12 col-sm-12">
            <label for=""> Address </label>
            <textarea class="form-control" id="address" name="address" cols="10" rows="2" >{{ $project->address }}</textarea>
            <span id="error_address" class="has-error"></span>
        </div>


        <div class="form-group col-md-4">
            <label for=""> Status </label><br/>
            <input type="radio" name="status" class="flat-green"
                   value="1" {{ ( $client->status == 1 ) ? 'checked' : '' }} /> Active
            <input type="radio" name="status" class="flat-green"
                   value="0" {{ ( $client->status == 0 ) ? 'checked' : '' }}/> In Active
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
        ajax_submit_update('projects', "{{ $project->id }}")
    });




</script>
