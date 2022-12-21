@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-sm-12 col-md-8 mx-auto">
                <x-alert></x-alert>
                <div class="card">
                    <div class="card-header py-0">
                        <h5 class="card-title">Detil Transaksi</h5>
                    </div>
                    <div class="card-body my-2">
                        <div class="row d-flex align-items-center">
                            <div class="col-sm-3">
                                Tanggal Transaksi
                            </div>
                            <div class="col-sm-9">
                                <h5 class="card-title py-0">{{ formatDateDayIndo($transaction->created_at) }}</h5>
                            </div>
                            <div class="col-sm-3">
                                Total Bayar
                            </div>
                            <div class="col-sm-9">
                                <h5 class="card-title py-0">@currency($transaction->total)</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body d-flex justify-content-between">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Gambar</th>
                                <th width="30%">Produk</th>
                                <th style="text-align:center;" width="20%">Qty</th>
                                <th style="text-align:right;">SubTotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transaction->transactionDetail as $transactionDetail)
                                <tr>
                                    <td>
                                        <img src="{{ url('storage/images/'.$transactionDetail->product->image) }}" class="card-img-top" style="height: 100px; width: 100px;">
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column justify-content-evenly align-items-start">
                                            <h5 class="card-title">{{ $transactionDetail->product->name }}</h5>
                                            <p class="text-danger fs-5 my-0">@currency($transactionDetail->product->price)</p>
                                        </div>
                                    </td>
                                    <td style="vertical-align:middle;text-align:center;">
                                        <h5 class="card-title">{{ $transactionDetail->amount }}</h5>
                                    </td>
                                    <td style="vertical-align:middle;text-align:right;">
                                        <p class="fs-4 my-0">@currency(($transactionDetail->amount * $transactionDetail->product->price))</p>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')

@endpush
