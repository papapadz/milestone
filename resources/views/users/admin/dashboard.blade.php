@extends('layouts.nav')

@section('content')
<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Admin Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
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
                        ALL ACCOUNTS
                        <button class="btn btn-sm btn-warning float-right">
                            <a href="{{ route('addAccount') }}">
                                <i class="nav-icon fa-solid fas fa-plus text-dark"></i>
                            </a>
                        </button>

                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Company Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Contact No</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($company) == 0)
                            <span class="d-flex justify-content-center bg-warning">
                                No Companies Active
                            </span>
                            @endif
                            @if(count($company) != 0)
                            @foreach($company as $row)
                                <tr>
                                    <td> {{$row->name}} </td>
                                    <td> {{$row->email}} </td>
                                    <td> {{$row->address}} </td>
                                    <td> {{$row->contact_no}} </td>
                                    <td> {{ $row->active == 1 ? "Active" : "Inactive"}} </td>
                                    @if($row->active == 1)
                                    <td>
                                        <a class="btn btn-danger" href="{{url('update-account/'.$row->id)}}">
                                            Unsubscribe
                                        </a>
                                    </td>
                                    @endif
                                    @if($row->active == 0)
                                    <td>
                                        <a class="btn btn-success" href="{{url('update-account/'.$row->id)}}">
                                            Subscribe
                                        </a>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div id="chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const chart = new Chartisan({
        el: '#chart',
        url: "@chart('simple_chart')"
    })
    </script>
@endsection