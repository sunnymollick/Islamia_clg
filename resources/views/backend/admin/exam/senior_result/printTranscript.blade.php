<!DOCTYPE html><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>

        table,th,td{
            border-collapse: collapse;
            border: 1px solid black;
            text-align: center;
            padding: 8px;
            font-size: 12px;

        }
        .grade-table td {
            padding:0;
            margin:0;
            font-size: 10;
        }

        table {
            width: 100%;
        }

        .header{
            border:1px solid white;
        }

        .container{
            border: 5px groove black;
            padding: 15px;
            padding-bottom: 15px;
            height: 95%;
            margin: 0;
        }

        html{
            padding: 10;
            margin: 10;
        }

        tbody{
            height: 100px;
        }

        #transcript_table th, td{
            height: 30px;
        }



    </style>
</head>
<body>
    <div class="container">
        <div class="header">
        <div style="width:5%;float: left;">
            <img src="assets/images/islamia_clg.jpg" alt="" height="90px" width="90px">
        </div>

        <div style="width:22%; float:right;margin-top:15px;">
            <table class="grade-table">
                <caption>Grade Tables</caption>
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
        <div style="text-align: center; margin-top:10px; margin-left:100px;">
            <h4 style="text-transform: uppercase; text-align:center">
                {{  $app_settings ? Str::upper($app_settings->name) : '' }}
            </h4>
            <h4 style="text-align:center;"> {{ Str::upper($data['exam_name']) }} </h4>

            <h5 style="color:green;"><u>ACADEMIC TRANSCRIPT</u></h5>
        </div>

    </div>
    <div class="hero">
        <div style="float:left; width:600px; margin-left:10px;">
            <h5>
                <strong>Name Of Student  : <i>{{ $data['student_name'] }}</i> </strong>
            </h5>
            <h5>
                <strong>Father's Name  : <i>{{ $data['result'][0]->fathers_name }}</i> </strong>
            </h5>
            <h5>
                <strong>Mother's Name  : <i>{{ $data['result'][0]->mothers_name }}</i> </strong>
            </h5>
            <h5>
                <strong>Name Of Institude :
                    <i>
                        {{  $app_settings ? $app_settings->name : 'Islamia College Chattogram' }}
                    </i>
                </strong>
            </h5>
            <h5>
                <strong>Roll : <i>{{ $data['std_roll'] }}</i> </strong>
            </h5>
            <h5>
                <strong>Class : <i>{{ $data['class_name'] }}</i> </strong>
            </h5>
            <h5>
                <strong>Shift : <i>{{ explode('-', trim($data['section_name']))[0]  }}</i> </strong>
            </h5>
        </div>

        <div class="hero" style="float:right; width: 300px;margin-top:100px; margin-right:-300px;">
            <p></p>
            <p></p>
            <br>
            <h5>
                <strong>Session : <i>{{ $data['year'] }}</i> </strong>
            </h5>
            <h5>
                <strong>Student's ID : <i>{{ $data['student_code'] }}</i> </strong>
            </h5>
        </div>
    </div>

    @php
            $total_marks = 0;
            $cgpa_status = 1;
            $total_gpa = 0;
            $total_cgpa = 0;
            $optional_sub_marks = 0;
            $total_subjects = 0;

            $bangla_marks = 0;
            $combined_bangla = 0;
            $combined_bangla_marks = 0;
            $bangla_both_theory = 0;
            $bangla_both_mcq = 0;

            $ban_cgpa = $ban_grade = 0;

            $eng_marks = 0;
            $combined_eng = 0;
            $combined_eng_marks = 0;

            $eng_cgpa = $eng_grade = 0;


            $total_subjects = count($data['result']);

            foreach($data['result'] as $row) {

            $total_marks+= $row->obtainedMark;

            if ($row->result_status === 'FAILED') {
                $cgpa_status = 0;
                }

                if ($cgpa_status != 0) {
                $total_cgpa = round($total_cgpa + $row->CGPA, 2);
                }




                // carrer and physical education combined
                if ($row->code == 156 || $row->code == 133) {
                    $total_subjects = $total_subjects -1; //  subject not count on average point so less
                    $total_cgpa = $total_cgpa - $row->CGPA;
                }

                // Optional subject calculation
                if ($row->subject_id == $row->optional_subject) {

                    $total_subjects = $total_subjects -1; // Optional subject not count on average point so less
                    $total_cgpa = $total_cgpa - $row->CGPA;

                    if ($row->CGPA > 2.00) {
                        $optional_sub_marks = $row->CGPA - 2.00;
                        $total_cgpa = $total_cgpa + $optional_sub_marks;
                    }
                }
            }



            $cgpa = sprintf('%0.2f', $total_cgpa / $total_subjects);

            $cgpa = $cgpa>5? '5.00':$cgpa;

            if ($cgpa_status != 0) {

                if ($cgpa >= 5) {
                    $gpa = "A+";
                } else if ($cgpa >= 4 and $cgpa <= 4.99) {
                    $gpa = "A";
                } else if ($cgpa >= 3.50 and $cgpa <= 3.99) {
                    $gpa = "A-";
                } else if ($cgpa >= 3 and $cgpa <= 3.49) {
                    $gpa = "B";
                } else if ($cgpa >= 2 and $cgpa <= 2.99) {
                    $gpa = "C";
                } else if ($cgpa >= 1 and $cgpa <= 1.99) {
                    $gpa = "D";
                } else {
                    $gpa = "<strong style='color: #e66f57'> Failed </strong>";
                }
            } else {
                $gpa = "<strong style='color: #e66f57'> Failed </strong>";
            }
            $total_numbers = "<strong style='color: #67bf7e'>" . $total_marks . "</strong>";
            $cgpa = $cgpa_status == '1' ? "<strong style='color: #67bf7e'>" . $cgpa . "</strong>" : "<strong style='color: #e66f57'> Failed </strong>";

        @endphp

    <div class="body" style="margin-top: 300px;">
        <table class="table" id="transcript_table">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Name Of Subjects</th>
                    <th>Letter Grade</th>
                    <th>Grade Point</th>
                    <th>GPA</th>
                    <th>GRADE</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $j=1;
                @endphp
                @for ($i=0; $i < count($data['result']); $i++)
                    @if ($data['result'][$i]->subject_id != $data['result'][$i]->optional_subject)
                                <tr>
                                    <td>{{ $j++ }}</td>
                                    <td class="sub_name">{{ $data['result'][$i]->subject }}</td>
                                    <td>{{ $data['result'][$i]->CGPA }}</td>
                                    <td>{{ $data['result'][$i]->grade }}</td>
                                    @if ($i == 0)
                                        <td rowspan="6">{!! $cgpa !!}</td>
                                    @else

                                    @endif

                                    @if ($i == 0)
                                        <td rowspan="8">{!! $gpa !!}</td>
                                    @else

                                    @endif

                                </tr>
                        @endif
                @endfor
                    <tr>
                        <td colspan="5" style="text-align: justify">Additional Subject : </td>
                    </tr>
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $optional_subject->subject }}</td>
                        <td>{{ $optional_subject->grade }}</td>
                        <td>{{ $optional_subject->CGPA }}</td>
                        <td style="padding: 0px;margin:0px;">
                            <div style="border-bottom: 1px solid black; width:100%;padding:0px;margin:0px;">GPA Above 2</div>
                            <div>{{ $optional_subject->CGPA - 2 }}</div>
                        </td>
                    </tr>
            </tbody>

        </table>
    </div>
    <div class="footer">
        <div style="margin-top: 60px;float: right;margin-right:0px;">
            <div style="width:45%;">
                <div style="float:left;">
                    <img src="assets/images/pricipal_signature.png" alt="" height="30px;"  style="margin-left: 25px;padding:0;" >
                    <p style="margin-top:0px;">Principal's Signature</p>
                </div>
            </div>
        </div>
        <div style="width:45%;margin-top: 59px;margin-left:10px;float: left;">
            <div style="">
                <p></p>
                <div style="width:250px; float:left;"> Date Of Publication Of Result :
            </div>
        </div>
    </div>
</div>
</body>
</html>
