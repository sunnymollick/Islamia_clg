<div class="col-md-12 col-sm-12 table-responsive">
     <input type="hidden" id="student_id" value="{{ $student_id }}">
    <table id="transactions_table" class="table table-collapse table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Bill No</th>
            <th>Paid</th>
            <th>Due</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Action</th>
        </tr>
        </thead>
    </table>
</div>

<script>
    $(function () {
        var student_id = $('#student_id').val();
        table = $('#transactions_table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax:{
                url : "{{ route('admin.allTransactions') }}",
                data : {
                    'student_id' : student_id
                },
                type: 'GET'
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'bill_no', name: 'bill_no'},
                    {data: 'paid', name: 'paid'},
                    {data: 'due', name: 'due'},
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

        $('#transactions_table').on('click', '.make-invoice', function() {
           var bill_id = $(this).attr('id');
           window.location.href = "/admin/transactions/" + bill_id;
        });
    });

</script>