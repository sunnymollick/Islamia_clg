<form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation"
      novalidate>
    <div id="status"></div>
    <div class="form-row">




        <div class="form-group col-md-4 col-sm-12">
            <label for="">Class name<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">In digit<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="in_digit" name="in_digit" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Has Optional Subject<span style="color: red;">*</span></label>
            <select name="has_optional" id="has_optional" class="form-control">
                <option value="" selected disabled>Select</option>
                <option value="1">YES</option>
                <option value="0">NO</option>
            </select>
            <span id="error_name" class="has-error"></span>
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
        ajax_submit_store('std_classes')
    });


</script>
