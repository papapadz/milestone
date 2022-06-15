@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                <div class="login-box">
                    <div class="container-fluid">
                        <h1 class="text-white">LOGIN</h1>
                        <form class="form" action="{{route('login')}}" method="POST">
                        @csrf
                            <div class="login-textbox">
                                <input placeholder="Email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}">
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="login-textbox">
                                <input class="form-control @error('email') is-invalid @enderror" type="password" placeholder="Password" name="password">
                                @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="login-textbox">
                                <a class="text-danger" href="{{route('password.request')}}">
                                    Forgot Password?
                                </a>
                            </div>
                            <div class="login-textbox">
                                <button class="btn">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-2">
                <img src="images/LandingPage.png">
            </div>
        </div>
    </div>
@endsection
