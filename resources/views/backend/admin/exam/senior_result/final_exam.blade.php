@extends('backend.layouts.master')
@section('title', 'Junior Full Marks Sheet')
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
            <div class="box box-success">
                {{-- <div class="box-header with-border">
                    <p class="panel-title"> Marksheets </p>
                </div> --}}
                <div class="panel-body">
                    <div class="row">
                        <div class="form-group col-md-2 col-sm-12">
                            <label for="">Class</label>
                            <select name="class_id" id="class_id" class="form-control" required
                                    onchange="getSection(this.value)">
                                <option value="" selected disabled>Select a class</option>
                                @foreach($stdclass as $class)
                                    <option value="{{$class->id}}">{{$class->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-2 col-sm-12">
                            <label for="">Section</label>
                            <select class="form-control" name="section_id" id="section_id" required>
                                <option value="">Select a section</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                            <label for="">Exam</label>
                            <select name="exam_id_half" id="exam_id_half" class="form-control" required>
                                <option value="">Select Exam</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3 col-sm-12">
                            <label for="">Exam</label>
                            <select name="exam_id_final" id="exam_id_final" class="form-control" required>
                                <option value="">Select Exam</option>
                            </select>
                        </div>
                        <div class="form-group  col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-3 mb-lg-0">
                            <label for="">&nbsp;</label>
                            <button type="button" class="btn  btn-success form-control"
                                    onclick="jrfinalSummeryResult()">Filter
                            </button>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="row ">
                        <div class="col-md-12 text-center">
                            <div id="not_found">
                                <img src="{{asset('assets/images/empty_box.png')}}" width="200px">
                            </div>
                            <img id="loader" src="{{asset('assets/images/loadingg.gif')}}" width="20px">
                        </div>
                    </div>
                    <div class=" row">
                        <div class="w-100" id="tabulations_content"></div>

                    </div>
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

        $('#loader').hide();
        var div = document.getElementById('tabulations_content');
        div.style.visibility = 'hidden';


        function jrfinalSummeryResult() {

            var exam_id_half = $("#exam_id_half").val();
            var exam_id_final = $("#exam_id_final").val();
            var section_id = $("#section_id").val();
            var class_id = $("#class_id").val();

            var exam_name_half = $("#exam_id_half option:selected").text();
            var exam_name_final = $("#exam_id_final option:selected").text();
            var class_name = $("#class_id option:selected").text();
            var section_name = $("#section_id option:selected").text();

            if (exam_id_half != null && exam_id_final != null && section_id != null && class_id != null) {

                $("#not_found").hide();
                var div = document.getElementById('tabulations_content');
                div.style.visibility = 'visible';
                $('#manage_all').DataTable().clear();
                $('#manage_all').DataTable().destroy();


                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: 'srfinalSummeryResult',
                    type: "POST",
                    data: {
                        "exam_id_half": exam_id_half,
                        "exam_id_final": exam_id_final,
                        "section_id": section_id,
                        "class_id": class_id,
                        "exam_name_half": exam_name_half,
                        "exam_name_final": exam_name_final,
                        "section_name": section_name,
                        "class_name": class_name,
                        "_token": CSRF_TOKEN
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('body').plainOverlay('show');
                    },
                    success: function (data) {
                        $('body').plainOverlay('hide');
                        $("#tabulations_content").html(data.html);
                    },
                    error: function (result) {
                        $("#tabulations_content").html("Sorry Cannot Load Data");
                    }
                });
            } else {
                $('#loader').hide();
                swal("Warning!", "Please Select all field!!", "error");
            }
        }
    </script>
    <script type="text/javascript">


        function getSection(std_class_id){

            getExam(std_class_id);

            $("#section_id").empty();
            $("#loader").show();
            $.ajax({
                type: 'GET',
                url: 'getSection/' + std_class_id,
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

            $("#exam_id_half").empty();
            $("#exam_id_final").empty();
            $("#loader").show();
            $.ajax({
                type: 'GET',
                url: 'getExam/' + std_class_id,
                success: function (data) {
                    $("#loader").hide();
                    $("#exam_id_half").html(data);
                    $("#exam_id_final").html(data);
                },
                error: function (result) {
                    $("#exam_id_half").html("Sorry Cannot Load Data");
                }
            });
        }

    </script>
@stop
