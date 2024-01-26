<div class="container" style="height: auto; transition:height 2s;">

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <h6 for="income_head_ids">Income Head<span style="color: red;">*</span></h6>
                <ul class="list-group">
                    @foreach($bill->billDetails as $billDetail)
                    <li class="list-group-item"> 
                        <div class="d-flex justify-content-between">
                            <div>{{$billDetail->incomeHead->name}}</div>
                            @if($billDetail->is_paid == 1) 
                                <div><input style="width:25px; height:25px;" data-amount="{{ $billDetail->payable }}"  type="checkbox" class="income_head" name="" value="{{$billDetail->id}}" checked disabled></div>
                            @else 
                                <div><input style="width:25px; height:25px;" data-amount="{{ $billDetail->payable }}"  type="checkbox" class="income_head" name="" value="{{$billDetail->id}}"></div>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @if($bill->billDetails()->count() > 0) 
    @php
        $totalDue = $previousBill->transaction->due ?? 0;
        $totalPayable = 0; 
    @endphp
    @foreach($bill->billDetails as $billDetail)
    @php 
        if (!$billDetail->is_paid) {
            $totalDue += $billDetail->payable;
        } else {
            $totalPayable += $billDetail->payable; 
        }
    @endphp
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="row shadow p-3 mb-5 bg-white rounded">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="amount">{{ $billDetail->incomeHead->name }}</label>
                    <input type="number" class="form-control" id="amount" name="" value="{{ $billDetail->payable ?? '' }}" readonly>
                </div>
        
                <div class="form-group col-md-6 col-ms-12" style="margin-top:8px;">
                    <lable for="">Discount</label>
                    <input type="number" class="form-control" id="" name="" value="{{ $billDetail->discount ?? ''}}" readonly/>
                <div>
            </div>
        </div> 
    </div>
    @endforeach
    <form id="make-pay" action="" class="row">
        <div class="col-md-12 col-sm-12">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="row shadow p-3 mb-5 bg-white rounded">
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="total_payable">Total:</label>
                            <input type="number" class="form-control text-info" id="total_payable" name="total_payable" value="{{ $bill->transaction->paid ?? $totalPayable }}" placeholder="{{ $totalPayable}}">
                        </div>
                
                        <div class="form-group col-md-6 col-ms-12" style="margin-top:8px;">
                            <lable for="total_due">Due:</label>
                            <input type="number" class="form-control text-warning" id="total_due" name="total_due" value="{{ $totalDue }}" placeholder="{{ $totalDue}}"/>
                        <div>
                        <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                    </div>
                </div> 
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="row shadow p-3 mb-5 bg-white rounded" >
                        <div class="form-group col-md-12 col-sm-12">
                            <label for="comment">Comment:</label>
                            <textarea  class="form-control" name="comment" id="comment"> {{ $bill->transaction->comment ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            @if (empty($bill->transaction))
            <div class="row d-flex justify-content-start">
                <div class="mr-3 text-warning">Print invoice ?</div>
            
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                    <input class="form-check-input ml-2" type="radio" name="is_pdf" id="inlineRadio1" value="1" checked>
                </div>
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="inlineRadio2">No</label>
                    <input class="form-check-input ml-2" type="radio" name="is_pdf" id="inlineRadio2" value="0">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="modal-footer" style="background-color: white; border:none">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                       
                        <button id="make-pay" type="submit" class="btn btn-success button-submit"
                                data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Make Payment
                        </button>
                        
                    </div>
                </div>
            </div>
            @endif
        </div>
    </form>
    @else
    <div class="row">
        <div class="col-md-12 sol-sm-12">
            <p class="text-warning">No bill details found!</p>
        </div>
    </div>
    @endif
</div>

<script>
    $(document).ready(function () {
    
        $('.income_head').click(function() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var is_paid;
            var id = $(this).val();
            var total_payable = $("#total_payable").val();
            var total_due = $("#total_due").val();

            if ($(this).prop('checked')) {
                is_paid = 1;
            } else {
                is_paid = 0;
            }

            $.ajax({
                url: 'billDetails/' + id,
                type: 'put',
                data: {
                    '_token': CSRF_TOKEN,
                    'is_paid': is_paid,
                    'total_payable': total_payable,
                    'total_due': total_due,  
                },
                success: function (data) {
                    if (data.type == 'success') {
                        $("#total_payable").val(data.amount.total_payable);
                        $("#total_due").val(data.amount.total_due);
                    }
                }
            })
        })

       
        $('#make-pay').validate({

            submitHandler: function (form) {
                var myData = new FormData($("#make-pay")[0]);
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                myData.append('_token', CSRF_TOKEN);

                $.ajax({
                    url: 'transactions',
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
                            $('#loader').hide();
                            $(".button-submit").prop('disabled', false); // disable button
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $("#status").html(data.message);

                            if (data.is_pdf == 1) {
                                window.location.href = "/admin/transactions/" + data.id;
                            }

                            $('#my_modal_sm').modal('hide'); 
                            $('body').plainOverlay('hide');// hide bootstrap modal

                        } else if (data.type === 'error') {
                            if (data.errors) {
                                $.each(data.errors, function (key, val) {
                                    $('#error_' + key).html(val);
                                });
                            }
                            $('#loader').hide();
                            $(".button-submit").prop('disabled', false); 
                            $('body').plainOverlay('hide');
                        }
                    }
                });
            }
            });  
        });
</script>