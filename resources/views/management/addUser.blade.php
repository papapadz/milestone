@extends('layouts.nav')

@section('content')
<div class="container">
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
                    <h1 class="m-0">Add User</h1>
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
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    @if(Auth::user()->role == 'admin')
                    <div class="card-header">
                        Add User
                    </div>
                    @endif
                    @if((Auth::user()->role == 'ceo')||(Auth::user()->role == 'manager'))
                    <div class="card-header">
                        Add Employee
                    </div>
                    @endif
                    <div class="card-body">
                        <form class="form" action="{{route('storeEmployee')}}" method="post">
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
                            <div class="employee-textbox" id="role-dropdown">
                                <label for="role">Role</label>
                                <select class="form-control role-dropdown @error('role') is-invalid @enderror" name="role" value="{{old('role')}}" id="exampleFormControlSelect1">
                                    <option disabled selected>--Select Role--</option>
                                    @if(Auth::user()->role == 'admin')
                                        <option value="admin"> admin </option>
                                        <option value="ceo"> ceo </option>
                                    @elseif((Auth::user()->role == 'ceo')||(Auth::user()->role == 'manager'))
                                        <option value="ceo"> ceo </option>
                                        <option value="employee"> employee </option>
                                        <option value="manager"> manager </option>
                                    @endif
                                </select>
                                @error('role')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                            <!-- email -->
                            <div class="employee-textbox">
                                <label for="email">Email</label>
                                <input class="form-control @error('email') is-invalid @enderror" placeholder="email" type="email"  name="email" value="{{old('email')}}">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div> 
                            <!-- password -->
                            <div class="employee-textbox">
                                <label for="password">Password</label>
                                <input class="form-control @error('password') is-invalid @enderror" placeholder="password" type="password"  name="password" value="{{old('password')}}">
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                            <!-- ceo input -->
                            <div class="ceo-input">
                                <!-- company -->
                                <div class="employee-textbox" id="company-dropdown">
                                    <label for="company">Company</label>
                                    <select class="form-control company-dropdown @error('company') is-invalid @enderror" name="company" value="{{old('company')}}" id="exampleFormControlSelect1">
                                        <option disabled selected>--Select Account--</option>
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
                                    <input class="form-control @error('address') is-invalid @enderror" placeholder="Your Personal Address" type="text"  name="address" value="{{old('address')}}">
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
                                        <!-- <option value="gay">Gay</option>
                                        <option value="lesbian">Lesbian</option>
                                        <option value="bixesual">Bisexual</option> -->
                                        <option value="NA">Choose not to disclose</option>
                                    </select>
                                    @error('gender')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
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

<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous">
</script>

<script>
    $(document).ready(function(){
        $('.admin-input').hide();
        $('.ceo-input').hide();
        $( ".role-dropdown" ).on('change', function() {
            if($(this).val() == 'admin'){
                // console.log('admin');
                $('.ceo-input').hide();
            }
            if($(this).val() == 'ceo'){
                // console.log('admin');
                $('.ceo-input').show();
            }
            if($(this).val() == 'manager'){
                // console.log('admin');
                $('.ceo-input').show();
            }
            if($(this).val() == 'employee'){
                // console.log('admin');
                $('.ceo-input').show();
            }
        });
    });
</script>
@endsection
