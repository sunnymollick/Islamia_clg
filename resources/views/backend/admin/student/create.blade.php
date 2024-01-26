{{-- <form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation"
      novalidate>
    <div id="status"></div>
    <div class="form-row">

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Student Name<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value=""
                placeholder="Student's Full Name" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Phone<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="phone" name="phone" value=""
                placeholder="Students Phone Number" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Father's Name<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="" name="" value=""
                placeholder="Father's Full Name" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Phone<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="" name="" value=""
                placeholder="Father's Phone Number" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Occupation<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="" name="" value=""
                placeholder="Father's Occupation" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Yearly Income<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="" name="" value=""
                placeholder="Yearly Income" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Mother's Name<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="" name="" value=""
                placeholder="Mother's Full Name" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Phone<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="" name="" value=""
                placeholder="Mother's Phone Number" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">In Absence Of Father<span style=""> (optional)</span></label>
            <input type="text" class="form-control" id="" name="" value=""
                placeholder="Full Name Of Alternative Guardian" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for=""><span style="">.</span></label>
            <input type="text" class="form-control" id="" name="" value=""
                placeholder="Occupation Of Alternative Guardians" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-6 col-sm-12">
            <label for=""><span style="color: red;"></span></label>
            <input type="text" class="form-control" id="" name="" value=""
                placeholder="Address Of Alternative Guardian" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for=""><span style="color: red;"></span></label>
            <input type="text" class="form-control" id="" name="" value=""
                placeholder="Relation With Student" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Date of Birth <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="dob" name="dob" value="{{ date('Y-m-d') }}"
                placeholder="" readonly required>
            <span id="error_service_date" class="has-error"></span>
        </div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Email<span style=""> (optional)</span></label>
            <input type="text" class="form-control" id="email" name="email" value=""
                placeholder="Email Address" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Nationality<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="nationality" name="nationality" value=""
                placeholder="Enter Nationality" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Gender</label>
            <select name="gender" id="gender" class="form-control">
                <option value="" selected disabled>Select Gender</option>
                <option value="Male" >Male</option>
                <option value="Female" >Female</option>
                <option value="Other " >Other </option>
            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Religion</label>
            <select name="religion" id="religion" class="form-control">
                <option value="" selected disabled>Select Religion</option>
                <option value="Islam" >Islam</option>
                <option value="Hinduism" >Hinduism</option>
                <option value="Buddhism " >Buddhism </option>
                <option value="Christianity" >Christianity</option>
            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-12 col-sm-12">
            <label for="">Permanent Address<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="permanent_address" name="permanent_address" value=""
                placeholder="Permanent Address" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-12 col-sm-12">
            <label for="">Present Address<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="present_address" name="present_address" value=""
                placeholder="Present Address" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-6 col-sm-12">
            <label for="">Desire Group To Admission<span style="color: red;">*</span></label>
            <select name="group" id="group" class="form-control">
                <option value="" selected disabled>Select Group</option>
                <option value="Science" >Science</option>
                <option value="Commerce" >Commerce</option>
                <option value="Arts" >Arts</option>
            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Shift<span style="color: red;">*</span></label>
            <select name="shift" id="shift" class="form-control">
                <option value="" selected disabled>Select Shift</option>
                <option value="Day" >Day</option>
                <option value="Evening" >Evening</option>
            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Information Of SSC Examination<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name_of_xm" name="name_of_xm" value=""
                placeholder="Name Of Exam" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for=""><span style="color: red;">*</span></label>
            <select name="board_name" id="board_name" class="form-control">
                <option value="" selected disabled>Board</option>
                <option value="Dhaka" >Dhaka</option>
                <option value="Chattogram" >Chattogram</option>
                <option value="Cumilla" >Cumilla</option>
            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for=""><span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="roll_number_ssc" name="roll_number_ssc" value=""
                placeholder="Roll Number" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for=""><span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="regi_number_ssc" name="regi_number_ssc" value=""
                placeholder="Registration Number" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for=""><span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="school_name" name="school_name" value=""
                placeholder="School Name" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for=""><span style="color: red;">*</span></label>
            <select name="passing_year" id="passing_year" class="form-control">
                <option value="" selected disabled>Passing Year</option>
                <option value="2020-2021" >2020-2021</option>
                <option value="2021-2022" >2021-2022</option>
            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for=""><span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="gpa" name="gpa" value=""
                placeholder="GPA " required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for=""><span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="grade" name="grade" value=""
                placeholder="Grade" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-12 col-sm-12">
            <label for=""><span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="all_subjects" name="all_subjects" value=""
                placeholder="All Subjects" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>


        <div class="form-group col-md-4 col-sm-12">
            <label for="">roll<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="roll" name="roll" value=""
                placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Year<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="year" name="year" value=""
                placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Optional Subject Id<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="optional_subject_id" name="optional_subject_id" value=""
                placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>



        <div class="col-md-6 mb-3">
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
        ajax_submit_store('students')
    });

    $('#doj').datepicker();
    $('#dob').datepicker();

    function getSection(std_class_id){
            $("#section_id").empty();
            $("#loader").show();
            $.ajax({
                type: 'GET',
                url: 'getSection/' + std_class_id,
                success: function (data) {
                    $("#loader").hide();
                    $("#section_id").html(data);
                },
                error: function (result) {
                    $("#section_id").html("Sorry Cannot Load Data");
                }
            });
        }

