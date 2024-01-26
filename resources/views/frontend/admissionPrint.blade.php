<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<style>

    table,th,td{
        border-collapse: collapse;
        border: 1px solid black;
        text-align: center;
        padding: 8px;

    }
    .grade-table td {
        padding:0;
        margin:0;
        font-size: 11;
    }

    table {
        width: 100%;
    }

    .header{
        border:1px solid white;
    }

</style>
<body style="page-break-after: auto">
@if(!empty($admissionApplication))
    <div class="" id="admission_application">
        <div id="row_block">
            <div class="col-md-2">
                {{-- <div class="office">
                    <p>Serial No. - </p>
                    <p>Admission Date - </p>
                    <p>Class - </p>
                    <p>Section - </p>
                    <p>Roll - </p>
                    <p>Session - </p>
                </div> --}}
            </div>
            <div id="header" class="col-md-8">
                <img src="{{ $app_settings->logo }}" width="60%"/>
                <p style="margin-top: -2px">178 Darogahat Road , Shadharghat, Chattogram, Bangladesh</p>
                <p>PABX - 2522200-29, Ex-5349,5317</p>
                <p>EIIN : 104299 </p>
                <br>
                <h3> Admission Application Form</h3>
            </div>
            <div class="col-md-2">
                <img src="{{ $admissionApplication->file_path }}" width="100px" class="img img-thumbnail" style="margin-top:15px;" />
            </div>
        </div>
        <hr/>
        <div style="clear: both"></div>
        <div id="row_block" style="display:none;">
            <div class="col-md-3">
                <div class="office">
                    <strong>Filled by Office</strong>
                    <hr/>
                    <p>Serial No. - </p>
                    <p>Admission Date - </p>
                    <p>Class - </p>
                    <p>Section - </p>
                    <p>Roll - </p>
                    <p>Session - </p>
                </div>
            </div>
            <div class="col-md-6">
                <div id="header">
                    <p> Admission Application Form</p>
                    <p> Application Form Number - {{$admissionApplication->applicant_form_no}}</p>
                </div>
            </div>
            <div class="col-md-3" style="text-align: right">
                {{-- <img src="{{asset('$admissionApplication->file_path')}}" width="140px"/> --}}
            </div>
        </div>
        <div style="clear: both"></div>
        <div class="row_block">
            <div class="col-md-4">
                <h3><strong>Class You Filled In Form : </strong></h3>
            </div>
            <div style="clear: both"></div>
            <div class="col-md-4">
                <p> Class : {{$admissionApplication->admitted_class}}</p>
            </div>
            <div class="col-md-4">
                <p> Department : {{ $admissionApplication->admitted_section }} </p>
            </div>
            <div class="col-md-4">
                <p> College Roll : {{ $admissionApplication->college_roll }} </p>
            </div>
        </div>
        <div style="clear: both"></div>
        <div class="row_block">
            <div class="col-md-12">
                <h3><strong>Applicant's Details :</strong></h3>
            </div>
            <div style="clear: both"></div>
            <div class="col-md-5">
                <p> Name : {{$admissionApplication->applicant_name_en}}</p>
            </div>
        </div>
        <div style="clear: both"></div>
        <div class="row_block">
            <div class="col-md-4">
                <p> Father's Name : {{$admissionApplication->father_name_en}}</p>
            </div>
            <div class="col-md-3">
                <p> Mobile : {{$admissionApplication->father_mobile}} </p>
            </div>
        </div>
        <div style="clear: both"></div>
        <div class="row_block">
            <div class="col-md-4">
                <p> Mother's Name : {{$admissionApplication->mother_name_en}}</p>
            </div>
            <div class="col-md-3">
                <p> Mobile : {{$admissionApplication->mother_mobile}} </p>
            </div>
        </div>
        <div style="clear: both"></div>
        <div class="row_block">
                <div class="col-md-4">
                    <p> Date of Birth : {{$admissionApplication->dob}}</p>
                </div>
                <div class="col-md-3">
                    <p> Phone : {{$admissionApplication->mobile}}</p>
                </div>
                <div class="col-md-3">
                    <p> Nationality : {{$admissionApplication->nationality}}</p>
                </div>
                <div class="col-md-3">
                    <p> Religion : {{$admissionApplication->religion}}</p>
                </div>
        </div>
        <div style="clear: both"></div>
        <div class="row_block">
            <div class="col-md-6">
                <h3>Present Address : </h3>
            </div>
            <div style="clear: both"></div>
            <div class="col-md-4">
                    <p> Village/City : {{$admissionApplication->present_village}}</p>
                </div>
                <div class="col-md-3">
                    <p> Post Office : {{$admissionApplication->present_post_office}}</p>
                </div>
                <div class="col-md-3">
                    <p> Thana : {{$admissionApplication->present_thana}}</p>
                </div>
                <div class="col-md-3">
                    <p> District : {{$admissionApplication->present_district}}</p>
                </div>
        </div>
        <div style="clear: both"></div>
        <div class="row_block">
            <div class="col-md-6">
                <h3>Parmanent Address : </h3>
            </div>
            <div style="clear: both"></div>
            <div class="col-md-4">
                    <p> Village/City : {{$admissionApplication->parmanent_village}}</p>
            </div>
            <div class="col-md-3">
                <p> Post Office : {{$admissionApplication->parmanent_post_office}}</p>
            </div>
            <div class="col-md-3">
                <p> Thana : {{$admissionApplication->parmanent_thana}}</p>
            </div>
            <div class="col-md-3">
                <p> District : {{$admissionApplication->parmanent_district}}</p>
            </div>
        </div>
        {{-- <div class="row_block">
            <div class="col-md-12">
                <strong> Present Address : </strong>
                    {{ ' Village : ' . $admissionApplication->present_village
                       . ', Post Office : ' . $admissionApplication->present_post_office }}</>
            </div>
            <div style="clear: both"></div>
            <div class="col-md-12">
                <p>
                    {{ ' Thana : ' . $admissionApplication->present_thana
                    . ', District : ' . $admissionApplication->present_district}}
                </p>
            </div>
            <div style="clear: both"></div>
            <div class="col-md-12">
                <p><strong> Parmanent Address : </strong>
                    {{ ' Village : ' . $admissionApplication->parmanent_village
                     . ', Post Office : ' . $admissionApplication->parmanent_post_office}}
                </p>
            </div>
            <div style="clear: both"></div>
            <div class="col-md-12">
                <p>
                    {{' Thana : ' . $admissionApplication->parmanent_thana
                     . ', District : ' . $admissionApplication->parmanent_district}}
                </p>
            </div>
        </div> --}}
        <div style="clear: both"></div>

        <div style="clear: both"></div>
        <div class="row_block">
                <h3>
                    <strong> Gurdian (Absence of father) : </strong>
                </h3>
                <div style="clear: both"></div>
                    @if($admissionApplication->alternet_gurdian_name != '')
                        
                        <div class="col-md-3">
                                <p> Name : {{$admissionApplication->alternet_gurdian_name}}</p>
                        </div>
                        <div class="col-md-3">
                            <p> Phone : {{$admissionApplication->alternet_gurdian_phone}}</p>
                        </div>
                        <div class="col-md-3">
                            <p> Relation : {{$admissionApplication->alternet_gurdian_phone}}</p>
                        </div>
                        <div class="col-md-3">
                            <p> Address : {{$admissionApplication->alternet_gurdian_phone}}</p>
                        </div>
                
                        @else
                            <p>No</p>
                        @endif
        </div>
        <div style="clear: both"></div>
        <div class="row_block" style="font-size:9px;">
            <div class="col-md-12">
                <h3><strong> Readable Subject : </strong></h3>
            </div>
            <div style="clear: both"></div>
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <th>Subject</th>
                        <th>Code</th>
                        <th>Type</th>
                    </tr>
                    @foreach($admissionApplication->readableSubjects as $subject)
                    <tr>
                        <td>{{$subject->sub_name}}</td>
                        <td>{{$subject->sub_code}}</td>
                        <td>Mandatory</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>{{$admissionApplication->optional_subject_name}}</td>
                        <td>{{$admissionApplication->optional_subject_code}}</td>
                        <td>Optional</td>
                    </tr>

                </table>
            </div>
        </div>
        <div style="clear: both"></div>
        <div class="row_block">
            <div class="col-md-12">
                <h3>Exam Name : Secondary / Equivalent (Details)</h3>
            </div>
        </div>
        <br>
        <div style="clear: both"></div>

        <div class="col-md-4">
            <p>School Name : {{$admissionApplication->passed_school_name}}</p>
        </div>
        <div class="col-md-4">
            <p>Exam Roll : {{$admissionApplication->ssc_exam_roll}}</p>
        </div>
        <div class="col-md-3">
            <p>Registration No. : {{$admissionApplication->ssc_reg_no}}</p>
        </div>
        <div style="clear: both"></div>
        <div class="col-md-4">
            <p>Board : {{$admissionApplication->ssc_exam_board}} </p></div>
        <div class="col-md-4">
            <p>Session : {{$admissionApplication->ssc_exam_session}} </p>
        </div>
        <div class="col-md-4">
            <p>Passed Year : {{$admissionApplication->ssc_passed_year}}</p>
        </div>
        <div style="clear: both"></div>

        <br>
        <br>
        <br>
        <br>
        <p></p>
        <div class="col-md-12">
                <h3><strong> Marks Obtained in Secondary / Equivalent Exam : </strong>
                </h3>
        </div>
        <div style="clear: both"></div>
        <div class="col-md-12">
            <table class="table">
                <tr>
                    <th>Subject</th>
                    <th>Letter Grade</th>
                    <th>GPA</th>
                </tr>
                @foreach($admissionApplication->sscSubjects as $ssc)
                <tr>
                    <td>{{$ssc->ssc_sub_name}}</td>
                    <td>{{$ssc->grade}}</td>
                    <td>{{$ssc->gpa}}</td>
                </tr>
                @endforeach

            </table>
        </div>
        <div style="clear: both"></div>

        <div class="row_block">
            <div class="col-md-5">
                <p>GPA (Excluding 4th subject) :    {{$admissionApplication->gpa_without_fourth}}
                </p>
            </div>
            <div class="col-md-4">
                <p>4th Subject GPA : {{$admissionApplication->fourth_sub_gpa}}</p>
            </div>
            <div class="col-md-3">
                <p>Total GPA : {{$admissionApplication->grand_gpa}}</p>
            </div>
        </div>
        <div style="clear: both"></div>
        <div class="row_block" style="margin-top:20px;">
            <div class="col-md-9">
                <p>--------------------------------------------------</p>
                <p>Admission Committee's Signature</p>
            </div>
            <div class="col-md-3" style="text-align:right;">
                <p>--------------------------------</p>
                <p>Principal's Signature</p>
            </div>
        </div>
        <div style="clear: both"></div>
    </div>
