@extends('backend.layouts.master')
@section('title', 'Make Bills')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="panel-title">
                        Make Bill
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="form-group row">

                                <div class="col-md-5">
                                    <select  id="class_id" class="form-control"
                                        onchange="get_sections(this.value)">
                                        <option value="" selected disabled>Select a class</option>
                                        @foreach($stdclass as $class)
                                            <option value="{{$class->id}}">{{$class->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-5">
                                    <select class="form-control"  id="section_id">
                                        <option value="" selected disabled>Select a section</option>
                                    </select>
                                </div>

                                <div class="form-group  col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-3 mb-lg-0">
                                    <button type="button" class="btn  btn-success form-control"
                                            onclick="getBillmodal()">Make Bill
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
        
        .bill-container{
            position:absolute; 
            padding: 5px;
            margin: 5px;
            left:0px; 
            bottom:100%; 
            z-index:999;
            background-color:#85C1E9;
        }

        .bill-menu{
            position: relative;
            width: 250px;
            height: auto;
            box-sizing: border-box;
        }

        .bill-menu-item {
            text-align: left;
            cursor: pointer;
            border-radius: 5px;
            font-size:20px;
            font-weight: 400;
            z-index: 999;
        }

        .bill-menu-item:hover {
            background: #F0F6F8;
            /* font-size: large; */
            /* margin: 5px; */
        }

        .bill-menu::after {
            position: absolute;
            width:20px;
            height: 20px;
            top: 100%;
            left: 30%;
            /* margin-left:30px; */
            content: '';
            transform: rotate(45deg);
            background-color:white;
            margin-top:-1px;
            z-index: -1;
        }
    </style>
    <script>

        function smsCreate() {
            ajax_submit_smsCreate('students');
        }
    </script>
    <script>
        document.body.classList.add("sidebar-collapse");
        $("#export_excel").hide();
        $("#export_pdf").hide();

        var div = document.getElementById('students_content');
        div.style.visibility = 'hidden';

        function getBillmodal() {

            var class_id = $("#class_id").val();
            var section_id = $("#section_id").val();
            var class_name = $("#class_id option:selected").text();
            var section = $("#section_id option:selected").text();

            if (class_id != null && section_id != null) {

                $("#not_found").hide();

                var div = document.getElementById('students_content');
                div.style.visibility = 'visible';
                $('#manage_all').DataTable().clear();
                $('#manage_all').DataTable().destroy();


                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                table = $('#manage_all').DataTable({
                    dom: "<'row'<'col-sm-4'l><'col-sm-8'f>>" +
                    "<'row'<'col-sm-12'>B>" + //
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-4'i><'col-sm-8'p>>",
                    processing: true,
                    serverSide: true,
                    pageLength: 50,
                    ajax: {
                        "url": '{!! route('admin.allStudents') !!}',
                        "type": "POST",
                        "data": {
                            "class_id": class_id, "section_id": section_id,
                            "class_name": class_name, "section": section,
                            "_token": CSRF_TOKEN
                        },
                        "dataType": 'json'
                    },
                    "initComplete": function (settings, json) {
                        // $("#export_excel").show();
                        // $("#export_pdf").show();
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'std_code', name: 'std_code'},
                        {data: 'std_name', name: 'std_name'},
                        // {data: 'std_session', name: 'std_session'},
                        {data: 'class_name', name: 'class_name'},
                        {data: 'section_name', name: 'section_name'},
                        {data: 'roll', name: 'roll'},
                        {data: 'action', name: 'action'}
                    ],
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-table"> EXCEL </i>',
                            titleAttr: 'Excel',
                            exportOptions: {
                                columns: ':visible:not(.not-exported)'
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            title: "{!! $app_settings->name  !!} \n Students Information \n",
                            text: '<i class="fa fa-file-pdf-o"> PDF</i>',
                            titleAttr: 'PDF',
                            filename: 'Students',
                            exportOptions: {
                                columns: ':visible'
                            },
                            customize: function (doc) {
                                doc.content[1].table.headerRows = 0
                                doc.pageMargins = [100, 10, 20, 10];
                                doc.defaultStyle.fontSize = 9;
                                doc.styles.tableHeader.fontSize = 9;
                                doc.styles.title.fontSize = 14;
                                // Remove spaces around page title
                                doc.content[0].text = doc.content[0].text.trim();
                                doc['footer'] = (function (page, pages) {
                                    return {
                                        columns: [
                                            '{{ $app_settings->name }}',
                                            {
                                                // This is the right column
                                                alignment: 'right',
                                                text: ['page ', {text: page.toString()}, ' of ', {text: pages.toString()}]
                                            }
                                        ],
                                        margin: [10, 0]
                                    }
                                });
                            }
                        },
                        {
                            extend: 'print',
                            title: "<div class='text-center'>{!! $app_settings->name  !!} <br/> Students Information </div>",
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
                    "columnDefs": [
                        {"className": "text-center", "targets": "_all"}
                    ],
                    "autoWidth": false,
                });
                $('.dataTables_filter input[type="search"]').attr('placeholder', 'Type here to search...').css({
                    'width': '220px',
                    'height': '30px'
                });
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
                    url: '/getSections/' + val,
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
                url: '/students/create',
                success: function (data) {
                    $("#modal_data").html(data.html);
                    $('#myModal').modal('show'); // show bootstrap modal
                },
                error: function (result) {
                    $("#modal_data").html("Sorry Cannot Load Data");
                }
            });

        }

        
        $("#manage_all").on("click", ".edit", function () {

            $("#modal_data").empty();
            $('.modal-title').text('Edit Students'); // Set Title to Bootstrap modal title

            var id = $(this).attr('id');

            $.ajax({
                url: 'students/' + id + '/edit',
                type: 'get',
                success: function (data) {
                    $("#modal_data").html(data.html);
                    $('#myModal').modal('show'); // show bootstrap modal
                },
                error: function (result) {
                    $("#modal_data").html("Sorry Cannot Load Data");
                }
            });
        });
 

        $("#manage_all").on('click', '.bill', function() {
            // console.log(this);
            var student_id = $(this).attr('id');

            if( $('.btn-group').has('.bill-menu').length == 0) {
                $(this).parents(".btn-group").append(`
                <div class="bill-container shadow p-3 mb-2 bg-white rounded" style="">
                    <div class="bill-menu">
                      <div  class="create_bill bill-menu-item" id="${student_id}"><i class="fas fa-money-bill-alt"></i>  Bill</div>
                      <div  class="bills_histories bill-menu-item" id="${student_id}"><i class="fas fa-file-invoice"></i>  Bills history</div>
                      <div  class="transactions bill-menu-item" id="${student_id}"><i class="fas fa-credit-card"></i> All Transactions</div>
                    <div>
                </div>`);
            } else {
                $(this).siblings(".bill-container").remove();
            }

        });

        $("#manage_all").on('click', ".create_bill", function() {
            $("#modal_data_sm").empty();
            $('.modal-title').text('Edit bill');

            var student_id = $(this).attr('id');
            var class_id = $("#class_id").val();
            console.log(student_id);

            $.ajax({
                url: 'bills/create',
                type: 'get',
                data: {
                    'student_id' : student_id, 
                    'std_class_id': class_id,
                },
                success: function (data) {
                    $("#modal_data_sm").html(data.html);
                    $('#my_modal_sm').modal('show');
                },
                error: function (result) {
                    $("#modal_data_sm").html("Sorry Cannot Load Data");
                }
            })
        });

        $("#manage_all").on('click', ".bills_histories", function() {
            $("#modal_data_sm").empty();
            $('.modal-title').text('All Bills');
            var student_id = $(this).attr('id');
            var class_id = $("#class_id").val();

            $.ajax({
                url: 'bills',
                type: 'get',
                data: {
                    'student_id' : student_id, 
                    'std_class_id': class_id,
                },
                success: function (data) {
                    $("#modal_data_sm").html(data.html);
                    $('#my_modal_sm').modal('show');
                },
                error: function (result) {
                    $("#modal_data_sm").html("Sorry Cannot Load Data");
                }
            })
        });

        $("#manage_all").on("click", ".transactions", function() {
            $("#modal_data_sm").empty();
            $('.modal-title').text('All Trasactions');
            var student_id = $(this).attr('id');
            var class_id = $("#class_id").val();
            
            $.ajax({
                url: 'transactions',
                type: 'get',
                data: {
                    'student_id': student_id,
                },
                success: function (data) {
                    $("#modal_data_sm").html(data.html);
                    $("#my_modal_sm").modal('show');
                },                
                error: function (result) {
                    $("#modal_data_sm").html("Sorry Cannot Load Data");
                }
            })
        });

        $("#manage_all").on("click", ".view", function () {

            $("#modal_data").empty();
            $('.modal-title').text('View Students'); // Set Title to Bootstrap modal title

            var id = $(this).attr('id');

            $.ajax({
                url: 'students/' + id,
                type: 'get',
                success: function (data) {
                    $("#modal_data").html(data.html);
                    $('#myModal').modal('show'); // show bootstrap modal
                },
                error: function (result) {
                    $("#modal_data").html("Sorry Cannot Load Data");
                }
            });
        });

        $("#manage_all").on("click", ".password", function () {

            $("#modal_data").empty();
            $('.modal-title').text('Change Password'); // Set Title to Bootstrap modal title

            var id = $(this).attr('id');

            $.ajax({
                url: 'std_change_password/' + id,
                type: 'get',
                success: function (data) {
                    $("#modal_data").html(data.html);
                    $('#myModal').modal('show'); // show bootstrap modal
                },
                error: function (result) {
                    $("#modal_data").html("Sorry Cannot Load Data");
                }
            });
        });

    </script>
    <script type="text/javascript">

        $(document).ready(function () {

            $("#manage_all").on("click", ".delete", function () {
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
                }, function () {
                    $.ajax({
                        url: 'students/' + id,
                        data: {"_token": CSRF_TOKEN},
                        type: 'DELETE',
                        dataType: 'json',
                        success: function (data) {

                            if (data.type === 'success') {

                                swal("Done!", "Successfully Deleted", "success");
                                getStudents();

                            } else if (data.type === 'danger') {

                                swal("Error deleting!", "Try again", "error");

                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            swal("Error deleting!", "Try again", "error");
                        }
                    });
                });
            });
        });

    </script>
@stop
