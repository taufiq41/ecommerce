<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if($user){
            $carts = Cart::with(['product'])
                ->where('user_id',$user->id)
                ->get();
        }else{
            $carts = [];
        }

        return view('user.cart',compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $rules = [
            'product_id'        => 'required|exists:products,id'
        ];

        $messages = [
            'product_id.required'   => 'Produk belum diisi',
            'product_id.exists'     => 'Produk tidak valid',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $data = $validator->validated();
        $user = auth()->user();

        $productId = $data['product_id'];

        try {
            $cart = Cart::where('user_id',$user->id)->where('product_id',$productId)->first();
            if($cart){
                Cart::where('id',$cart->id)->update(
                    ['amount' => DB::raw('amount+1')]
                );
            }else{
                Cart::create([
                    'user_id'    => $user->id,
                    'product_id' => $productId,
                    'amount'     => '1',
                ]);
            }

            return redirect()->back()->withSuccess('Keranjang berhasil ditambah');
        }catch (\Exception $e){
            return redirect()->back()->withErrors('Keranjang gagal ditambah');
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'amount'            => 'required|numeric|min:1',
            'product_id'        => 'required|exists:products,id'
        ];

        $messages = [
            'amout.required'        => 'Jumlah belum diisi',
            'amount.numeric'        => 'Jumlah harus angka',
            'amount.min'            => 'Jumlah tidak valid',
            'product_id.required'   => 'Produk belum diisi',
            'product_id.exists'     => 'Produk tidak valid',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $data = $validator->validated();
        $user = auth()->user();

        $productId = $data['product_id'];
        $amount = $data['amount'];

        try {
            $cart = Cart::with(['product'])->where('user_id',$user->id)->where('product_id',$productId)->first();

            if($cart){
                Cart::where('id',$cart->id)->update(
                    ['amount' => DB::raw('amount+'.$amount)]
                );
            }else{
                Cart::create([
                    'user_id'    => $user->id,
                    'product_id' => $productId,
                    'amount'      => $amount,
                ]);
            }

            return redirect()->back()->withSuccess('Keranjang berhasil ditambah');
        }catch (\Exception $e){
            return redirect()->back()->withErrors('Keranjang gagal ditambah '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'amount'            => 'required|numeric|min:1',
        ];

        $messages = [
            'amout.required'        => 'Jumlah belum diisi',
            'amount.numeric'        => 'Jumlah harus angka',
            'amount.min'            => 'Jumlah tidak valid',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $data = $validator->validated();

        $amount = $data['amount'];

        try {
            Cart::where('id',$id)->update(['amount' => $amount]);

            return redirect()->back()->withSuccess('Keranjang berhasil diubah');
        }catch (\Exception $e){
            return redirect()->back()->withErrors('Keranjang gagal diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::find($id)->delete();
        return redirect()->back()->withSuccess('Keranjang berhasil diubah');
    }
}
