<div>
    <form id='edit' enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div id="status"></div>

    {{method_field('PATCH')}}

    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
                <Label><strong>Class Wanted To Admit : </strong></Label>
                    <select name="admitted_class" id="admitted_class" class="form-control" required class="form-control"
                            onchange="get_sections_manually(this.value)">
                        <option value="" selected disabled>Select a class</option>
                            <option value="HSC"
                            @if ($admissionApplication->admitted_class == 'HSC')
                                selected
                            @endif>HSC</option>
                            <option value="HONOURS" @if ($admissionApplication->admitted_class == 'HONOURS')
                                selected
                            @endif>HONOUR'S</option>
                    </select>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                {{-- <select class="form-control" name="admitted_section" id="admitted_section" required>
                    @foreach($section as $s)
                        <option
                            value="{{$s->id}}" {{$s->id == $admissionApplication->admitted_section ? 'Selected':''}}>{{$s->name}}</option>
                    @endforeach
                </select> --}}
                <Label><strong>Department</strong></Label>
                <input type="text" class="form-control" value="{{ $admissionApplication->admitted_section }}" id="admitted_section" name="admitted_section">
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        <br/><h5><strong>Applicant's Information : </strong></h5><br/>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-3 col-sm-12">
                <label for=""> College Roll* </label>
                <input type="text" class="form-control" id="college_roll" name="college_roll" value="{{$admissionApplication->college_roll}}"
                    required>
                <span id="college_roll" class="has-error"></span>
            </div>
            <div class="form-group col-md-3 col-sm-12">
                <label for=""> Full Name (English Block Letter)* </label>
                <input type="text" class="form-control" id="applicant_name_en" name="applicant_name_en"
                    value="{{$admissionApplication->applicant_name_en}}"
                    required>
                <span id="error_applicant_name_en" class="has-error"></span>
            </div>
            <div class="form-group col-md-3 col-sm-12">
                <label for=""> Full Name (Bangla)* </label>
                <input type="text" class="form-control" id="applicant_name_bn" name="applicant_name_bn"
                    value="{{$admissionApplication->applicant_name_bn}}"
                    required>
                <span id="error_applicant_name_bn" class="has-error"></span>
            </div>
            <div class="form-group col-md-3 col-sm-12">
                <label for=""> Mobile (Must be provided) * </label>
                <input type="text" class="form-control" id="mobile"
                    name="mobile" value="{{$admissionApplication->mobile}}" required>
                <span id="error_mobile" class="has-error"></span>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
                <label for=""> Father's Name (English Block Letter)* </label>
                <input type="text" class="form-control" id="father_name_en" name="father_name_en"
                    value="{{$admissionApplication->father_name_en}}"
                    required>
                <span id="error_father_name_en" class="has-error"></span>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <label for=""> Father's Name (Bangla)* </label>
                <input type="text" class="form-control" id="father_name_bn" name="father_name_bn"
                    value="{{$admissionApplication->father_name_bn}}"
                    required>
                <span id="error_father_name_bn" class="has-error"></span>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <label for=""> Father's Mobile </label>
                <input type="text" class="form-control" id="father_mobile"
                    name="father_mobile" value="{{$admissionApplication->father_mobile}}" >
                <span id="error_mobile" class="has-error"></span>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
            <label for=""> Mother's Name (English Block Letter)* </label>
            <input type="text" class="form-control" id="mother_name_en" name="mother_name_en"
                value="{{$admissionApplication->mother_name_en}}"
                required>
            <span id="error_mother_name_en" class="has-error"></span>
        </div>
        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Mother's Name (Bangla)* </label>
            <input type="text" class="form-control" id="mother_name_bn" name="mother_name_bn"
                value="{{$admissionApplication->mother_name_bn}}"
                required>
            <span id="error_mother_name_bn" class="has-error"></span>
        </div>
        <div class="form-group col-md-4 col-sm-12">
            <label for=""> Mother's Mobile </label>
            <input type="text" class="form-control" id="mother_mobile"
                name="mother_mobile" value="{{$admissionApplication->mother_mobile}}">
            <span id="error_mobile" class="has-error"></span>
        </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-3 col-sm-12">
            <label for=""> Date of Birth </label>
            <input type="text" class="form-control" id="dob"
                name="dob" value="{{$admissionApplication->dob}}" required readonly>
            <span id="error_dob" class="has-error"></span>
        </div>
        <div class="form-group col-md-3 col-sm-12">
            <label for=""> Email </label>
            <input type="text" class="form-control" id="email"
                name="email" value="{{$admissionApplication->email}}">
        </div>
        <div class="form-group col-md-3 col-sm-12">
            <label for=""> Nationality </label>
            <input type="text" class="form-control" id="nationality"
                name="nationality" value="{{$admissionApplication->nationality}}" required>
        </div>
        <div class="form-group col-md-3 col-sm-12">
            <label for=""> Religion * </label>
            <select name="religion" class="form-control">
                <option value="{{$admissionApplication->religion}}">{{$admissionApplication->religion}}</option>
                <option value="Islam">Islam</option>
                <option value="Hindu">Hindu</option>
                <option value="Buddhist">Buddhist</option>
                <option value="Christian">Christian</option>
                <option value="Others">Others</option>
            </select>
        </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        <br/><h5><strong>Present Address : </strong></h5><br/>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-3 col-sm-12">
                <label for="">Village/City</label>
                <input type="text" class="form-control" id="present_village"
                    name="present_village" value="{{$admissionApplication->present_village}}" placeholder="Village *"
                    required>
                <span id="error_present_village" class="has-error"></span>
            </div>
            <div class="form-group col-md-3 col-sm-12">
                <label for="">Post Office</label>
                <input type="text" class="form-control" id="present_post_office"
                    name="present_post_office" value="{{$admissionApplication->present_post_office}}"
                    placeholder="Post Office *"
                    required>
                <span id="error_present_post_office" class="has-error"></span>
            </div>
            <div class="form-group col-md-3 col-sm-12">
                <label for="">Police Station</label>
                <input type="text" class="form-control" id="present_thana"
                    name="present_thana" value="{{$admissionApplication->present_thana}}" placeholder="Thana" required>
                <span id="error_present_thana" class="has-error"></span>
            </div>
            <div class="form-group col-md-3 col-sm-12">
                <label for="">District</label>
                <input type="text" class="form-control" id="present_district"
                    name="present_district" value="{{$admissionApplication->present_district}}" placeholder="District"
                    required>
                <span id="error_present_thana" class="has-error"></span>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        <br/><h5><strong>Permanent Address : </strong></h5><br/>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-3 col-sm-12">
                <label for="">Village/City</label>
            <input type="text" class="form-control" id="parmanent_village"
                name="parmanent_village" value="{{$admissionApplication->parmanent_village}}" placeholder="Village">
            <span id="error_parmanent_village" class="has-error"></span>
        </div>
        <div class="form-group col-md-3 col-sm-12">
            <label for="">Post Office</label>
            <input type="text" class="form-control" id="parmanent_post_office"
                name="parmanent_post_office" value="{{$admissionApplication->parmanent_post_office}}"
                placeholder="Post Office">
            <span id="error_parmanent_post_office" class="has-error"></span>
        </div>
        <div class="form-group col-md-3 col-sm-12">
            <label for="">Police Station</label>
            <input type="text" class="form-control" id="parmanent_thana"
                name="parmanent_thana" value="{{$admissionApplication->parmanent_thana}}" placeholder="Thana">
            <span id="error_parmanent_thana" class="has-error"></span>
        </div>
        <div class="form-group col-md-3 col-sm-12">
            <label for="">District</label>
            <input type="text" class="form-control" id="parmanent_district"
                name="parmanent_district" value="{{$admissionApplication->parmanent_district}}" placeholder="District">
            <span id="error_parmanent_district" class="has-error"></span>
        </div>
        </div>
    </div>
    <div class="clearfix"></div>


    <div class="clearfix"></div>

    <div class="clearfix"></div>
    <div class="col-md-12">
        <br/><h5><strong>If parents unavailable then other gurdian information : </strong></h5><br/>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-3 col-sm-12">
                <label for=""> Name </label>
                <input type="text" class="form-control" id="alternet_gurdian_name"
                    name="alternet_gurdian_name" value="{{$admissionApplication->alternet_gurdian_name}}">
                <span id="error_alternet_gurdian_name" class="has-error"></span>
            </div>
            <div class="form-group col-md-3 col-sm-12">
                <label for=""> Phone </label>
                <input type="text" class="form-control" id="alternet_gurdian_phone"
                    name="alternet_gurdian_phone" value="{{$admissionApplication->alternet_gurdian_phone}}">
                <span id="error_alternet_gurdian_phone" class="has-error"></span>
            </div>
            <div class="form-group col-md-3 col-sm-12">
                <label for=""> Relation </label>
                <input type="text" class="form-control" id="alternet_gurdian_relation"
                    name="alternet_gurdian_relation" value="{{$admissionApplication->alternet_gurdian_relation}}">
                <span id="error_alternet_gurdian_relation" class="has-error"></span>
            </div>
            <div class="form-group col-md-3 col-sm-12">
                <label for="">Address </label>
                <input type="text" class="form-control" id="alternet_gurdian_address"
                    name="alternet_gurdian_address" value="{{$admissionApplication->alternet_gurdian_address}}">
                <span id="error_alternet_gurdian_address" class="has-error"></span>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        <br/><h5>
            <strong>Subject name and Subject code (Choose group and optional subject from subjects table)
            :</strong>
        </h5><br/>
    </div>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 form-group">
                <table id="form_table" class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th> Subject Name</th>
                        <th> Subject Code</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($admissionApplication->readableSubjects as $subject)
                        <tr class='case'>
                            <td><input type="text" id="sub_{{$subject->sub_name}}" class="form-control" type='text'
                                    name='sub_name[]' value="{{$subject->sub_name}}"
                                    placeholder="Group Subject" required/></td>
                            <td><input type="text" id="sub_{{$subject->sub_code}}" class="form-control" type='text'
                                    value="{{$subject->sub_code}}"
                                    name='sub_code[]' required/>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td><input type="text" class="form-control" type='text' name='optional_subject_name'
                                value="{{$admissionApplication->optional_subject_name}}"
                                placeholder="Optional Subject" required/></td>
                        <td><input type="text" class="form-control" type='text' name='optional_subject_code'
                                value="{{$admissionApplication->optional_subject_code}}"
                                placeholder="" required/></td>
                    </tr>
                    </tbody>
                </table>
                <strong>Take 3 group subjects and 1 optional subject from a group</strong>
            </div>
            <div class="col-md-6 form-group">
                <div id="subject_tables"></div>
                <table id="sub_table" class="table table-striped table-hover table-bordered">
                    <tr>
                        <th> Subjects</th>
                        <th> Code</th>
                        <th> Goup</th>
                        <th> Optional</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class='case'>
                        <td>Physics</td>
                        <td>174</td>
                        <td>Science</td>
                        <td></td>
                    </tr>
                    <tr class='case'>
                        <td>Chemistry</td>
                        <td>176</td>
                        <td>Science</td>
                        <td></td>
                    </tr>
                    <tr class='case'>
                        <td>Biology</td>
                        <td>178</td>
                        <td>Science</td>
                        <td>Optional</td>
                    </tr>
                    <tr class='case'>
                        <td>Higher Math</td>
                        <td>265</td>
                        <td>Science</td>
                        <td>Optional</td>
                    </tr>
                    <tr class='case'>
                        <td>Accounting</td>
                        <td>253</td>
                        <td>Business Studies</td>
                        <td></td>
                    </tr>
                    <tr class='case'>
                        <td>Production Management & Marketing</td>
                        <td>286</td>
                        <td>Business Studies</td>
                        <td></td>
                    </tr>
                    <tr class='case'>
                        <td>Business Organization & Management</td>
                        <td>277</td>
                        <td>Business Studies</td>
                        <td>Optional</td>
                    </tr>
                    <tr class='case'>
                        <td>Economics</td>
                        <td>109</td>
                        <td>Business Studies</td>
                        <td>Optional</td>
                    </tr>
                    <tr class='case'>
                        <td>Logic</td>
                        <td>121</td>
                        <td>Humanities</td>
                        <td></td>
                    </tr>
                    <tr class='case'>
                        <td>Civics & Good Governance</td>
                        <td>269</td>
                        <td>Humanities</td>
                        <td></td>
                    </tr>
                    <tr class='case'>
                        <td>Islamic History & Culture</td>
                        <td>267</td>
                        <td>Humanities</td>
                        <td></td>
                    </tr>
                    <tr class='case'>
                        <td>Economics</td>
                        <td>109</td>
                        <td>Humanities</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
                <strong>In Humanities take any 1 subject as optional from 4 subjects</strong>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="col-md-12">
        <h5>
            <strong>Secondary / Equivalent examination details : </strong>
        </h5>
    </div>
    <br>
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
                <label for=""> School Name </label>
                <input type="text" class="form-control" id="passed_school_name"
                    name="passed_school_name" value="{{$admissionApplication->passed_school_name}}" required>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <label for=""> Exam Roll </label>
                <input type="text" class="form-control" id="ssc_exam_roll"
                    name="ssc_exam_roll" value="{{$admissionApplication->ssc_exam_roll}}" required>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <label for=""> Registration No. </label>
                <input type="text" class="form-control" id="ssc_reg_no"
                    name="ssc_reg_no" value="{{$admissionApplication->ssc_reg_no}}" required>
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-md-4 col-sm-12">
                <label for=""> Board </label>
                <input type="text" class="form-control" id="ssc_exam_board"
                    name="ssc_exam_board" value="{{$admissionApplication->ssc_exam_board}}" required>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <label for=""> Session </label>
                <input type="text" class="form-control" id="ssc_exam_session"
                    name="ssc_exam_session" value="{{$admissionApplication->ssc_exam_session}}" required>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <label for=""> Passed Year </label>
                <input type="text" class="form-control" id="ssc_passed_year"
                    name="ssc_passed_year" value="{{$admissionApplication->ssc_passed_year}}" required>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="col-md-12">
        <br/><h5>Marks Obtianed in Secondary / Equivalent examination : </h5><br/>
    </div>
    <div class="col-md-12 form-group">
        <table id="ssc_form_table" class="table table-striped table-hover table-bordered">
            <thead>
            <tr>
                <th> Subject Name</th>
                <th> Letter Grade</th>
                <th> GPA</th>
            </tr>
            </thead>
            <tbody>
            @foreach($admissionApplication->sscSubjects as $ssc)
                <tr class='ssc'>
                    <td><input type="text" class="form-control" type='text' name='ssc_sub_name[]' value="{{$ssc->ssc_sub_name}}" required/>
                    </td>
                    <td><input type="text" class="form-control" type='text' name='grade[]' value="{{$ssc->grade}}" required/></td>
                    <td><input type="text" class="form-control" type='text' name='gpa[]' value="{{$ssc->gpa}}" required/></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <button type="button" class='btn btn-success addmoressc'> + Add New</button>
        <br>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        <div class="row">
            <div class="form-group col-md-4 col-sm-12">
                <label for=""> GPA (Excluding 4th subject) </label>
                <input type="text" class="form-control" id="gpa_without_fourth"
                    name="gpa_without_fourth" value="{{$admissionApplication->gpa_without_fourth}}" required>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <label for=""> 4th Subject GPA </label>
                <input type="text" class="form-control" id="fourth_sub_gpa"
                    name="fourth_sub_gpa" value="{{$admissionApplication->fourth_sub_gpa}}" required>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <label for=""> Total GPA </label>
                <input type="text" class="form-control" id="grand_gpa"
                    name="grand_gpa" value="{{$admissionApplication->grand_gpa}}" required>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <br/>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6">
                <label for="photo">Applicant's Photo</label>
                <input id="photo" type="file" name="photo" style="display:none">
                <div class="input-group">
                    <div class="input-group-btn">
                        <a class="btn btn-success" onclick="$('input[id=photo]').click();">Browse</a>
                    </div><!-- /btn-group -->
                    <input type="text" name="SelectedFileName" class="form-control" id="SelectedFileName"
                        value="{{$admissionApplication->file_path}}" readonly required>
                </div>
                <div class="clearfix"></div>
                <p class="help-block">File must be jpg, jpeg, png and less than 300KB</p>
                <script type="text/javascript">
                    $('input[id=photo]').change(function () {
                        $('#SelectedFileName').val($(this).val());
                    });
                </script>
                <span id="error_photo" class="has-error"></span>
            </div>
            <div class="form-group col-md-6">
                <label for=""> Status </label><br/>
                <input type="radio" name="status" class="flat-green"
                    value="2" {{ ( $admissionApplication->status == 2 ) ? 'checked' : '' }} /> Active
                <input type="radio" name="status" class="flat-red"
                    value="0" {{ ( $admissionApplication->status == 0 ) ? 'checked' : '' }}/> In Active
            </div>
        </div>
    </div>

    <div class="col-md-4" style="text-align: right">
        <img src="{{asset($admissionApplication->file_path)}}" width="160px" class="img img-thumbnail"/>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12">
        <button class="btn btn-success">SUBMIT</button>
        <img id="loader" src="{{asset('assets/images/loadingg.gif')}}" width="20px">
    </div>
    <div class="clearfix"></div>
    <br/>
