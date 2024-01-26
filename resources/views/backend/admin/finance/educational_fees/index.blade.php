@extends('backend.layouts.master')
@section('title', 'Section')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
                </div>
                <div>All Fees</div>
                <div class="d-inline-block ml-2">
                    @can('educational-fee-create')
                        <button class="btn btn-success" onclick="create()"><i
                                class="glyphicon glyphicon-plus"></i>
                                Assign Fee
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="manage_all" class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Class Name</th>
                                <th>Head Name</th>
                                <th>Amount(/-)</th>
                                <th>Session</th>
                                <th>Created At </th>
                                <th>Updated At</th>
                                <th>Action </th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        @media screen and (min-width: 768px) {
            #myModal .modal-dialog {
                width: 80%;
                border-radius: 5px;
            }
        }

        #not_found {
            margin-top: 30px;
            z-index: 0;
        }
    </style>

    <script>
        $(function () {
            table = $('#manage_all').DataTable({
                    processing: true,
                    serverSide: true,
                    pageLength: 50,
                    ajax: "{{ route('admin.educational-fees.index') }}",
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {data: 'class_name', name: 'class_name'},
                        {data: 'name', name: 'name'},
                        {data: 'amount', name: 'amount'},
                        {data: 'session', name: 'session'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'updated_at', name: 'updated_at'},
                        {data: 'action', name: 'action'}
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
            });
    </script>
    <script type="text/javascript">

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax
        }


        function create() {

            $("#modal_data_sm").empty();
            $('.modal-title').text('Add New Fees'); // Set Title to Bootstrap modal title

            $.ajax({
                type: 'GET',
                url: 'educational-fees/create',
                success: function (data) {
                    $("#modal_data_sm").html(data.html);
                    $('#my_modal_sm').modal('show'); // show bootstrap modal
                },
                error: function (result) {
                    $("#modal_data_sm").html("Sorry Cannot Load Data");
                }
            });

        }


        $("#manage_all").on("click", ".edit", function () {

            $("#modal_data_sm").empty();
            $('.modal-title').text('Edit Head Income'); // Set Title to Bootstrap modal title

            var id = $(this).attr('id');

            $.ajax({
                url: 'educational-fees/' + id + '/edit',
                type: 'get',
                success: function (data) {
                    $("#modal_data_sm").html(data.html);
                    $('#my_modal_sm').modal('show'); // show bootstrap modal
                },
                error: function (result) {
                    $("#modal_data_sm").html("Sorry Cannot Load Data");
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
                    text: "Deleting of a assigned fee!!",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Delete",
                    cancelButtonText: "Cancel"
                }, function () {
                    $.ajax({
                        url: 'educational-fees/' + id,
                        data: {"_token": CSRF_TOKEN},
                        type: 'DELETE',
                        dataType: 'json',
                        success: function (data) {

                            if (data.type === 'success') {
                                swal("Done!", "Successfully Deleted", "success");
                                reload_table();
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
