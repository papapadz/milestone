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
                            @if(Auth::user()->role == 'employee')
                                <li class="breadcrumb-item"><a href="#">Employee</a></li>
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
                    <div class="card-header">
                    {{request()->is('product/*/edit') ? 'Update '. $product->name : 'Add product'}}
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{request()->is('product/*/edit') ? route('updateProduct', request()->route()->id) : route('storePalay') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="variant">Variant @if(!isset($product->to_mill->id))<input id="newVariant" type="checkbox"><small><i>(New Variant)</i></small>@endif</label>

                                        <input id="variant1" disabled=true style="display: none" class="form-control @error('variant') is-invalid @enderror" placeholder="Product name" type="text" name="variant" value="{{isset($product) ? $product->name : ''}}">
                                        <select id="variant2" style="display: block" name="variant" class="form-control @error('variant') is-invalid @enderror">
                                            @forelse($variants as $variant)
                                            <option value="{{ $variant->variant }}">{{ $variant->variant }}</option>
                                            @empty
                                            <option disabled selected>No Record</option>
                                            @endforelse
                                        </select>
                                        @error('variant')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <label for="quantity">Quantity</label>
                                                <input class="form-control @error('quantity') is-invalid @enderror" placeholder="Quantity" type="number" name="quantity" value="{{isset($product) ? $product->quantity : ''}}">
                                                @error('quantity')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <label for="unit">Unit</label>
                                                <select class="form-control company-dropdown @error('unit') is-invalid @enderror" name="unit" id="exampleFormControlSelect1">
                                                    <option disabled>--Select Unit--</option>
                                                    <option {{isset($product) && $product->unit == 'kilogram' ? 'selected' : '' }} value="kilogram">kilogram</option>
                                                    <option {{isset($product) && $product->unit == 'sacks' ? 'selected' : '' }} value="sacks">sacks</option>
                                                    <option {{isset($product) && $product->unit == 'tons' ? 'selected' : '' }} value="tons">tons</option>
                                                </select>
                                                @error('unit')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col">
                                                <label for="date_ordered">Date Ordered </label>
                                                <input min="{{ Carbon\Carbon::now()->subYear()->toDateString() }}" class="form-control @error('date_ordered') is-invalid @enderror" placeholder="mm/dd/yyyy" type="date" value="{{isset($product) ? date('Y-m-d', strtotime($product->date_ordered)) : ''}}" name="date_ordered">
                                                @error('date_ordered')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <label for="date_delivered">Date Delivered </label>
                                                <input min="{{ Carbon\Carbon::now()->subYear()->toDateString() }}" class="form-control @error('date_delivered') is-invalid @enderror" placeholder="mm/dd/yyyy" type="date" value="{{isset($product) ? date('Y-m-d', strtotime($product->date_delivered)) : ''}}" name="date_delivered">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="supplier">Supplier</label>
                                        <select class="form-control @error('supplier') is-invalid @enderror" name="supplier">
                                            @foreach($suppliers as $row)
                                                <option value="{{$row->id}}">{{ucwords($row->name)}}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group" id="company-dropdown">
                                        <label for="moving">Moving</label>
                                        <select class="form-control company-dropdown @error('moving') is-invalid @enderror" name="moving" value="{{old('moving')}}" id="exampleFormControlSelect1">
                                            <option disabled selected>--Select Moving--</option>
                                            <option {{isset($product) && $product->moving == 'fast' ? 'selected' : '' }} value="fast">fast</option>
                                            <option {{isset($product) && $product->moving == 'slow' ? 'selected' : '' }} value="slow">slow</option>
                                        </select>
                                        @error('moving')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    @if(request()->is('product/*/edit'))
                                    <div class="form-group" id="company-dropdown">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="toMill" name="toMill" {{isset($product->to_mill->id) ? 'checked disabled' : ''}}>
                                            <label for="toMill">Mill product?</label>
                                        </div>
                                    </div>
                                    @if(isset($product->to_mill->id))
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col">
                                                    <span class="badge bg-success">This product has processed to mill.</span>
                                                </div>
                                                <div class="col">
                                                    <strong>Mill date:</strong> {{Carbon\Carbon::parse($product->to_mill->mill_date)->format('M d, Y')}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @endif
                                </div>
                            </div>

                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-warning">{{request()->is('product/*/edit') ? 'Update product' : 'Save and continue'}} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
$('#newVariant').on('click', function() {
   if($(this).is(':checked')) {
    $('#variant1').show()
    $('#variant1').prop('disabled',false)
    $('#variant2').hide()
    $('#variant2').prop('disabled',true)
   } else {
    $('#variant2').show()
    $('#variant2').prop('disabled',false)
    $('#variant1').hide()
    $('#variant1').prop('disabled',true)
   }

})
</script>
@endsection
