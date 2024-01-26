<form id='edit_bill' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8" class="needs-validation"
      novalidate>
    <div id="status"></div>
    <input type="hidden" id="bill_id" name="bill_id" value="{{ $bill->id }}">
    <div class="container">

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="form-group">
                    <h6 for="income_head_ids">Income Head<span style="color: red;">*</span></h6>
                    <ul class="list-group">
                        @foreach($educationalFees as $educationalFee)
                        <li class="list-group-item"> 
                            <div class="d-flex justify-content-between">
                                <div>{{$educationalFee->incomeHead->name}}</div>
                                <div>
                                    @if(in_array($educationalFee->incomeHead->id, $selected_items_id))
                                    <input style="width:25px; height:25px;" data-name="{{$educationalFee->incomeHead->name}}" data-amount="{{ $educationalFee->amount}}"  type="checkbox" class="income_head" name="" value="{{$educationalFee->incomeHead->id }}" checked>
                                    @else
                                    <input style="width:25px; height:25px;" data-name="{{$educationalFee->incomeHead->name}}" data-amount="{{ $educationalFee->amount}}" type="checkbox" class="income_head" name="" value="{{$educationalFee->incomeHead->id }}">
                                    @endif
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="items row">
        
        </div>
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="std_class_id" value="{{ $std_class_id }}">
                <input type="hidden" name="student_id" value="{{ $student_id }}">

                <div class="modal-footer" style="background-color: white; border:none">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success button-submit"
                                data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Save
                        </button>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
   $(document).ready(function () {

        var billDetails = {!! json_encode($selected_items) !!};
        var head_items = []; 

        $('select').select2();
        $('#loader').hide();
    
        billDetails.forEach(billDetail => {
            var id = billDetail.id;
            var name = billDetail.name;
            var amount = billDetail.amount;
            var discount = billDetail.discount;
            var item = `
                <div id="item_${id}" class="col-md-12 col-sm-12">
                        <div class="row shadow p-3 mb-5 bg-white rounded">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="amount_${id}">${name}<span style="color:red;">*</span></label>
                                <input type="number" class="form-control" id="amount_${id}" name="amount_${id}" value="${amount}" required>
                                <input type="hidden" name="income_head_${id}" value="${id}">
                                <span id="error${name}_amount" class="has-error"></span>
                            </div>
                    
                            <div class="form-group col-md-6 col-ms-12" style="margin-top:8px;">
                                <lable for="">Discount</label>
                                <input type="number" class="form-control" id="" name="discount_${id}" value="${discount}"/>
                            <div>
                        </div>
                </div>
            `;
            $('.items').append(item);
            head_items.push(id);
        });

        $('.income_head').click(function() {
            
            if($(this).prop('checked')) {
                var id = $(this).val();
                var name = $(this).data('name');
                var amount = $(this).data('amount');
                var item = `
                    <div id="item_${id}" class="col-md-12 col-sm-12">
                            <div class="row shadow p-3 mb-5 bg-white rounded">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="amount_${id}">${name}<span style="color:red;">*</span></label>
                                    <input type="number" class="form-control" id="amount_${id}" name="amount_${id}" value="${amount}" required>
                                    <input type="hidden" name="income_head_${id}" value="${id}">
                                    <span id="error${name}_amount" class="has-error"></span>
                                </div>
                        
                                <div class="form-group col-md-6 col-ms-12" style="margin-top:8px;">
                                    <lable for="">Discount</label>
                                    <input type="number" class="form-control" id="" name="discount_${id}"/>
                                <div>
                            </div>
                    </div>
                `;
                $('.items').append(item);
                head_items.push(id);
            } else {
                    
                var income_head_id = $(this).val();
                var bill_id = $('#bill_id').val();
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                swal({
                    title: "Are you sure?",
                    text: "Deleting of a bill !!",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Delete",
                    cancelButtonText: "Cancel"
                }, function () {
                    $('#item_' + income_head_id).remove();
                    head_items = $.grep(head_items, function(value) {
                    return value != income_head_id;
                    });

                    $.ajax({
                        url: 'bills/billDetails',
                        data: {
                            "_token": CSRF_TOKEN, 
                            "bill_id": bill_id,
                            'income_head_id': income_head_id
                        },
                        type: 'DELETE',
                        dataType: 'json',
                        success: function (data) {
                    
                        if (data.type === 'success') {

                        swal("Done!", data.message , "success");

                        } else if (data.type === 'danger') {

                        swal("Error deleting!", data.message, "error");

                        }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            swal("Error deleting!", "Try again", "error");
                        }
                    });
                });
            }
        });

        
        $('.button-submit').click(function() { 
            $('#edit_bill').validate({
    
                submitHandler: function (form) {
                    var bill_id = $('#bill_id').val();
                    var myData = new FormData($("#edit_bill")[0]);                    
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    myData.append('_token', CSRF_TOKEN);
                    myData.append('income_head_ids', head_items);
    
                    $.ajax({
                        url: 'bills/' + bill_id,
                        type: 'POST',
                        data: myData,
                        dataType: 'json',
                        cache: false,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $('body').plainOverlay('show');
                        },
                        success: function (data) {
                            if (data.type === 'success') {
                                notify_view(data.type, data.message);
    
                                $('#loader').hide();
                                $(".button-submit").prop('disabled', false); // disable button
                                $("html, body").animate({scrollTop: 0}, "slow");
                                $('#my_modal_sm').modal('hide'); 
                                $('body').plainOverlay('hide');// hide bootstrap modal
    
                            } else if (data.type === 'error') {
                                if (data.errors) {
                                    $.each(data.errors, function (key, val) {
                                        $('#error_' + key).html(val);
                                    });
                                }
                                $("#status").html(data.message);
                                $('#loader').hide();
                                $(".button-submit").prop('disabled', false); 
                                $('body').plainOverlay('hide');
                            }
                        }
                    });
                }
            });  
        });

    });
</script>
