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

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-sm">Tambah</a>
                    <div class="d-flex justify-content-evenly gap-2">
                        <button type="button" class="btn btn-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modal">
                            Pencarian
                        </button>
                        <a href="{{ route('admin.product.export') }}" class="btn btn-info btn-sm">Export Data</a>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive table-wrapper">
                    <table id="table" class="table">
                        <thead>
                        <tr>
                            <th scope="col">Nomor</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col" width="20%">Gambar</th>
                            <th scope="col">Stok</th>
                            <th scope="col">#</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </section>
</div>
<div class="modal fade" id="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pencarian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.product.index') }}" class="row g-3 needs-validation" method="GET">

                    <div class="col-md-12">
                        <label for="validationCustom01" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                        <div class="valid-feedback">Produk belum diisi</div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button class="btn btn-primary">Cari</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let table;

        let query = {};

        @foreach(request()->all() as $key => $value)
            query['{{$key}}'] = '{{$value}}';
        @endforeach

        $(document).ready(function() {
            loadTable();
        });

        function loadTable(){

            table = $('#table');
            table.DataTable({
                destroy: true,
                ajax: {
                    url     : "{{ route('admin.product.datatable') }}",
                    method  : "GET",
                    data    : query
                },
                columns: getColumn(),
                buttons: [],
                ordering: false,
                searching: false
            });
        }


        function getColumn(){
            return [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false,
                    class: 'no_padding'
                },
                {
                    data: 'name',
                    name: 'name',
                    class: 'no_padding'
                },
                {
                    data: 'price',
                    name: 'price',
                    class: 'no_padding'
                },
                {
                    data: 'image',
                    name: 'image',
                    class: 'no_padding'
                },
                {
                    data: 'stock',
                    name: 'stock',
                    class: 'no_padding'
                },
                {
                    data: 'action',
                    name: 'action',
                    class: 'no_padding'
                },
            ];
        }
    </script>
@endpush
