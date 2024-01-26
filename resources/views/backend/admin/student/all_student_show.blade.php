<hr>
@if (count($students) > 0)

    <div class="col-md-12">
        <div class="col-md-4 col-md-offset-4 mx-auto">
            <div class="card card_text">
                <div class="card-body text-center">
                    <h4> Class : {{ $class_name }} </h4>
                    <h4> Section : {{ $section }} </h4>
                </div>
            </div>
            <hr />
        </div>
    </div>

    <div class="col-md-12">
        <div class="row">
            @if ($class_name == 'XI-Humanities' || $class_name == 'XII-Humanities')
                <div class="col-md-6">
                    <select name="subject_id" id="subject_id" class="form-control"
                        onchange="searchStudentBySubject(this.value)">
                        <option value="">Find Compulsory Subject</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" @if (
                                $subject->name == 'Bangla 1st Paper' ||
                                    $subject->name == 'English 1st Paper' ||
                                    $subject->name == 'ICT' ||
                                    $subject->name == 'Bangla 2nd Paper' ||
                                    $subject->name == 'English 2nd Paper') hidden @endif>
                                {{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if ($class_name == 'XI-Humanities' || $class_name == 'XII-Humanities')
                <div class="col-md-6">
                    <select name="subject_id" id="subject_id" class="form-control"
                        onchange="searchStudentByOptionalSubject(this.value)">
                        <option value="">Find Optional Subject</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" @if (
                                $subject->name == 'Bangla 1st Paper' ||
                                    $subject->name == 'English 1st Paper' ||
                                    $subject->name == 'ICT' ||
                                    $subject->name == 'Bangla 2nd Paper' ||
                                    $subject->name == 'English 2nd Paper') hidden @endif>
                                {{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-12">
        <p></p>
    </div>



    <form id="create" action="" method="POST" enctype="multipart/form-data" accept-charset="utf-8"
        class="col-md-12">
        <input type="hidden" name="class_id" value="{{ $class_id }}" id="">
        <input type="hidden" name="section_id" value="{{ $section_id }}">
        <div id="status"></div>
        <div>
            <table id="manage_all" class="table table-bordered table-hover" width="100%">
                <thead class="table-dark">
                    <tr>
                        <th class="serial">#</th>
                        <th class="std_id">StudentCode</th>
                        <th class="std_name">Name</th>
                        <th class="std_name">Roll</th>
                        @if ($class_name == 'XI-Humanities' || $class_name == 'XII-Humanities')
                            <th class="marks">Subject1</th>
                            <th class="marks">Subject2</th>
                            <th class="marks">Subject3</th>
                        @else
                        @endif

                        <th>Optional</th>

                        <th class="">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $student->student_code }}</td>
                            <td>{{ $student->std_name }}</td>
                            <td class="text-center">{{ $student->roll }}</td>
                            <input type="hidden" name="student_id[]" value="{{ $student->student_id }}">

                            @if ($class_name == 'XI-Humanities' || $class_name == 'XII-Humanities')
                                <td>
                                    <select name="compulsory_1[]" id="compulsory_1" class="form-control">
                                        <option value="">Select </option>
                                        @foreach ($subjects as $row)
                                            <option value="{{ $row->id }}"
                                                {{ $student->compulsory_1 == $row->id ? 'selected' : '' }}
                                                @if (
                                                        $row->name == 'Bangla 1st Paper' ||
                                                        $row->name == 'English 1st Paper' ||
                                                        $row->name == 'ICT' ||
                                                        $row->name == 'Bangla 2nd Paper' ||
                                                        $row->name == 'English 2nd Paper') hidden @endif>{{ $row->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="compulsory_2[]" id="compulsory_2" class="form-control">
                                        <option value="">Select </option>
                                        @foreach ($subjects as $row)
                                            <option value="{{ $row->id }}"
                                                {{ $student->compulsory_2 == $row->id ? 'selected' : '' }}
                                                @if (
                                                    $row->name == 'Bangla 1st Paper' ||
                                                        $row->name == 'English 1st Paper' ||
                                                        $row->name == 'ICT' ||
                                                        $row->name == 'Bangla 2nd Paper' ||
                                                        $row->name == 'English 2nd Paper') hidden @endif>{{ $row->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="compulsory_3[]" id="compulsory_3" class="form-control">
                                        <option value="">Select </option>
                                        @foreach ($subjects as $row)
                                            <option value="{{ $row->id }}"
                                                {{ $student->compulsory_3 == $row->id ? 'selected' : '' }}
                                                @if (
                                                    $row->name == 'Bangla 1st Paper' ||
                                                        $row->name == 'English 1st Paper' ||
                                                        $row->name == 'ICT' ||
                                                        $row->name == 'Bangla 2nd Paper' ||
                                                        $row->name == 'English 2nd Paper') hidden @endif>{{ $row->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            @else
                            @endif
                            <td>
                                @php
                                    $optional = DB::table('subjects')->where('id',$student->optional_subject_id)->first();
                                @endphp

                                <input type="text" class="form-control" value="{{ $optional->name }}" readonly >

                            </td>


                            <td>
                                <a data-toggle="tooltip" id="{{ $student->student_id }}"
                                    class="btn btn-xs btn-info margin-r-5 view" title="View"><i
                                        class="fa fa-eye fa-fw"></i> </a>
                                <a data-toggle="tooltip" id="{{ $student->student_id }}"
                                    class="btn btn-xs btn-warning margin-r-5 edit" title="Edit"><i
                                        class="fa fa-edit fa-fw"></i> </a>

                                    @if (Auth::user()->id == 1)
                                        <a data-toggle="tooltip" id="{{ $student->student_id }}"
                                            class="btn btn-xs btn-danger margin-r-5 delete" title="Delete"><i
                                                class="fa fa-trash fa-fw"></i> </a>
                                        <a data-toggle="tooltip" id="{{ $student->student_id }}"
                                            class="btn btn-xs btn-success margin-r-5 password" title="Change Password"><i
                                                class="fa fa-lock fa-fw"></i> </a>
                                    @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
        @if ($class_name == 'XI-Humanities' || $class_name == 'XII-Humanities')
            <div class="form-group col-md-12">
                <button type="submit" class="btn btn-success" id="submit"><span class="fa fa-save fa-fw"></span>
                    Save
                </button>
                <img id="loaderSubmit" src="{{ asset('assets/images/loadingg.gif') }}" width="20px">
            </div>
        @endif
    </form>
@else
    <div class="col-md-12 text-center">
        <div class="alert alert-danger">
            <strong>Sorry!! no records have found </strong>
        </div>
    </div>
@endif

<div class="col-md-12" id="searchResultSection">
    <div class="table-responsive">
        <table id="student_list_table" class="table table-collapse table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th width="10px">#</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th width="10px">Roll</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#searchResultSection").hide();

    });
</script>
<script>
    function searchStudentBySubject(subject_id) {

        var class_id = $("#class_id").val();
        var section_id = $("#section_id").val();

        if (class_id != null && subject_id != null) {

            $("#create").hide();
            $("#searchResultSection").show();

            $('#student_list_table').DataTable().clear();
            $('#student_list_table').DataTable().destroy();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            table = $('#student_list_table').DataTable({
                dom: "<'row'<'col-sm-4'l><'col-sm-8'f>>" +
                    "<'row'<'col-sm-12'>B>" + //
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4'i><'col-sm-8'p>>",
                processing: true,
                serverSide: true,
                pageLength: 50,
                ajax: {
                    "url": '{!! route('admin.allStudentsForSubject') !!}',
                    "type": "POST",
                    "data": {
                        "class_id": class_id,
                        "subject_id": subject_id,
                        "section_id": section_id,
                        "_token": CSRF_TOKEN
                    },
                    "dataType": 'json'
                },
                "initComplete": function(settings, json) {
                    // $("#export_excel").show();
                    // $("#export_pdf").show();
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'std_code',
                        name: 'std_code'
                    },
                    {
                        data: 'std_name',
                        name: 'std_name'
                    },
                    {
                        data: 'roll',
                        name: 'roll'
                    },
                ],
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-table"> EXCEL </i>',
                        titleAttr: 'Excel',
                        exportOptions: {
                            columns: ':visible:not(.not-exported)'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: "{!! $app_settings->name !!} \n Students Information \n",
                        text: '<i class="fa fa-file-pdf-o"> PDF</i>',
                        titleAttr: 'PDF',
                        filename: 'Students',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(doc) {
                            doc.content[1].table.headerRows = 0
                            doc.pageMargins = [100, 10, 20, 10];
                            doc.defaultStyle.fontSize = 9;
                            doc.styles.tableHeader.fontSize = 9;
                            doc.styles.title.fontSize = 14;
                            // Remove spaces around page title
                            doc.content[0].text = doc.content[0].text.trim();
                            doc['footer'] = (function(page, pages) {
                                return {
                                    columns: [
                                        '{{ $app_settings->name }}',
                                        {
                                            // This is the right column
                                            alignment: 'right',
                                            text: ['page ', {
                                                text: page.toString()
                                            }, ' of ', {
                                                text: pages.toString()
                                            }]
                                        }
                                    ],
                                    margin: [10, 0]
                                }
                            });
                        }
                    },
                    {
                        extend: 'print',
                        title: "<div class='text-center'>{!! $app_settings->name !!} <br/> Students Information </div>",
                        text: '<i class="fa fa-print"> PRINT </i>',
                        titleAttr: 'Print',
                        exportOptions: {
                            columns: ':visible'
                        }

                    }, {
                        extend: 'colvis',
                        text: '<i class="fa fa-eye-slash"> Column Visibility </i>',
                        titleAttr: 'Visibility'
                    }

                ],
                "columnDefs": [{
                    "className": "text-center",
                    "targets": "_all"
                }],
                "autoWidth": false,
            });
            $('.dataTables_filter input[type="search"]').attr('placeholder', 'Type here to search...').css({
                'width': '220px',
                'height': '30px'
            });



        }

    }
</script>
<script>
    function searchStudentByOptionalSubject(subject_id) {
        var class_id = $("#class_id").val();
        var section_id = $("#section_id").val();

        if (class_id != null && subject_id != null) {

            $("#create").hide();
            $("#searchResultSection").show();

            $('#student_list_table').DataTable().clear();
            $('#student_list_table').DataTable().destroy();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            table = $('#student_list_table').DataTable({
                dom: "<'row'<'col-sm-4'l><'col-sm-8'f>>" +
                    "<'row'<'col-sm-12'>B>" + //
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4'i><'col-sm-8'p>>",
                processing: true,
                serverSide: true,
                pageLength: 50,
                ajax: {
                    "url": '{!! route('admin.allStudentsForOptionalSubject') !!}',
                    "type": "POST",
                    "data": {
                        "class_id": class_id,
                        "subject_id": subject_id,
                        "section_id": section_id,
                        "_token": CSRF_TOKEN
                    },
                    "dataType": 'json'
                },
                "initComplete": function(settings, json) {
                    // $("#export_excel").show();
                    // $("#export_pdf").show();
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'std_code',
                        name: 'std_code'
                    },
                    {
                        data: 'std_name',
                        name: 'std_name'
                    },
                    {
                        data: 'roll',
                        name: 'roll'
                    },
                ],
                buttons: [{
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-table"> EXCEL </i>',
                        titleAttr: 'Excel',
                        exportOptions: {
                            columns: ':visible:not(.not-exported)'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: "{!! $app_settings->name !!} \n Students Information \n",
                        text: '<i class="fa fa-file-pdf-o"> PDF</i>',
                        titleAttr: 'PDF',
                        filename: 'Students',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(doc) {
                            doc.content[1].table.headerRows = 0
                            doc.pageMargins = [100, 10, 20, 10];
                            doc.defaultStyle.fontSize = 9;
                            doc.styles.tableHeader.fontSize = 9;
                            doc.styles.title.fontSize = 14;
                            // Remove spaces around page title
                            doc.content[0].text = doc.content[0].text.trim();
                            doc['footer'] = (function(page, pages) {
                                return {
                                    columns: [
                                        '{{ $app_settings->name }}',
                                        {
                                            // This is the right column
                                            alignment: 'right',
                                            text: ['page ', {
                                                text: page.toString()
                                            }, ' of ', {
                                                text: pages.toString()
                                            }]
                                        }
                                    ],
                                    margin: [10, 0]
                                }
                            });
                        }
                    },
                    {
                        extend: 'print',
                        title: "<div class='text-center'>{!! $app_settings->name !!} <br/> Students Information </div>",
                        text: '<i class="fa fa-print"> PRINT </i>',
                        titleAttr: 'Print',
                        exportOptions: {
                            columns: ':visible'
                        }

                    }, {
                        extend: 'colvis',
                        text: '<i class="fa fa-eye-slash"> Column Visibility </i>',
                        titleAttr: 'Visibility'
                    }

                ],
                "columnDefs": [{
                    "className": "text-center",
                    "targets": "_all"
                }],
                "autoWidth": false,
            });
            $('.dataTables_filter input[type="search"]').attr('placeholder', 'Type here to search...').css({
                'width': '220px',
                'height': '30px'
            });



        }

    }
</script>
<script>
    $("#manage_all").on("click", ".edit", function() {

        $("#modal_data").empty();
        $('.modal-title').text('Edit Students'); // Set Title to Bootstrap modal title

        var id = $(this).attr('id');

        $.ajax({
            url: 'students/' + id + '/edit',
            type: 'get',
            success: function(data) {
                $("#modal_data").html(data.html);
                $('#myModal').modal('show'); // show bootstrap modal
            },
            error: function(result) {
                $("#modal_data").html("Sorry Cannot Load Data");
            }
        });
    });

    $("#manage_all").on("click", ".view", function() {

        $("#modal_data").empty();
        $('.modal-title').text('View Students'); // Set Title to Bootstrap modal title

        var id = $(this).attr('id');
        // console.log(id);
        $.ajax({
            url: 'students/' + id,
            type: 'get',
            success: function(data) {
                $("#modal_data").html(data.html);
                $('#myModal').modal('show'); // show bootstrap modal
            },
            error: function(result) {
                $("#modal_data").html("Sorry Cannot Load Data");
            }
        });
    });

    $("#manage_all").on("click", ".password", function() {

        $("#modal_data").empty();
        $('.modal-title').text('Change Password'); // Set Title to Bootstrap modal title

        var id = $(this).attr('id');

        $.ajax({
            url: 'std_change_password/' + id,
            type: 'get',
            success: function(data) {
                $("#modal_data").html(data.html);
                $('#myModal').modal('show'); // show bootstrap modal
            },
            error: function(result) {
                $("#modal_data").html("Sorry Cannot Load Data");
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {

        $("#manage_all").on("click", ".delete", function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var id = $(this).attr('id');
            swal({
                title: "Are you sure?",
                text: "Becarefull student related all data will be deleted too!!",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                confirmButtonStudents: "btn-danger",
                confirmButtonText: "Delete",
                cancelButtonText: "Cancel"
            }, function() {
                $.ajax({
                    url: 'students/' + id,
                    data: {
                        "_token": CSRF_TOKEN
                    },
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(data) {

                        if (data.type === 'success') {

                            swal("Done!", "Successfully Deleted", "success");
                            reload_table();

                        } else if (data.type === 'danger') {

                            swal("Error deleting!", "Try again", "error");

                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal("Error deleting!", "Try again", "error");
                    }
                });
            });
        });
    });
</script>

<script type="text/javascript">
    $('#loaderSubmit').hide();

    $('#create').validate({ // <- attach '.validate()' to your form

        submitHandler: function(form) {
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
            }, function() {

                var myData = new FormData($("#create")[0]);
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                myData.append('_token', CSRF_TOKEN);


                $.ajax({
                    url: 'compulsorySubject',
                    data: myData,
                    type: 'POST',
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.type === 'success') {

                            swal("Done!", data.message, "success");
                            reload_table();
                        } else if (data.type === 'danger') {
                            swal("Error!", data.message, "error");
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal("Error!", "Try again", "error");
                    }
                });
            });
        }
    });
</script>
