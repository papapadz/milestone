@extends('layouts.nav')

@section('content')
<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{request()->is('product/*/edit') ? 'Update product' : 'Add product'}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(Auth::user()->role == 'ceo')
                        <li class="breadcrumb-item"><a href="#">CEO</a></li>
                        @endif
                        @if(Auth::user()->role == 'manager')
                        <li class="breadcrumb-item"><a href="#">Manager</a></li>
                        @endif
                        <li class="breadcrumb-item active">Add Account</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Complete Milling </div>
                    <div class="card-body">
                        <form class="form" action="{{route('toMillUpdate', request()->route()->id)}}" method="post">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control" value="{{$toMill->product->name}}" readonly>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" value="{{$toMill->product->quantity .' '.$toMill->product->unit}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rice">Rice quantity</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="number" class="form-control @error('riceQty') is-invalid @enderror" name="riceQty">
                                        @error('riceQty')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <select class="form-control company-dropdown @error('riceUnit') is-invalid @enderror" name="riceUnit" id="exampleFormControlSelect1">
                                            <option disabled>--Select Unit--</option>
                                            <option {{isset($product) && $product->unit == 'kilogram' ? 'selected' : '' }} value="kilogram">kilogram</option>
                                            <option {{isset($product) && $product->unit == 'sacks' ? 'selected' : '' }} value="sacks">sacks</option>
                                            <option {{isset($product) && $product->unit == 'tons' ? 'selected' : '' }} value="tons">tons</option>
                                        </select>
                                        @error('riceUnit')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rice">Darak quantity</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" class="form-control @error('darakQty') is-invalid @enderror" name="darakQty">
                                        @error('darakQty')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <select class="form-control company-dropdown @error('darakUnit') is-invalid @enderror" name="darakUnit" id="exampleFormControlSelect1">
                                            <option disabled>--Select Unit--</option>
                                            <option {{isset($product) && $product->unit == 'kilogram' ? 'selected' : '' }} value="kilogram">kilogram</option>
                                            <option {{isset($product) && $product->unit == 'sacks' ? 'selected' : '' }} value="sacks">sacks</option>
                                            <option {{isset($product) && $product->unit == 'tons' ? 'selected' : '' }} value="tons">tons</option>
                                        </select>
                                        @error('darakUnit')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-warning">Complete Milling</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</div>
@endsection
