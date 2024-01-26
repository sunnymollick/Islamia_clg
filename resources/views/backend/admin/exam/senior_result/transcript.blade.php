@if(!empty($data))
    <div class="" id="marksheet">
        <div class="row" id="header_details">

            {{-- <div class="col-md-3 col-sm-12 pull-left">
                <img style="border: none;margin-left:50px;" src="{{ asset('assets/images/islamia_clg.jpg') }}" class="img-responsive img-thumbnail"
                width="120px" height="100px"/>
            </div> --}}
            <div class="col-md-12 col-sm-12 text-center" >
                <img src="{{ asset($app_settings->logo) }}" alt="" height="100px">
                <h3>
                    <strong style="text-align: center;">
                        {{ Str::upper($data['exam_name']) }} </strong>
                    <p></p>
                    <h6 style="text-decoration:underline; " class="text-success">ACADEMIC TRANSCRIPT</h6>
                </h3>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="col-md-8 col-sm-12 pull-left" style="margin-top:20px;margin-left:20px;">
                    <h6>
                        <strong>Name Of Student  : <i>{{ $data['student_name'] }}</i> </strong>
                    </h6>
                    <p></p>
                    <h6>
                        <strong>Father's Name  : <i>{{ $data['result'][0]->fathers_name }}</i> </strong>
                    </h6>
                    <p></p>
                    <h6>
                        <strong>Mother's Name  : <i>{{ $data['result'][0]->mothers_name }}</i> </strong>
                    </h6>
                    <p></p>
                    <h6>
                        <strong>Name Of Institude : <i>Islamia College Chattogram</i> </strong>
                    </h6>
                    <p></p>
                    <h6>
                        <strong>Class: <i>{{ $data['class_name'] }}</i> </strong>
                    </h6>
                    <p></p>
                    <h6>
                        <strong>Section: <i>{{ $data['section_name'] }}</i> </strong>
                    </h6>
                    <p></p>
                    <h6>
                        <strong>Roll : <i>{{ $data['std_roll'] }}</i> </strong>
                    </h6>
                    <p></p>
                    <h6>
                        <strong>Student's ID : <i>{{ $data['student_code'] }}</i> </strong>
                    </h6>
                    <p></p>
                    <h6>
                        <strong>Session : <i>{{ $data['year'] }}</i> </strong>
                    </h6>

                </div>
                <div  class="col-md-3 col-sm-12 pull-right" style="margin-top:-300px;   ">
                <table id="marks_inf" class="table table-bordered" >
                    <thead>
                    <tr>
                        <th> Class Interval</th>
                        <th>Letter Grade</th>
                        <th> Grade Point</th>
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

                // Bangla combined
                if ($row->code == 101 || $row->code == 102) {
                    $combined_bangla = $combined_bangla + 1;
                    $combined_bangla_marks = $combined_bangla_marks + $row->obtainedMark;
                    $total_cgpa = $total_cgpa - $row->CGPA;
                    $bangla_both_theory = $bangla_both_theory + $row->theoryPMarks;
                    $bangla_both_mcq = $bangla_both_mcq + $row->mcq_marks;
                }


                // English combined
                if ($row->code == 107 || $row->code == 108) {
                    $combined_eng = $combined_eng + 1;
                    $combined_eng_marks = $combined_eng_marks + $row->obtainedMark;
                    $total_cgpa = $total_cgpa - $row->CGPA;
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

            //dd($combined_bangla_marks);

            // if($combined_bangla == 2){
            //         $total_subjects = $total_subjects -1; // both are now 1 subject so 1 minus from total subject
            //         $bangla_marks = round($combined_bangla_marks/2,2);

            //         // need total 66 to pass the subject
            //         if($combined_bangla_marks>=66 && $bangla_both_theory>=46 && $bangla_both_mcq>=20 ){

            //         if($bangla_marks>=80){
            //             $ban_cgpa = 5.00;
            //             $ban_grade = 'A+';
            //             $total_cgpa = $total_cgpa + $ban_cgpa;
            //         }elseif($bangla_marks >= 70 and $bangla_marks <= 79){
            //             $ban_cgpa = 4.00;
            //             $ban_grade = 'A';
            //             $total_cgpa = $total_cgpa + $ban_cgpa;
            //         }elseif($bangla_marks >= 60 and $bangla_marks <= 69){
            //             $ban_cgpa = 3.50;
            //             $ban_grade = 'A-';
            //             $total_cgpa = $total_cgpa + $ban_cgpa;
            //         }elseif($bangla_marks >= 50 and $bangla_marks <= 59){
            //             $ban_cgpa = 3.00;
            //             $ban_grade = 'B';
            //             $total_cgpa = $total_cgpa + $ban_cgpa;
            //         }elseif($bangla_marks >= 40 and $bangla_marks <= 49){
            //             $ban_cgpa = 2.00;
            //             $ban_grade = 'C';
            //             $total_cgpa = $total_cgpa + $ban_cgpa;
            //         }elseif($bangla_marks >= 33 and $bangla_marks <= 39){
            //             $ban_cgpa = 1.00;
            //             $ban_grade = 'D';
            //             $total_cgpa = $total_cgpa + $ban_cgpa;
            //         }else{
            //             $ban_cgpa = 3.50;
            //             $ban_grade = 'A-';
            //             $total_cgpa = $total_cgpa + $ban_cgpa;
            //         }

            //         }else{
            //             $ban_cgpa = 0.00;
            //             $ban_grade = 'F';
            //             $cgpa_status = 0;
            //         }
            // }


            // if($combined_eng == 2){
            //         $total_subjects = $total_subjects -1; // both are now 1 subject so 1 minus from total subject
            //         $eng_marks = round($combined_eng_marks/2,2);

            //         if($combined_eng_marks>=66){

            //         if($eng_marks>=80){
            //             $eng_cgpa = 5.00;
            //             $eng_grade = 'A+';
            //             $total_cgpa = $total_cgpa + $eng_cgpa;
            //         }elseif($eng_marks >= 70 and $eng_marks <= 79){
            //             $eng_cgpa = 4.00;
            //             $eng_grade = 'A';
            //             $total_cgpa = $total_cgpa + $eng_cgpa;
            //         }elseif($eng_marks >= 60 and $eng_marks <= 69){
            //             $eng_cgpa = 3.50;
            //             $eng_grade = 'A-';
            //             $total_cgpa = $total_cgpa + $eng_cgpa;
            //         }elseif($eng_marks >= 50 and $eng_marks <= 59){
            //             $eng_cgpa = 3.00;
            //             $eng_grade = 'B';
            //             $total_cgpa = $total_cgpa + $eng_cgpa;
            //         }elseif($eng_marks >= 40 and $eng_marks <= 49){
            //             $eng_cgpa = 2.00;
            //             $eng_grade = 'C';
            //             $total_cgpa = $total_cgpa + $eng_cgpa;
            //         }elseif($eng_marks >= 33 and $eng_marks <= 39){
            //             $eng_cgpa = 1.00;
            //             $eng_grade = 'D';
            //             $total_cgpa = $total_cgpa + $eng_cgpa;
            //         }else{
            //             $eng_cgpa = 3.50;
            //             $eng_grade = 'A-';
            //             $total_cgpa = $total_cgpa + $eng_cgpa;
            //         }

            //         }else{
            //             $eng_cgpa = 0.00;
            //             $eng_grade = 'F';
            //             $cgpa_status = 0;
            //         }
            // }


            if($combined_bangla_marks>=80){
                $ban_cgpa = 5.00;
                $ban_grade = 'A+';
                $total_cgpa = $total_cgpa + $ban_cgpa;
            }elseif($combined_bangla_marks >= 70 and $combined_bangla_marks <= 79){
                $ban_cgpa = 4.00;
                $ban_grade = 'A';
                $total_cgpa = $total_cgpa + $ban_cgpa;
            }elseif($combined_bangla_marks >= 60 and $combined_bangla_marks <= 69){
                $ban_cgpa = 3.50;
                $ban_grade = 'A-';
                $total_cgpa = $total_cgpa + $ban_cgpa;
            }elseif($combined_bangla_marks >= 50 and $combined_bangla_marks <= 59){
                $ban_cgpa = 3.00;
                $ban_grade = 'B';
                $total_cgpa = $total_cgpa + $ban_cgpa;
            }elseif($combined_bangla_marks >= 40 and $combined_bangla_marks <= 49){
                $ban_cgpa = 2.00;
                $ban_grade = 'C';
                $total_cgpa = $total_cgpa + $ban_cgpa;
            }elseif($combined_bangla_marks >= 33 and $combined_bangla_marks <= 39){
                $ban_cgpa = 1.00;
                $ban_grade = 'D';
                $total_cgpa = $total_cgpa + $ban_cgpa;
            }else{
                $ban_cgpa = 3.50;
                $ban_grade = 'A-';
                $total_cgpa = $total_cgpa + $ban_cgpa;
            }

            // dd($combined_eng_marks);


            if($combined_eng_marks>=80){
                $eng_cgpa = 5.00;
                $eng_grade = 'A+';
                $total_cgpa = $total_cgpa + $eng_cgpa;
            }elseif($combined_eng_marks >= 70 and $combined_eng_marks <= 79){
                $eng_cgpa = 4.00;
                $eng_grade = 'A';
                $total_cgpa = $total_cgpa + $eng_cgpa;
            }elseif($combined_eng_marks >= 60 and $combined_eng_marks <= 69){
                $eng_cgpa = 3.50;
                $eng_grade = 'A-';
                $total_cgpa = $total_cgpa + $eng_cgpa;
            }elseif($combined_eng_marks >= 50 and $combined_eng_marks <= 59){
                $eng_cgpa = 3.00;
                $eng_grade = 'B';
                $total_cgpa = $total_cgpa + $eng_cgpa;
            }elseif($combined_eng_marks >= 40 and $combined_eng_marks <= 49){
                $eng_cgpa = 2.00;
                $eng_grade = 'C';
                $total_cgpa = $total_cgpa + $eng_cgpa;
            }elseif($combined_eng_marks >= 33 and $combined_eng_marks <= 39){
                $eng_cgpa = 1.00;
                $eng_grade = 'D';
                $total_cgpa = $total_cgpa + $eng_cgpa;
            }else{
                $eng_cgpa = 3.50;
                $eng_grade = 'A-';
                $total_cgpa = $total_cgpa + $eng_cgpa;
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


        <div class="row">
            <div class="col-md-12 col-sm-12 table-responsive">
                <table id="manage_all_result" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Serial</th>
                        <th style="text-align: left"> Subject</th>
                        <th> Grade Point</th>
                        <th> Letter Grade</th>
                        <th> GPA </th>
                        <th> Grade </th>
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
                        <td>{{ $optional_subject->CGPA }}</td>
                        <td>{{ $optional_subject->grade }}</td>
                        <td style="padding: 0px;margin:0px;">
                            <div style="border-bottom: 1px solid #e9ecef; width:100%;padding:0px;margin:0px;">GPA Above 2</div>
                            <div>{{ $optional_subject->CGPA - 2 }}</div>
                        </td>
                    </tr>
            </tbody>
                </table>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-4">
                <table>
                    <thead>
                        <th>Pricipal's Signature</th>

                    </thead>
                    <tbody>
                        <tr>
                        <td><img style="border: none;" height="80px" width="120px" src="{{ asset('assets/images/pricipal_signature.png') }}" class="img-responsive img-thumbnail" width="50px"/>
                        </td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <button type='button' id='btn' class='btn btn-success pull-right' value='Print'
                onClick='exportMarksheet();'>Print Transcript
        </button>
    </div>
    <div class="clearfix"></div>
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
    th {
        text-transform: uppercase;
    }

    #header_details p {
        font-size: 14px;
    }

    #manage_all_result td, th {
        text-align: center;
        font-size: 11px;
    }

    #manage_all_result td.sub_name {
        text-align: left;
    }

    #marks_inf td, th {
        text-align: center;
        font-size: 11px;
    }

    #std_inf td, th {
        font-size: 11px;
    }

    #std_inf td.sub_name {
        text-align: right;
    }

    input {
        border: 1px solid #f6f6f6;
    }

    @media screen and (min-width: 768px) {

        #marks_distribution {
            border-left: 1px solid #e9e9e9;
        }

    }

    #manage_all_result th {
        text-align: center;
    }
