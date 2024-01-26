<hr/>
@if(count($data) > 0)
    @php
        $no = 1;
    @endphp
    <div class="col-md-12">
        <div class="col-md-4 col-md-offset-4 mx-auto">
            <div class="card card_text">
                <div class="card-body text-center">
                    {{-- <h3> {{ $data[0]->exam_name }}</h3>
                    <h4> Class : {{ $data[0]->class_name }} </h4>
                    <h4> Section : {{ $data[0]->section_name }} </h4> --}}
                    {{-- <h4> Subject : {{ $data[0]->sub_name }} </h4> --}}

                    <h4 id="exam_name"> </h4>
                    <h6 id="class_name"></h6>
                    <h6 id="section_name"></h6>
                    <h6 id="subject_name"></h6>
                </div>
            </div>
            <hr/>
        </div>
    </div>

        <form id='create' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
            <input type="hidden" name="exam_id" value="{{$exam_id}}">
            <input type="hidden" name="class_id" value="{{ $class_id }}">
            <input type="hidden" name="section_id" value="{{ $section_id }}">
            <input type="hidden" name="subject_id" value="{{ $subject_id }} ">

            <div id="status"></div>
            <div class="col-md-12 col-sm-12 table-responsive">
                <table id="manage_all" class="table table-collapse table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="serial">#</th>
                        <th class="std_id">Student Code</th>
                        <th class="std_name">Name</th>
                        <th class="text-center">Roll</th>
                        <th class="marks">Theory Marks</th>
                        <th class="marks">MCQ Marks</th>
                        <th class="marks">Practical Marks</th>
                        <th class="marks">CT Marks</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $key=>$row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->student_code }}</td>
                            <td>{{ $row->student_name }}</td>
                            <td class="text-center">{{ $row->roll }}</td>
                            
                            <td hidden><input type="number" max="100" min="0" class="form-control decimal"
                                name="student[{{$key}}][student_code]"
                                value="{{$row->student_code ? $row->student_code : ''}}"></td>
                            <td><input type="number" max="100" min="0" class="form-control decimal"
                                    name="student[{{$key}}][theory_marks]"
                                    value="{{$row->theory_marks ? $row->theory_marks : ''}}"></td>
                            <td><input type="number" max="50" min="0" class="form-control decimal"
                                    name="student[{{$key}}][mcq_marks]"
                                    value="{{$row->mcq_marks ? $row->mcq_marks : ''}}"></td>
                            <td><input type="number" max="50" min="0" class="form-control decimal"
                                    name="student[{{$key}}][practical_marks]"
                                    value="{{$row->practical_marks ? $row->practical_marks : ''}}"></td>
                            <td><input type="number" max="50" min="0" class="form-control decimal"
                                    name="student[{{$key}}][ct_marks]"
                                    value="{{$row->ct_marks ? $row->ct_marks : ''}}"></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-md-12">
                <button type="submit" class="btn btn-success" id="submit"><span class="fa fa-save fa-fw"></span> Save
                </button>
                <img id="loaderSubmit" src="{{asset('assets/images/loadingg.gif')}}" width="20px">
            </div>
        </form>

@else
    <div class="col-md-12 text-center">
        <div class="alert alert-danger">
            <strong>Sorry!! no records have found </strong>
        </div>
    </div>
@endif
<style>
    .serial {
        width: 5%;
    }

    .std_id {
        width: 13%;
    }

    .std_name {
        width: 25%;
    }

    .marks {
        width: 12%;
    }
</style>
<script type="text/javascript">

    $('#loaderSubmit').hide();

    $('#create').validate({// <- attach '.validate()' to your form
        // Rules for form validation
        rules: {
            name: {
                required: true
            },
            phone: {
                required: true,
                number: true
            }
        },
        // Messages for form validation
        messages: {
            name: {
                required: 'Enter name'
            }
        },
        submitHandler: function (form) {
            swal({
                title: "Are you sure?",
                text: "Please check it before submit!!",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                confirmButtonAttendance: "btn-danger",
                confirmButtonText: "Submit",
                cancelButtonText: "Cancel"
            }, function () {

                var myData = new FormData($("#create")[0]);
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                myData.append('_token', CSRF_TOKEN);


                $.ajax({
                    url: 'marks',
                    data: myData,
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.type === 'success') {
                            getMarks();
                            swal("Done!", data.message, "success");
                        } else if (data.type === 'danger') {
                            swal("Error!", data.message, "error");
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        swal("Error!", "Try again", "error");
                    }
                });
            });
        }
    });

    var exam_name=$("#exam_id option:selected").text();
    var class_name=$("#class_id option:selected").text();
    var section_name=$("#section_id option:selected").text();
    var subject_name=$("#subject_id option:selected").text();

    document.getElementById('exam_name').innerText=exam_name;
    document.getElementById('class_name').innerText='Class : '+class_name;
    document.getElementById('section_name').innerText='Section : '+section_name;
    document.getElementById('subject_name').innerText='Subject : '+subject_name;


</script>
