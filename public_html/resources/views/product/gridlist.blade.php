@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>{{ __('Products') }}</h2></div>
                <div class="card-body">
                    @include('flash-message')
                    @if(!$productLists->isEmpty())
                        <div class="row">
                        @foreach($productLists as $productDetail)
                        <div class="col-12 col-md-6 col-lg-4 mb-2 productCls">
                            <div class="card">
                                <div class="card-body">
                                <h4 class="card-title"><b>{{ $productDetail->product_name }}</b></h4>
                                <p class="card-text" style="height:40px">{{ $productDetail->description }}</p>
                                <p class="card-text"><b><i>Price: {{ $productDetail->PriceWithSymbol }}</i></b></p>
                                <a class="btn btn-danger" href="{{ route('product-checkout',['id'=>Crypt::encryptString($productDetail->id)]) }}">Buy Now</a>
                                </div>
                            </div>
                        </div>                            
                        @endforeach
                        </div>  
                        {{ $productLists->links() }} 
                    @else
                        <p class="text-center"><b>No Products available.</b></p>                     
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
