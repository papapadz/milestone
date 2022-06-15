@extends('layouts.nav')

@section('content')
<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Task</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(Auth::user()->role == 'ceo')
                        <li class="breadcrumb-item"><a href="#">CEO</a></li>
                        @endif
                        @if(Auth::user()->role == 'manager')
                        <li class="breadcrumb-item"><a href="#">Manager</a></li>
                            @endif
                        <li class="breadcrumb-item active">Task</li>
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
                        TASKS
                        <a href="{{ route('addTask') }}" class="mr-2 btn btn-sm btn-warning float-right">
                            <i class="nav-icon fa-solid fas fa-plus"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-warning">
                                <tr>
                                    <th>Assigned to</th>
                                    <th>Task</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($task) == 0)
                                <span class="d-flex justify-content-center bg-danger">
                                    No Active Task
                                </span>
                                @endif
                                @if(count($task) != 0)
                                @foreach($task as $row)
                                <tr>
                                    <td> {{$row->user->firstname}} {{$row->user->lastname}} </td>
                                    <td> {{$row->name}} </td>
                                    <td> {{$row->status == 1 ? 'In Progress...' : 'Completed' }} </td>
                                    @if($row->status == 1)
                                    <td>
                                        <a class="btn btn-warning" href="{{url('update-task/'.$row->id)}}">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    </td>
                                    @endif
                                    @if($row->status == 0)
                                    <td>
                                        <a class="btn btn-danger" href="{{url('update-task/'.$row->id)}}">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        IN PROGRESS
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-warning">
                                <tr>
                                    <th>Assigned To</th>
                                    <th>Task</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($onprogress) == 0)
                                <span class="d-flex justify-content-center bg-danger">
                                    No On Going Tasks
                                </span>
                                @endif
                                @if(count($onprogress) != 0)
                                @foreach($onprogress as $row)
                                <tr>
                                    <td> {{$row->user->firstname}} {{$row->user->lastname}} </td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->updated_at}}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        COMPLETED
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-warning">
                                <tr>
                                    <th>Assigned to</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($completed) == 0)
                                <span class="d-flex justify-content-center bg-danger">
                                    No Completed Tasks
                                </span>
                                @endif
                                @if(count($completed) != 0)
                                @foreach($completed as $row)
                                <tr>
                                    <td>{{$row->user->firstname}} {{$row->user->lastname}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->updated_at}}</td>
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
