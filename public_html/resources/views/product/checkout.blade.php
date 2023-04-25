@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h2>{{ __('Checkout') }}<h2></div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="col-md-12">
                        <h3>Review Order Details</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-secondary">
                                    <th width="30%">Product</th>
                                    <th width="60%">Description</th>
                                    <th width="10%">Price</th>            
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $productDetails->product_name }}</td>
                                    <td>{{ $productDetails->description }}</td>
                                    <td>{{ $productDetails->PriceWithSymbol }}</td>
                                    
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-right"><b>Total</b></td>
                                    <td colspan="2"><b>{{ $productDetails->PriceWithSymbol }}</b></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12">
                                <form id="paymentForm" method="POST" action="{{ route('purchase') }}" class="card-form mt-3 mb-3">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3>Shipping Address</h3>
                                            <div class="row">                                
                                                <div class="col-md-6">                                    
                                                    <div class="form-group">
                                                        <label for="shippingAddress1">Address 1<span class="required-symbol">*</span></label>              
                                                        <input id="shippingAddress1" class="form-control" name="shippingAddress1" type="text" value="{{ old('shippingAddress1') }}" />              
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="shippingAddress2">Address 2</label>              
                                                        <input id="shippingAddress2" class="form-control" name="shippingAddress2" type="text" value="{{ old('shippingAddress2') }}" />              
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="shippingCity">City<span class="required-symbol">*</span></label>              
                                                        <input id="shippingCity" class="form-control" name="shippingCity" type="text" value="{{ old('shippingCity') }}" />              
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="shippingState">State<span class="required-symbol">*</span></label>              
                                                        <input id="shippingState" class="form-control" name="shippingState" type="text" value="{{ old('shippingState') }}" />              
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="shippingZipcode">Zipcode<span class="required-symbol">*</span></label>              
                                                        <input id="shippingZipcode" class="form-control" name="shippingZipcode" type="number" value="{{ old('shippingZipcode') }}" />              
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="shippingCountry">Country<span class="required-symbol">*</span></label>              
                                                        <select class="form-control" id="shippingCountry" name="shippingCountry">
                                                            <option value="US">United States</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h3>Credit Card</h3>
                                            <div class="row"> 
                                                <div class="col-md-12">                                    
                                                    <div class="form-group cardHName">
                                                        <label for="name_on_card">Card Holder Name<span class="required-symbol">*</span></label>              
                                                        <input id="name_on_card" class="form-control" name="name_on_card" type="text" value="{{ old('name_on_card') }}" autocomplete="name_on_card" autofocus />              
                                                    </div>
                                                    </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Card Number<span class="required-symbol">*</span></label>
                                                        <div id="card-number"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Expiration Date (MM/YY)<span class="required-symbol">*</span></label>
                                                        <div id="card-expiry"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>CVC<span class="required-symbol">*</span></label>
                                                        <div id="card-cvc"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div id="card-errors" role="alert"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>            
                                    <div class="row">
                                        <div class="col-md-12">
                                        <div class="form-group mt-3 text-center">
                                            <input type="hidden" name="payment_method" class="payment-method">
                                            <input type="hidden" name="productInfo" value="{{ Crypt::encryptString($productDetails->id) }}" />
                                            <a id="card-button" class="btn btn-danger pay">Place Order</a>
                                        </div>
                                    </div>                                    
                                </form>
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Alert popup --}}
<div class="modal fade" id="default-alert">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <button class="close dfmodalClose" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <p class="default-msg"></p>
            <p class="dfPopupBtnSec">
                <a class="btn btn-dark" data-dismiss="modal">Ok</a>
            </p>
        </div>
    </div>
</div>
<div class="default-loader" style="display:none">
    <img width="60px" src="{{ asset('images/loader.gif') }}" alt="loader" />
</div>
@endsection

