<div class="col-md-12 col-sm-12 table-responsive">
     <input type="hidden" id="student_id" value="{{ $student_id }}">
     <input type="hidden" id="std_class_id" value="{{ $std_class_id }}">
    <table id="bills_table" class="table table-collapse table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Bill No</th>
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
    table = $('#bills_table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            ajax:{
              url : "{{ route('admin.allBills') }}",
              data : {
                'student_id' : student_id
              },
              type: 'GET'
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'bill_no', name: 'bill_no'},
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

    
    function reload_table() {
      table.ajax.reload(null, false); //reload datatable ajax
    }

   
    
    $("#bills_table").on("click", ".edit", function () {

      $("#modal_data_sm").empty();
      $('.modal-title').text('Edit bill'); // Set Title to Bootstrap modal title

      var id = $(this).attr('id');
      var std_class_id = $("#class_id").val();

      // var std_class_id = $('#std_class_id').val();
      // console.log(std_class_id);
      $.ajax({
          url: 'bills/' + id + '/edit',
          type: 'get',
          data : { 'std_class_id': std_class_id },
          success: function (data) {
              $("#modal_data_sm").html(data.html);
              $('#my_modal_sm').modal('show'); // show bootstrap modal
          },
          error: function (result) {
              $("#modal_data_sm").html("Sorry Cannot Load Data");
          }
      });
    });


    $("#bills_table").on("click", ".billDetails", function () {
      $("#modal_data_sm").empty();
      $('.modal-title').text('Bill Details');

      var id = $(this).attr('id');

      $.ajax({
        url: 'bills/' + id,
        type: 'get',
        success: function (data) {
          $("#modal_data_sm").html(data.html);
          $("#my_modal_sm").modal('show');
        },
        error: function (data) {
          $("#modal_data_sm").html("Sorry Connot Load Data");
        }
      })
    });

    $("#bills_table").on("click", ".delete", function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var id = $(this).attr('id');
        swal({
            title: "Are you sure?",
            text: "Deleting of a bill !! Be carefull deleting of a bill deletes all  data related with that bill. ",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Delete",
            cancelButtonText: "Cancel"
        }, function () {
            $.ajax({
                url: 'bills/' + id,
                data: {"_token": CSRF_TOKEN},
                type: 'DELETE',
                dataType: 'json',
                success: function (data) {
                if (data.type === 'success') {

                  swal("Done!", data.message , "success");
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
    
  </script>