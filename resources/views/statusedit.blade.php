@extends('layout.master')
@section('title','Status')
@section('maincontent')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Status</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{route("status")}}">Status</a></li>
            <li class="breadcrumb-item active">Edit Status</li>
        </ol>
        <div class="row d-flex justify-content-center align-items-center mb-5 h-100">

            <div class="card mx-3 col-md-10 col-lg-6 col-xl-5 order-1 order-lg-2" style="width: 30rem;" >
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    List of Status
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Status Description</th>
                                <th style='text-align:center'>Edit</th>
                            </tr>
                        </thead>
                        <tbody >
                            @foreach ($statusList as $status )
                                <tr>
                                    <td>{{$status->status_desc}}</td>
                                    <td style='text-align:center'> <a href="{{route('status.edit',['id'=>$status->id])}}"> <i class="fa-solid fa-pen-to-square" title="Edit"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mx-2  mb-5 col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1" style="width: 30rem;">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Edit Status
                </div>
                <div class="card-body ">
                    @foreach ($statusListEdit as $status )
                        <form action="{{route("status.modify",['id'=>$status->id])}}" method="POST">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="d-flex flex-row align-items-center mb-5">
                                    <i class="fas fa-clipboard-check fa-lg me-3 fa-fw"></i>
                                    <div class="form-outline flex-fill mb-0">
                                        <input type="text" name="status_desc" class="form-control" value="{{$status->status_desc}}" placeholder="Status Description" required/>
                                    </div>
                                </div>

                                <div class="d-grid gap-2  mb-3 mb-lg-6">
                                    <button type="submit" class="btn btn-primary btn-lg" >Update</button>
                                </div>
                            </div>
                        </form>
                    @endforeach

                </div>

            </div>

        </div>

    </div>




    <script>

        new DataTable("#datatablesSimple");

    </script>

@endsection
