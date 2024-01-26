<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body style="page-break-after: auto">
    <div id="footer">
        <p class="page">page </p>
    </div>
@if(!empty($data))
    <div class="" id="marksheet">
        <div id="header_details">
            <div style="width:25%;float: left;">
                <img src="assets/images/islamia_clg.jpg" alt="" style="margin-left: 220px;margin-top:25px;" height="80px" width="80px">
            </div>

            <div style="width:22%; float:right;margin-top:0px;margin-right:-50px;">
                <caption style="margin-right:70px;">Grade System</caption>
                <table class="grade-table">

                    <tr>
                        <td>Letter Grade</td>
                        <td>Class Interval (%)</td>
                        <td>Grade Point</td>
                    </tr>
                    <tr>

                        <td>A+</td>
                        <td>80-100</td>
                        <td>5.00</td>
                    </tr>
                    <tr>
                        <td>A</td>
                        <td>70-79</td>
                        <td>4.00</td>
                    </tr>
                    <tr>
                        <td>A-</td>
                        <td>60-69</td>
                        <td>3.50</td>
                    </tr>
                    <tr>
                        <td>B</td>
                        <td>50-59</td>
                        <td>3.00</td>
                    </tr>
                    <tr>
                        <td>C</td>
                        <td>40-49</td>
                        <td>2.00</td>
                    </tr>
                    <tr>
                        <td>D</td>
                        <td>33-39</td>
                        <td>1.00</td>
                    </tr>
                    <tr>
                        <td>F</td>
                        <td>00-32</td>
                        <td>0.00</td>
                    </tr>
                </table>
            </div>
            <div style="width:100%; text-align: center; margin-top:10px;font-size:22px;text-align:center;">
                <h4 style="text-transform: uppercase; margin-bottom:-25px;">
                    {{  $app_settings ? Str::upper($app_settings->name) : '' }}
                </h4>
                <h5 style="text-align:center;"> {{ Str::upper($data['exam_name']) }} </h5>

                <h5 style="color:green;margin-top:-15px;text-align:center;"><u>Tablulation Sheet</u></h5>
            </div>
                <div id="col_3">
                    <h4>
                        <strong>Class : </strong>{{ $data['class_name'] }}<br/>
                        <strong> Session : </strong>{{ $data['year'] }}
                    </h4>
                </div>
        </div>
        &nbsp;


        <div id="marks_table">
            <table style="width: 100%;border-collapse:collapse;">
            <col>
            <col>
            <colgroup span="3"></colgroup>
            <thead>
                <tr>
                <th scope="col">Information Of The Examinee</th>
                <th colspan="3" scope="colgroup">Compulsory Subject</th>
                <th colspan="3" scope="colgroup">Group Subject</th>
                <th colspan="1" scope="colgroup">Fourth Subject</th>
                <th scope="col">Grade Point Average(GPA)</th>
                </tr>
            </thead>
            <tbody>

                {{-- @dd($student[$i][0]->optional_subject); --}}


                @for ($i=0; $i < count($data['result']) ; $i++)

                @php
                    $total_marks = 0;
                    $cgpa_status = 1;
                    $total_gpa = 0;
                    $total_cgpa = 0;
                    $optional_sub_marks = 0;
                    $total_subjects = 0;

                    $bangla_gpa = 0;
                    $english_gpa = 0;
                    $ict_gpa = 0;
                    $optional_subject_gpa = 0;

                    $group_subject =  array();
                    $com_opt_sub = array('101','102','107','108','275');

                    $all_subject = [];
                    $total_subjects = count($student[$i]);



                    foreach($student[$i] as $row) {

                        $all_subject[] = $row->code;

                        $total_marks+= $row->obtainedMark;


                        if ($row->result_status === 'FAILED') {
                            $cgpa_status = 0;
                            }

                            if ($cgpa_status != 0) {
                            $total_cgpa = round($total_cgpa + $row->CGPA, 2);
                            }

                            // Bangla
                            if ($row->code == 101 || $row->code == 102) {
                                $bangla_gpa = $row->grade;
                            }
                            // English
                            if ($row->code == 107 || $row->code == 108) {
                                $english_gpa = $row->grade;
                            }
                            if ($row->code == 275) {
                                $ict_gpa = $row->grade;
                            }
                            // Optional subject calculation
                            if ($row->subject_id == $row->optional_subject) {
                                array_push($com_opt_sub,$row->code) ;
                                $optional_subject_gpa = $row->grade;
                                $total_subjects = $total_subjects -1; // Optional subject not count on average point so less
                                $total_cgpa = $total_cgpa - $row->CGPA;

                                if ($row->CGPA > 2.00) {
                                    $optional_sub_marks = $row->CGPA - 2.00;
                                    $total_cgpa = $total_cgpa + $optional_sub_marks;
                                }
                            }


                    }

                    $group_subject = array_diff($all_subject,$com_opt_sub);


                    $group_subject_val = [];

                    foreach ($student[$i] as $row) {
                        if (in_array($row->code,$group_subject)) {
                            $group_subject_val[] = $row;
                        }
                    }


                    $cgpa = sprintf('%0.2f', $total_cgpa / $total_subjects);

                    $cgpa = $cgpa>5? '5.00':$cgpa;


                @endphp

                {{-- @dd($group_subject_val); --}}

                    <tr>
                        <th scope="rowgroup" style="width:200px;padding:0px;">
                            <p>{{ $student[$i][0]->name }} <br>
                                Section : {{ $data['section_name'] }} <br>
                                Roll : {{ $student[$i][0]->stdRoll }} / {{ $data['result'][$i]->stdCode }}
                            </p>
                        </th>

                        <td style="padding: 0px;margin:0px;">

                                <div  style="border-bottom: 0.5px solid #727b83;height:30px;width:70px;text-align:center;" >Bangla</div>

                            <div style="text-align: center;padding-top:5px;">{{ $bangla_gpa }}</div>
                        </td>
                        <td style="padding: 0;margin:0">

                                <div style="border-bottom: 0.5px solid #727b83;height:30px;width:70px;text-align:center;" >English</div>

                            <div style="text-align: center;padding-top:5px;">{{ $english_gpa }}</div>
                        </td>
                        <td style="padding: 0;margin:0">

                                <div style="border-bottom: 0.5px solid #727b83;height:30px;width:70px;text-align:center;" >ICT</div>

                            <div style="text-align: center;padding-top:5px;">{{ $ict_gpa }}</div>
                        </td>

                        @foreach ($group_subject_val as $row)
                            <td style="padding: 0;margin:0">
                                <div style="border-bottom: 0.5px solid #727b83;height:30px;width:140px;text-align:center;" >
                                    {{ Str::limit($row->subject, 15) }}
                                </div>
                                <div style="text-align: center;padding-top:5px;">
                                    {{ $row->grade }}
                                </div>
                            </td>

                        @endforeach

                        @php
                            $optional_subject = DB::table('subjects')->where('id',$student[$i][0]->optional_subject)->first();
                        @endphp

                        <td style="padding: 0;margin:0">
                            <div style="border-bottom: 0.5px solid #727b83;height:30px;width:140px;text-align:center;" >
                                {{ Str::limit($optional_subject->name, 15) }}
                                </div>
                            <div style="text-align: center;padding-top:5px;">{{ $optional_subject_gpa }}</div>
                        </td>

                        <td style="text-align: center;">
                            @if ($data['result'][$i]->result == 'PASSED')
                                {{ $cgpa }}
                            @else
                                0.00
                            @endif
                        </td>

                    </tr>

                @endfor


            </tbody>



        </table>
        </div>

        <br/>
        <div>
            <p>
                <strong>N.B.:</strong> Subtracting 2(two) points from the optional subject's grade point(GP), the rest (if any) is added to the grade points of all other subjects and then GPA is determined by dividing the total grade points(GP) by the number of subjects excepting the optional one . The GPA is thus determined to a maximum of 5.00.
                <br>
                <p></p>
                <b>DATE OF PUBLICATION OF RESULT - {{ date('Y-m-d') }}</b>
                <div style="float:right;margin-right:60px;">
                    <img src="assets/images/pricipal_signature.png" alt="" height="30px;"  style="margin-left: 25px;padding:0;" >
                    <p style="margin-top:0px;">Principal's Signature</p>
                </div>
            </p>

        </div>

    </div>
