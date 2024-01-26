<div class="col-md-12">
    <label for="">Select All</label>
    <input type="checkbox" id="select_all" />
</div>
<div class="col-md-12">
    @php $i=1 @endphp
    <table class="table table-striped table-bordered" width="100%">
        <thead>
        <tr>
            <th>Roll</th>
            <th>Student ID</th>
            {{-- <th>Select</th> --}}
            <th>Student Name</th>
            {{-- <th>Class</th>
            <th>Section</th> --}}
            <th>Attendance</th>
        </tr>
        </thead>
        <tbody>
        @foreach($students as $student)
            <tr>
                {{-- <td width="2%">
                    {{ $i++ }}
                </td> --}}
                <td width="10%">
                    <strong>{{$student->roll}}</strong>
                    <input type="hidden" class="form-control" name="roll[]" value="{{$student->roll}}">
                </td>
                <td width="20%">
                    <strong>{{$student->std_code}}</strong>
                    <input type="hidden" class="form-control" name="std_code[]" value="{{$student->std_code}}">
                </td>

                <td width="30%">
                    <strong>{{$student->std_name}}</strong>
                    <input type="hidden" class="form-control" name="student_code" value="{{$student->student_code}}">
                </td>

                <td width="2%"><input type="checkbox" class="checkbox"></td>
                {{-- <td width="10%">
                    <input type="checkbox" class="data-check flat-green" name="student_attendance"
                        value="1">
                </td> --}}
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="form-group col-md-12">
    <button type="submit" class="btn btn-success button-submit" onclick="createAttendance()"
                data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Save
    </button>
</div>

<script>
    $(document).ready(function () {
        $('.select').select2();
        $('input[type="checkbox"].flat-green').iCheck({
                checkboxClass: 'icheckbox_flat-green',
            });
    });
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
            $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
});
</script>

<script>
    function createAttendance() {

        var student_codes = [];
        //var teacher_ids = [];
        $(".checkbox:checked").each(function () {
            var student_code = $(this).parents('tr').find('input[name=student_code]').val();
            student_codes.push(student_code);
        });

        console.log(student_codes);

        var class_id = $('#class_id').val();
        var section_id = $('#section_id').val();

        $('#create').validate({
                    submitHandler: function (form) {

                        var myData = new FormData($("#create")[0]);
                        myData.append('student_codes', student_codes);
                        myData.append('_token', CSRF_TOKEN);

                        swal({
                            title: "Are you sure to submit?",
                            text: "Student attendance insert",
                            type: "warning",
                            showCancelButton: true,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true,
                            confirmButtonClass: "btn-danger",
                            confirmButtonText: "Yes, Submit!"
                        }, function () {
                            $.ajax({
                                url: '/admin/attendancestudents',
                                type: 'POST',
                                data: myData,
                                dataType: 'json',
                                cache: false,
                                processData: false,
                                contentType: false,
                                success: function (data) {
                                    if (data.type === 'success') {
                                        swal("Done!", data.message, "success");
                                        $("#subject_instructor").empty();
                                    } else if (data.type === 'error') {
                                        if (data.errors) {
                                            $.each(data.errors, function (key, val) {
                                                $('#error_' + key).html(val);
                                            });
                                        }
                                        $("#status").html(data.message);
                                        swal("Error sending!", "Please fix the errors", "error");
                                    }
                                }
                            });
                        });
                    }
                });
    }
</script>
