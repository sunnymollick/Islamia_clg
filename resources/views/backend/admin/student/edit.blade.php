<form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div id="status"></div>
    {{method_field('PATCH')}}

    <div class="form-row">


        <div class="form-group col-md-6 col-sm-12">
            <label for="">Student Name<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $student->name }}"
                   placeholder="" required>
            <input type="hidden" name="enroll_id" value="{{$enroll->id}}">
        <span id="error_name" class="has-error"></span>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Student Code<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="code" name="code" value="{{ $student->code }}"
                   placeholder="" readonly >
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>




        <div class="form-group col-md-3 col-sm-12">
            <label for=""> Date of Birth <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="dob" name="dob" value="{{ $student->dob }}"
                placeholder="" readonly required>
            <span id="error_service_date" class="has-error"></span>
        </div>



        <div class="form-group col-md-3">
            <label for="">Gender</label>
            <select name="gender" id="gender" class="form-control" required>
                <option value="{{ $student->gender }}">{{ $student->gender }}</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Others">Others</option>
            </select>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Religion</label>
            <select name="religion" class="form-control">
                <option value="{{ $student->religion }}">{{ $student->religion }}</option>
                <option value="Islam">Islam</option>
                <option value="Hindu">Hindu</option>
                <option value="Buddhist">Buddhist</option>
                <option value="Christian">Christian</option>
                <option value="Others">Others</option>
            </select>
            <span id="error_religion" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3">
            <label for="">Blood Group</label>
            <select name="blood_group" id="blood_group" class="form-control">
                <option value="{{ $student->blood_group }}">{{ $student->blood_group }}</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-3 col-sm-12">
            <label for="">Phone<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $student->phone }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Email<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="email" name="email" value="{{ $student->email }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
        <label for=""> Student Session </label>
        <input type="text" class="form-control" id="std_session" name="std_session" value="{{ $enroll->year }}"
               placeholder="" required>
        <span id="error_std_session" class="has-error"></span>
    </div>
    <div class="clearfix"></div>
    <div class="form-group col-md-3 col-sm-12">
        <label for="">Student Class</label>
        <select name="class_id" id="std_class_id" class="form-control" required
                onchange="get_class_sections(this.value)">
            <option value="" selected disabled>Select a class</option>
            @foreach($stdclass as $class)
                <option value="{{$class->id}}"
                    {{ ( $class->id == $enroll->class_id) ? 'selected' : '' }} >{{$class->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-3 col-sm-12">
        <label for="">Student Section</label>
        <select class="form-control" name="section_id" id="std_section_id" required>
            @foreach ($sections as $row)
                <option value="{{ $row->id }}"
                    {{ $row->id == $enroll->section->id ? 'selected' : '' }}
                >
                {{ $row->name }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="form-group col-md-4 col-sm-12">
        <label for="">Optional Subject</label>
        <select class="form-control" name="subject_id" id="subject_id">
            @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}"
                    @if (
                    $subject->name == 'Bangla 1st Paper' ||
                        $subject->name == 'English 1st Paper' ||
                        $subject->name == 'ICT' ||
                        $subject->name == 'Bangla 2nd Paper' ||
                        $subject->name == 'English 2nd Paper') hidden
                    @endif
                    {{ $subject->id == $enroll->optional_subject_id ? 'selected' : '' }}
                    >{{ $subject->name }}</option>
            @endforeach

            {{-- <option
                value="{{ $enroll->optional_subject_id ? $enroll->subject->id : '' }}">
                {{ $enroll->optional_subject_id ? $enroll->subject->name : '' }}
            </option> --}}
        </select>
    </div>


        <div class="form-group col-md-4 col-sm-12">
            <label for="">roll<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="roll" name="roll" value="{{ $enroll->roll }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Year<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="year" name="year" value="{{ $student->year }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-6 col-sm-12">
            <label for="">Present Address<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="present_address" name="present_address" value="{{ $student->present_address }}"
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Permanent Address<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="permanent_address" name="permanent_address" value="{{ $student->permanent_address }}"
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
                        value="{{ $student->file_path }}" readonly>
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
                   value="1" {{ ( $student->status == 1 ) ? 'checked' : '' }} /> Active
            <input type="radio" name="status" class="flat-green"
                   value="0" {{ ( $student->status == 0 ) ? 'checked' : '' }}/> In Active
        </div>




        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-success button-submit"
                    data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Save
            </button>
        </div>
    </div>



</form>

<script>

function get_class_sections(val) {
        $("#class_section_id").empty();
        get_optional_subject(val)
        $.ajax({
            type: 'GET',
            url: 'getSections/' + val,
            success: function (data) {
                $("#std_section_id").html(data);
            },
            error: function (result) {
                $("#std_section_id").html("Sorry Cannot Load Data");
            }
        });
    }

    function get_optional_subject(val) {
        $("#subject_id").empty();
        $.ajax({
            type: 'GET',
            url: 'getOptionalSubjects/' + val,
            success: function (data) {
                $("#subject_id").html(data);
            },
            error: function (result) {
                $("#subject_id").html("Sorry Cannot Load Data");
            }
        });
    }
    $('input[type="radio"].flat-green').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });



    $('#table_field').on('click', '#remove', function(){
        $(this).closest('tr').remove();

    });

    $('input[type="radio"].flat-green').iCheck({
        radioClass: 'iradio_flat-green'
    });
    $('.button-submit').click(function () {
        // route name and record id
        ajax_submit_update('students', "{{ $student->id }}")
    });




</script>
