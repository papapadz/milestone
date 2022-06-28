@extends('layouts.nav')

@section('content')
<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Notifications</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(Auth::user()->role == 'ceo')
                        <li class="breadcrumb-item"><a href="#">CEO</a></li>
                        @endif
                        @if(Auth::user()->role == 'manager')
                        <li class="breadcrumb-item"><a href="#">Manager</a></li>
                            @endif
                        <li class="breadcrumb-item active">Task</li>
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
                        Notifications
                        <a href="{{ route('addTask') }}" class="mr-2 btn btn-sm btn-warning float-right">
                            <i class="nav-icon fa-solid fas fa-plus"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-warning">
                                <tr>
                                    <th>Date</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notifications as $notif)
                                <tr 
                                    @if(!$notif->is_read)
                                        class="bg-primary"
                                    @endif
                                >
                                    <td>{{ Carbon\Carbon::parse($notif->created_at)->toDateTimeString() }}</td>
                                    <td>
                                        <b>
                                        @if(!$notif->sender)
                                            System
                                        @elseif($notif->sender_id==Auth::User()->id)
                                            You
                                        @else
                                            {{ $notif->sender->lastname }}, {{ $notif->sender->firstname }}
                                        @endif
                                        </b> |
                                        {{ $notif->message }}
                                    </td>
                                    <td>
                                        @if(!$notif->is_read)
                                        <a class="btn btn-xs btn-success" href="{{ route('notifications-read',['id'=>$notif->id]) }}">
                                            Mark as Read
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection