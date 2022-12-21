@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="row">
             <div class="col-sm-12 col-md-8">
                 <div class="card">
                     <div class="card-header d-flex justify-content-between">
                         <img src="{{ url('storage/images/'.$product->image) }}" class="card-img-top" style="height: 350px; width: 350px;">
                         <div class="card-body d-flex flex-column justify-content-evenly">
                             <div>
                                 <h5 class="card-title">{{ $product->name }}</h5>

                                 <p class="text-danger fs-5 my-0">@currency($product->price)</p>
                                 <p class="text-warning fs-5 my-0">Stok {{ $product->stock }}</p>
                             </div>
                             <div class="d-flex flex-column">
                                 <h5 class="card-title py-1">Deskripsi</h5>
                                 <hr class="my-0">
                                 <div>
                                     {{ $product->description }}
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="col-sm-12 col-md-4">
                 @if(auth()->check())
                     <x-alert></x-alert>
                     <div class="card rounded">
                         <div class="card-header py-0">
                             <h5 class="card-title">Atur jumlah dan catatan</h5>
                         </div>
                         <div class="card-body">
                             <form action="{{ route('user.cart.store') }}" method="POST">
                                 @csrf
                                 <input type="hidden" class="form-control" name="product_id" value="{{ $product->id }}">
                                 <div class="d-flex justify-content-between align-items-center py-2">
                                     <div class="w-10">
                                         <input type="number" class="form-control" id="amount" name="amount" min="0" max="{{$product->stock}}" onchange="subTotal(this.value,'{{$product->stock}}')">
                                     </div>
                                     <p class="my-0">{{ 'Stok : sisa '.$product->stock }} </p>
                                 </div>
                                 <div class="d-flex justify-content-between align-items-center">
                                     <p>Sub Total</p>
                                     <p class="fs-4" id="subtotal">Rp. 0</p>
                                 </div>
                                 <button class="btn btn-primary btn-sm col-sm-12"> <i class="bi bi-cart"></i> Keranjang</button>
                             </form>
                         </div>
                     </div>
                 @endif
             </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        var price = '{{ $product->price }}';

        function subTotal(amount,stock){
            if(parseInt(amount) > parseInt(stock)){
                amount = stock;
            }

            var subTotal = price * amount;

            $("#amount").val(amount);
            $("#subtotal").html(formatRupiah(subTotal.toString(),'Rp. '));
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
