@extends('layout.master')
@section('title','Add User')

@section('maincontent')
<div class="container-fluid px-4">
    <h1 class="mt-4">Add User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route("user")}}">User Profile</a></li>
        <li class="breadcrumb-item active">Add User</li>
    </ol>
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-12 col-xl-11">
            <div class="card-body p-md-1">
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                        <form action="{{route("user.store")}}" method="POST">
                            @csrf
                            <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required/>
                                <label class="form-label">Name</label>
                            </div>
                            </div>

                            <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required/>
                                <label class="form-label">Email</label>
                            </div>
                            </div>

                            <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input type="password" name="password" class="form-control" value="{{ old('password') }}" required/>
                                <label class="form-label">Password</label>
                            </div>
                            </div>

                            <div class="d-flex flex-row align-items-center mb-4">
                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input type="password" name="repeat_password" class="form-control" value="{{ old('repeat_password') }}"required/>
                                <label class="form-label">Repeat your password</label>
                            </div>
                            </div>

                            <div class="d-grid gap-2  mb-3 mb-lg-5">
                            <button type="submit" class="btn btn-primary btn-lg" >Register</button>
                            </div>

                        </form>
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

