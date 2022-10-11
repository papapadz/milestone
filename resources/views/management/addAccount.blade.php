@extends('layouts.nav')

@section('content')
<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Account</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(Auth::user()->role == 'ceo')
                        <li class="breadcrumb-item"><a href="#">CEO</a></li>
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
                        Add Account
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{route('storeAccount')}}" method="post">
                            @csrf
                            <div class="employee-textbox">
                                <label for="name">Company Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" placeholder="Company Name" type="text" name="name" value="{{old('name')}}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="employee-textbox">
                                <label for="email">Email</label>
                                <input class="form-control  @error('email') is-invalid @enderror" placeholder="admin@email.com" type="email" name="email" value="{{old('email')}}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="employee-textbox">
                                <label for="contact_no">Contact No</label>
                                <input class="form-control  @error('contact_no') is-invalid @enderror" placeholder="09123456789" type="number" name="contact_no" value="{{old('contact_no')}}">
                                @error('contact_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="employee-textbox">
                                <label for="address">Address</label>
                                <input class="form-control  @error('address') is-invalid @enderror" placeholder="Address" type="text" name="address" value="{{old('address')}}">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="employee-textbox">
                                <label for="contract_duration">Contract Duration</label>
                                <input class="form-control  @error('contract_duration') is-invalid @enderror" placeholder="1 year" type="text" name="contract_duration" value="{{old('contract_duration')}}">
                                @error('contract_duration')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div> <br>
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
