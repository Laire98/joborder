@extends('layout.master')
@section('title','Customer')
@section('maincontent')
    <div class="container px-4">
        <h1 class="mt-4">Customer Profile</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Customer Profile</li>
        </ol>
        <div class="row">

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Customers
                </div>
                <div class="card-body  table-responsive">
                    <div class="col-6 col-sm-2 mt-2">
                        <a href="{{route("customer.create")}}" class="card bg-primary text-white mb-4" style="text-decoration: none;">
                            <div class="card-body">
                                <i class="fa-sharp fa-light fa-users"></i> Add Customer
                            </div>
                        </a>
                    </div>
                    <hr>
                    <table id="datatablesSimple" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th style='text-align:center'>Edit</th>
                                {{--  <th>Remove</th>  --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customerList as $customer )
                                <tr>
                                    <td>{{$customer->name}}</td>
                                    <td>{{$customer->contact}}</td>
                                    <td>{{$customer->email}}</td>
                                    <td>{{$customer->address}}</td>
                                    <td style='text-align:center'> <a href="{{route('customer.edit',['id'=>$customer->id])}}"> <i class="fa-solid fa-pen-to-square" title="Edit"></i></a></td>
                                    {{--  <td> <i class="fa-solid fa-trash"></i></td>  --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

    <script>

        new DataTable("#datatablesSimple");

    </script>

@endsection
