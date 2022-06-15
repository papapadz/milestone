@extends('layouts.nav')

@section('content')
<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Task</h1>
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
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Add Task
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{route ('storeTask')}}" method="post">
                            @csrf
                            <div class="employee-textbox" id="company-dropdown">
                                <label for="employee">Task for</label>
                                <select class="form-control company-dropdown @error('employee') is-invalid @enderror" name="employee" value="{{old('employee')}}" id="exampleFormControlSelect1">
                                    <option disabled selected>--Select Employee--</option>
                                    @foreach($employee as $row)
                                    <option value="{{$row->user->id}}"> {{$row->user->firstname}} {{$row->user->lastname}} </option>
                                    @endforeach
                                </select>
                                @error('employee')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                            <div class="employee-textbox">
                                <label for="name">Task name</label>
                                <input class="form-control @error('name') is-invalid @enderror" placeholder="Tast name" type="text" name="name" value="{{old('name')}}">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                            <div class="employee-textbox">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" rows="4", cols="54" type="text" name="description">{{old('description')}}</textarea>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                            <br>
                            <div class="employee-textbox">
                                <button class="btn btn-warning">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
