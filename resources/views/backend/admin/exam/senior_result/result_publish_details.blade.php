@if(!empty($data))
    <hr/>
    <div class="row">
        <hr/>
        @php
            $total_std = 0;
            $pass = 0;
            $fail = 0;
            $cgpa = 0.00;

            $exam_name =  $data['exam_name'] ;
            $section_name =  $data['section_name'] ;
            $class_name =  $data['class_name'] ;
            $header_data =  "<h4>$app_settings->name</h4>" .
                            "<h4>$exam_name</h4>" .
                            "<h4>Class : $class_name </h4>" .
                            "<h4>Section : $section_name</h4>";

        @endphp
    </div>

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
    </style>



    <div class="col-md-12">
        <div style="width:5%;float: left;">
            <img src="{{ asset("assets/images/islamia_clg.jpg") }}" alt="" height="150px" width="150px">
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
        <div style="text-align: center; margin-top:10px; margin-left:150px;">
            <h4 style="text-transform: uppercase; text-align:center">
                {{  $app_settings ? Str::upper($app_settings->name) : '' }}
            </h4>
            <h4 style="text-align:center;"> {{ Str::upper($data['exam_name']) }} </h4>
            <p></p>
            <h5 style="color:green;"><u>Tablulation Sheet</u></h5>
        </div>
    </div>
    <br>
    <br>
    <br>
    <div class="col-md-12">
        <h5><b>Class : </b>{{ $class_name }}</h5>
        <h5><b>Session : </b> {{ $data['year'] }}</h5>
    </div>

    <div id="status"></div>
    <img id="loaderSubmit" src="{{asset('assets/images/loadingg.gif')}}" width="20px">

    <br>

    <div class="card">
        <table class="table table-bordered table-striped">

            <col>
            <col>
            <colgroup span="3"></colgroup>
            <thead id="table-dark">
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
                        <th scope="rowgroup" style="width:280px;">
                            <p>{{ $student[$i][0]->name }} <br>
                            Section : {{ $data['section_name'] }} <br> Roll : {{ $student[$i][0]->stdRoll }}/{{ $data['result'][$i]->stdCode }}</p>
                        </th>

                        <td style="padding: 0;margin:0">
                            
                                <div  style="border-bottom: 0.5px solid #e9ecef;width:100px;height:35px;" >Bangla</div>
                            
                            <div style="text-align: center;margin-top:20px;">{{ $bangla_gpa }}</div>
                        </td>
                        <td style="padding: 0;margin:0">
                            
                                <div style="border-bottom: 0.5px solid #e9ecef;width:100px;height:35px;" >English</div>
                            
                            <div style="text-align: center;margin-top:20px;">{{ $english_gpa }}</div>
                        </td>
                        <td style="padding: 0;margin:0">
                            
                                <div style="border-bottom: 0.5px solid #e9ecef;width:100px;height:35px;" >ICT</div>
                            
                            <div style="text-align: center;margin-top:20px;">{{ $ict_gpa }}</div>
                        </td>

                        @foreach ($group_subject_val as $row)
                            <td style="padding: 0;margin:0">
                                <div style="border-bottom: 0.5px solid #e9ecef;width:135px;height:35px;" >{{ $row->subject }}</div>
                                <div style="text-align: center;margin-top:20px;">{{ $row->grade }}</div>
                            </td>

                        @endforeach

                        @php
                            $optional_subject = DB::table('subjects')->where('id',$student[$i][0]->optional_subject)->first();
                        @endphp

                        <td style="padding: 0;margin:0">
                            <div style="border-bottom: 0.5px solid #e9ecef;width:135px;height:35px;" >{{ $optional_subject->name }}</div>
                            <div style="text-align: center;margin-top:20px;">{{ $optional_subject_gpa }}</div>
                        </td>

                        <td>
                            @if ($data['result'][$i]->result == 'PASSED')
                                {{ $cgpa }}
                            @else
                                0.00
                            @endif
                        </td>

                    </tr>



                @endfor




            </tbody>



            </tbody>

        </table>
    </div>

    <br>
    <div class="col-md-12">
        <button type='button' id='btn' class='btn btn-success pull-right' value='Print'
                onClick='exportTabultationSheet();'>Print Tabulation Sheet
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
    .serial {
        width: 5%;
    }

    .std_id {
        width: 15%;
    }

    .std_name {
        width: 27%;
    }
</style>
<script>
    $("#loaderSubmit").hide();
</script>

<script>
    function printTabulationSheet() {
        $('#marksheet').printThis({
            importCSS: true,
            importStyle: true,//thrown in for extra measure
            loadCSS: "{{ asset('/assets/css/bootstrap.min.css') }}",
            //header: '<h1> Table Report</h1>',

        });
    }

    function exportTabultationSheet() {

        var class_id = "{{$data['class_id']}}";
        var section_id = "{{$data['section_id']}}";
        var exam_id = "{{$data['exam_id']}}";

        var class_name = "{{$data['class_name']}}";
        var section_name = "{{$data['section_name']}}";
        var exam_name = "{{$data['exam_name']}}";



        var base = '{!! route('srTabulationSheetPrint.access') !!}';
        var url = base + '?class_id=' + class_id + '&section_id=' + section_id + '&exam_id=' + exam_id + '&class_name=' + class_name + '&section_name=' + section_name + '&exam_name=' + exam_name;
        window.location.href = url;
    }
</script>
