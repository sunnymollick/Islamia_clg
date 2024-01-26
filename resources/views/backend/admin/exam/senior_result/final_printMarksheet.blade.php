<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body style="page-break-after: auto">
@if(!empty($data))
    <div class="" id="marksheet">
        <div id="header_details">
            <div class="header_image">
                <img style="border: none;" src="{{ asset('assets/images/port_school_logo.png') }}"
                class="img-responsive img-thumbnail"
                width="70px"/>

                <strong style="font-size:20px;">&nbsp;<br>&nbsp;{{ $app_settings ? $app_settings->name : '' }}</strong> <br>

                {{-- <strong style="padding-left:115px; padding-top:100px; font-size:16px;"> Exam : {{ $data['exam_name'] }} </strong> --}}
            </div>
            <div style="margin-left: 80px; margin-top: -5px; ">
                <p style="text-align: left">
                    <strong style="font-size:17px;"> Exam : Annual Exam </strong>
                </p>
            </div>
            <div id="col_1">
                <p style="text-align: left"><strong>Student Name : {{ $data['student_name'] }}</strong> <br/>
                    <strong>Class : </strong> {{ $data['class_name'] }} &nbsp;&nbsp; <strong>Section : </strong> {{ $data['section_name'] }}<br/>
                    <strong>Roll : </strong> {{ $data['std_roll'] }}
                </p>
            </div>
            <div id="col_2">
                <p style=" text-align: center">
                    &nbsp;
                </p>
            </div>
            <div id="col_3">
                <p style="text-align: right">
                    <strong>Student ID : </strong>{{ $data['student_code']}}<br/>
                    {{-- <strong> Session : </strong>{{ $data['year'] }} --}}
                </p>
            </div>
        </div>
        &nbsp;

        @php
            $total_marks = 0;
            $cgpa_status = 1;
            $total_gpa = 0;
            $total_cgpa = 0;
            $optional_sub_marks = 0;
            $total_subjects = 0;
            // -------------
            $half_yearly_bangla_marks = 0;
            $half_yearly_combined_bangla = 0;
            $half_yearly_combined_bangla_marks = 0;
            $half_yearly_bangla_both_theory = 0;
            $half_yearly_bangla_both_mcq = 0;

            $half_yearly_ban_cgpa = $half_yearly_ban_grade = 0;


            $final_yearly_bangla_marks = 0;
            $final_yearly_combined_bangla = 0;
            $final_yearly_combined_bangla_marks = 0;
            $final_yearly_bangla_both_theory = 0;
            $final_yearly_bangla_both_mcq = 0;

            $final_yearly_ban_cgpa = $final_yearly_ban_grade = 0;

            $avg_bangla_marks = 0;
            $avg_combined_bangla = 0;
            $avg_combined_bangla_marks = 0;
            $avg_bangla_both_theory = 0;
            $avg_bangla_both_mcq = 0;

            $avg_ban_cgpa = $avg_ban_grade = 0;
            // -------------------



            $half_yearly_eng_marks = 0;
            $half_yearly_combined_eng = 0;
            $half_yearly_combined_eng_marks = 0;

            $half_yearly_eng_cgpa = $half_yearly_eng_grade = 0;

            $final_yearly_eng_marks = 0;
            $final_yearly_combined_eng = 0;
            $final_yearly_combined_eng_marks = 0;

            $final_yearly_eng_cgpa = $final_yearly_eng_grade = 0;


            $avg_eng_marks = 0;
            $avg_combined_eng = 0;
            $avg_combined_eng_marks = 0;

            $avg_eng_cgpa = $avg_eng_grade = 0;


            $total_subjects = count($data['result']);

            foreach($data['result'] as $row) {

            $total_marks+= $row->avgMarks;

            if ($row->avgResultStatus === 'FAILED') {
                $cgpa_status = 0;
                }

                if ($cgpa_status != 0) {
                $total_cgpa = round($total_cgpa + $row->avgCGPA, 2);
                }

                // Bangla combined
                if ($row->code == 101 || $row->code == 102) {

                    $half_yearly_combined_bangla = $half_yearly_combined_bangla + 1;
                    $half_yearly_combined_bangla_marks = $half_yearly_combined_bangla_marks + $row->halfObtainedMarks;

                    $final_yearly_combined_bangla = $final_yearly_combined_bangla + 1;
                    $final_yearly_combined_bangla_marks = $final_yearly_combined_bangla_marks + $row->finalObtainedMarks;

                    $avg_combined_bangla = $avg_combined_bangla + 1;
                    $avg_combined_bangla_marks = $avg_combined_bangla_marks + $row->avgMarks;

                    $total_cgpa = $total_cgpa - $row->avgCGPA;

                    $half_yearly_bangla_both_theory = $half_yearly_bangla_both_theory + $row->halfTheoryPMarks;
                    $half_yearly_bangla_both_mcq = $half_yearly_bangla_both_mcq + $row->halfMcqPMarks;

                    $final_yearly_bangla_both_theory = $final_yearly_bangla_both_theory + $row->finalTheoryPMarks;
                    $final_yearly_bangla_both_mcq = $final_yearly_bangla_both_mcq + $row->finalMcqPMarks;

                    $avg_bangla_both_theory = $avg_bangla_both_theory + $row->avgTheoryPMarks;
                    $avg_bangla_both_mcq = $avg_bangla_both_mcq + $row->avgMcqPMarks;
                }


                // English combined
                if ($row->code == 107 || $row->code == 108) {
                    $half_yearly_combined_eng = $half_yearly_combined_eng + 1;
                    $half_yearly_combined_eng_marks = $half_yearly_combined_eng_marks + $row->halfObtainedMarks;

                    $final_yearly_combined_eng = $final_yearly_combined_eng + 1;
                    $final_yearly_combined_eng_marks = $final_yearly_combined_eng_marks + $row->finalObtainedMarks;

                    $avg_combined_eng = $avg_combined_eng + 1;
                    $avg_combined_eng_marks = $avg_combined_eng_marks + $row->avgMarks;


                    $total_cgpa = $total_cgpa - $row->avgCGPA;

                }


                // carrer and physical education combined
                if ($row->code == 156 || $row->code == 133) {
                    $total_subjects = $total_subjects -1; //  subject not count on average point so less
                    $total_cgpa = $total_cgpa - $row->avgCGPA;
                }

                // Optional subject calculation
                if ($row->subject_id == $row->optional_subject) {

                    $total_subjects = $total_subjects -1; // Optional subject not count on average point so less
                    $total_cgpa = $total_cgpa - $row->avgCGPA;

                    if ($row->avgCGPA > 2.00) {
                        $optional_sub_marks = $row->avgCGPA - 2.00;
                        $total_cgpa = $total_cgpa + $optional_sub_marks;
                    }
                }
            }

            if($half_yearly_combined_bangla == 2){


                $half_yearly_bangla_marks = round($half_yearly_combined_bangla_marks/2,2);


                if($half_yearly_combined_bangla_marks>=66 && $half_yearly_bangla_both_theory>=46 && $half_yearly_bangla_both_mcq>=20 ){

                    if($half_yearly_bangla_marks>=80){
                        $half_yearly_ban_cgpa = 5.00;
                        $half_yearly_ban_grade = 'A+';
                    }elseif($half_yearly_bangla_marks >= 70 and $half_yearly_bangla_marks <= 79){
                        $half_yearly_ban_cgpa = 4.00;
                        $half_yearly_ban_grade = 'A';
                    }elseif($half_yearly_bangla_marks >= 60 and $half_yearly_bangla_marks <= 69){
                        $half_yearly_ban_cgpa = 3.50;
                        $half_yearly_ban_grade = 'A-';
                    }elseif($half_yearly_bangla_marks >= 50 and $half_yearly_bangla_marks <= 59){
                        $half_yearly_ban_cgpa = 3.00;
                        $half_yearly_ban_grade = 'B';
                    }elseif($half_yearly_bangla_marks >= 40 and $half_yearly_bangla_marks <= 49){
                        $half_yearly_ban_cgpa = 2.00;
                        $half_yearly_ban_grade = 'C';
                    }elseif($half_yearly_bangla_marks >= 33 and $half_yearly_bangla_marks <= 39){
                        $half_yearly_ban_cgpa = 1.00;
                        $half_yearly_ban_grade = 'D';
                    }else{
                        $half_yearly_ban_cgpa = 3.50;
                        $half_yearly_ban_grade = 'A-';
                    }

                }else{
                    $half_yearly_ban_cgpa = 0.00;
                    $half_yearly_ban_grade = 'F';

                }
            }

            if($final_yearly_combined_bangla == 2){

                $final_yearly_bangla_marks = round($final_yearly_combined_bangla_marks/2,2);

                if($final_yearly_combined_bangla_marks>=66 && $final_yearly_bangla_both_theory>=46 && $final_yearly_bangla_both_mcq>=20 ){

                    if($final_yearly_bangla_marks>=80){
                        $final_yearly_ban_cgpa = 5.00;
                        $final_yearly_ban_grade = 'A+';
                    }elseif($final_yearly_bangla_marks >= 70 and $final_yearly_bangla_marks <= 79){
                        $final_yearly_ban_cgpa = 4.00;
                        $final_yearly_ban_grade = 'A';
                    }elseif($final_yearly_bangla_marks >= 60 and $final_yearly_bangla_marks <= 69){
                        $final_yearly_ban_cgpa = 3.50;
                        $final_yearly_ban_grade = 'A-';
                    }elseif($final_yearly_bangla_marks >= 50 and $final_yearly_bangla_marks <= 59){
                        $final_yearly_ban_cgpa = 3.00;
                        $final_yearly_ban_grade = 'B';
                    }elseif($final_yearly_bangla_marks >= 40 and $final_yearly_bangla_marks <= 49){
                        $final_yearly_ban_cgpa = 2.00;
                        $final_yearly_ban_grade = 'C';
                    }elseif($final_yearly_bangla_marks >= 33 and $final_yearly_bangla_marks <= 39){
                        $final_yearly_ban_cgpa = 1.00;
                        $final_yearly_ban_grade = 'D';
                    }else{
                        $final_yearly_ban_cgpa = 3.50;
                        $final_yearly_ban_grade = 'A-';
                    }

                }else{
                    $final_yearly_ban_cgpa = 0.00;
                    $final_yearly_ban_grade = 'F';

                }

            }

            if($avg_combined_bangla == 2){
                $total_subjects = $total_subjects -1; // both are now 1 subject so 1 minus from total subject

                $avg_bangla_marks = round($avg_combined_bangla_marks/2,2);

                if($avg_combined_bangla_marks>=66 && $avg_bangla_both_theory>=46 && $avg_bangla_both_mcq>=20 ){

                    if($avg_bangla_marks>=80){
                        $avg_ban_cgpa = 5.00;
                        $avg_ban_grade = 'A+';
                        $total_cgpa = $total_cgpa + $avg_ban_cgpa;
                    }elseif($avg_bangla_marks >= 70 and $avg_bangla_marks <= 79){
                        $avg_ban_cgpa = 4.00;
                        $avg_ban_grade = 'A';
                        $total_cgpa = $total_cgpa + $avg_ban_cgpa;
                    }elseif($avg_bangla_marks >= 60 and $avg_bangla_marks <= 69){
                        $avg_ban_cgpa = 3.50;
                        $avg_ban_grade = 'A-';
                        $total_cgpa = $total_cgpa + $avg_ban_cgpa;
                    }elseif($avg_bangla_marks >= 50 and $avg_bangla_marks <= 59){
                        $avg_ban_cgpa = 3.00;
                        $avg_ban_grade = 'B';
                        $total_cgpa = $total_cgpa + $avg_ban_cgpa;
                    }elseif($avg_bangla_marks >= 40 and $avg_bangla_marks <= 49){
                        $avg_ban_cgpa = 2.00;
                        $avg_ban_grade = 'C';
                        $total_cgpa = $total_cgpa + $avg_ban_cgpa;
                    }elseif($avg_bangla_marks >= 33 and $avg_bangla_marks <= 39){
                        $avg_ban_cgpa = 1.00;
                        $avg_ban_grade = 'D';
                        $total_cgpa = $total_cgpa + $avg_ban_cgpa;
                    }else{
                        $avg_ban_cgpa = 3.50;
                        $avg_ban_grade = 'A-';
                        $total_cgpa = $total_cgpa + $avg_ban_cgpa;
                    }

                }else{
                    $avg_ban_cgpa = 0.00;
                    $avg_ban_grade = 'F';
                    $cgpa_status = 0;
                }
            }

            if($half_yearly_combined_eng == 2){

                $half_yearly_eng_marks = round($half_yearly_combined_eng_marks/2,2);

                if($half_yearly_combined_eng_marks>=66){

                    if($half_yearly_eng_marks>=80){
                        $half_yearly_eng_cgpa = 5.00;
                        $half_yearly_eng_grade = 'A+';
                    }elseif($half_yearly_eng_marks >= 70 and $half_yearly_eng_marks <= 79){
                        $half_yearly_eng_cgpa = 4.00;
                        $half_yearly_eng_grade = 'A';
                    }elseif($half_yearly_eng_marks >= 60 and $half_yearly_eng_marks <= 69){
                        $half_yearly_eng_cgpa = 3.50;
                        $half_yearly_eng_grade = 'A-';
                    }elseif($half_yearly_eng_marks >= 50 and $half_yearly_eng_marks <= 59){
                        $half_yearly_eng_cgpa = 3.00;
                        $half_yearly_eng_grade = 'B';
                    }elseif($half_yearly_eng_marks >= 40 and $half_yearly_eng_marks <= 49){
                        $half_yearly_eng_cgpa = 2.00;
                        $half_yearly_eng_grade = 'C';
                    }elseif($half_yearly_eng_marks >= 33 and $half_yearly_eng_marks <= 39){
                        $half_yearly_eng_cgpa = 1.00;
                        $half_yearly_eng_grade = 'D';
                    }else{
                        $half_yearly_eng_cgpa = 3.50;
                        $half_yearly_eng_grade = 'A-';
                    }

                }else{
                    $half_yearly_eng_cgpa = 0.00;
                    $half_yearly_eng_grade = 'F';
                }

            }

            if($final_yearly_combined_eng == 2){

                $final_yearly_eng_marks = round($final_yearly_combined_eng_marks/2,2);

                if($final_yearly_combined_eng_marks>=66){

                    if($final_yearly_eng_marks>=80){
                        $final_yearly_eng_cgpa = 5.00;
                        $final_yearly_eng_grade = 'A+';
                    }elseif($final_yearly_eng_marks >= 70 and $final_yearly_eng_marks <= 79){
                        $final_yearly_eng_cgpa = 4.00;
                        $final_yearly_eng_grade = 'A';
                    }elseif($final_yearly_eng_marks >= 60 and $final_yearly_eng_marks <= 69){
                        $final_yearly_eng_cgpa = 3.50;
                        $final_yearly_eng_grade = 'A-';
                    }elseif($final_yearly_eng_marks >= 50 and $final_yearly_eng_marks <= 59){
                        $final_yearly_eng_cgpa = 3.00;
                        $final_yearly_eng_grade = 'B';
                    }elseif($final_yearly_eng_marks >= 40 and $final_yearly_eng_marks <= 49){
                        $final_yearly_eng_cgpa = 2.00;
                        $final_yearly_eng_grade = 'C';
                    }elseif($final_yearly_eng_marks >= 33 and $final_yearly_eng_marks <= 39){
                        $final_yearly_eng_cgpa = 1.00;
                        $final_yearly_eng_grade = 'D';
                    }else{
                        $final_yearly_eng_cgpa = 3.50;
                        $final_yearly_eng_grade = 'A-';
                    }

                }else{
                    $final_yearly_eng_cgpa = 0.00;
                    $final_yearly_eng_grade = 'F';
                }
            }

            if($avg_combined_eng == 2){
                $total_subjects = $total_subjects -1; // both are now 1 subject so 1 minus from total subject


                $avg_eng_marks = round($avg_combined_eng_marks/2,2);

                if($avg_combined_eng_marks>=66){

                    if($avg_eng_marks>=80){
                        $avg_eng_cgpa = 5.00;
                        $avg_eng_grade = 'A+';
                        $total_cgpa = $total_cgpa + $avg_eng_cgpa;
                    }elseif($avg_eng_marks >= 70 and $avg_eng_marks <= 79){
                        $avg_eng_cgpa = 4.00;
                        $avg_eng_grade = 'A';
                        $total_cgpa = $total_cgpa + $avg_eng_cgpa;
                    }elseif($avg_eng_marks >= 60 and $avg_eng_marks <= 69){
                        $avg_eng_cgpa = 3.50;
                        $avg_eng_grade = 'A-';
                        $total_cgpa = $total_cgpa + $avg_eng_cgpa;
                    }elseif($avg_eng_marks >= 50 and $avg_eng_marks <= 59){
                        $avg_eng_cgpa = 3.00;
                        $avg_eng_grade = 'B';
                        $total_cgpa = $total_cgpa + $avg_eng_cgpa;
                    }elseif($avg_eng_marks >= 40 and $avg_eng_marks <= 49){
                        $avg_eng_cgpa = 2.00;
                        $avg_eng_grade = 'C';
                        $total_cgpa = $total_cgpa + $avg_eng_cgpa;
                    }elseif($avg_eng_marks >= 33 and $avg_eng_marks <= 39){
                        $avg_eng_cgpa = 1.00;
                        $avg_eng_grade = 'D';
                        $total_cgpa = $total_cgpa + $avg_eng_cgpa;
                    }else{
                        $avg_eng_cgpa = 3.50;
                        $avg_eng_grade = 'A-';
                        $total_cgpa = $total_cgpa + $avg_eng_cgpa;
                    }

                }else{
                    $avg_eng_cgpa = 0.00;
                    $avg_eng_grade = 'F';
                    $cgpa_status = 0;
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


        <div id="marks_table">
            <table id="table_1">
                <thead class="divTableHeading">
                <tr>
                    <th rowspan="2"> Subject</th>
                    <th rowspan="2"> Subject Marks</th>
                    <th colspan="5"> {{ $data['exam_name_half'] }}</th>
                    <th colspan="5"> {{ $data['exam_name_final'] }}</th>
                    <th rowspan="2"> Avg. Marks</th>
                    <th rowspan="2"> Avg. Grade</th>
                    <th rowspan="2"> Avg. GPA</th>
                </tr>
                <tr>
                    <th> CA</th>
                    <th> Creative</th>
                    <th> Total</th>
                    <th> Grade</th>
                    <th> GP</th>

                    <th> CA</th>
                    <th> Creative</th>
                    <th> Total</th>
                    <th> Grade </th>
                    <th> GP</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['result'] as $row)
                    <tr>
                        <td class="sub_name">{{ $row->subject_name }} {{$row->subject_id == $row->optional_subject ? ' ( Optional Subject ) ' : '' }}</td>
                        <td>{{ $row->marks}}</td>

                        <td>{{ $row->halfCTPmarks}}</td>
                        <td>{{ $row->halfTheoryPMarks }}</td>
                        <td>{{ $row->halfObtainedMarks }}</td>
                        {{-- <td>{{ $row->halfGrade }}</td>
                        <td>{{ $row->halfCGPA }}</td> --}}

                        @if($row->code == 101)
                            <td rowspan="2" style="vertical-align : middle;">{{ number_format($half_yearly_ban_cgpa,2) }}</td>
                            <td rowspan="2" style="vertical-align : middle;">{{ $half_yearly_ban_grade }}</td>
                        @elseif($row->code == 107 )
                            <td rowspan="2" style="vertical-align : middle;">{{ number_format($half_yearly_eng_cgpa,2) }}</td>
                            <td rowspan="2" style="vertical-align : middle;">{{ $half_yearly_eng_grade }}</td>
                        @elseif($row->code == 102 || $row->code == 108 )

                        @else
                            <td>{{ $row->halfCGPA }}</td>
                            <td>{{ $row->halfGrade }}</td>
                        @endif

                        <td>{{ $row->finalCTPmarks}}</td>
                        <td>{{ $row->finalTheoryPMarks }}</td>
                        <td>{{ $row->finalObtainedMarks }}</td>
                        {{-- <td>{{ $row->finalGrade }}</td>
                        <td>{{ $row->finalCGPA }}</td> --}}

                        @if($row->code == 101)
                            <td rowspan="2" style="vertical-align : middle;">{{ number_format($final_yearly_ban_cgpa,2) }}</td>
                            <td rowspan="2" style="vertical-align : middle;">{{ $final_yearly_ban_grade }}</td>
                        @elseif($row->code == 107 )
                            <td rowspan="2" style="vertical-align : middle;">{{ number_format($final_yearly_eng_cgpa,2) }}</td>
                            <td rowspan="2" style="vertical-align : middle;">{{ $final_yearly_eng_grade }}</td>
                        @elseif($row->code == 102 || $row->code == 108 )

                        @else
                            <td>{{ $row->finalCGPA }}</td>
                            <td>{{ $row->finalGrade }}</td>
                        @endif


                        <td>{{ $row->avgMarks }}</td>
                        {{-- <td>{{ $row->avgGrade }}</td>
                        <td>{{ $row->avgCGPA }}</td> --}}

                        @if($row->code == 101)
                            <td rowspan="2" style="vertical-align : middle;">{{ number_format($avg_ban_cgpa,2) }}</td>
                            <td rowspan="2" style="vertical-align : middle;">{{ $avg_ban_grade }}</td>
                        @elseif($row->code == 107 )
                            <td rowspan="2" style="vertical-align : middle;">{{ number_format($avg_eng_cgpa,2) }}</td>
                            <td rowspan="2" style="vertical-align : middle;">{{ $avg_eng_grade }}</td>
                        @elseif($row->code == 102 || $row->code == 108 )

                        @else
                            <td>{{ $row->avgCGPA }}</td>
                            <td>{{ $row->avgGrade }}</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
                <tfoot style="display: none">
                <tr>
                    <td>Total Marks</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tfoot>
            </table>
        </div>
        <br/>
        <div id="sum_1">
            <table id="table_2">
                <tbody>
                <tr>
                    <td width="120px;">Total Marks</td>
                    <td width="10px;">:</td>
                    <td width="80px;">{!! $total_numbers !!} </td>
                    <td width="300px;" rowspan="9">Comments :</td>
                </tr>
                <tr>
                    <td>GPA</td>
                    <td>:</td>
                    <td>{!! $cgpa !!}</td>
                </tr>
                <tr>
                    <td>Grade</td>
                    <td>:</td>
                    <td>{!! $gpa !!}</td>
                </tr>
                <tr>
                    <td>Total Students</td>
                    <td>:</td>
                    <td>{{$data['total_std']}}</td>
                </tr>
                <tr>
                    <td>Total Working Days</td>
                    <td>:</td>
                    <td>{{$data['total_wd']}}</td>
                </tr>
                <tr>
                    <td>Total Attendance</td>
                    <td>:</td>
                    <td>{{$data['total_atd']}}</td>
                </tr>
                <tr>
                    <td>Parent's Signature</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Teacher's Signature</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Head Teacher's Signature</td>
                    <td>:</td>
                    <td>
                        <img style="border: none;" src="{{ asset('assets/images/head_master.png') }}"
                             class="img-responsive img-thumbnail"
                             width="50px"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div id="sum_2">
            <table id="table_3">
                <thead class="divTableHeading">
                <tr>
                    <th> Score</th>
                    <th> Grade</th>
                    <th> CGPA</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>80-100</td>
                    <td>A+</td>
                    <td>5.00</td>
                </tr>
                <tr>
                    <td>70-79</td>
                    <td>A</td>
                    <td>4.00</td>
                </tr>
                <tr>
                    <td>60-69</td>
                    <td>A-</td>
                    <td>3.50</td>
                </tr>
                <tr>
                    <td>50-59</td>
                    <td>B</td>
                    <td>3.00</td>
                </tr>
                <tr>
                    <td>40-49</td>
                    <td>C</td>
                    <td>2.00</td>
                </tr>
                <tr>
                    <td>33-39</td>
                    <td>D</td>
                    <td>1.00</td>
                </tr>
                <tr>
                    <td>0-32</td>
                    <td>F</td>
                    <td>0.00</td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
@else
    <div class="row">
        <div class="col-md-12 text-center">
            <div id="not_found">
                <img src="{{asset('assets/images/empty_box.png')}}" width="200px">
            </div>
            <h2>No data found of this requirement</h2>
        </div>
    </div>
@endif
<style>

    .points {
        color: #0b2e13;
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
        margin-top: 100px;
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
        border-collapse: collapse;
        font-size: 12px;
        padding: 1px;
        overflow: hidden;
        line-height: 20px;
    }

    #table_1 {
        text-align: center;
        border: 1px solid #727b83;
        border-collapse: collapse;
        width: 100%;
        line-height: 20px;
    }

    #table_2 {
        border-collapse: collapse;
        width: 68%;
        float: left;
        text-align: left;
        line-height: 20px;
    }

    #table_3 {
        width: 30%;
        float: right;
        line-height: 20px;
        text-align: center;
    }

    #table_2 td:nth-child(1) {
        text-align: right;
    }

    #table_1 td:nth-child(1) {
        font-weight: bold;
    }

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
