@extends('layout.master')
@section('title','User')
@section('maincontent')

    <div class="container px-4">
        <h1 class="mt-4">Daily Report</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daily Report</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                History - Work Order - Claimed
            </div>
            <div class="card-body table-responsive">
                <form action="{{route("dailyreport.workorder.search")}}" method="GET">
                    <div class="row">
                        <div class="col-6 col-sm-3">
                            <label class="form-check-label"  style="cursor: pointer">Start Date:</label>
                            <input type="date" name="workorder_start_date" id="workorder_start_date" class="form-control form-control-sm "   onkeydown="EnterKey(event, 'workorder_end_date')" required/>
                        </div>
                        <div class="col-6 col-sm-3">
                            <label class="form-check-label"  style="cursor: pointer">End Date:</label>
                            <input type="date" name="workorder_end_date" id="workorder_end_date" class="form-control form-control-sm " onkeydown="EnterKey(event, 'workorder_search')" required/>
                        </div>
                        <div class="col-auto align-self-end">
                            <button type="submit" id="workorder_search" class="btn btn-primary mt-2" ><i class="fas fa-search" title="Print"></i>&nbsp; Search</button>
                        </div>
                    </div>
                </form>
                <hr>
                <table id="datatable_Workorder_History" class="table table-hover table-sm ">
                    <thead>
                        <tr>
                            <th >Number</th>
                            <th >Name</th>
                            <th >Contact</th>
                            <th>Device</th>
                            <th>Model</th>
                            <th style='text-align:center'>Claim Date</th>
                            <th style='text-align:center'>Amount</th>
                            <th style='text-align:center'>View</th>
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
                                <td style='text-align:center'>{{\Carbon\Carbon::parse($workorder->status_at)->format('Y-m-d')}}</td>
                                <td style='text-align:right'>₱ {{number_format($workorder->total_cost, 2, '.',',')}}</td>
                                <td style='text-align:center; cursor: pointer;'><a data-id="{{ $workorder->workorder_id }}" class="page-link link-primary" ><i class="fas fa-file" title="View"></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class="container px-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                History - Receivables - Paid
            </div>
            <div class="card-body table-responsive">
                <form action="{{route("dailyreport.receivable.search")}}" method="GET">
                    <div class="row">
                        <div class="col-6 col-sm-3">
                            <label class="form-check-label"  style="cursor: pointer">Start Date:</label>
                            <input type="date" name="receivable_start_date" id="receivable_start_date" class="form-control form-control-sm "   onkeydown="EnterKey(event, 'receivable_end_date')" required/>
                        </div>
                        <div class="col-6 col-sm-3">
                            <label class="form-check-label"  style="cursor: pointer">End Date:</label>
                            <input type="date" name="receivable_end_date" id="receivable_end_date" class="form-control form-control-sm " onkeydown="EnterKey(event, 'receivable_search')" required/>
                        </div>
                        <div class="col-auto align-self-end">
                            <button type="submit" id="receivable_search" class="btn btn-primary mt-2" ><i class="fas fa-search" title="Print"></i>&nbsp; Search</button>
                        </div>
                    </div>
                </form>
                <hr>
                <table id="datatable_Receivable_History" class="table table-hover table-sm ">
                    <thead>
                        <tr>
                            <th >Work Order</th>
                            <th >Name</th>
                            <th >Contact</th>
                            <th >Device</th>
                            <th >Model</th>
                            <th >Created Date</th>
                            <th style='text-align:center'>Amount</th>
                            <th style='text-align:center'>View</th>
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
                                <td>{{\Carbon\Carbon::parse($payment->workorder_created_at)->format('Y-m-d')}}</td>
                                <td style='text-align:right'>₱ {{number_format($payment->total_cost, 2, '.',',')}}</td>
                                <td style='text-align:center; cursor: pointer;'><a data-id="{{ $payment->workorder_desc }}"  class="page-link link-primary" ><i class="fas fa-file" title="View"></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>

        </div>
    </div>




    {{--  View_Receivables modal  --}}
    <div class="modal fade" id="Modal_View_Receivables" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="form_View_Receivables_modal" >
                    <div class="modal-header">
                        <h5 class="modal-title" name='modal_view_receivables_name'>Name:  <span name='modal_view_receivables_name' id="modal_view_receivables_name"></span></h5>
                        <h5 class="modal-title" name='modal_view_receivables_work_number'>Order Number:  <span name='modal_view_receivables_work_number' id="modal_view_receivables_work_number"></span></h5>
                    </div>
                    <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                        <div class="container">
                            <table id="datatable_View_Receivables" class="table table-hover table-sm ">
                                <thead>
                                    <tr>
                                        <th >Date/Time</th>
                                        <th >Voucher</th>
                                        <th style='text-align:right'>Debit</th>
                                        <th style='text-align:right'>Credit</th>
                                        <th style='text-align:right'>Running</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{--  AJAX Query build updateTable  --}}
                                </tbody>
                            </table>
                            <div id="ajax-spinner" class="spinner-border text-secondary" role="status" style="display: none; position: absolute; top: 50%; left: 50%; ">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" style="justify-content: flex-start;" id="modal_view_receivables_submit" >Convert to PDF</button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal"  onclick="view_receivables_Modal()">Cancel</button>
                    </div>

                 </form>
            </div>
        </div>
    </div>





    <script>


        var glblid = '';

        function EnterKey(event, nextInputId) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById(nextInputId).focus();
            }
        }

        function view_receivables_Modal() {
            $('#Modal_View_Receivables').modal('hide');
        }


        function getCurrentTime() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        function getCurrentDate()
        {
            const now = new Date();
            var value = now.toISOString().split('T')[0];
            return value;
        }

        function getPreviousDate()
        {
            const now = new Date();
            now.setMonth(now.getMonth() - 1);
            var value = now.toISOString().split('T')[0];
            return value;
        }

        window.addEventListener('load', function (){

            const urlParams = new URLSearchParams(window.location.search);
            //alert(urlParams);
            const startDateParam = urlParams.get('workorder_start_date');
            const endDateParam = urlParams.get('workorder_end_date');

            $('#workorder_start_date').val(startDateParam || getPreviousDate());
            $('#workorder_end_date').val(endDateParam || getCurrentDate());

        });

        new DataTable("#datatable_Workorder_History");

        $('#datatable_Workorder_History').on('click', '.page-link', function(e){

            var dataId  = $(this).data('id');
            var url_data = "{{ route('dailyreport.workorder.generate', ['id' => ':id']) }}";
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


        window.addEventListener('load', function (){

            const urlParams = new URLSearchParams(window.location.search);
            //alert(urlParams);
            const startDateParam = urlParams.get('receivable_start_date');
            const endDateParam = urlParams.get('receivable_end_date');

            $('#receivable_start_date').val(startDateParam || getPreviousDate());
            $('#receivable_end_date').val(endDateParam || getCurrentDate());

        });

        new DataTable("#datatable_Receivable_History");

        $('#datatable_Receivable_History').on('click', '.page-link', function(){
            $('#Modal_View_Receivables').modal('show');
        });

        $('#datatable_Receivable_History').on('click', '.page-link', function(e){
            e.preventDefault();
            var dataId  = $(this).data('id');
            var url_data = "{{ route('dailyreport.receivable.view', ['id' => ':id']) }}";
            url_data = url_data.replace(':id', dataId);

            //alert(url_data);
            $.ajax({

                url: url_data,
                method: 'GET',
                data: { },
                beforeSend: function(){
                    $('#ajax-spinner').show();
                },
                success: function(response){
                    //console.log(response);
                    $('#ajax-spinner').hide();

                    $('#modal_view_receivables_work_number').text(response.receivableList[0]['workorder_desc']).prop('readonly',true);
                    $('#modal_view_receivables_name').text(response.receivableList[0]['name']).prop('readonly',true);
                    glblid = response.receivableList[0]['workorder_desc'];

                    updateTable(response);

                },

            });


        });

        function updateTable(data) {

            var tbody = $('#datatable_View_Receivables tbody');
            tbody.empty();

            data.runningBalanceList.forEach(function (item){

                var newRow = '<tr>' +
                    '<td>' + item.created_at + '</td>' +
                    '<td>' + item.voucher + '</td>' +
                    '<td style="text-align:right"> ' + number_format(item.debit, 2, '.', ',') + '</td>' +
                    '<td style="text-align:right"> ' + number_format(item.credit, 2, '.', ',') + '</td>' +
                    '<td style="text-align:right"> ' + number_format(item.running_balance, 2, '.', ',') + '</td>' +
                    '</tr>';

                 tbody.append(newRow);

            });
        }

        function number_format(number, decimals, dec_point, thousands_sep) {
            number = parseFloat(number);
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };

            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }

            return s.join(dec);
        }


        $('#form_View_Receivables_modal').on('submit',function(e){
            e.preventDefault();

            var url_data = "{{route("dailyreport.soa.generate",['id' => ':id' ])}}"
            url_data = url_data.replace(':id', glblid);
            $.ajax({

                url: url_data,
                method: 'GET',
                data: { },
                success: function(response){
                    //console.log(response);
                    var newWindow = window.open(response.url);
                        if (!newWindow) {
                            alert('Popup blocked! Please allow popups and try again.');
                        }
                },

            });

        });

    </script>

@endsection
