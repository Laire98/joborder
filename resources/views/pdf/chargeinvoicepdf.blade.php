@extends('layout.masterpdf')
@section('maincontent')
    <div class="container-sm" style="font-family: calibri">
        <div class="row ">
            <div class="col">
                @foreach ($chargeinvoiceList as $chargeinvoice)
                    <h2 class="mb-0" style="font-weight: bold"> JHAZEKE COMPUTER SHOP </h2>
                    <p class="mb-0">BRGY.4 CORDERO ST., KABANKALAN CITY  <span style="font-weight: bold" class="float-end">CHARGE INVOICE # {{$chargeinvoice->charge_desc}}</span></p>
                    <p class="mb-0">09630865616 <span class="mb-0 float-end">Printed: {{ now()->format('F j, Y') }}</span></p>
                @endforeach
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col">
                <span class="mb-1 float-end">Contact: {{ $chargeinvoice->contact }}</span>
                <p class="mb-1">Customer: {{ $chargeinvoice->name }}</p>
                <span  class="mb-1 float-end">TIN: {{ $chargeinvoice->tin }}</span>
                <p class="mb-1">Address: {{ $chargeinvoice->address }}</p>
                <p class="mb-1">Remarks: {{ $chargeinvoice->remarks }}</p>
            </div>
        </div>
        <br>
        <div class="row">
            <table class="table table-bordered border-dark ">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 7rem"> Quantity</th>
                        <th class="text-center" style="width: 6rem"> Unit</th>
                        <th class="text-center"> Articles</th>
                        <th class="text-center" style="width: 10rem"> Unit Price</th>
                        <th class="text-center" style="width: 12rem"> Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($chargeinvoice_detailList as $workorder_detail)
                    <tr>
                        <td class="text-center"> {{$workorder_detail->quantity}} </td>
                        <td class="text-center"> {{$workorder_detail->unit}} </td>
                        <td> {{$workorder_detail->articles}} </td>
                        <td class="text-end">₱ {{number_format($workorder_detail->price, 2, '.',',')}} </td>
                        <td class="text-end">₱ {{number_format($workorder_detail->total, 2, '.',',')}} </td>
                    </tr>
                    @endforeach
                    @foreach ($chargeinvoiceList as $chargeinvoice)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="font-weight: bold; background-color: rgb(255, 225, 0)" class=" text-center">Total</td>
                        <td style="font-weight: bold; background-color: rgb(255, 225, 0)" class="text-end">₱ {{number_format($chargeinvoice->grandtotal, 2, '.',',')}} </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <br>
        <div class="row">
            <div class="col-4">
                <table class="table table-bordered border-dark table-custom">
                    <thead>
                        <th class="px-4">VAT Analysis</th>
                        <th class="px-4">Amount</th>
                        <th class="px-4">VAT</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>NON-VAT Output</td>
                            <td></td>
                            <td class="text-end">0.00</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-end">0.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-4">
                <p>Prepared By:</p>
                <br>
                <br>
                <label>______________________________________</lab>
                <p class="text-center">{{auth()->user()->name}}</p>
            </div>
            <div class="col-4 offset-8">
                <p>Customer Representative:</p>
                <br>
                <br>
                <label>______________________________________</lab>
                <p class="text-center">Signature Over Printed Name</p>
            </div>
        </div>
    </div>

@endsection