</style>
<link href="{{ asset('/assets/css/marksheet.css') }}" type="text/css" rel="stylesheet" media="print">
<script>
    function printMarksheet() {
        $('#marksheet').printThis({
            importCSS: true,
            importStyle: true,//thrown in for extra measure
            loadCSS: "{{ asset('/assets/css/bootstrap.min.css') }}",
            //header: '<h1> Table Report</h1>',

        });
    }

    function exportMarksheet() {

        var class_id = "{{$data['class_id']}}";
        var student_code = "{{$data['student_code']}}";
        var section_id = "{{$data['section_id']}}";
        var exam_id = "{{$data['exam_id']}}";

        var class_name = "{{$data['class_name']}}";
        var section_name = "{{$data['section_name']}}";
        var exam_name = "{{$data['exam_name']}}";
        var student_name = "{{$data['student_name']}}";
        var std_roll = "{{$data['std_roll']}}";

        var total_std = $('#total_std').val();
        var total_atd = $('#total_atd').val();
        var total_wd = $('#total_wd').val();
        var position = $('#position').val();


        var base = '{!! route('srPrintTranscript.access') !!}';
        var url = base + '?class_id=' + class_id + '&section_id=' + section_id + '&student_code=' + student_code
            + '&exam_id=' + exam_id + '&class_name=' + class_name + '&section_name=' + section_name
            + '&exam_name=' + exam_name + '&student_name=' + student_name + '&std_roll=' + std_roll
            + '&total_std=' + total_std + '&total_atd=' + total_atd + '&total_wd=' + total_wd + '&position=' + position;
        window.location.href = url;
    }
</script>
