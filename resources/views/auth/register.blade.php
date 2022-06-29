@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form class="form" action="{{route('register')}}" method="post">
                        @csrf
                        <!-- firstname -->
                        <div class="employee-textbox">
                            <label for="firstname">Firstname</label>
                            <input class="form-control @error('firstname') is-invalid @enderror" placeholder="firstname" type="text"  name="firstname" value="{{old('firstname')}}">
                            @error('firstname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- lastname -->
                        <div class="employee-textbox">
                            <label for="lastname">Lastname</label>
                            <input class="form-control @error('lastname') is-invalid @enderror" placeholder="lastname" type="text"  name="lastname" value="{{old('lastname')}}">
                            @error('lastname')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!-- role -->
                        <input type="text" value="employee" name="role" hidden>
                        <!-- email -->
                        <div class="employee-textbox">
                            <label for="email">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" placeholder="email" type="email"  name="email" value="{{old('email')}}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> 
                        <!-- company -->
                        <div class="employee-textbox" id="company-dropdown">
                            <label for="company">Company</label>
                            <select class="form-control company-dropdown @error('company') is-invalid @enderror" name="company" value="{{old('company')}}" id="exampleFormControlSelect1">
                                <option disabled selected>--Select Company--</option>
                                @foreach($company as $row)
                                <option value="{{$row->id}}"> {{$row->name }} </option>
                                @endforeach
                            </select>
                            @error('company')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="employee-textbox">
                            <label for="age">Age</label>
                            <input class="form-control @error('age') is-invalid @enderror" placeholder="Age" type="number"  name="age" value="{{old('age')}}">
                            @error('age')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="employee-textbox">
                            <label for="contact_no">Contact No</label>
                            <input class="form-control @error('contact_no') is-invalid @enderror" placeholder="09xxxxxxxxx" type="number"  name="contact_no" value="{{old('contact_no')}}">
                            @error('contact_no')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="employee-textbox">
                            <label for="address">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" placeholder="Your Personal Address" name="address">{{old('address')}}</textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="employee-textbox" id="company-dropdown">
                            <label for="gender">Gender</label>
                            <select class="form-control company-dropdown @error('gender') is-invalid @enderror" name="gender" value="{{old('gender')}}" id="exampleFormControlSelect1">
                                <option disabled selected>--Select Gender--</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="gay">Gay</option>
                                <option value="lesbian">Lesbian</option>
                                <option value="bixesual">Bisexual</option>
                                <option value="NA">Choose not to disclose</option>
                            </select>
                            @error('gender')
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
@endsection