@else
    <div class="row">
        <div class="col-md-12 text-center">
            <div id="not_found">
                {{-- <img src="{{asset('assets/images/empty_box.png')}}" width="200px"> --}}
            </div>
            <h2>No data found of this requirement</h2>
        </div>
    </div>
@endif
<style>

    @page { margin: 5px 5px 10px; }
    #footer {
        position: fixed;
        right: 0px;
        bottom: 0px;
        margin-bottom: -30px !important;
        padding: 0px !important;
        }
    #footer .page:after {
        content: counter(page);
    }

    .points {
        color: #0b2e13;
    }

    html{
        padding: 0;
        margin: 20px;
    }

    #header_details {
        width: 100%;
        display: block;
    }

    #header_details p {
        font-size: 13px;
    }

    #marks_table {
        position: relative;
        width: 100%;
        display: block;
        margin-top: 60px;
        font-size: 12px;
        border-collapse: none;
    }
    .grade-table {
        font-size: 8px;
        text-align: center;
        border-collapse: collapse;

    }

    .divTableHeading {
        background-color: #eee;
        display: table-header-group;
        font-weight: bold;
    }

    #col_1, #col_2, #col_3 {
        width: 33.3%;
        float: left;
        position: relative;
    }

    #manage_all_result td, th {
        text-align: center;
    }

    input {
        border: 1px solid #f6f6f6;
    }

    .heading p {
        text-align: center;
        font-size: 13px;
        margin-left: -80px;
    }

    .footer p {
        text-align: center;
        font-size: 13px;
    }

    table th, td {
        border: 1px solid #727b83;
        padding: 1px;
        overflow: hidden;
        line-height: 15px;
    }
 */

    .header_image img {
        float: left;
        margin-left: 280px;

    }

    .header_image h1 {
        position: relative;
        top: 18px;
        left: 10px;
    }


</style>

</body>
