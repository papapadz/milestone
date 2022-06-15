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
                                <input class="form-control" placeholder="firstname" type="text" class="form-control emailbox p_input" name="firstname" value="{{old('firstname')}}">
                            </div>
                            <!-- lastname -->
                            <div class="employee-textbox">
                                <label for="lastname">Lastname</label>
                                <input class="form-control" placeholder="lastname" type="text" class="form-control emailbox p_input" name="lastname" value="{{old('lastname')}}">
                            </div>
                            <!-- role -->
                            @if(Auth::user()->role == 'admin')
                            <div class="employee-textbox" id="role-dropdown">
                                <label for="role">Role</label>
                                <select class="form-control role-dropdown" name="role" value="{{old('role')}}" id="exampleFormControlSelect1">
                                    <option value="null">--Select Role--</option>
                                    <option value="admin"> admin </option>
                                    <option value="ceo"> ceo </option>
                                </select>
                            </div>
                            @endif
                            @if((Auth::user()->role == 'ceo')||(Auth::user()->role == 'manager'))
                            <div class="employee-textbox" id="role-dropdown">
                                <label for="role">Role</label>
                                <select class="form-control role-dropdown" name="role" value="{{old('role')}}" id="exampleFormControlSelect1">
                                    <option value="null">--Select Role--</option>
                                    <option value="ceo"> ceo </option>
                                    <option value="employee"> employee </option>
                                    <option value="manager"> manager </option>
                                </select>
                            </div>
                            @endif 
                            <!-- email -->
                            <div class="employee-textbox">
                                <label for="email">Email</label>
                                <input class="form-control" placeholder="email" type="email" class="form-control emailbox p_input" name="email" value="{{old('email')}}">
                            </div> 
                            <!-- password -->
                            <div class="employee-textbox">
                                <label for="password">Password</label>
                                <input class="form-control" placeholder="password" type="text" class="form-control emailbox p_input" name="password" value="{{old('password')}}">
                            </div>
                            <!-- ceo input -->
                            <div class="ceo-input">
                                <!-- company -->
                                <div class="employee-textbox" id="company-dropdown">
                                    <label for="company">Company</label>
                                    <select class="form-control company-dropdown" name="company" value="{{old('company')}}" id="exampleFormControlSelect1">
                                        <option value="{{$company->company->id}}">{{$company->company->name}}</option>
                                    </select>
                                </div>
                                <div class="employee-textbox">
                                    <label for="age">Age</label>
                                    <input class="form-control" placeholder="Age" type="number" class="form-control emailbox p_input" name="age" value="{{old('age')}}">
                                </div>
                                <div class="employee-textbox">
                                    <label for="contact_no">Contact No</label>
                                    <input class="form-control" placeholder="09xxxxxxxxx" type="number" class="form-control emailbox p_input" name="contact_no" value="{{old('contact_no')}}">
                                </div>
                                <div class="employee-textbox">
                                    <label for="address">Address</label>
                                    <input class="form-control" placeholder="Your Personal Address" type="text" class="form-control emailbox p_input" name="address" value="{{old('address')}}">
                                </div>
                                <div class="employee-textbox" id="company-dropdown">
                                    <label for="gender">Gender</label>
                                    <select class="form-control company-dropdown" name="gender" value="{{old('gender')}}" id="exampleFormControlSelect1">
                                        <option value="null">--Select Gender--</option>
                                        <option value="male">male</option>
                                        <option value="female">female</option>
                                    </select>
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