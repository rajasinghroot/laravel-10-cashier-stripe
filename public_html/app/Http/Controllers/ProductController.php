<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Product;
use Auth;
use Illuminate\Contracts\Encryption\DecryptException;


class ProductController extends Controller
{
    //* Displaying all the products in grid view */
    public function index(){        
        $productLists = Product::orderBy('id', 'asc')->paginate(9);        
        return view('product.gridlist', compact('productLists'));
    }

    /* Checkout process */
    public function checkout($productId){
        /* Checking a product is valid or not */
        try {
            $productId = Crypt::decryptString($productId);
            $productDetails = Product::find($productId);    
        } catch (DecryptException $e) {
            return redirect()->route('product-list')->with('error','Invalid Product.');
        }
        
        return view('product.checkout', compact('productDetails'));
    }
}
