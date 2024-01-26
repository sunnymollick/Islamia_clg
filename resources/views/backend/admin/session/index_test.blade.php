@extends('backend.layouts.master')
@section('title', 'Sessions')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
                </div>
                <div>All Sessions</div>
                <div class="d-inline-block ml-2">
                    @can('vendor-create')
                        <button class="btn btn-success" onclick="create()"><i
                                class="glyphicon glyphicon-plus"></i>
                                New Session
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
                        <table id="manage_all"
                               class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                            <tr>
                                <th>#</th>

                                <th>Session Name</th>
                                <th>Status </th>
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
                width: 50%;
                border-radius: 5px;
            }
        }
    </style>

    <script>
        $(function () {
            table = $('#manage_all').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'admin/allSessions',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'}
                ],
                "columnDefs": [
                    {"className": "", "targets": "_all"}
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
        function create() {
            ajax_submit_create('sessions');
        }

        $(document).ready(function () {
            // View Form
            $("#manage_all").on("click", ".view", function () {
                var id = $(this).attr('id');
                ajax_submit_view('sessions', id);
            });
            
            //Edit Form
            $("#manage_all").on("click", ".edit", function() {
                var id = $(this).attr('id');
                ajax_submit_edit('sessions', id);
            });

            // Delete

            $("#manage_all").on("click", ".delete", function () {
                var id = $(this).attr('id');
                
                swal({
                    title: "Are you sure?",
                    text: "Deleted data cannot be recovered!!",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: true,
                    showLoaderOnConfirm: true,
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Delete"
                }, function () {
                    $.ajax({
                        url: 'sessions/' + id,
                        type: 'DELETE',
                        headers: {
                            "X-CSRF-TOKEN": CSRF_TOKEN
                        },
                        "dataType": 'json',
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

                    })
                })
            })

        })
    
    </script>