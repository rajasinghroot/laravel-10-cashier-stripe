@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>{{ __('My Orders') }}</h2></div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="my-orders">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Order Number</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            @if(!empty($orders))
                                @foreach($orders as $ordersKey=>$ordersinfo)
                                    <tr>
                                        <td>{{ $ordersKey+1 }}</td>
                                        <td>{{ $ordersinfo->order_number }}</td>
                                        <td>{{ $ordersinfo->product->product_name }}</td>
                                        <td>{{ $ordersinfo->OrderPriceWithSymbol }}</td>
                                        <td>{{ $ordersinfo->created_at }}</td>
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
@endsection
@section('bottom-script')
<script type="text/javascript">
    $(document).ready(function(){
        /* Pagination for my orders table */
        if($('#my-orders').length>0){
            $('#my-orders').DataTable({
                searching: false,
                "iDisplayLength": 5,
                "bLengthChange" : false, 
                "bInfo":false,
                pagingType: 'full_numbers',
            });
        }
    });
</script>
@endsection
