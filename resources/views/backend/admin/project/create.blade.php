<form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation"
      novalidate>
    <div id="status"></div>
    <div class="form-row">

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Company</label>
            <select name="client_id" id="client_id" class="form-control" required>
                <option value=""  selected disabled>Select Company</option>

                @foreach ($clients as $client)
                <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach


            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-6 col-sm-12">
            <label for="">Project Name <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-12 col-sm-12">
            <label for=""> Address </label>
            <textarea class="form-control" id="address" name="address" cols="10" rows="2" required></textarea>
            <span id="error_address" class="has-error"></span>
        </div>


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
        ajax_submit_store('projects')
    });


</script>
