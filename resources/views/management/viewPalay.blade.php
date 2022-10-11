@extends('layouts.nav')

@section('content')
<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">View Palay</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(Auth::user()->role == 'ceo')
                        <li class="breadcrumb-item"><a href="#">CEO</a></li>
                        @endif
                        @if(Auth::user()->role == 'manager')
                        <li class="breadcrumb-item"><a href="#">Manager</a></li>
                        @endif
                        <li class="breadcrumb-item active">Add Account</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div> <!--/.content-header -->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        List of Palays
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-warning">
                                <tr>
                                    <th>ID</th>
                                    <th>Variant</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($palay) == 0)
                                <tr>
                                    <span class="d-flex justify-content-center bg-danger">
                                        No Active Palays
                                    </span>
                                </tr>
                                @endif
                                @if(count($palay) != 0)
                                @foreach($palay as $row)
                                <tr>
                                    <td> {{$row->id}} </td>
                                    <td> {{$row->name}} </td>
                                    <td> {{$row->quantity}} {{$row->unit}} </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
