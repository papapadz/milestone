@extends('layouts.nav')

@section('content')
<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">CEO Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">CEO</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
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
                        CEO
                    </div>
                    <div class="card">
                        <div class="card-header">
                            My Tasks
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead class="bg-warning">
                                    <tr>
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
        </div>
    </div>
</div>  
@endsection
