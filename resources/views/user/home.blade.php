@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="row">
            @foreach($products as $product)
                <div class="col-sm-6 col-md-2 col-lg-2 px-1">
                    <div class="card">
                        <img src="{{ url('storage/images/'.$product->image) }}" class="card-img-top" style="height: 200px">
                        <div class="card-body">
                            <h5 class="card-title my-0">{{ $product->name }}</h5>
                            <p class="text-danger fs-5 my-0">@currency($product->price)</p>
                            <div class="d-flex justify-content-between align-items-center gap-1">
                                <form action="{{ route('user.cart.add') }}" method="POST" class="col-sm-6">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button class="btn btn-success btn-sm col-sm-12"><i class="bi bi-cart"></i></button>
                                </form>
                                <a href="{{ route('product.detail',['productId' => $product->id]) }}" class="btn btn-primary btn-sm col-sm-6"><i class="bi bi-bucket-fill"></i> Beli</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
