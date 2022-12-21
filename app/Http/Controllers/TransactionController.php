<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $transactions = Transaction::where('user_id',$user->id)->get();
        return view('user.transaction_history', compact('transactions'));
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
    public function store(Request $request)
    {
        $user = auth()->user();
        $carts = Cart::with(['product'])->where('user_id',$user->id)->get();

        DB::beginTransaction();
        try{
            $total = 0;

            foreach ($carts as $cart){
                if($cart->product){
                    $total = ($cart->product->price * $cart->amount) + $total;
                }else{
                    Cart::find($cart->id)->delete();
                    return redirect()->back()->withErrors('Produk tidak ditemukan atau sudah dihapus');
                }
            }

            $transaction = Transaction::create([
                'user_id'   => $user->id,
                'total'     => $total,
            ]);

            foreach ($carts as $cart){
                if($cart->product){

                    if((int)$cart->product->stock < (int) $cart->amount){
                        return redirect()->back()->withErrors('Transaksi gagal stok '.$cart->product->name.' tidak mencukupi');
                    }

                    TransactionDetail::create(
                        [
                            'transaction_id' => $transaction->id,
                            'user_id' => $user->id,
                            'product_id' => $cart->product->id,
                            'product_name'  => $cart->product->name,
                            'amount' => $cart->amount,
                            'price' => $cart->product->price,
                            'total' => ($cart->amount * $cart->product->price)
                        ]
                    );

                    Product::where('id',$cart->product->id)->update(
                        ['stock' => DB::raw('stock-'.$cart->amount)]
                    );
                }
            }

            Cart::where('user_id',$user->id)->delete();

            DB::commit();

            return redirect()->back()->withSuccess('Transaksi berhasil');
        }catch (\Exception $e){
            return redirect()->back()->withErrors('Transaksi gagal');
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
        $transaction = Transaction::with(['transactionDetail'])->where('id',$id)->first();
        return view('user.transaction_detail', compact('transaction'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
