@extends('backend.layouts.master')
@section('title','student attendance')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
                </div>
                <div>Student Attendance Of {{ date("Y-m-d") }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation" novalidate>
                <div class="form-group row">
                    <div class="col-md-5">
                        <select name="class_id" id="class_id" class="form-control select" onchange="getSection(this.value)" >
                            <option value="" selected disabled>Select a class</option>
                            @foreach ($std_classes as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <select name="section_id" id="section_id" class="form-control select">
                            <option value="" selected disabled>Select a section</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success form-control" onclick="getStudents()">Filter</button>
                    </div>

                </div>
                <div class="col-md-12" id="subject_instructor"></div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-center">
            <div id="not_found">
                <img src="{{asset('assets/images/empty_box.png')}}" width="200px">
            </div>
        </div>
    </div>

    <style>
        @media screen and (min-width: 768px) {
            #myModal .modal-dialog {
                width: 85%;
                border-radius: 5px;
            }
        }

        #not_found {
            margin-top: 30px;
            z-index: 0;
        }

    </style>

    <script>
        $(document).ready(function(){
            $('.select').select2();
        });
    </script>

    <script type="text/javascript">
        function getSection(val){
            $("#section_id").empty();
            $.ajax({
                type : 'GET',
                url : 'getSections/'+val,
                success : function(data){
                    $("#section_id").html(data);
                },
                error: function(result){
                    $("#modal_data").html("Sorry Cannot Load Data");
                }
            });
        }
    </script>
    <script>
        document.body.classList.add("sidebar-collapse");

        function getStudents(){
            $("#not_found").hide();
            var class_id = $("#class_id").val();
            var section_id = $("#section_id").val();

            var class_name= $("#class_id option:selected").text();
            var section = $("#section_id option:selected").text();

            $.ajax({
                url: '/admin/getAllStudentsForAttendance',
                type:"GET",
                data:{
                    'class_id' : class_id,
                    'section_id' : section_id
                },
                beforeSend: function () {
                    $('body').plainOverlay('show');
                },
                success: function (data) {
                    $("#subject_instructor").html(data.html);
                    $('body').plainOverlay('hide');

                },
                error: function (result) {
                    $("#subject_instructor").html("Sorry Cannot Load Data");
                }
            });

        }
    </script>
@endsection

