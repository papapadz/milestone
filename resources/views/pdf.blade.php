<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reports</title>


</head>
<body>
<div class="container mt-5">
    <h2 class="text-lg-center mb-md-5">PALAY INVENTORY</h2>

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
    <div class="container mt-5">
        <h2 class="text-center mb-3">MILL/MILLED PRODUCTS</h2>
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
        <div class="container mt-5">
            <h2 class="text-center mb-3">RICE INVENTORY</h2>
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
            <div class="container mt-5">
                <h2 class="text-center mb-3">DARAK INVENTORY</h2>
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

</body>
</html>
