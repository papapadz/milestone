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
                    <p style="text-align:center">Hassle-free and uncomplicated inventory and task management application  to kickstart  your business advancement. Make us part of your first milestone. Book a discovery call now!</p>
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
                            <small>We’re Milestone — a group of innovators that celebrates your first Milestone in embracing technology. Empowering you to engage and welcome development. SO LET US BECOME YOUR FIRST MILESTONE.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
