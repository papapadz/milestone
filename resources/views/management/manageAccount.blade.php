@extends('layouts.nav')

@section('content')
<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Account</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(Auth::user()->role == 'ceo')
                        <li class="breadcrumb-item"><a href="#">CEO</a></li>
                        @endif
                        @if(Auth::user()->role == 'manager')
                        <li class="breadcrumb-item"><a href="#">Manager</a></li>
                        @endif
                        @if(Auth::user()->role == 'employee')
                        <li class="breadcrumb-item"><a href="#">Employee</a></li>
                        @endif
                        <li class="breadcrumb-item active">Manage Account</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span>
                            Manage Account
                        </span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('postManageAccount') }}">
                            @csrf
                            <div class="employee-textbox">
                                <label for="current">Current Password</label>
                                <input class="form-control" placeholder="Current Password" type="password" name="current" value="{{old('current')}}">
                            </div>
                            <div class="employee-textbox">
                                <label for="new">New Password</label>
                                <input class="form-control @error('new') is-invalid @enderror" placeholder="New Password" type="password" name="new" value="{{old('new')}}">
                                @error('new') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="employee-textbox">
                                <label for="confirm">Confirm New Password</label>
                                <input class="form-control @error('new') is-invalid @enderror" placeholder="Confirm New Password" type="password" name="confirm" value="{{old('confirm')}}">
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