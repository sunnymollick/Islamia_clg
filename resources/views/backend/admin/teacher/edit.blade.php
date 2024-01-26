<form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div id="status"></div>
    {{method_field('PATCH')}}

    <div class="form-row">


        <div class="form-group col-md-6 col-sm-12">
            <label for="">Teacher Name<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $teacher->name }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Teacher Code<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="code" name="code" value="{{ $teacher->code }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Quanlification<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="qualification" name="qualification" value="{{ $teacher->qualification }}"
                   placeholder="">
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Maritial Status<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="marital_status" name="marital_status" value="{{ $teacher->marital_status }}"
                   placeholder="">
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for=""> Date of Birth <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="dob" name="dob" value="{{ $teacher->dob }}"
                placeholder="" readonly>
            <span id="error_service_date" class="has-error"></span>
        </div>

        <div class="form-group col-md-3 col-sm-12">
            <label for=""> Date of Joining <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="doj" name="doj" value="{{ $teacher->doj }}"
                placeholder="" readonly>
            <span id="error_service_date" class="has-error"></span>
        </div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Gender<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="gender" name="gender" value="{{ $teacher->gender }}"
                   placeholder="">
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Religion<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="religion" name="religion" value="{{ $teacher->religion }}"
                   placeholder="">
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Blood Group<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="blood_group" name="blood_group" value="{{ $teacher->blood_group }}"
                   placeholder="">
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-3 col-sm-12">
            <label for="">Phone<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $teacher->phone }}"
                   placeholder="">
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Email<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="email" name="email" value="{{ $teacher->email }}"
                   placeholder="" >
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-12 col-sm-12">
            <label for="">Address<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="address" name="address" value="{{ $teacher->address }}"
                   placeholder="" >
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>




        <div class="form-group col-md-3 col-sm-12">
            <label for="">Designation<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="designation" name="designation" value="{{ $teacher->designation }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Order<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="order" name="order" value="{{ $teacher->order }}"
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
                        value="{{ $teacher->file_path }}" readonly>
            </div>
            <script type="text/javascript">
                $('input[id=photo]').change(function () {
                    $('#SelectedFileName').val($(this).val());
                });
            </script>
            <span id="error_photo" class="has-error"></span>
        </div>





        <div class="form-group col-md-4">
            <label for=""> Status </label><br/>
            <input type="radio" name="status" class="flat-green"
                   value="1" {{ ( $teacher->status == 1 ) ? 'checked' : '' }} /> Active
            <input type="radio" name="status" class="flat-green"
                   value="0" {{ ( $teacher->status == 0 ) ? 'checked' : '' }}/> In Active
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
        ajax_submit_update('teachers', "{{ $teacher->id }}")
    });




</script>
