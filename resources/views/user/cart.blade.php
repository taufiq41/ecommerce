@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-sm-12 col-md-8 mx-auto">
                <x-alert></x-alert>
                <div class="card">
                    <div class="card-header py-0">
                        <h5 class="card-title">Keranjang belanja</h5>
                    </div>
                    <div class="card-body d-flex justify-content-between">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th width="30%">Produk</th>
                                    <th style="text-align:center;" width="20%">Jumlah</th>
                                    <th style="text-align:right;">SubTotal</th>
                                    <th style="text-align:center;"  width="5%">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($carts as $cart)
                                    <tr>
                                        <td>
                                            <img src="{{ url('storage/images/'.$cart->product->image) }}" class="card-img-top" style="height: 100px; width: 100px;">
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-evenly align-items-start">
                                                <h5 class="card-title">{{ $cart->product->name }}</h5>
                                                <p class="text-danger fs-5 my-0">@currency($cart->product->price)</p>
                                            </div>
                                        </td>
                                        <td style="vertical-align:middle;">
                                            <form action="{{ route('user.cart.update',['cart' => $cart->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="input-group">
                                                    <input type="number" id="{{ 'amount_'.$cart->id }}" class="form-control" name="amount" min="1" max="{{$cart->product->stock}}"
                                                           value="{{ $cart->amount }}"
                                                           onchange="subTotal('{{ $cart->id }}','{{ $cart->product->price }}',this.value,'{{ $cart->product->stock }}')">
                                                    <button class="btn btn-success btn-sm"><i class="bi bi-check"></i></button>
                                                </div>
                                            </form>
                                        </td>
                                        <td style="vertical-align:middle;text-align:right;">
                                            <p id="{{ $cart->id }}" class="fs-4 my-0">@currency(($cart->amount * $cart->product->price))</p>
                                        </td>
                                        <td style="vertical-align:middle;">
                                            <form action="{{ route('user.cart.destroy',['cart' => $cart->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button  class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            @if(count($carts) > 0)
                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <form action="{{ route('user.transaction.store') }}" method="POST">
                                                @csrf
                                                <button class="btn btn-primary btn-sm col-sm-12"> <i class="bi bi-bucket-fill"></i> Checkout</button>
                                            </form>
                                        </td>
                                    </tr>
                                </tfoot>
                            @endif

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>

        function subTotal(id,price,amount,stock){
            if(parseInt(amount) > parseInt(stock)){
                amount = stock;
            }

            var subTotal = price * amount;
            $("#amount_"+id).val(amount);
            $("#"+id).html(formatRupiah(subTotal.toString(),'Rp. '));
        }

        function formatRupiah(angka, prefix){
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split   		= number_string.split(','),
                sisa     		= split[0].length % 3,
                rupiah     		= split[0].substr(0, sisa),
                ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    </script>
@endpush
