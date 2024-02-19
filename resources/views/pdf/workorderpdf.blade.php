@extends('layout.masterpdf')
@section('maincontent')
    <div class="container-sm" style="font-family: calibri">
        <div class="row">
            <div class="col">
                @foreach ($workorderList as $workorder)
                    <h2 class="mb-0" style="font-weight: bold"> JHAZEKE COMPUTER SHOP <span class="float-end">Job Order Slip</span> </h2>
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
                @endforeach
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm">
                <table class="table table-bordered border-dark table-custom">
                    <thead>
                        <tr>
                            <th class="text-center">Description</th>
                            <th class="text-center">Serial Number</th>
                            <th class="text-center">Password</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($workorderList as $workorder)
                                <td class="text-center">{{$workorder->device}} &nbsp; {{$workorder->model}}</td>
                                <td class="text-center">{{$workorder->serial}} </td>
                                <td class="text-center">{{$workorder->access}}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
                </div>
        </div>
        <br>
        <div class="row">
            @foreach ($workorderList as $workorder)
                <div class="col">
                    <p class="mb-0">Issue: {{$workorder->issue}}</p>
                    <p class="mb-0">Diagnostic: {{$workorder->diagnostic}}</p>
                    <p class="mb-2">Resolution Plan: {{$workorder->resolutionplan}} </p>
                    <p class="mb-0">Completion Date: {{$workorder->completion_date}}</p>
                    <p class="mb-0">Completion Time:  {{$workorder->completion_time}}</p>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-4 offset-8">
                <table class="table table-bordered border-dark table-custom">
                    <thead >
                        <tr>
                            <th class="text-center" colspan="2">Charges</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($workorderList as $workorder)
                        <tr>
                            <td>Labor Charge</td>
                            <td class="text-end">{{$workorder->labor_charges}}</td>
                        </tr>
                        <tr>
                            <td>Parts/Software Cost</td>
                            <td class="text-end"> {{$workorder->software_cost}}</td>
                        </tr>
                        <tr>
                            <td>Miscellaneous Expenses</td>
                            <td class="text-end"> {{$workorder->miscellaneous_expense}}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Total</td>
                            <td class="fw-bold text-end"> {{$workorder->total_cost}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row">
            <p>Customer Signature: ___________________________________</p>
        </div>
        <br>
        <div class="row">
            <p class="text-center" style="color: gray">--------- I agree that all work has been performed to my satisfaction ---------</p>
        </div>
        <hr>
    </div>

@endsection
