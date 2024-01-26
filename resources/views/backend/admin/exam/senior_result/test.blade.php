
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

    </style>
</head>
<body>
    <div class="header">
        <div style="width:20%;float: left;">
            {{-- <img src="assets/images/islamia_clg.jpg" alt=""> --}}
        </div>

        <div style="width:20%; float:right;">
            <table class="grade-table">
                <caption>Grade Tables</caption>
                <tr><td>90-100</td><td>A+</td></tr>
                <tr><td>85-89</td><td>A</td></tr>
                <tr><td>80-84</td><td>A-</td></tr>
                <tr><td>75-79</td><td>B+</td></tr>
                <tr><td>70-74</td><td>B</td></tr>
                <tr><td>65-69</td><td>B-</td></tr>
                <tr><td>60-64</td><td>C+</td></tr>
                <tr><td>55-59</td><td>C</td></tr>
                <tr><td>50-54</td><td>C-</td></tr>
            </table>
        </div>
        <div style="text-align: center; margin-top:10px; margin-left:100px;">
            <h3 style="text-transform: uppercase; text-align:center">
                {{  $app_settings ? Str::upper($app_settings->name) : '' }}
            </h3>
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
                <strong>Name Of Institude : <i>Islamia Degree College Chittagong</i> </strong>
            </h5>
        </div>

        <div class="hero" style="float:right; width: 300px;margin-right:-300px;">
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

    <div class="body" style="margin-top: 200px;">
        <table class="table">
            <tr>
                <th>Sl No</th>
                <th>Name Of Subjects</th>
                <th>Letter Grade</th>
                <th>Grade Point</th>
                <th>GPA</th>
                <th>GRADE</th>
            </tr>

            <tr>
                <td>1.</td>
                <td>{{ $data['result'][0]->subject }}</td>
                <td>{{ $data['result'][0]->grade }}</td>
                <td>{{ $data['result'][0]->CGPA }}</td>
                <td rowspan="7">{!! $cgpa !!}</td>
                <td rowspan="7">{!! $gpa !!}</td>
            </tr>
            <tr>
                <td>2.</td>
                <td>{{ $data['result'][1]->subject }}</td>
                <td>{{ $data['result'][1]->grade }}</td>
                <td>{{ $data['result'][1]->CGPA }}</td>
            </tr>
            <tr>
                <td>3.</td>
                <td>{{ $data['result'][2]->subject }}</td>
                <td>{{ $data['result'][2]->grade }}</td>
                <td>{{ $data['result'][2]->CGPA }}</td>
            </tr>
            <tr>
                <td>4.</td>
                <td>{{ $data['result'][3]->subject }}</td>
                <td>{{ $data['result'][3]->grade }}</td>
                <td>{{ $data['result'][3]->CGPA }}</td>
            </tr>
            <tr>
                <td>5.</td>
                <td>{{ $data['result'][4]->subject }}</td>
                <td>{{ $data['result'][4]->grade }}</td>
                <td>{{ $data['result'][4]->CGPA }}</td>
            </tr>
            <tr>
                <td>6.</td>
                <td>{{ $data['result'][5]->subject }}</td>
                <td>{{ $data['result'][5]->grade }}</td>
                <td>{{ $data['result'][5]->CGPA }}</td>
            </tr>
            <tr>
                <td>7.</td>
                <td>{{ $data['result'][6]->subject }}</td>
                <td>{{ $data['result'][6]->grade }}</td>
                <td>{{ $data['result'][6]->CGPA }}</td>
            </tr>

        </table>
    </div>
    <div class="footer">
        <div style="margin-top: 60px;margin-left:10px;">
            <div style="width:75%;">
                <div style="width:250px; float:left;">Principal's Signature <span>______________</span> </div>
            </div>
        </div>
    </div>
</body>
