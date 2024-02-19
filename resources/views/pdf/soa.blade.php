@extends('layout.masterpdf')
@section('maincontent')
    <div class="container-sm" style="font-family: calibri">
        <div class="row">
            <div class="col">
                @foreach ($workorderList as $workorder)
                    <h2 class="mb-0" style="font-weight: bold"> JHAZEKE COMPUTER SHOP <span class="float-end">Statement of Account</span> </h2>
                    <p class="mb-0">BRGY.4 CORDERO ST., KABANKALAN CITY </p>
                    <span class="float-end">Work Order No: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$workorder->workorder_desc}}</span>
                    <p class="mb-0">09630865616</p>
                    <p class="mb-0 float-end">Work Order Date: &nbsp; {{$workorder->start_date}}</p>
                @endforeach
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col">
                @foreach ($workorderList as $workorder)
                <p class="mb-0"><br></p>
                <span class="mb-0 float-end">Contact: {{$workorder->contact}}</span>
                <p class="mb-0">Customer: {{$workorder->name}}</p>
                <span class="mb-0 float-end">Email: {{$workorder->email}}</span>
                <p class="mb-0">Address: {{$workorder->address}}</p>
                <p>Description: {{$workorder->description}} </p>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <table class="table table-bordered border-dark table-custom">
                    <thead>
                        <tr>
                            <th class="text-center">Date/Time</th>
                            <th class="text-center">Voucher</th>
                            <th class="text-center">Debit</th>
                            <th class="text-center">Credit</th>
                            <th class="text-center">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($runningBalanceList as $runningBalance)
                        <tr>
                                <td class="text-center">{{ $runningBalance['created_at'] }}</td>
                                <td class="text-center">{{ $runningBalance['voucher'] }}</td>
                                <td class="text-end">{{ number_format($runningBalance['debit'], 2, '.', ',') }}</td>
                                <td class="text-end">{{ number_format($runningBalance['credit'], 2, '.', ',') }}</td>
                                <td class="text-end">{{ number_format($runningBalance['running_balance'], 2, '.', ',') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
