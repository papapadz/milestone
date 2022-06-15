@extends('layouts.nav')

@section('content')
<div class="container-fluid">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Products</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(Auth::user()->role == 'ceo')
                        <li class="breadcrumb-item"><a href="#">CEO</a></li>
                        @endif
                        @if(Auth::user()->role == 'manager')
                        <li class="breadcrumb-item"><a href="#">Manager</a></li>
                        @endif
                        <li class="breadcrumb-item active">Supply</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Suppliers
                        <a href="{{ route('addNewSupplier') }}" class="mr-2 btn btn-sm btn-warning float-right">
                            <i class="nav-icon fa-solid fas fa-plus"></i> New Supplier
                        </a> 
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-warning">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Supplier name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th style="width:15px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suppliers as $row)
                                    <tr>
                                        <td class="text-center">{{$row->id}}</td>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->email}}</td>
                                        <td>{{$row->address}}</td>
                                        <td>
                                            @if($row->active == 1)
                                            <span class="badge bg-success">active</span>
                                            @else
                                            <span class="badge bg-warning">inactive</span>
                                            @endif
                                        </td>
                                        <td><a href="{{route('editSupplier', $row->id)}}" class="text-orange"><i class="fa fa-edit"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
