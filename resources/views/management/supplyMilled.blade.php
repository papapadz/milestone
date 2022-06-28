@extends('layouts.nav')

@section('content')
<div class="container-fluid">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Milled Products</h1>
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
                       MILLED PRODUCTS
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-warning">
                                <tr>
                                    <th>ID</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th style="width:150px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($toMill as $row)
                                    <tr>
                                        <td>{{$row->id}}</td>
                                        <td>{{$row->product->name}}</td>
                                        <td>
                                            {{$row->product->quantity}}
                                            <small>
                                            @if($row->product->unit == 'kilogram')
                                            kg
                                            @elseif($row->product->unit == 'sacks')
                                            sk
                                            @elseif($row->product->unit == 'tons')
                                            t
                                            @endif
                                            </small>
                                        </td>
                                        <td>
                                            @if($row->status == 'in progress')
                                                <span class="badge bg-primary">{{$row->status }}</span>
                                            @elseif($row->status == 'complete')
                                               <span class="badge bg-success">{{$row->status }}</span>
                                            @elseif($row->status == 'pending')
                                                <span class="badge bg-danger">{{$row->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($row->status != 'complete')
                                                <a href="{{route('toMillUpdate', $row->id)}}" class="text-orange"><i class="fa fa-check-circle"></i> Mark as done</a>
                                            @elseif(!$row->is_sold)
                                                <a href="{{route('toMillSold', $row->id)}}" class="text-success"><i class="fa fa-check-circle"></i> Mark as sold</a>
                                            @else
                                                <span class="text-muted"><i class="fa fa-check-circle"></i> Sold {{ Carbon\Carbon::parse($row->updated_at)->toFormattedDateString() }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-5">
                <div class="card">
                    <div class="card-header">
                        RICE INVENTORY
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-warning">
                                <tr>
                                    <th style="width:25px;">ID</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th style="width:150px;">Date Produced</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rice as $row)
                                <tr>
                                    <td class="text-center">{{$row->id}}</td>
                                    <td>{{$row->product->name}}</td>
                                    <td>{{$row->quantity.' '.$row->unit}}</td>
                                    <td>{{Carbon\Carbon::parse($row->created_at)->format('M d, Y')}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 mb-5">
                <div class="card">
                    <div class="card-header">
                        DARAK INVENTORY
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="bg-warning">
                                <tr>
                                    <th style="width:25px;">ID</th>
                                    <th>Variant</th>
                                    <th>Quantity</th>
                                    <th style="width:150px;">Date Produced</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($darak as $row)
                                <tr>
                                    <td class="text-center">{{$row->id}}</td>
                                    <td>{{$row->product->name}}</td>
                                    <td>{{$row->quantity.' '.$row->unit}}</td>
                                    <td>{{Carbon\Carbon::parse($row->created_at)->format('M d, Y')}}</td>
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
