@extends('frontend.layouts.fullwidth_master')
@section('title', 'Online Admission Form')
@section('content')
    <div class="container p-top-50 p-bottom-50 p-right-40">
        <div class="section-title">
            <div class="row" style="padding: 10px; background: #e0f6ff">
                <div class="col-md-4">
                    <strong>Filled by Office</strong>
                    <p>Serial No. - </p>
                    <p>Admission Date - </p>
                    <p>Class - </p>
                    <p>Section - </p>
                    <p>Roll - </p>
                    <p>Session - </p>
                </div>
                <div class="col-md-4 text-center">
                    <img src="{{ asset($app_settings->logo) }}" width="90%"/>
                    <p>{{ $app_settings->address }}</p>
                    <p>PABX - {{ $app_settings->pabx }}, Ex-5349,5317</p>
                    <p>EIIN : {{ $app_settings->eiin }}</p>
                    <p> Admission Application Form</p>
                </div>
                <div class="col-md-4" style="text-align: right">
                    {{-- <img src="{{asset('assets/images/no.png')}}" width="160px"/> --}}
                </div>
            </div>
        </div>
        <div class="row">
            <div id="status"></div>

            <div style="clear: both"></div>

            <hr/>
            <form id='create' enctype="multipart/form-data" method="post" accept-charset="utf-8">
                <div id="status"></div>
                <div class="col-md-4">
                    <h5>Class you want to admit? : </h5>
                </div>
                {{-- <div class="form-group col-md-4 col-sm-12">
                    <select name="admitted_class" id="admitted_class" class="form-control" required
                            onchange="get_sections(this.value)">
                        <option value="" selected disabled>Select a class</option>
                        @foreach($stdclass as $class)
                            @if($class->in_digit ==11)
                                <option value="{{$class->id}}">{{$class->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div> --}}
                <div class="form-group col-md-4 col-sm-12">
                    <select name="admitted_class" id="admitted_class" class="form-control" required
                            onchange="get_sections_manually(this.value)">
                        <option value="" selected disabled>Select a class</option>
                            <option value="HSC">HSC</option>
                            <option value="HONOURS">HONOUR'S</option>
                    </select>
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <select class="form-control" name="admitted_section" id="admitted_section" onchange="get_group_subject(this.value)" required>
                        <option value="" selected disabled>Select a section</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <br/><h5>Applicant's Information : </h5><br/>
                </div>
                {{-- <div id="college_roll_div">
                    <div class="form-group col-md-4 col-sm-12">
                        <label for=""> College Roll* </label>
                        <input type="number" class="form-control" id="college_roll" name="college_roll" value="">
                        <span id="college_roll" class="has-error"></span>
                    </div>
                </div> --}}
                <div class="form-group col-md-4 col-sm-12">
                    <label for=""> Full Name (English Block Letter)* </label>
                    <input type="text" class="form-control" id="applicant_name_en" name="applicant_name_en" value="" required>
                    <span id="error_applicant_name_en" class="has-error"></span>
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for=""> Full Name (Bangla)* </label>
                    <input type="text" class="form-control" id="applicant_name_bn" name="applicant_name_bn" value=""
                           required>
                    <span id="error_applicant_name_bn" class="has-error"></span>
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for=""> Mobile (Must have to provide for communication) * </label>
                    <input type="number" class="form-control" id="mobile"
                           name="mobile" value="" required>
                    <span id="error_mobile" class="has-error"></span>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for=""> Father's Name (English Block Letter)* </label>
                    <input type="text" class="form-control" id="father_name_en" name="father_name_en" value=""
                           required>
                    <span id="error_father_name_en" class="has-error"></span>
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for=""> Father's Name (Bangla)* </label>
                    <input type="text" class="form-control" id="father_name_bn" name="father_name_bn" value=""
                           required>
                    <span id="error_father_name_bn" class="has-error"></span>
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for=""> Father's Mobile </label>
                    <input type="text" class="form-control" id="father_mobile"
                           name="father_mobile" value="">
                    <span id="error_mobile" class="has-error"></span>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for=""> Mother's Name (English Block Letter)* </label>
                    <input type="text" class="form-control" id="mother_name_en" name="mother_name_en" value=""
                           required>
                    <span id="error_mother_name_en" class="has-error"></span>
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for=""> Mother's Name (Bangla)* </label>
                    <input type="text" class="form-control" id="mother_name_bn" name="mother_name_bn" value=""
                           required>
                    <span id="error_mother_name_bn" class="has-error"></span>
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for=""> Mother's Mobile </label>
                    <input type="text" class="form-control" id="mother_mobile"
                           name="mother_mobile" value="">
                    <span id="error_mobile" class="has-error"></span>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-3 col-sm-12">
                    <label for=""> Date of Birth </label>
                    <input type="text" class="form-control" id="dob"
                           name="dob" value="" required readonly>
                    <span id="error_dob" class="has-error"></span>
                </div>
                <div class="form-group col-md-3 col-sm-12">
                    <label for=""> Email </label>
                    <input type="text" class="form-control" id="email"
                           name="email" value="">
                </div>
                <div class="form-group col-md-3 col-sm-12">
                    <label for=""> Nationality </label>
                    <input type="text" class="form-control" id="nationality"
                           name="nationality" value="" required>
                </div>
                <div class="form-group col-md-3 col-sm-12">
                    <label for=""> Religion * </label>
                    <select name="religion" class="form-control">
                        <option value="Islam">Islam</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddhist">Buddhist</option>
                        <option value="Christian">Christian</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <br/>
                <div class="col-md-3">
                    <h5>Present Address : </h5>
                </div>
                <div class="form-group col-md-3 col-sm-12">
                    <input type="text" class="form-control" id="present_village"
                           name="present_village" value="" placeholder="Village *" required>
                    <span id="error_present_village" class="has-error"></span>
                </div>
                <div class="form-group col-md-2 col-sm-12">
                    <input type="text" class="form-control" id="present_post_office"
                           name="present_post_office" value="" placeholder="Post Office *" required>
                    <span id="error_present_post_office" class="has-error"></span>
                </div>
                <div class="form-group col-md-2 col-sm-12">
                    <input type="text" class="form-control" id="present_thana"
                           name="present_thana" value="" placeholder="Thana" required>
                    <span id="error_present_thana" class="has-error"></span>
                </div>
                <div class="form-group col-md-2 col-sm-12">
                    <input type="text" class="form-control" id="present_district"
                           name="present_district" value="" placeholder="District" required>
                    <span id="error_present_thana" class="has-error"></span>
                </div>
                <div class="clearfix"></div>
                <br/>
                <div class="col-md-3">
                    <h5>Permanent Address : </h5>
                </div>
                <div class="form-group col-md-3 col-sm-12">
                    <input type="text" class="form-control" id="parmanent_village"
                           name="parmanent_village" value="" placeholder="Village">
                    <span id="error_parmanent_village" class="has-error"></span>
                </div>
                <div class="form-group col-md-2 col-sm-12">
                    <input type="text" class="form-control" id="parmanent_post_office"
                           name="parmanent_post_office" value="" placeholder="Post Office">
                    <span id="error_parmanent_post_office" class="has-error"></span>
                </div>
                <div class="form-group col-md-2 col-sm-12">
                    <input type="text" class="form-control" id="parmanent_thana"
                           name="parmanent_thana" value="" placeholder="Thana">
                    <span id="error_parmanent_thana" class="has-error"></span>
                </div>
                <div class="form-group col-md-2 col-sm-12">
                    <input type="text" class="form-control" id="parmanent_district"
                           name="parmanent_district" value="" placeholder="District">
                    <span id="error_parmanent_district" class="has-error"></span>
                </div>
                <div class="clearfix"></div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <br/><h5>If parents unavailable then other gurdian information : </h5><br/>
                </div>
                <div class="form-group col-md-3 col-sm-12">
                    <label for=""> Name </label>
                    <input type="text" class="form-control" id="alternet_gurdian_name"
                           name="alternet_gurdian_name" value="">
                    <span id="error_alternet_gurdian_name" class="has-error"></span>
                </div>
                <div class="form-group col-md-3 col-sm-12">
                    <label for=""> Phone </label>
                    <input type="number" class="form-control" id="alternet_gurdian_phone"
                           name="alternet_gurdian_phone" value="">
                    <span id="error_alternet_gurdian_phone" class="has-error"></span>
                </div>
                <div class="form-group col-md-3 col-sm-12">
                    <label for=""> Relation </label>
                    <input type="text" class="form-control" id="alternet_gurdian_relation"
                           name="alternet_gurdian_relation" value="">
                    <span id="error_alternet_gurdian_relation" class="has-error"></span>
                </div>
                <div class="form-group col-md-3 col-sm-12">
                    <label for="">Address </label>
                    <input type="text" class="form-control" id="alternet_gurdian_address"
                           name="alternet_gurdian_address" value="">
                    <span id="error_alternet_gurdian_address" class="has-error"></span>
                </div>
                <div class="clearfix"></div>
                <div class="div" id="subject_name_and_code_div">
                    <div class="col-md-12">
                    <br/><h5>Subject name and Subject code (Choose group and optional subject from subjects table)
                        : </h5><br/>
                </div>
                <div class="col-md-6 form-group">
                    <table id="form_table" class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr>
                            <th> Subject Name</th>
                            <th> Subject Code</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class='case'>
                            <td><input type="text" value="Bangla" class="form-control" type='text'
                                       name='sub_name[]' readonly/></td>
                            <td><input type="text" value="101" class="form-control" type='text' name='sub_code[]'
                                       readonly/></td>
                        </tr>
                        <tr class='case'>
                            <td><input type="text" value="English" class="form-control" type='text'
                                       name='sub_name[]' readonly/></td>
                            <td><input type="text" value="107" class="form-control" type='text' name='sub_code[]'
                                       readonly/></td>
                        </tr>
                        <tr class='case'>
                            <td><input type="text" value="ICT" class="form-control" type='text' name='sub_name[]'
                                       readonly/></td>
                            <td><input type="text" value="275" class="form-control" type='text' name='sub_code[]'
                                       readonly/></td>
                        </tr>
                        @for($i=1 ; $i<4; $i++)
                            <tr class='case'>
                                <td><input type="text" class="form-control" type='text' name='sub_name[]'
                                           placeholder="Group Subject" /></td>
                                <td><input type="number" class="form-control" type='text' name='sub_code[]' />
                                </td>
                            </tr>
                        @endfor
                        <tr>
                            <td><input type="text" class="form-control" type='text' name='optional_subject_name'
                                       placeholder="Optional Subject" /></td>
                            <td><input type="number" class="form-control" type='text' name='optional_subject_code'
                                       placeholder="" /></td>
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
                            <td>174,175</td>
                            <td>Science</td>
                            <td></td>
                        </tr>
                        <tr class='case'>
                            <td>Chemistry</td>
                            <td>176,177</td>
                            <td>Science</td>
                            <td></td>
                        </tr>
                        <tr class='case'>
                            <td>Biology</td>
                            <td>178,179</td>
                            <td>Science</td>
                            <td>Optional</td>
                        </tr>
                        <tr class='case'>
                            <td>Higher Math</td>
                            <td>265,266</td>
                            <td>Science</td>
                            <td>Optional</td>
                        </tr>
                        <tr class='case'>
                            <td>Accounting</td>
                            <td>253,254</td>
                            <td>Business Studies</td>
                            <td></td>
                        </tr>
                        <tr class='case'>
                            <td>Finance and Banking</td>
                            <td>292,293</td>
                            <td>Business Studies</td>
                            <td></td>
                        </tr>
                        <tr class='case'>
                            <td>Business Organization & Management</td>
                            <td>277,278</td>
                            <td>Business Studies</td>
                            <td></td>
                        </tr>
                        <tr class='case'>
                            <td>Economics</td>
                            <td>109,110</td>
                            <td>Business Studies/Humanities</td>
                            <td>Optional</td>
                        </tr>
                        <tr class='case'>
                            <td>Logic</td>
                            <td>121,122</td>
                            <td>Humanities</td>
                            <td></td>
                        </tr>
                        <tr class='case'>
                            <td>Civics & Good Governance</td>
                            <td>269,270</td>
                            <td>Humanities</td>
                            <td></td>
                        </tr>
                        <tr class='case'>
                            <td>Islamic History & Culture</td>
                            <td>267,268</td>
                            <td>Humanities</td>
                            <td></td>
                        </tr>
                        <tr class='case'>
                            <td>Islamic Studies</td>
                            <td>249,250</td>
                            <td>Humanities</td>
                            <td></td>
                        </tr>
                        <tr class='case'>
                            <td>Home Economics</td>
                            <td>273,274</td>
                            <td>Humanities</td>
                            <td></td>
                        </tr>
                        <tr class='case'>
                            <td>Sociology</td>
                            <td>117,118</td>
                            <td>Humanities</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    <strong>In Humanities take any 1 subject as optional from 4 subjects</strong>
                </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <br/><h5>Secondary / Equivalent examination details : </h5><br/>
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for=""> School Name </label>
                    <input type="text" class="form-control" id="passed_school_name"
                           name="passed_school_name" value="" required>
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for=""> Exam Roll </label>
                    <input type="number" class="form-control" id="ssc_exam_roll"
                           name="ssc_exam_roll" value="" required>
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for=""> Registration No. </label>
                    <input type="number" class="form-control" id="ssc_reg_no"
                           name="ssc_reg_no" value="" required>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-md-3 col-sm-12">
                    <label for=""> Board </label>
                    <input type="text" class="form-control" id="ssc_exam_board"
                           name="ssc_exam_board" value="" required>
                </div>
                <div class="form-group col-md-3 col-sm-12">
                    <label for=""> Session </label>
                    <input type="text" class="form-control" id="ssc_exam_session"
                           name="ssc_exam_session" value="" required>
                </div>
                <div class="form-group col-md-3 col-sm-12">
                    <label for=""> Passed Year </label>
                    <input type="number" class="form-control" id="ssc_passed_year"
                           name="ssc_passed_year" value="" required>
                </div>
                <div class="form-group col-md-3 col-sm-12" id="ssc_gpa_section">
                    <label for=""> GPA </label>
                    <input type="number" class="form-control" id="ssc_gpa"
                           name="ssc_gpa" value="">
                </div>
                <div class="clearfix"></div>
                <div class="div" id="hsc_examination_details">
                    <div class="col-md-12">
                        <br/>
                            <h5>Higher Secondary / Equivalent examination details : </h5>
                        <br/>
                    </div>
                    <div class="form-group col-md-4 col-sm-12">
                        <label for=""> College Name </label>
                        <input type="text" class="form-control" id="passed_college_name"
                            name="passed_college_name" value="">
                    </div>
                    <div class="form-group col-md-4 col-sm-12">
                        <label for=""> Exam Roll </label>
                        <input type="number" class="form-control" id="hsc_exam_roll"
                            name="hsc_exam_roll" value="" >
                    </div>
                    <div class="form-group col-md-4 col-sm-12">
                        <label for=""> Registration No. </label>
                        <input type="number" class="form-control" id="hsc_reg_no"
                            name="hsc_reg_no" value="" >
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-3 col-sm-12">
                        <label for=""> Board </label>
                        <input type="text" class="form-control" id="hsc_exam_board"
                            name="hsc_exam_board" value="" >
                    </div>
                    <div class="form-group col-md-3 col-sm-12">
                        <label for=""> Session </label>
                        <input type="number" class="form-control" id="hsc_exam_session"                           name="hsc_exam_session" value="" >
                    </div>
                    <div class="form-group col-md-3 col-sm-12">
                        <label for=""> Passed Year </label>
                        <input type="number" class="form-control" id="hsc_passed_year"
                            name="hsc_passed_year" value="">
                    </div>
                    <div class="form-group col-md-3 col-sm-12">
                        <label for=""> GPA </label>
                        <input type="number" class="form-control" id="hsc_gpa"
                            name="hsc_gpa" value="">
                    </div>
                </div>
                <div class="clearfix"></div>
                {{-- <div class="div" id="ssc_relavent_portion">
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
                            <tr class='ssc'>
                                <td><input type="text" class="form-control" type='text' name='ssc_sub_name[]' /></td>
                                <td><input type="text" class="form-control" type='text' name='grade[]' /></td>
                                <td><input type="number" class="form-control" type='text' name='gpa[]' /></td>
                            </tr>
                            </tbody>
                        </table>
                        <button type="button" class='btn btn-success addmoressc'> + Add New</button>
                        <br>
                    </div>
                <div class="clearfix"></div> --}}

                <div class="col-md-12">
                    <br/><h5>Marks Obtianed in Secondary / Equivalent examination : </h5><br/>
                </div>

                <div class="col-md-12 form-group" id="ssc_science_group_sub_div">
                    <table id="ssc_science_group" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Subject Name</th>
                                <th>Letter Grade</th>
                                <th>GPA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Bangla " name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="English" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Math" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Religion" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="ICT" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Bangladesh & World" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Physics" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Chemistry" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Biology" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Higher Math" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Information & Technology" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Agriculture Studies" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Home Science" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 form-group" id="ssc_business_group_sub_div">
                    <table id="ssc_science_group" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Subject Name</th>
                                <th>Letter Grade</th>
                                <th>GPA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Bangla " name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="English" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Math" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Religion" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="ICT" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Finance & Banking" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Accounting" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Business Ent." name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="General Science" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Information & Technology" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Agriculture Studies" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Home Science" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 form-group" id="ssc_humanities_group_sub_div">
                    <table id="ssc_science_group" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Subject Name</th>
                                <th>Letter Grade</th>
                                <th>GPA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Bangla " name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="English" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Math" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Religion" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="ICT" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Geography" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Civic & Citizenship" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Economics" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="General Science" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Information & Technology" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Agriculture Studies" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="History of Bangladesh" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="Home Science" name="ssc_sub_name[]" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="grade[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="gpa[]">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="form-group col-md-4 col-sm-12">
                    <label for=""> GPA (Excluding 4th subject) </label>
                    <input type="number" class="form-control" id="gpa_without_fourth"
                           name="gpa_without_fourth" value="" >
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for=""> 4th Subject GPA </label>
                    <input type="number" class="form-control" id="fourth_sub_gpa"
                           name="fourth_sub_gpa" value="" >
                </div>
                <div class="form-group col-md-4 col-sm-12">
                    <label for=""> Total GPA </label>
                    <input type="number" class="form-control" id="grand_gpa"
                           name="grand_gpa" value="" >
                </div>
                </div>
                <div class="clearfix"></div>

                <br/>
                <div class="col-md-12">
                    <label for="photo">Applicant's Photo</label>
                    <input id="photo" type="file" name="photo" style="display:none">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <a class="btn btn-success" onclick="$('input[id=photo]').click();">Browse</a>
                        </div><!-- /btn-group -->
                        <input type="text" name="SelectedFileName" class="form-control" id="SelectedFileName"
                               value="" readonly required>
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
                <div class="clearfix"></div>
                <div class="col-md-12">
                    <button class="site-btn submit">SUBMIT</button>
                    <img id="loader" src="{{asset('assets/images/loadingg.gif')}}" width="20px">
                </div>
            </form>
        </div>
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
        $('table').on('click', 'tr a', function (e) {
            e.preventDefault();
            $(this).parents('tr').remove();
        });
    </script>
    <script>
        $("#ssc_science_group_sub_div").hide();
        $("#ssc_business_group_sub_div").hide();
        $("#ssc_humanities_group_sub_div").hide();
    </script>
    <script>
        function get_sections(val) {
            console.log(val);
            $("#admitted_section").empty();
            $.ajax({
                type: 'GET',
                url: 'getSections/' + val,
                success: function (data) {
                    console.log(data);
                    $("#admitted_section").html(data);
                    //   get_subjects(val);
                },
                error: function (result) {
                    $("#admitted_section").html("Sorry Cannot Load Data");
                }
            });
        }

        function get_sections_manually(val) {
            console.log(val);
            if (val == 'HONOURS') {
                $("#subject_name_and_code_div").hide() && $("#ssc_gpa_section").show() && $("#ssc_relavent_portion").hide() && $("#hsc_examination_details").show();
            }else if(val == 'HSC'){
                $("#subject_name_and_code_div").show() && $("#ssc_gpa_section").hide() && $("#ssc_relavent_portion").show() && $("#hsc_examination_details").hide();;
            }
            $("#admitted_section").empty();
            $.ajax({
                type: 'GET',
                url: 'getSectionsManually/' + val,
                success: function (data) {
                    console.log(data);
                    $("#admitted_section").html(data);
                    //   get_subjects(val);
                },
                error: function (result) {
                    $("#admitted_section").html("Sorry Cannot Load Data");
                }
            });
        }

        function get_group_subject(val){

            if (val == 'Science') {
                $("#ssc_science_group_sub_div").show() && $("#ssc_business_group_sub_div").hide() && $("#ssc_humanities_group_sub_div").hide();
            }
            else if(val == 'Business Studies'){
                $("#ssc_science_group_sub_div").hide() && $("#ssc_humanities_group_sub_div").hide() && $("#ssc_business_group_sub_div").show() ;
            }
            else if(val == 'Humanities'){
                $("#ssc_science_group_sub_div").hide() && $("#ssc_business_group_sub_div").hide() && $("#ssc_humanities_group_sub_div").show();
            }
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


        $(document).ready(function () {

            $('#loader').hide();
            $('#dob').datepicker({format: "yyyy-mm-dd"}).on('changeDate', function (e) {
                $(this).datepicker('hide');
            });

            $('#create').validate({// <- attach '.validate()' to your form
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

                    var myData = new FormData($("#create")[0]);
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    myData.append('_token', CSRF_TOKEN);

                    $.ajax({
                        url: 'onlineAdmission',
                        type: 'POST',
                        data: myData,
                        dataType: 'json',
                        cache: false,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $('#loader').show();
                            $(".submit").prop('disabled', true); // disable button
                        },
                        success: function (data) {
                            if (data.type === 'success') {
                                $('#loader').hide();
                                $(".submit").prop('disabled', false); // disable button
                                $("html, body").animate({scrollTop: 0}, "slow");
                                $('#status').html(data.message); // hide bootstrap modal
                                document.getElementById("create").reset();

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
@endsection
