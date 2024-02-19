@extends('layout.master')
@section('title','Edit Customer')

@section('maincontent')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Customer</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route("customer")}}">Customer Profile</a></li>
        <li class="breadcrumb-item active">Edit Customer</li>
    </ol>
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
            <div class="card-body p-md-1">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                        @foreach ($customerList as $customer )
                        <form action="{{route("customer.modify",['id'=>$customer->id])}}" method="POST">
                            @csrf
                                <div class="d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <input type="text" name="name" class="form-control" value="{{$customer->name}}"  required/>
                                    <label class="form-label">Customer Name</label>
                                </div>
                                </div>

                                <div class="d-flex flex-row align-items-center mb-4">
                                    <i class="fas fa-phone fa-lg me-3 fa-fw"></i>
                                    <div class="form-outline flex-fill mb-0">
                                        <input type="numeric" name="contact" class="form-control" value="{{$customer->contact}}"  required/>
                                        <label class="form-label">Customer Contact</label>
                                    </div>
                                </div>

                                <div class="d-flex flex-row align-items-center mb-4">
                                <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                <div class="form-outline flex-fill mb-0">
                                    <input type="email" name="email" class="form-control" value="{{$customer->email}}" />
                                    <label class="form-label">Customer Email</label>
                                </div>
                                </div>

                                <div class="d-flex flex-row align-items-center mb-4">
                                    <i class="fas fa-map-marker-alt fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="address" name="address" class="form-control" value="{{$customer->address}}"  />
                                            <label class="form-label">Customer Address</label>
                                        </div>
                                </div>



                                <div class="d-grid gap-2  mb-3 mb-lg-6">
                                <button type="submit" class="btn btn-primary btn-lg" >Update</button>
                                </div>
                        </form>
                        @endforeach
                    </div>

                    <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                        <img src="{{asset('/image/register.png')}}" class="img-fluid" >
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection

