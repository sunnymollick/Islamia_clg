@extends('backend.layouts.master')
@section('title', 'Admit Card')
@section('content')

<div class="app-page-title">
    <div class="page-title-wrapper">
        <div class="page-title-heading">
            <div class="page-title-icon">
                <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
            </div>
            <div>Allow For Certificate</div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
    {{-- <div class="form-group col-md-4 col-sm-12">
        <label for=""> Date of Issue </label>
        <input type="date" class="form-control" name="issue_date" id="issue_date"
        value="{{ $students[0]->issue_date }}">
        <span id="error_issue_date" class="has-error"></span>
    </div> --}}
    @php $i=1 @endphp
    <table id="manage_all" class="table table-striped table-bordered" width="100%">
        <thead>
        <tr>
            <th>#</th>
            <th class="text-center">
                <input type="checkbox" id="checkAll" class="data-check flat-green"> Select All
                <hr>
                Select
            </th>
            <th>Student Name</th>
            <th>Student Code</th>
            {{-- <th>Total Course</th>
            <th>Total Pass Course</th> --}}
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($students as $std)
            <tr>
                <td>
                    {{ $i++ }}
                    <input type="hidden" name="student_id" value="{{$std->student_id}}"/>
                </td>
                <td class="text-center"><input type="checkbox" class="data-check flat-green singel-select"></td>
                <td>
                    {{$std->student->name}}
                </td>
                <td>
                    {{$std->student->std_code}}
                </td>
                {{-- <td>
                    {{$total_courses}}
                </td> --}}
                {{-- <td>
                    {{$std->total_pass}}
                </td> --}}
                <td>
                    @can('result-view')
                        <a class="btn btn-success viewResult" id="{{$std->student_id}}">View Result Sheet</a>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br/>
    <div class="form-group col-md-12 mt-3 mb-3">
        <a type="submit" class="btn btn-success button-submit" onclick="studentEnrollmentProcess()"><span
                class="fa fa-save fa-fw"></span> Allow
        </a>
    </div>
    {{-- <div class="col-md-12">
        <button type="submit" class="btn btn-success button-submit btn-block" onclick="studentEnrollmentProcess()"
                data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Allow
        </button>
    </div> --}}
    <br/>
</div>

<style>
    @media screen and (min-width: 768px) {
        #myModal .modal-dialog {
            width: 90%;
            border-radius: 5px;
        }
    }

    #not_found {
        margin-top: 30px;
        z-index: 0;
    }

</style>
</div>

<script type='text/javascript'>
    var triggeredByChild = false;
    // $('input').iCheck({
    //     checkboxClass: 'checkbox-default',
    //     radioClass: 'radio-default',
    // });
    $('#checkAll').on('ifChecked', function (event) {
        $('.data-check').iCheck('check');
        triggeredByChild = false;
    });
    $('#checkAll').on('ifUnchecked', function (event) {
        if (!triggeredByChild) {
            $('.data-check').iCheck('uncheck');
        }
        triggeredByChild = false;
    });
    // Removed the checked state from "All" if any checkbox is unchecked
    $('.data-check').on('ifUnchecked', function (event) {
        triggeredByChild = true;
        $('#checkAll').iCheck('uncheck');
    });
    $('.data-check').on('ifChecked', function (event) {
        if ($('.data-check').filter(':checked').length == $('.data-check').length) {
            $('#checkAll').iCheck('check');
        }
    });
      </script>

<script type="text/javascript">


    $(document).ready(function () {

        // $("#checkAll").on('change',function(){
        //     $(".data-check").prop('checked',$(this).is(":checked"));
        // });

        $('input[type="checkbox"].flat-green').iCheck({
                checkboxClass: 'icheckbox_flat-green',
            });

        $("#manage_all").on("click", ".viewResult", function () {

        var student_id = $(this).attr('id');
        var schedule_id = $("#schedule_id").val();
        var exam_type = $("#exam_type").val();

        if (schedule_id != '' && schedule_id != null && student_id != null && exam_type != '') {
            $('body').plainOverlay('show');

            $.ajax({
                url: '/admin/generateStudentResultSheet',
                type: "GET",
                data: {
                    "schedule_id": schedule_id,
                    "student_id": student_id,
                    "exam_type": exam_type,
                    "_token": CSRF_TOKEN
                },
                dataType: 'json',
                success: function (data) {
                    $('body').plainOverlay('hide');
                    $("#modal_data").html(data.html);
                    $('#myModal').modal('show'); // show bootstrap modal
                },
                error: function (result) {
                    $("#modal_data").html("Sorry Cannot Load Data");
                }
            });

        } else {
            swal("Warning!", "Please select fields", "error");
        }
        });


    });

    function studentEnrollmentProcess() {

        var student_ids = [];
        var schedule_id = $("#schedule_id").val();

        $(".singel-select:checked").each(function () {
            var student_id = $(this).parents('tr').find('input[name=student_id]').val();
            student_ids.push(student_id);
        });


        if (student_ids.length > 0 && schedule_id != null) {
            swal({
                title: "Confirm to Allow",
                text: "Allow for Certificate",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, Allow!"
            }, function () {

                $.ajax({
                    url: '/admin/allowCertificate',
                    type: 'GET',
                    data: {
                        "student_ids": student_ids,
                        "schedule_id": schedule_id
                    },
                    beforeSend: function () {
                        $('body').plainOverlay('show');
                    },
                    success: function (data) {
                        $('body').plainOverlay('hide');
                        if (data.type === 'success') {
                            swal("Done!", "It was succesfully done!", "success");
                        } else if (data.type === 'error') {
                            swal("Error sending!", "Please try again", "error");
                        }
                    }
                });
            });
        } else {
            swal("", "No course schedule or stduent have Selected!", "warning");
        }

    };

</script>
@stop
