@extends('layout.master')
@section('title','User')
@section('maincontent')
<div class="container px-4">
    <h1 class="mt-4">User Profile</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">User Profile</li>
    </ol>
    <div class="row">

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Users
            </div>
            <div class="card-body  table-responsive">
                <div class="col-6 col-sm-2 mt-2">
                    <a href="{{route("user.create")}}" class="card bg-primary text-white mb-4" style="text-decoration: none;">
                        <div class="card-body">
                            <i class="fa-sharp fa-light fa-users"></i> Add User
                        </div>
                    </a>
                </div>
                <hr>
                <table id="datatablesSimple" class="table table-hover table-sm ">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created at</th>
                            <th style='text-align:center'>Edit</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($userList as $user )
                            <tr>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at}}</td>
                                <td style='text-align:center'> <a href="{{route('user.edit',['id'=>$user->id])}}"> <i class="fa-solid fa-pen-to-square" title="Edit"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

</div>

    <script>

        new DataTable("#datatablesSimple");

    </script>

@endsection
