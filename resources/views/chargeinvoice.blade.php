@extends('layout.master')
@section('title','Charge Invoice')
@section('maincontent')

    <div class="container px-4">
        <h1 class="mt-4">Charge Invoice</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Charge Invoice</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
            List of Charge Invoices
            </div>
            <div class="card-body  table-responsive">
                <form action="{{route("chargeinvoice")}}" method="GET" >
                    <div class="row">
                        <div class="col-6 col-sm-3">
                            <label class="form-check-label"  style="cursor: pointer">Start Date:</label>
                            <input type="date" name="charge_start_date" id="charge_start_date" class="form-control form-control-sm "   onkeydown="EnterKey(event, 'charge_end_date')" required/>
                        </div>
                        <div class="col-6 col-sm-3">
                            <label class="form-check-label"  style="cursor: pointer">End Date:</label>
                            <input type="date" name="charge_end_date" id="charge_end_date" class="form-control form-control-sm " onkeydown="EnterKey(event, 'charge_search')" required/>
                        </div>
                        <div class="col align-self-end">
                            <button type="submit" id="charge_search" class="btn btn-primary" ><i class="fas fa-search" title="Print"></i>&nbsp; Search</button>
                        </div>
                        <div class="col-auto align-self-end">
                            <button type="button" id="charge_add" class="btn btn-success mt-2" ><i class="fa-sharp fa-light fa-users" title="Add Charge Invoice"></i>&nbsp; Add Charge Invoice</button>
                        </div>
                    </div>
                </form>
                <hr>
                <div>
                    <table class="table table-hover table-md" id="chargetable">
                        <thead>
                            <tr>
                                <th>Order No.</th>
                                <th>Customer</th>
                                <th style='text-align:center'>Created At</th>
                                <th style='text-align:right'>Grand Total</th>
                                <th style='text-align:center'>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($chargeinvoiceList as $chargeinvoice )
                            <tr>
                                <td>{{$chargeinvoice->charge_desc}}</td>
                                <td>{{$chargeinvoice->name}}</td>
                                <td style='text-align:center'>{{\Carbon\Carbon::parse($chargeinvoice->created_at)->format('Y-m-d') }}</td>
                                <td style='text-align:right'>₱ {{number_format($chargeinvoice->grandtotal, 2, '.',',')}}</td>
                                <td style='text-align:center; cursor: pointer;'><a data-id="{{ $chargeinvoice->charge_id }}" class="nav-link link-primary" ><i class="fas fa-file" title="View"></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script>
        new DataTable("#chargetable");

        function EnterKey(event, nextInputId) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById(nextInputId).focus();
            }
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
            const startDateParam = urlParams.get('charge_start_date');
            const endDateParam = urlParams.get('charge_end_date');

            $('#charge_start_date').val(startDateParam || getPreviousDate());
            $('#charge_end_date').val(endDateParam || getCurrentDate());

        });

        $('#charge_add').on('click',function (){
            window.location.href = '{{ route('chargeinvoice.add') }}';
        });

        $('#chargetable').on('click', '.nav-link', function(e){

            var dataId  = $(this).data('id');
            var url_data = "{{ route('chargeinvoice.preview', ['id' => ':id']) }}";
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
