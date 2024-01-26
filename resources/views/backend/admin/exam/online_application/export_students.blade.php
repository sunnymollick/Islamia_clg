<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<style>

    table,th,td{
        border-collapse: collapse;
        border: 1px solid black;
        text-align: center;
        padding: 5px;

    }
    .grade-table td {
        padding:0;
        margin:0;
        font-size: 12;
    }

    table {
        width: 100%;
    }

    .header{
        border:1px solid white;
    }

</style>
<body style="page-break-after: auto">
@if(!empty($data))
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
                <h3>All Admission Application Form</h3>
            </div>
            <div class="col-md-2">
                <img src="" width="100px" class="img img-thumbnail" style="margin-top:15px;" />
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
        </div>
        <div style="clear: both"></div>
        
        
        <div style="clear: both"></div>
        <div class="row_block" style="font-size:9px;">

            <div style="clear: both"></div>
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <th>No.</th>
                        <th>College Roll</th>
                        <th>Applicant Name</th>
                        <th>Father's Name</th>
                        <th>Mother's Name</th>
                        <th>Admitted Section</th>
                        <th>Mobile</th>
                        <th>Picture</th>
                    </tr>
                    @php
                        $i=1;
                    @endphp
                    @foreach($data as $applicant)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{$applicant->college_roll}}</td>
                        <td>{{$applicant->applicant_name_en}}</td>
                        <td>{{$applicant->father_name_en}}</td>
                        <td>{{$applicant->mother_name_en}}</td>
                        <td>{{$applicant->admitted_section}}</td>
                        <td>{{$applicant->mobile}}</td>
                        <td><img src="{{ $applicant->file_path }}" alt="" height="50px" width="50px"></td>
                    </tr>
                    @endforeach

                </table>
            </div>
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
