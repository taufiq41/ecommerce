@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>{{ $breadcrumbs[(count($breadcrumbs)-1)]['text'] }}</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        @for($i =0; $i < count($breadcrumbs); $i++)
            <li class="breadcrumb-item {{ ($i+1) == count($breadcrumbs) ? 'active' : '' }}">
                <a href="{{ $breadcrumbs[$i]['route'] }}">{{ $breadcrumbs[$i]['text'] }}</a>
            </li>
        @endfor
      </ol>
    </nav>
</div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
        <x-alert></x-alert>
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">{{ !isset($product) ? 'Tambah Produk' : 'Perbarui Produk'}}</h5>

              <form action="{{ !isset($product) ? route('admin.product.store') : route('admin.product.update',['product' => $product->id]) }}"
                    class="row g-3 needs-validation" method="POST"
                    enctype="multipart/form-data" novalidate>
                  @csrf
                  @if(isset($product))
                      @method('PUT')
                  @endif
                <div class="col-md-12">
                  <label for="validationCustom01" class="form-label">Nama Produk</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{ isset($product) ? $product->name :old('name') }}" required>
                  <div class="valid-feedback">Produk belum diisi</div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ isset($product) ? $product->price : old('price') }}" required>
                    <div class="valid-feedback">Harga belum diisi</div>
                </div>
                <div class="col-md-12">
                    <label for="validationCustom01" class="form-label">Gambar Produk</label>
                    <input type="file" class="form-control" id="image" name="image" value="{{ isset($product) ? $product->image : old('image') }}" {{ !isset($product) ? 'required' : '' }}>
                    <div class="valid-feedback">Gambar produk belum diisi</div>
                    @if(isset($product))
                        <div class="row d-flex justify-content-start align-items-center w-25">
                            <img src="{{ url('storage/images/'.$product->image) }}" alt="" class="rounded img-thumbnail">
                        </div>
                    @endif
                </div>
                <div class="col-md-12">
                  <label for="validationCustom03" class="form-label">Stok</label>
                  <input type="number" class="form-control" id="stock" name="stock" value="{{ isset($product) ? $product->stock : old('stock') }}" required>
                  <div class="invalid-feedback">Stok belum diisi</div>
                </div>
                  <div class="col-md-12">
                      <label for="validationCustom01" class="form-label">Deskripsi</label>
                      <textarea class="form-control" id="description" name="description">{{ isset($product) ? $product->description :old('description') }}</textarea>
                  </div>
                <div class="col-12">
                  <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
              </form><!-- End Custom Styled Validation -->

            </div>
          </div>
    </div>
  </section>
</div>
@endsection
