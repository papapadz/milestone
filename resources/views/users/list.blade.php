@extends('layouts.nav')

@section('content')
<div class="container-fluid">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                @if((Auth::user()->role == 'ceo')||(Auth::user()->role == 'manager'))
                <div class="col-sm-6">
                    <h1 class="m-0">Add Employee</h1>
                </div>
                @endif
                @if(Auth::user()->role == 'admin')
                <div class="col-sm-6">
                    <h1 class="m-0">User lists</h1>
                </div>
                @endif
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(Auth::user()->role == 'admin')
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        @endif
                        @if(Auth::user()->role == 'ceo')
                        <li class="breadcrumb-item"><a href="#">CEO</a></li>
                        @endif
                        @if(Auth::user()->role == 'manager')
                        <li class="breadcrumb-item"><a href="#">Manager</a></li>
                        @endif
                        <li class="breadcrumb-item active">Add Employee</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
    <!-- content-header -->
    <div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Active user lists
                    @if(Auth::user()->role == 'admin')
                        <a href="{{route('addUser')}}" class="btn btn-primary btn-sm float-right">Add new user</a>
                    @elseif(Auth::user()->role == 'ceo' || Auth::user()->role == 'manager')
                        <a href="{{route('addUser')}}" class="btn btn-primary btn-sm float-right">Add employee</a>
                    @endif
                </div>
                <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 15px">#</th>
                            <th>Name</th>
                            <th>email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ ucwords($row->firstname.' '.$row->lastname) }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->role == 'ceo' ? strtoupper($row->role) : ucwords($row->role) }}</td>
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

<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous">
</script>

<script>
    $(document).ready(function(){
        
    });
</script>
@endsection
