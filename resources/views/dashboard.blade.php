@extends('layout.master')

@section('title','Dashboard')
@section('maincontent')
    {{--  Work Orders  --}}
    <div class="container px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Work Orders:
            </div>
            <div class="card-body table-responsive">
                <table class="table caption-top table-hover" id="workorder_datatable">
                    <thead>
                        <tr>
                            <th >Number</th>
                            <th >Name</th>
                            <th >Contact</th>
                            <th>Device</th>
                            <th>Model</th>
                            <th style='text-align:center'>Start date</th>
                            <th style='text-align:center'>Amount</th>
                            <th style='text-align:center'>Status</th>
                            <th style='text-align:center'>View</th>
                            <th style='text-align:center'>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($workorderList as $workorder )
                        <tr>
                            <td>{{$workorder->workorder_desc}}</td>
                            <td>{{$workorder->name}}</td>
                            <td>{{$workorder->contact}}</td>
                            <td>{{$workorder->device}}</td>
                            <td>{{$workorder->model}}</td>
                            <td style='text-align:center'>{{$workorder->start_date}}</td>
                            <td style='text-align:right'>₱ {{number_format($workorder->total_cost, 2, '.',',')}}</td>
                            <td style='text-align:center; cursor: pointer;'><a data-id="{{ $workorder->workorder_id }}" class="page-link link-primary" > {{$workorder->status_desc}}</a></td>
                            <td style='text-align:center; cursor: pointer;'><a data-id="{{ $workorder->workorder_id }}" class="nav-link link-primary" ><i class="fas fa-file" title="View"></a></td>
                            <td style='text-align:center'><a href="{{route("workorder.edit",['id'=>$workorder->workorder_id])}}"> <i class="fa-solid fa-pen-to-square" title="Edit"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <hr>
    {{--  Payment  --}}
    <div class="container px-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Receivables:
            </div>
            <div class="card-body table-responsive">
                <table class="table caption-top table-hover" id="payment_datatable">
                    <thead>
                        <tr>
                            <th >Work Order</th>
                            <th >Name</th>
                            <th >Contact</th>
                            <th >Device</th>
                            <th >Model</th>
                            <th style='text-align:center'>Receivable</th>
                            <th style='text-align:center'>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paymentList as $payment )
                            <tr>
                                <td>{{$payment->workorder_desc}}</td>
                                <td>{{$payment->name}}</td>
                                <td>{{$payment->contact}}</td>
                                <td>{{$payment->device}}</td>
                                <td>{{$payment->model}}</td>
                                <td style='text-align:right'>₱ {{number_format($payment->balance, 2, '.',',')}}</td>
                                <td style='text-align:center'><a data-id="{{ $payment->workorder_id }}" class="page-link link-primary btn"> <i class="fa-solid fa-pen-to-square" title="payment"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>



    {{--  Status modal  --}}
    <div class="modal fade" id="StatusModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="status_modal_form">

                    <div class="modal-header">
                        <h5 class="modal-title">Order Number:  <span id="modal_work_number"></span></h5>
                    </div>
                    <div class="modal-body">
                            <div class="d-flex flex-row align-items-center mx-4 mt-3 mb-4">
                                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <input type="text" name="modal_name" id="modal_name" class="form-control" placeholder="Customer" value="" required/>
                                </div>
                            </div>

                            <div class="d-flex flex-row align-items-center mx-4 mt-3 mb-4">
                                <i class="fas fa-phone fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <input type="text" name="modal_contact" id="modal_contact" class="form-control" placeholder="Contact" value=""  required/>
                                </div>
                            </div>

                            <div class="d-flex flex-row align-items-center mx-4 mt-3 mb-4">
                                <i class="fas fa-desktop fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <input type="text" name="modal_info" id="modal_info" class="form-control" placeholder="Information" value="" required/>
                                </div>
                            </div>

                            <div class="d-flex flex-row align-items-center mx-4 mt-3 mb-4">
                                <i class="fas fa-money-check-alt fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <input type="text" name="modal_total" id="modal_total" class="form-control" placeholder="Total"  value="" required/>
                                </div>
                            </div>


                        <div class="d-flex flex-row align-items-center mx-4 mb-4">
                            <i class="fas fa-clipboard-check fa-lg me-3 fa-fw"></i>
                            <div class="flex-fill mb-0 position-relative">
                                <select name="modal_status" id="modal_status" class="form-control" style="cursor: pointer">
                                    @foreach ($statusList as $status )
                                        <option value="{{ $status->id }}">{{$status->status_desc}}</option>
                                    @endforeach
                                </select>
                                <div class="position-absolute top-50 end-0 translate-middle-y me-3">
                                    <i class="fas fa-caret-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" style="justify-content: flex-start;" id="modal_submit">Confirm</button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal"  onclick="statusModal()">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    {{--  Payments modal  --}}
    <div class="modal fade" id="PaymentsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="payments_modal_form">

                    <div class="modal-header">
                        <h5 class="modal-title" name='modal_payments_work_number'>Order Number:  <span name='modal_payments_work_number' id="modal_payments_work_number"></span></h5>
                    </div>
                    <div class="modal-body">
                            <div class="d-flex flex-row align-items-center mx-4 mt-2 mb-1">
                                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <label class="form-label">Name:</label>
                                    <input type="text" name="modal_payments_name" id="modal_payments_name" class="form-control  "  placeholder="Customer" value="" onkeydown="EnterKey(event, 'modal_payments_total')" readonly/>
                                </div>
                            </div>

                            <div class="d-flex flex-row align-items-center mx-4 mt-2 mb-1">
                                <i class="fas fa-file-invoice-dollar fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <label class="form-label">Total:</label>
                                    <input type="text" name="modal_payments_total" id="modal_payments_total" class="form-control" placeholder="Total"  value="" onkeydown="EnterKey(event, 'modal_payments_balance')" readonly/>
                                </div>
                            </div>

                            <div class="d-flex flex-row align-items-center mx-4 mt-2 mb-1">
                                <i class="fas fa-money-check-alt fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <label class="form-label">Balance:</label>
                                    <input type="text" name="modal_payments_balance" id="modal_payments_balance" class="form-control" placeholder="Balance"  value="₱ 0.00" onkeydown="EnterKey(event, 'modal_payments_cash')" readonly/>
                                </div>
                            </div>

                            <div class="d-flex flex-row align-items-center mx-4 mt-2 mb-1">
                                <i class="fas fa-wallet fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <label class="form-label">Cash Received:</label>
                                    <input type="text" name="modal_payments_cash" id="modal_payments_cash" class="form-control" placeholder="Cash Received"  value="₱ 0.00" onkeydown="EnterKey(event, 'modal_payments_change')" required/>
                                </div>
                            </div>

                            <div class="d-flex flex-row align-items-center mx-4 mt-2 mb-1">
                                <i class="fas fa-comments-dollar fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <label class="form-label">Change:</label>
                                    <input type="text" name="modal_payments_change" id="modal_payments_change" class="form-control" placeholder="Change"  value="₱ 0.00" onkeydown="EnterKey(event, 'modal_submit')" readonly/>
                                </div>
                            </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" style="justify-content: flex-start;" id="modal_submit">Confirm</button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal"  onclick="paymentsModal()">Cancel</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{--  Notification modal after submit  --}}
    <div class="modal fade" id="notifyModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Notification:</h5>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"  onclick="closeNotify()">Close</button>
                </div>
            </div>
        </div>
    </div>



    <script>

        function EnterKey(event, nextInputId) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById(nextInputId).focus();
            }
        }

        var glbl_url_id = null;

        new DataTable("#workorder_datatable");

        function closeNotify()
        {
             $('#notifyModal').modal('hide');
        }

        $('#workorder_datatable').on('click', '.page-link', function(){
            $('#StatusModal').modal('show');
        });

        function statusModal() {
            $('#StatusModal').modal('hide');
        }

        $('#workorder_datatable').on('click', '.page-link', function(e){
            e.preventDefault();

            var dataId  = $(this).data('id');
            var url_data = "{{ route('workorder.status', ['id' => ':id']) }}";
            url_data = url_data.replace(':id', dataId);

            //id send into global id
            glbl_url_id = dataId;

            // alert(dataId);
            $('#modal_name').val('').prop('readonly',true);
            $('#modal_contact').val('').prop('readonly',true);
            $('#modal_info').val('').prop('readonly',true);
            $('#modal_total').val('').prop('readonly',true);
            $('#modal_status').val('').prop('readonly',true);

            $.ajax({

                url: url_data,
                method: 'GET',
                data: { },
                success: function(response){

                   // console.log('Ajax response:', response.workorderList[0]['name']);
                    $('#modal_work_number').text(response.workorderList[0]['workorder_desc']).prop('readonly',true);
                    $('#modal_name').val(response.workorderList[0]['name']).prop('readonly',true);
                    $('#modal_contact').val(response.workorderList[0]['contact']).prop('readonly',true);
                    $('#modal_info').val(response.workorderList[0]['device']+' - '+ response.workorderList[0]['model'] ).prop('readonly',true);
                    $('#modal_total').val('₱ '+ response.workorderList[0]['total_cost'] ).prop('readonly',true);
                    $('#modal_status').val( response.workorderList[0]['status_id'] ).prop('readonly',true);

                },

            });
        });


        $('#status_modal_form').on('submit',function(e){
            e.preventDefault();

            if(e.originalEvent.submitter.id === "modal_submit")
            {
                var dataId  = glbl_url_id;
                var url_data = "{{ route('workorder.confirmation', ['id' => ':id']) }}";
                url_data = url_data.replace(':id', dataId);

                var formData = $('#status_modal_form').serialize();

                $.ajax({
                    url: url_data,
                    method: 'POST',
                    data: formData,
                    headers:
                        {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    success: function (response)
                    {
                        statusModal();
                        $('#notifyModal').modal('show');
                        $('#notifyModal .modal-body').text(response.message);

                        setTimeout( function (){
                            location.reload();
                        }, 1000);

                    },


                });
            }
        });

        new DataTable("#payment_datatable");

        $('#payment_datatable').on('click', '.page-link', function(){
            $('#PaymentsModal').modal('show');
        });

        function paymentsModal() {
            $('#PaymentsModal').modal('hide');
        }

        $('#payment_datatable').on('click', '.page-link', function(e){
            e.preventDefault();

            var dataId  = $(this).data('id');
            var url_data = "{{ route('payments.balance', ['id' => ':id']) }}";
            url_data = url_data.replace(':id', dataId);

            //id send into global id
            glbl_url_id = dataId;

            // alert(dataId);
            $('#modal_payments_name').val('').prop('readonly',true);
            $('#modal_payments_total').val('').prop('readonly',true);
            $('#modal_payments_balance').val('').prop('readonly',true);
            $('#modal_payments_cash').val('₱ 0.00').prop('readonly',false);
            $('#modal_payments_change').val('₱ 0.00').prop('readonly',true);

            setTimeout(function() {

                var modal_payments_cash = $('#modal_payments_cash');
                modal_payments_cash.focus();
                modal_payments_cash.on('focus',  function (){
                    this.select();
                });

            }, 500);

            $.ajax({

                url: url_data,
                method: 'GET',
                data: { },
                success: function(response){

                   // console.log('Ajax response:', response.workorderList[0]['name']);
                    $('#modal_payments_work_number').text(response.workorderList['workorder_desc']).prop('readonly',true);
                    $('#modal_payments_name').val(response.workorderList['name']).prop('readonly',true);
                    $('#modal_payments_total').val('₱ '+ response.balance['balance'] ).prop('readonly',true);
                    $('#modal_payments_balance').val('₱ '+ response.balance['balance'] ).prop('readonly',true);
                },

            });
        });

        $('input[name="modal_payments_cash"]').on('blur', function () {

            var total =  $('#modal_payments_total').val().replace(/[^\d.]/g, '');
            var inputValue = $(this).val().replace(/[^\d.]/g, '');
            if (inputValue === '' || isNaN(inputValue) || inputValue < 0) {
                $(this).val('₱ 0.00');
            }
            else
            {
                $(this).val('₱ ' + parseFloat(inputValue).toFixed(2));

                var change = inputValue - total;
                var balance = total - inputValue;

                if( parseFloat(inputValue) >= parseFloat(total))
                {
                    $('#modal_payments_change').val('₱ ' + parseFloat(change).toFixed(2));
                    $('#modal_payments_balance').val('₱ ' + parseFloat(0).toFixed(2));

                }
                else
                {
                    $('#modal_payments_change').val('₱ ' + parseFloat(0).toFixed(2));
                    $('#modal_payments_balance').val('₱ ' + parseFloat(balance).toFixed(2));
                }
            }

        });

        $('#payments_modal_form').on('submit',function(e){
            e.preventDefault();
            if(e.originalEvent.submitter.id === "modal_submit")
            {
                var url_data = "{{ route('payments.pay') }}";

                var formData = $('#payments_modal_form').serialize();
                var orderNumber = $('#modal_payments_work_number').text();
                    formData += '&modal_payments_work_number=' + encodeURIComponent(orderNumber);

                //alert(formData);

                $.ajax({
                    url: url_data,
                    method: 'POST',
                    data: formData,
                    headers:
                        {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    success: function (response)
                    {
                        paymentsModal();
                        $('#notifyModal').modal('show');
                        $('#notifyModal .modal-body').text(response.message);

                        setTimeout( function (){
                            location.reload();
                        }, 1000);

                    },


                });
            }

        });

        $('#workorder_datatable').on('click', '.nav-link', function(e){

             var dataId  = $(this).data('id');
             var url_data = "{{ route('dashboard.workorder.view', ['id' => ':id']) }}";
             url_data = url_data.replace(':id', dataId);

             $.ajax({

                 url: url_data,
                 method: 'GET',
                     data: { },
                     success: function(response){
                         console.log(response.data);

                         var newWindow = window.open(response.url);
                         if (!newWindow) {
                             alert('Popup blocked! Please allow popups and try again.');
                         }

                     },

                 });
         });


    </script>

@endsection
