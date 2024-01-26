<form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div id="status"></div>
    {{method_field('PATCH')}}

    <div class="form-row">

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Class</label>
            <select name="std_class_id" id="std_class_id" class="form-control">
                <option value="" disabled>Select Class</option>

                @foreach ($std_classes as $std_class)
                <option value="{{ $std_class->id }}" {{$exam->std_class_id==$std_class->id? 'selected':''}}>{{ $std_class->name }}</option>
                @endforeach


            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-6 col-sm-12">
            <label for="">Exam Name <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $exam->name }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>



        <div class="form-group col-md-6 col-sm-12">
            <label for="">Description <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="description" name="description" value="{{ $exam->description }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for=""> Start Date <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="start_date" name="start_date" value="{{ $exam->start_date }}"
                placeholder="" readonly required>
            <span id="error_service_date" class="has-error"></span>
        </div>


        <div class="form-group col-md-3 col-sm-12">
            <label for=""> End Date <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="end_date" name="end_date" value="{{ $exam->end_date }}"
                placeholder="" readonly required>
            <span id="error_service_date" class="has-error"></span>
        </div>


        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Result Modification Last Date  <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="result_modification_last_date" name="result_modification_last_date" value="{{ $exam->result_modification_last_date }}"
                placeholder="" readonly required>
            <span id="error_service_date" class="has-error"></span>
        </div>



        {{-- <div class="form-group col-md-6 col-sm-12">
            <label for="">Main Marks Percentage <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="main_marks_percentage" name="main_marks_percentage" value="{{ $exam->main_marks_percentage }}"
                placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div> --}}

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Main Marks Percentage <span style="color: red;">*</span></label>
            <Select id="main_marks_percentage" name="main_marks_percentage" class="form-control">
                <option value="100"
                    {{ ($exam->main_marks_percentage == 100) ? 'selected' : '' }}
                >100%</option>
                <option value="80"
                    {{ ($exam->main_marks_percentage == 80) ? 'selected' : '' }}
                >80%</option>
            </Select>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">CT Marks Percentage <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="ct_marks_percentage" name="ct_marks_percentage" value="{{ $exam->ct_marks_percentage }}"
                placeholder="" readonly>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="col-md-6">
        <label for="photo">Upload Exam Routine</label>
        <input id="photo" type="file" name="photo" style="display:none">
        <div class="input-group">
            <div class="input-group-btn">
                <a class="btn btn-success" onclick="$('input[id=photo]').click();">Browse</a>
            </div><!-- /btn-group -->
            <input type="text" name="SelectedFileName" class="form-control" id="SelectedFileName"
                value="{{ $exam->file_path }}" readonly required>
        </div>
        <div class="clearfix"></div>
        <p class="help-block" style="margin-top: 8px">File must be jpg, jpeg, png , doc, docx, pdf.</p>
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
                   value="1" {{ ( $exam->status == 1 ) ? 'checked' : '' }} /> Active
            <input type="radio" name="status" class="flat-green"
                   value="0" {{ ( $exam->status == 0 ) ? 'checked' : '' }}/> In Active
        </div>
        <div class="clearfix"></div>




        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-success button-submit"
                    data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Save
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 import_notice">
            <p> Please follow the Instructions before creating Exam: </p>
            <ol>
                <li style="margin-bottom: 15px">Double check the running session.You can change running session from setting menu.
                </li>
                <li>Set Main marks Percentage 100 if exam will not include class test marks</li>
            </ol>
            <span style="margin-bottom: 20px">
                *** Double check the information. Double check the Exam Name, Marks Percentage. *** </span>
        </div>
    </div>



</form>

<script>

    $('#start_date').datepicker();
    $('#end_date').datepicker();
    $('#result_modification_last_date').datepicker();


    $('input[type="radio"].flat-green').iCheck({
        radioClass: 'iradio_flat-green'
    });
    $('.button-submit').click(function () {
        // route name and record id
        ajax_submit_update('exams', "{{ $exam->id }}")
    });

    $(document).ready(function(){
        $("#main_marks_percentage").change(function(){
            var main_mark = $("#main_marks_percentage").val();
            if ($.isNumeric(main_mark)) {
                $("#ct_marks_percentage").val(100 - main_mark);
            }
        });
    });




</script>