@section('custom-style')
<style>
    .default-loader{background: rgba(0,0,0,0.3); width: 100%; height: 100%; position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 2; cursor: pointer;}
    .default-loader img{position: absolute; left: 0; right: 0; margin: auto; top: 0; bottom: 0;}
    .required-symbol{color:red;}
    .StripeElement {display: block; width: 100%; height: calc(1.6em + 0.75rem + 2px); padding: 0.375rem 0.75rem; font-size: 0.9rem; font-weight: 400; line-height: 1.6; color: #495057; background-color: #fff; background-clip: padding-box; border: 1px solid #ced4da; border-radius: 0.25rem; transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out; }
    .StripeElement--invalid {border-color: #fa755a;}
    .StripeElement--focus {box-shadow: 0 1px 3px 0 #cfd7df;}    
    .StripeElement--webkit-autofill {background-color: #fefde5 !important;}
    input.error{border-color: #fa755a;}
    #card-errors,.error{color:red;}    
    input.error:focus,input:focus{box-shadow: 0 1px 3px 0 #cfd7df; border-color: #fa755a !important;}    
</style>
@endsection

@section('bottom-script')
    
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>    
    <script>
        /* setting a csrf token into ajax headers */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* getting a stripe key */
        const stripe = Stripe("{{ env('STRIPE_KEY') }}");

        /* custom styles for stripe element */
        const customStripeStyles={
            base: {
                'color': '#9e9e9e',    
                '::placeholder': {
                    'color': '#d9d9d9',
                    'fontSize':'14px',
                    'opacity': '1',
                    
                },
            }
        };

        /* creating a stripe element */
        const elements = stripe.elements();
        const cardNumber = elements.create('cardNumber',{style: customStripeStyles});
        cardNumber.mount('#card-number');
        const cardExpiry = elements.create('cardExpiry',{style: customStripeStyles});
        cardExpiry.mount('#card-expiry');
        const cardCvc = elements.create('cardCvc',{style: customStripeStyles});
        cardCvc.mount('#card-cvc');

        const cardHolderName = document.getElementById('name_on_card');
        const cardButton = document.getElementById('card-button');

        /* get a client secrect id by from stripe */
        let getNewSetupIntent=()=>{        
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "{{route('ajax-get-set-up-intent')}}",
                    type: 'POST',
                    success: function (data) {                    
                        resolve(data.intent_id)
                    },
                    error: function (error) {  
                        reject(error.msg)
                    },
                });
            });
        }

        /* Processing a stripe payment */
        cardButton.addEventListener('click', async (e) => {
            $('.default-loader').show();
            getNewSetupIntent().then((intent_id) => {
                let clientSecret = intent_id;
                stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardNumber,
                            billing_details: { name: cardHolderName.value }
                        }
                    }
                ).then(function (result) {
                    $('.default-loader').hide();
                    if(result.error){
                        $('#card-errors').text(result.error.message)
                    } 
                    else{
                        $('#card-errors').empty();
                        $('.payment-method').val(result.setupIntent.payment_method);
                        $("#paymentForm").submit();
                    }
                });
            }).catch((intent_error) => {
                $('.default-msg').html(intent_error);
                $('#default-alert').modal('show');
                $('.default-loader').hide();
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            /* Validating a checkout page fields */
            $("#paymentForm").validate({
                rules: {
                    shippingAddress1: {required: true},   
                    shippingCity: {required: true},
                    shippingState: {required: true},
                    shippingZipcode: {required: true},
                    shippingCountry: {required: true},
                    name_on_card: {required: true},             
                },
                messages: {
                    shippingAddress1: "Address1 is required.", 
                    shippingCity: "City is required.",
                    shippingState: "State is required.",
                    shippingZipcode: "Zipcode is required.",
                    shippingCountry: "Country is required.",
                    name_on_card: "Card holder name is required.",       
                },
                submitHandler: function(form) {
                    $('.default-loader').show();
                    form.submit();            
                }
            });
        });
    </script>
@endsection
