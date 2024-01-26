@extends('backend.layouts.master')
@section('title','student attendance')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
                </div>
                <div>Attendance</div>
                <div class="ml-2">

                    @can('attendance-students')
                        <a style="color: #fff" href="{{ asset('assets/documents/attendance_student_demo.xlsx') }}" class="btn btn-danger">Demo Students Excel File</a>
                    @endcan

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation" novalidate>
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="">Select Class</label>
                        <select name="class_id" id="class_id" class="form-control select" onchange="getSection(this.value)" >
                            <option value="" selected disabled>Select a class</option>
                            @foreach ($std_classes as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="">Select Section</label>
                        <select name="section_id" id="section_id" class="form-control select">
                            <option value="" selected disabled>Select a section</option>
                        </select>
                    </div>
                    {{-- <div class="col-md-4">
                        <label for="">Attendance Date</label>
                        <input type="text" value="{{ date('Y-m-d') }}" class="form-control" id="atten_date" name="atten_date" readonly >
                    </div> --}}
                </div>

                <div class="form-group row col-md-12">
                    <label for="excel_upload">Import Students Attendance</label>
                    <input id="excel_upload" type="file" name="excel_upload" style="display:none">
                    <div class="input-group">
                        <div class="input-group-btn">
                            <a class="btn btn-success"
                                onclick="$('input[id=excel_upload]').click();">Browse</a>
                        </div><!-- /btn-group -->
                        <input type="text" name="SelectedFileName" class="form-control" id="SelectedFileName" value="" readonly required>
                    </div>
                    <div class="clearfix"></div>
                    <p class="help-block">File must be xlsx, xls, csv.</p>
                    <script type="text/javascript">
                        $('input[id=excel_upload]').change(function () {
                            $('#SelectedFileName').val($(this).val());
                        });
                    </script>
                    <span id="error_excel_upload" class="has-error"></span>
                </div>
                <div class="col-md-2 form-group row">
                    <label for=""></label>
                    <button type="submit" class="btn btn-success .submit"
                            data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Import
                    </button>
                </div>
                <div class="col-md-12" id="subject_instructor">

                </div>
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

    {{-- <script>
        $(document).ready(function(){
            $('.select').select2();
            $("#atten_date").datepicker();
        });
    </script> --}}

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

        $(document).ready(function () {

            $('#loader').hide();

            $('#create').validate({// <- attach '.validate()' to your form
                // Rules for form validation
                rules: {
                    excel_upload: {
                        required: true
                    }
                },
                // Messages for form validation
                messages: {
                    excel_upload: {
                        required: 'Enter file'
                    }
                },
                submitHandler: function (form) {

                    var myData = new FormData($("#create")[0]);
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    myData.append('_token', CSRF_TOKEN);

                    var class_name = $("#class_id option:selected").text();
                    var section = $("#section_id option:selected").text();

                    swal({
                        title: "Are you sure?",
                        text: "Please check the information "
                        + " \n Class : " + class_name
                        + " \n Section : " + section,
                        type: "warning",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Imports",
                        cancelButtonText: "Cancel"
                    }, function () {
                        $.ajax({
                            url: 'importStdattendances',
                            type: 'POST',
                            data: myData,
                            dataType: 'json',
                            cache: false,
                            processData: false,
                            contentType: false,
                            beforeSend: function () {
                                $('#loader').show();
                                $(".submit").prop('disabled', true); // disable button
                            },
                            success: function (data) {

                                if (data.type === 'success') {
                                    document.getElementById("create").reset();
                                    swal("Done!", data.message, "success");
                                    $(".submit").prop('disabled', false); // disable button

                                } else if (data.type === 'error') {

                                    if (data.errors) {
                                        $.each(data.errors, function (key, val) {
                                            $('#error_' + key).html(val);
                                        });
                                    }
                                    //   notify_view(data.type, data.message);
                                    swal("Error importing!", data.message, "error");
                                    $(".submit").prop('disabled', false); // disable button
                                }
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                swal("Error importing!", "Try again", "error");
                            }
                        });
                    });
                }
                // <- end 'submitHandler' callback
            });                    // <- end '.validate()'

        });
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