</form>
</div>

<script>
    $(document).ready(function () {

        $(".addmoressc").on('click', function () {
            //  var count = $('table tr').length;
            var data = "<tr class='ssc'>";
            data += "<td><input type='text' class='form-control' type='text' name='ssc_sub_name[]' required/></td>"
                + " <td><input type='text' class='form-control' type='text' name='grade[]' required/></td>"
                + " <td><input type='text' class='form-control' type='text' name='gpa[]' required/></td>"
                + "<td style='text-align:center;'><a class='btn btn-danger'><i class='fa fa-times'></i></a></td></tr>";
            $('#ssc_form_table').append(data);
        });
    });
</script>
<script>
    $('#ssc_form_table').on('click', 'tr a', function (e) {
        e.preventDefault();
        $(this).parents('tr').remove();
    });
</script>
<script>
    function get_sections(val) {
        $("#admitted_section").empty();
        $.ajax({
            type: 'GET',
            url: 'getSections/' + val,
            success: function (data) {
                $("#admitted_section").html(data);
                //   get_subjects(val);
            },
            error: function (result) {
                $("#admitted_section").html("Sorry Cannot Load Data");
            }
        });
    }

    function get_subjects(val) {
        $("#subject_table").empty();
        $.ajax({
            type: 'GET',
            url: 'getSubjects/' + val,
            success: function (data) {
                $("#subject_table").html(data);
            },
            error: function (result) {
                $("#subject_table").html("Sorry Cannot Load Data");
            }
        });
    }

    $('input[type="radio"].flat-green').iCheck({
        radioClass: 'iradio_flat-green'
    });

    $('input[type="radio"].flat-red').iCheck({
        radioClass: 'iradio_flat-red'
    });


    $(document).ready(function () {

        $('#loader').hide();
        $('#dob').datepicker({format: "yyyy-mm-dd"}).on('changeDate', function (e) {
            $(this).datepicker('hide');
        });

        $('#edit').validate({// <- attach '.validate()' to your form
            // Rules for form validation
            rules: {
                name: {
                    required: true
                },
                photo: {
                    required: true
                }
            },
            // Messages for form validation
            messages: {
                name: {
                    required: 'Enter your name'
                }
            },
            submitHandler: function (form) {

                var myData = new FormData($("#edit")[0]);
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                myData.append('_token', CSRF_TOKEN);

                $.ajax({
                    url: 'admissionApplication/' + '{{ $admissionApplication->id }}',
                    type: 'POST',
                    data: myData,
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                        $('body').plainOverlay('show');
                    },
                    success: function (data) {
                        $('body').plainOverlay('hide');
                        if (data.type === 'success') {
                            reload_table();
                            notify_view(data.type, data.message);
                            $('#loader').hide();
                            $(".submit").prop('disabled', false); // disable button
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('#myModal').modal('hide'); // hide bootstrap modal

                        } else if (data.type === 'error') {
                            if (data.errors) {
                                $.each(data.errors, function (key, val) {
                                    $('#error_' + key).html(val);
                                });
                            }
                            $("#status").html(data.message);
                            $('#loader').hide();
                            $(".submit").prop('disabled', false); // disable button

                        }
                    }
                });
            }
            // <- end 'submitHandler' callback
        });                    // <- end '.validate()'

    });
</script>