</script> --}}




    <form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation" novalidate>
    <div id="status"></div>
    <div class="form-row">


        <div class="form-group col-md-8 col-sm-12">
            <label for="">Student Name<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="name" name="name" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        {{-- <div class="form-group col-md-3 col-sm-12">
            <label for="">Teacher Code<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="code" name="code" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div> --}}

        {{-- <div class="form-group col-md-3 col-sm-12">
            <label for="">Quanlification<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="qualification" name="qualification" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div> --}}

        {{-- <div class="form-group col-md-3 col-sm-12">
            <label for="">Maritial Status<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="marital_status" name="marital_status" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div> --}}

        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Date of Birth <span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="dob" name="dob" value="{{ date('Y-m-d') }}"
                placeholder="" readonly required>
            <span id="error_service_date" class="has-error"></span>
        </div>



        <div class="form-group col-md-4 col-sm-12">
            <label for="">Gender</label>
            <select name="gender" id="gender" class="form-control">
                <option value="" selected disabled>Select Gender</option>
                <option value="Male" >Male</option>
                <option value="Female" >Female</option>
                <option value="Other " >Other </option>
            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Religion</label>
            <select name="religion" id="religion" class="form-control">
                <option value="" selected disabled>Select Religion</option>
                <option value="Islam" >Islam</option>
                <option value="Hinduism" >Hinduism</option>
                <option value="Buddhism " >Buddhism </option>
                <option value="Christianity" >Christianity</option>
            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-4 col-sm-12">
            <label for="">Blood Group</label>
            <select name="blood_group" id="blood_group" class="form-control">
                <option value="">Select Blood Group</option>
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

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Phone<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="phone" name="phone" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Email<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="email" name="email" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Present Address<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="present_address" name="present_address" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-6 col-sm-12">
            <label for="">Permanent Address<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="permanent_address" name="permanent_address" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>





        <div class="form-group col-md-3 col-sm-12">
            <label for="">Class</label>
            <select name="std_class_id" id="std_class_id" onclick="getSection(this.value)" class="form-control">
                <option value="" selected disabled>Select class</option>
                @foreach ($std_classes as $std_class)
                    <option value="{{ $std_class->id }}">{{ $std_class->name }}</option>
                @endforeach
            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Section</label>
            <select name="section_id" id="sectionId" class="form-control">
                <option value="" selected disabled>Select class</option>
            </select>
            <span id="error_name" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">roll<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="roll" name="roll" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        <div class="form-group col-md-3 col-sm-12">
            <label for="">Year<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="year" name="year" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div>

        {{-- <div class="form-group col-md-6 col-sm-12">
            <label for="">Select Optional Subject<span style="color: red;">*</span></label>
            <input type="text" class="form-control" id="optional_subject_id" name="optional_subject_id" value=""
                   placeholder="" required>
            <span id="error_title" class="has-error"></span>
        </div>
        <div class="clearfix"></div> --}}
        <div class="form-group col-md-6 col-sm-12">
            <label for="photo">Optional Subject</label>
            <select class="form-control" name="subject_id" id="subject_id">
                <option value="">Select optional subject</option>
            </select>
        </div>



        <div class="col-md-6 mb-3">
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
        ajax_submit_store('students')
    });

    $('#doj').datepicker();
    $('#dob').datepicker();

    function getSection(std_class_id){
        get_optional_subject(std_class_id)
            $("#sectionId").empty();
            $("#loader").show();
            $.ajax({
                type: 'GET',
                url: 'getSection/' + std_class_id,
                success: function (data) {
                    $("#loader").hide();
                    $("#sectionId").html(data);
                },
                error: function (result) {
                    $("#sectionId").html("Sorry Cannot Load Data");
                }
            });
        }

    function get_optional_subject(val) {
        $("#subject_id").empty();
        $.ajax({
            type: 'GET',
            url: 'getSubjects/' + val,
            success: function (data) {
                $("#subject_id").html(data);
            },
            error: function (result) {
                $("#subject_id").html("Sorry Cannot Load Data");
            }
    });
    }

</script>

