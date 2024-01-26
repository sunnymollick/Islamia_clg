@extends('backend.layouts.master')
@section('title', 'Teacher')
@section('content')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-users icon-gradient bg-mean-fruit"> </i>
                </div>
                <div>All Teachers</div>
                <div class="ml-2">
                    @can('teacher-create')
                        <button class="btn btn-success" onclick="create()"><i
                                class="glyphicon glyphicon-plus"></i>
                                New Teacher
                        </button>
                    @endcan
                    @can('teacher-create')
                        <button class="btn btn-success" onclick="smsCreate()"><i
                                class="glyphicon glyphicon-plus"></i>
                                Send sms
                        </button>
                    @endcan
                    @can('teacher-import')
                            <a href="{!! route('admin.importTeachers.import') !!}" class="btn btn-danger"
                               style="color: #fff;">Import Teachers</a>
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

                                <th>Teacher Name</th>
                                <th>Code</th>
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
                width: 70%;
                border-radius: 5px;
            }
        }
    </style>
    <script>
        $(function () {
            //alert("alert");
            table = $('#manage_all').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/admin/allTeachers',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'code', name: 'code'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'},
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
            ajax_submit_create('teachers');
        }

        function smsCreate() {
            ajax_submit_smsCreate('teachers');
        }

        $(document).ready(function () {
            // View Form
            $("#manage_all").on("click", ".view", function () {
                var id = $(this).attr('id');
                ajax_submit_view('teachers', id)
            });

            // Edit Form
            $("#manage_all").on("click", ".edit", function () {
                var id = $(this).attr('id');
                ajax_submit_edit('teachers', id)
            });


            // Delete
            $("#manage_all").on("click", ".delete", function () {
                var id = $(this).attr('id');
                ajax_submit_delete('teachers', id)
            });

        });

    </script>
@stop