@else
    <div class="row">
        <div class="col-md-12 text-center">
            <div id="not_found">
                {{-- <img src="{{asset('assets/images/empty_box.png')}}" width="200px"> --}}
            </div>
            <h2 style="font-family: SolaimanLipi, sans-serif">Not found</h2>
        </div>
    </div>
@endif

<style>

    .bd_font {
        font-family: 'bangla', sans-serif;;
    }

    #admission_application {
        padding-right: 5px;
        font-size: 10px;
        line-height: -10px;
    }

    #header {
        text-align: center;
        line-height: 6px;
    }

    #row_block {
        width: 100%;
        display: block;
        clear: both;
        position: relative;
    }

    .office {
        line-height: 6px;
    }

    .col-md-2 {
        width: 15%;
        float: left;
    }

    .col-md-3 {
        width: 25%;
        float: left;
    }

    .col-md-4 {
        width: 33.33%;
        float: left;
    }

    .col-md-5 {
        width: 40%;
        float: left;
    }

    .col-md-6 {
        width: 50%;
        float: left;
    }

    .col-md-7 {
        width: 55%;
        float: left;
    }

    .col-md-8 {
        width: 70%;
        float: left;
    }

    .col-md-9 {
        width: 70%;
        float: left;
    }

    .col-md-12 {
        width: 100%;
        float: left;
    }


</style>
</body>
</html>
