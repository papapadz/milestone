<!doctype html>
<html lang="en">
<head>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<style>
    .page-break {
        page-break-after: always;
    }
</style>
<div class="container mt-5">
    <h2 class="text-center mb-md-5">PALAY INVENTORY</h2>
    <h4 class="text-center">as of {{ Carbon\Carbon::now()->toFormattedDateString() }}</h2>
    <table class="table table-bordered mb-5">
        <thead>
        <tr>
            <th>ID</th>
            <th>Variant</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Supplier</th>
            <th>Date Ordered</th>
            <th>Date Delivered</th>
            <th>Moving</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $prod)
            <tr>
                <td>{{$prod->id}}</td>
                <td>{{$prod->name}}</td>
                <td>{{$prod->quantity}}</td>
                <td>{{$prod->unit}}</td>
                <td>{{ucwords($prod->supplier->name)}}</td>
                <td>{{Carbon\Carbon::parse($prod->date_ordered)->format('M d, Y')}}</td>
                <td>{{Carbon\Carbon::parse($prod->date_delivered)->format('M d, Y')}}</td>
                <td>{{$prod->moving}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="page-break"></div>
<div class="container mt-5">
    <h2 class="text-center mb-3">MILL/MILLED PRODUCTS</h2>
    <h4 class="text-center">as of {{ Carbon\Carbon::now()->toFormattedDateString() }}</h2>
    <table class="table table-bordered mb-lg-5">
        <thead>
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>

        @foreach($mill as $prod)

            <tr>
                <td>{{$prod->id}}</td>
                <td>{{$prod->product->name}}</td>
                <td>{{$prod->product->quantity}}</td>
                <td>{{$prod->product->unit}}</td>
                <td>{{$prod->status}}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="page-break"></div>
<div class="container mt-5">
    <h2 class="text-center mb-3">RICE INVENTORY</h2>
    <h4 class="text-center">as of {{ Carbon\Carbon::now()->toFormattedDateString() }}</h2>
    <table class="table table-bordered mb-lg-5">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Date Produced</th>

                </tr>
                </thead>
                <tbody>

                @foreach($rice as $prod)

                    <tr>
                        <td>{{$prod->id}}</td>
                        <td>{{$prod->product->name}}</td>
                        <td>{{$prod->quantity}}</td>
                        <td>{{$prod->unit}}</td>
                        <td>{{Carbon\Carbon::parse($prod->created_at)->format('M d, Y')}}</td>
                    </tr>
                @endforeach
                </tbody>
    </table>
</div>
<div class="page-break"></div>
            <div class="container mt-5">
                <h2 class="text-center mb-3">DARAK INVENTORY</h2>
                <h4 class="text-center">as of {{ Carbon\Carbon::now()->toFormattedDateString() }}</h2>
                <table class="table table-bordered mb-lg-5">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Variant</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Date Produced</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($mill as $prod)

                        <tr>
                            <td>{{$prod->id}}</td>
                            <td>{{$prod->product->name}}</td>
                            <td>{{$prod->product->quantity}}</td>
                            <td>{{$prod->product->unit}}</td>
                            <td>{{Carbon\Carbon::parse($prod->created_at)->format('M d, Y')}}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
