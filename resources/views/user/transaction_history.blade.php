@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-sm-12 col-md-8 mx-auto">
                <x-alert></x-alert>
                <div class="card">
                    <div class="card-header py-0">
                        <h5 class="card-title">Riwayat Pesanan</h5>
                    </div>
                    <div class="card-body d-flex justify-content-between">
                        <table class="table">
                            <thead>
                            <tr>
                                <th width="40%">Transaksi</th>
                                <th style="text-align:right;" width="30%">Total</th>
                                <th style="text-align:center;">Detil</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td style="vertical-align:middle; text-align:left;">
                                        <h5 class="card-title">{{ formatDateDayIndo($transaction->created_at) }}</h5>
                                    </td>
                                    <td style="vertical-align:middle; text-align:right;">
                                        <h5 class="card-title">@currency($transaction->total)</h5>
                                    </td>
                                    <td style="vertical-align:middle; text-align:center;">
                                        <a href="{{ route('user.transaction.show',['transaction' => $transaction->id]) }}" class="btn btn-success btn-sm"><i class="bi bi-journal-check"></i></a>
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
