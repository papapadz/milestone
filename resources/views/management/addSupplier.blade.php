@extends('layouts.nav')

@section('content')
<div class="container">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Products</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(Auth::user()->role == 'ceo')
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">CEO</a></li>
                        @endif
                        @if(Auth::user()->role == 'manager')
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Manager</a></li>
                        @endif
                        <li class="breadcrumb-item active">Supply</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Suppliers
                        <a href="{{ route('suppliers') }}" class="mr-2 btn btn-sm btn-warning float-right">
                            <i class="nav-icon fa-solid fas fa-eye"></i> View Suppliers
                        </a> 
                    </div>
                    <div class="card-body">
                    <form class="form" action="{{request()->is('edit-supplier/*') ? route('editSupplier', request()->route()->id) : route('addNewSupplier')}}" method="post">
                            @csrf
                            <div class="employee-textbox mb-2">
                                <label for="name">Supplier Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" placeholder="Supplier Name" type="text" name="name" value="{{isset($supplier) ? $supplier->name : ''}}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="employee-textbox mb-2">
                                <label for="email">Email</label>
                                <input class="form-control @error('email') is-invalid @enderror" placeholder="admin@email.com" type="text" name="email" value="{{isset($supplier) ? $supplier->email : ''}}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="employee-textbox mb-2">
                                <label for="contact_no">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" cols="30" rows="3">{{isset($supplier) ? $supplier->address : ''}}</textarea>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @if(request()->is('edit-supplier/*') && (Auth::user()->role != 'employee'))
                            <div class="employee-textbox">
                                <label for="contact_no">Status</label>
                                <select name="active" class="form-control">
                                    <option value="1" {{isset($supplier) && $supplier->active == 1 ? 'selected' : ''}}>Active</option>
                                    <option value="0" {{isset($supplier) && $supplier->active == 0 ? 'selected' : ''}}>Inactive</option>
                                </select>
                            </div>
                            @endif 
                            <div class="employee-textbox mt-4">
                                <button type="submit" class="btn btn-warning">{{request()->is('edit-supplier/*') ? 'Update supplier' : 'Save supplier'}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
