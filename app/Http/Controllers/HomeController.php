<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $products = Product::where(function($query) use($request){
            if($request->search){
                $query->where('name','LIKE','%'.$request->search.'%');
            }
        })->get();

        return view('user.home',compact('products'));
    }
}
