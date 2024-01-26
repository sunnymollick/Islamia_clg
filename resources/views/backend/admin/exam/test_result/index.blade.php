@extends('backend.layouts.master')
@section('title','Test Exam Result')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
                </div>
                <div>Marksheets</div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="row">

                <div class="col-md-3">
                    <div class="form-group">
                        <select name="class_id" id="class_id" onchange="getSection(this.value)" class="form-control">
                            <option value="" selected disabled>Select Class</option>
                            @foreach ($stdClass as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <select name="section_id" id="section_id" class="form-control">
                            <option value="" selected disabled>Select Section</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <select name="exam_id" id="exam_id" class="form-control">
                            <option value="" selected disabled>Select Exam</option>
                        </select>
                    </div>
                </div>

                <div class="form-group  col-md-2">
                    <button type="button" class="btn  btn-success form-control"
                            onclick="testExamResultNew()">Filter
                    </button>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <div id="not_found">
                        <img src="{{asset('assets/images/empty_box.png')}}" width="200px">
                    </div>
                    <img id="loader" src="{{asset('assets/images/loadingg.gif')}}" width="20px">
                </div>
            </div>

            <div class="row">
                <div class="w-100" id="result_content">

                </div>
            </div>

        </div>
    </div>

    <style>
        @media screen and (min-width: 768px) {
            #myModal .modal-dialog {
                width: 95%;
                border-radius: 5px;
            }
        }

        #not_found {
            margin-top: 30px;
            z-index: 0;
        }

    </style>

    <script>
        document.body.classList.add("sidebar-collapse");

        $("#loader").hide();
        var div = document.getElementById('result_content');
        div.style.visibility = 'hidden';

        function testExamResultNew(){
            var class_id = $("#class_id").val();
            var section_id = $("#section_id").val();
            var exam_id = $("#exam_id").val();

            var class_name = $("#class_id option:selected").text();
            var section = $("#section_id option:selected").text();
            var exam_name = $("#exam_id option:selected").text();

            if (class_id != null && section_id != null && exam_id != null) {
                $("#not_found").hide();
                div.style.visibility = 'visible';

                $("#manage_all").DataTable().clear();
                $("#manage_all").DataTable().clear();
            }
        }
    </script>

    <script>
            function getSection(class_id){
                    getExam(class_id);
                    $("#section_id").empty();
                    $("#loader").show();

                    $.ajax({
                    type: 'GET',
                    url: 'getSection/' + class_id,
                    success: function (data) {
                        $("#loader").hide();
                        $("#section_id").html(data);
                    },
                    error: function (result) {
                        $("#section_id").html("Sorry Cannot Load Data");
                    }
                });
            }

            function getExam(std_class_id){

                $("#exam_id").empty();
                $("#loader").show();
                $.ajax({
                    type: 'GET',
                    url: 'getExam/' + std_class_id,
                    success: function (data) {
                        $("#loader").hide();
                        $("#exam_id").html(data);
                    },
                    error: function (result) {
                        $("#exam_id").html("Sorry Cannot Load Data");
                    }
                });
            }
    </script>
@endsection
