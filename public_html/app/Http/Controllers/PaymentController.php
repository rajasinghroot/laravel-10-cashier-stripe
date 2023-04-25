<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\user;
use App\Models\Product;
use App\Models\Order;
use Auth;
use Illuminate\Contracts\Encryption\DecryptException;

class PaymentController extends Controller
{
    /* Getting a client secret key from stripe-end */
    public function ajaxGetSetUpIntent(Request $request)
    {
        if($request->ajax()){
            $loggedUserInfo=Auth::user();            
            $requestData = $request->all();
            return response()->json(['status'=>'success','intent_id'=>$loggedUserInfo->createSetupIntent()->client_secret]);
        }
        return response()->json(['status'=>'error','msg'=>'Invalid request.']);
    }

    /* Payment process for stripe */
    public function purchase(Request $request){
        if($request->isMethod('post')){ 
            /* Getting a current logged user details */
            $loggedUserInfo= Auth::user();

            /* Getting a stripe payment related request form checkout page */
            $paymentMethod = $request->payment_method;
            $productInfo = $request->productInfo;

            /* getting a shipping address from checkout page */
            $shippingAddress1 = $request->shippingAddress1;
            $shippingAddress2 = $request->shippingAddress2;
            $shippingCity = $request->shippingCity;
            $shippingState = $request->shippingState;
            $shippingZipcode = $request->shippingZipcode;
            $shippingCountry = $request->shippingCountry;  
            $shippingAddressInfo=['address'=>['line1'=>$shippingAddress1,'line2'=>$shippingAddress2,'postal_code'=>$shippingZipcode,'city'=>$shippingCity,'state'=>$shippingState,'country'=>$shippingCountry],'name'=>$loggedUserInfo->name];
                    

            /* Checking a product is valid or not */
            try {
                $pid=Crypt::decryptString($productInfo);
                $productDetails = Product::find($pid);    
            } catch (DecryptException $e) {
                return redirect()->route('product-list')->with('error','Product is invalid.');
            }
            
            /* Processing a stripe payment */
            try {
                /* Checking a user is available in stripe otherwise creating a new user into stripe */
                if (is_null($loggedUserInfo->stripe_id)) {
                    $createUserOptions = [
                        'name' => $loggedUserInfo->name
                    ];
                    $loggedUserInfo->createOrGetStripeCustomer($createUserOptions);
                }

                /* Updating a default payment method in stripe for logged user */
                $loggedUserInfo->updateDefaultPaymentMethod($paymentMethod);

                /*Charging a amout through a credit card */
                $orderNumber=Order::createOrderNumber();
                $payment=$loggedUserInfo->charge($productDetails->product_price * 100, $paymentMethod,['description'=>$productDetails->description,"metadata" => ["orderNumber" => $orderNumber],['shipping'=>$shippingAddressInfo]]);    
                /* if payment is success to redirect a success page otherwise displaying a error in the checkout page */
                if($payment->status=='succeeded'){
                    $orderDetails=[
                        'orderNumber'=>$orderNumber,
                        'userId'=>$loggedUserInfo->id,
                        'productId'=>$pid,
                        'price'=>$productDetails->product_price,
                        'status'=>$payment->status,
                        'paymentIntentId'=>$payment->id
                    ];
                    $newOrderCreated=Order::storeOrder($orderDetails);
                    if($newOrderCreated==1){
                        return redirect()->route('success')->with('success','Your order has been placed successfully.');
                    }
                    return back()->with('error','Your order has been placed.But Something went wrong order storing proces. Please contact SM Team.');
                }
                return back()->with('error','Somgthing went wrong in the payment process. Please try again later or contact to SM team.');
            } catch (\Exception $exception) {
                return back()->with('error', $exception->getMessage());
            }
        }
        return back()->with('error','Invalid request.');
    }
}
