@extends('backend.layouts.master')
@section('title', 'Marks')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
                </div>
                <div>Manage Marks</div>
                <div class="d-inline-block ml-2">
                    @can('vendor-create')
                        <a href="{!! route('admin.importMarks.import') !!}" class="btn btn-danger"
                        style="color: #fff;">Import Marks</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">

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

                        <div class="form-group col-md-2 col-sm-12">
                            <label for="">Exam</label>
                            <select name="exam_id" id="exam_id" class="form-control" required>
                                <option value="" selected disabled>Select a Exam</option>
                            </select>
                        </div>

                        <div class="form-group col-md-2 col-sm-12">
                            <label for="">Subject</label>
                            <select class="form-control" name="subject_id" id="subject_id" required>
                                <option value="">Select a subject</option>
                            </select>
                        </div>

                        <div class="form-group  col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-3 mb-lg-0">
                            <label for="">&nbsp;</label>
                            <button type="button" class="btn  btn-success form-control"
                                    onclick="getMarks()">Filter
                            </button>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div id="not_found">
                                <img src="{{asset('assets/images/empty_box.png')}}" width="200px">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="marks_content"></div>
                    </div>
                </div>
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

        $("#export_excel").hide();
        $("#export_pdf").hide();

        $(document).ready(function () {
            var div = document.getElementById('marks_content');
            div.style.visibility = 'hidden';
        });

        function getMarks() {

            var class_id = $("#class_id").val();
            var section_id = $("#section_id").val();
            var exam_id = $("#exam_id").val();
            var subject_id = $("#subject_id").val();





            if (class_id != null && section_id != null && exam_id != null && subject_id != null) {

                $("#not_found").hide();


                var div = document.getElementById('marks_content');
                div.style.visibility = 'visible';

                // $('#manage_all').DataTable().clear();
                // $('#manage_all').DataTable().destroy();

                console.log("test");
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: 'getMarks',
                    type: "POST",
                    data: {
                        "class_id": class_id,
                        "section_id": section_id,
                        "exam_id": exam_id,
                        "subject_id": subject_id,
                        "_token": CSRF_TOKEN
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('body').plainOverlay('show');
                    },
                    success: function (data) {
                        $('body').plainOverlay('hide');
                        $("#marks_content").html(data.html);
                        $("#export_excel").show();
                        $("#export_pdf").show();
                    },
                    error: function (result) {
                        $("#marks_content").html("Sorry Cannot Load Data");
                    }
                });
            } else {
                swal("Warning!", "Please Select all field!!", "error");
            }
        }
    </script>

    <script type="text/javascript">

        function exportMarks(val) {

            var class_id = $("#class_id").val();
            var section_id = $("#section_id").val();
            var exam_id = $("#exam_id").val();
            var subject_id = $("#subject_id").val();

            if (class_id != null && section_id != '' && exam_id != null && subject_id != '') {
                if (val == 'Excel') {

                    var base = '{!! route('admin.exportExcelMarks') !!}';
                    var url = base + '?class_id=' + class_id + '&section_id=' + section_id
                        + '&exam_id=' + exam_id + '&subject_id=' + subject_id;
                    window.location.href = url;

                } else {
                    var base = '{!! route('admin.exportPdfMarks') !!}';
                    var url = base + '?class_id=' + class_id + '&section_id=' + section_id
                        + '&exam_id=' + exam_id + '&subject_id=' + subject_id;
                    window.location.href = url;
                }

            }
        }


        function getSection(std_class_id){

            getExam(std_class_id);
            getSubject(std_class_id);

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


        function getSubject(std_class_id){
            console.log(std_class_id);
            $("#subject_id").empty();
            $("#loader").show();
            $.ajax({
                type: 'GET',
                url: 'getSubject/' + std_class_id,
                success: function (data) {
                    $("#loader").hide();
                    $("#subject_id").html(data);
                },
                error: function (result) {
                    $("#subject_id").html("Sorry Cannot Load Data");
                }
            });
        }
    </script>
@stop
