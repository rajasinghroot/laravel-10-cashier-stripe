@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">                
                <div class="card-body">
                    <div class="text-center">
                        <img width="125px" src="{{ asset('images/success.png') }}" alt="Success"/>                        
                        <h3 class="mt-3">{{ Session::get('success') }}</h3>
                        <p>Check <a href={{ route('order-lists') }}>My Orders</a> or <a href={{ route('product-list') }}>Continue Shopping</a></p>
                    </div>                                               
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
