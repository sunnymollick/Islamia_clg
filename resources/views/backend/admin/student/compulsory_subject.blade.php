@extends('backend.layouts.master')
@section('title', 'Student')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
                </div>
                <div>Select Humanities Students Compulsory Subject</div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-center">
            <div class="form-group row">
                <div class="col-md-5">
                    <select  id="class_id" class="form-control"
                        onchange="get_sections(this.value)">
                        <option value="" selected disabled>Select a class</option>
                        @foreach($stdclass as $class)
                            <option value="{{$class->id}}"
                                @if ($class->name == 'XI-Science' || $class->name == 'XI-Business' || $class->name == 'XII-Science' || $class->name == 'XII-Business')
                                    hidden 
                                @endif
                                >{{$class->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-5">
                    <select class="form-control"  id="section_id">
                        <option value="" selected disabled>Select a section</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="button" class="btn  btn-success form-control"
                            onclick="getStudents()">Filter
                    </button>
                </div>

            </div>

        </div>
        <div class="clearfix"></div>
    </div>
        <br>
        <br>
    <div class="row">
        <div class="col-md-12 text-center">
            <div id="not_found">
                <img src="{{asset('assets/images/empty_box.png')}}" width="200px">
            </div>
        </div>
    </div>
    <div class="row" id="students_content">

    </div>


    <script>
        function smsCreate() {
            ajax_submit_smsCreate('students');
        }
    </script>
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
        document.body.classList.add("sidebar-collapse");
        $("#export_excel").hide();
        $("#export_pdf").hide();

        var div = document.getElementById('students_content');
        div.style.visibility = 'hidden';

        function getStudents(){
            var class_id = $("#class_id").val();
            var section_id = $("#section_id").val();

            var class_name = $("#class_id option:selected").text();
            var section = $("#section_id option:selected").text();

            if (class_id != null && section_id != null) {
                $("#not_found").hide();

                var div = document.getElementById('students_content');
                div.style.visibility = 'visible';

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: '{!! route('admin.allStudentsList') !!}',
                    type: "POST",
                    data: {
                        "class_id": class_id,
                        "section_id": section_id,
                        "class_name": class_name,
                        "section": section,
                        "_token": CSRF_TOKEN
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('body').plainOverlay('show');
                    },
                    success: function (data) {
                        $('body').plainOverlay('hide');
                        $("#students_content").html(data.html);
                        $("#export_excel").show();
                        $("#export_pdf").show();
                    },
                    error: function (result) {
                        $("#students_content").html("Sorry Cannot Load Data");
                    }
                });


            } else {
                swal("Warning!", "Please Select all field!!", "error");
            }
        }

    </script>

    <script type="text/javascript">

        function exportStudent(val) {

            var class_id = $("#class_id").val();
            var section_id = $("#section_id").val();

            if (class_id != null && section_id != null) {
                if (val == 'Excel') {
                    var url = 'exportStudentExcel/' + class_id + '/' + section_id;
                    window.location.href = url;
                } else {
                    var url = 'exportStudentPdf/' + class_id + '/' + section_id;
                    window.location.href = url;
                }

            }
        }

        function get_sections(val) {
            if (val != 'all') {
                $("#section_id").empty();
                $.ajax({
                    type: 'GET',
                    url: 'getSections/' + val,
                    success: function (data) {
                        $("#section_id").html(data);
                    },
                    error: function (result) {
                        $("#modal_data").html("Sorry Cannot Load Data");
                    }
                });
            }
        }


        function create() {

            $("#modal_data").empty();
            $('.modal-title').text('Add New Student'); // Set Title to Bootstrap modal title

            $.ajax({
                type: 'GET',
                url: 'students/create',
                success: function (data) {
                    $("#modal_data").html(data.html);
                    $('#myModal').modal('show'); // show bootstrap modal
                },
                error: function (result) {
                    $("#modal_data").html("Sorry Cannot Load Data");
                }
            });

        }

    </script>



@stop
