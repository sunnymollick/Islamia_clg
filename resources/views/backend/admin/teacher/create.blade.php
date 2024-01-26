<form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation"
      novalidate>
    <div id="status"></div>
    <div class="form-row">




        <div class="form-group col-md-6 col-sm-12">
            <label for="">Teacher Name<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Teacher Code<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="code" name="code" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Quanlification<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="qualification" name="qualification" value=""
                   placeholder="">
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Maritial Status<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="marital_status" name="marital_status" value=""
                   placeholder="" >
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for=""> Date of Birth <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="dob" name="dob" value="{{ date('Y-m-d') }}"
                placeholder="" readonly >
            <span id="error_service_date" class="has-error"></span>
        </div>

        <div class="form-group col-md-3 col-sm-12">
            <label for=""> Date of Joining <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="doj" name="doj" value="{{ date('Y-m-d') }}"
                placeholder="" readonly>
            <span id="error_service_date" class="has-error"></span>
        </div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Gender<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="gender" name="gender" value=""
                   placeholder="">
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Religion<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="religion" name="religion" value=""
                   placeholder="" >
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Blood Group<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="blood_group" name="blood_group" value=""
                   placeholder="" >
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        {{-- <div class="form-group col-md-3 col-sm-12">
            <label for="">Blood Group<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="blood_group" name="blood_group" value=""
                   placeholder="" >
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div> --}}

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Phone<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="phone" name="phone" value=""
                   placeholder="">
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-12 col-sm-12">
            <label for="">Address<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="address" name="address" value=""
                   placeholder="">
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>



        <div class="form-group col-md-3 col-sm-12">
            <label for="">Email<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="email" name="email" value=""
                   placeholder="" >
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Designation<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="designation" name="designation" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Order<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="order" name="order" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="col-md-3 mb-3">
            <label for="photo">Picture</label>
            <div class="input-group">
                <input id="photo" type="file" name="photo" style="display:none">
                <div class="input-group-prepend">
                    <a class="btn btn-secondary text-white" onclick="$('input[id=photo]').click();">Browse</a>
                </div>
                <input type="text" name="SelectedFileName" class="form-control" id="SelectedFileName"
                        value="" readonly>
            </div>
            <script type="text/javascript">
                $('input[id=photo]').change(function () {
                    $('#SelectedFileName').val($(this).val());
                });
            </script>
            <span id="error_photo" class="has-error"></span>
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
        ajax_submit_store('teachers')
    });

    $('#doj').datepicker();
    $('#dob').datepicker();


</script>
