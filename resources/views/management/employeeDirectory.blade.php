@extends('layouts.nav')

@section('content')
<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Employee Directory</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">CEO</a></li>
                        <li class="breadcrumb-item active">Employee Directory</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Employee Directory
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-warning">
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Fullname</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Position</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employee as $row)
                                <tr>
                                    <td> {{$row->id}} </td>
                                    <td> {{$row->user->firstname}} {{$row->user->lastname}} </td>
                                    <td> {{$row->user->email}} </td>
                                    <td> {{$row->contact_no}} </td>
                                    <td> {{$row->position}} </td>
                                </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</div>
@endsection
