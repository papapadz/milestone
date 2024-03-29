@extends('layouts.nav')

@section('content')
<div class="container-fluid">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Products</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(Auth::user()->role == 'ceo')
                        <li class="breadcrumb-item"><a href="#">CEO</a></li>
                        @endif
                        @if(Auth::user()->role == 'manager')
                        <li class="breadcrumb-item"><a href="#">Manager</a></li>
                        @endif
                        <li class="breadcrumb-item active">Supply</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-5">
                <div class="card">
                    <div class="card-header">
                        PALAY INVENTORY
                        <a href="{{ route('viewPalay') }}" class="btn btn-sm btn-warning float-right">
                            <i class="nav-icon fa-solid fas fa-eye"></i> View all product
                        </a>
                        <a href="{{ route('addPalay') }}" class="mr-2 btn btn-sm btn-warning float-right">
                            <i class="nav-icon fa-solid fas fa-plus"></i> Add new product
                        </a>
                        <a href="{{ route('download-pdf') }}" class="mr-2 btn btn-sm btn-warning float-right">
                            <i class="nav-icon fa-solid fas fa fa-arrow-circle-down"></i> Export as PDF
                        </a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-warning">

                                <tr>
                                    <th class="text-center">ID</th>
                                    <th>Variant</th>
                                    <th>Quantity</th>
                                    <th>Supplier</th>
                                    <th>Date Ordered</th>
                                    <th>Date Delivered</th>
                                    <th>Moving</th>
                                    <th style="width:15px"></th>
                                </tr>

                            </thead>
                            <tbody>


                                @if(count($palay) == 0)
                                <span class="d-flex justify-content-center bg-danger">
                                    No Active Palays
                                </span>
                                @endif
                                @if(count($palay) != 0)
                                @foreach($palay as $row)


                                <tr>
                                    <td class="text-center"> {{$row->id}} </td>
                                    <td> {{$row->name}} </td>
                                    <td>
                                        {{number_format($row->quantity)}}
                                        <small>
                                        @if($row->unit == 'kilogram')
                                        kg
                                        @elseif($row->unit == 'sacks')
                                        sk
                                        @elseif($row->unit == 'tons')
                                        t
                                        @endif
                                        </small>
                                        <small>in stock</small>
                                    </td>
                                    <td>{{ucwords($row->supplier->name)}}</td>
                                    <td>{{Carbon\Carbon::parse($row->date_ordered)->format('M d, Y')}}</td>
                                    <td>{{Carbon\Carbon::parse($row->date_delivered)->format('M d, Y')}}</td>
                                    <td>
                                        @if($row->moving == 'fast')
                                        <span class="badge bg-success">Fast</span>
                                        @elseif($row->moving == 'slow')
                                        <span class="badge bg-danger">Slow</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!$row->to_mill || $row->to_mill->status!='complete')
                                            <a href="{{route('updateProduct', $row->id)}}" class="text-orange"><i class="fa fa-edit"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
