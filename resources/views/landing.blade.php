@extends('layouts.app')

@section('content')
    <section class="container-fluid">
        <div class="row pb-5">
            <div class="col-2">
                <h1 class="text-white">GOING<br>BEYOND<br>WITH<br>MILESTONE</h1>
                <a href="{{route('login')}}" class="btn" style="margin-left: 14%;">Get Started &#8594</a>
            </div>
            <div class="col-2">
                <img src="images/LandingPage.png">
            </div>
        </div>
        <div class="row bg-white">
            <div class="container pt-3">
                <div class="blog px-5 mx-5">
                    <h1>Track your Inventory and Manage your Team</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
            </div>

            <div class="blogphoto">
                <img src="images/SamplePage.png">
            </div>
            <div class="mockup">
                <div class="small-container"> 
                    <div class="row">
                        <div class="col-2">
                            <img src="images/MockUp.png" class="sample">
                        </div>
                        <div class="col-2">
                            <h1>About us</h1>
                            <small>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
