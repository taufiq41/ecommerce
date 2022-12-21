<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function index($productId){

        $user = auth()->user();

        $product = Product::find($productId);
        if($user){
            $carts = Cart::where('user_id',$user->id)->get();
        }else{
            $carts = null;
        }

        return view('user.product_detail',compact('product','carts'));

    }
}
