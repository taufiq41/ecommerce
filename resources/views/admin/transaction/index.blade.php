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
</div>
<section class="section">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <x-alert></x-alert>
            <div class="card">
                <div class="card-header py-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Riwayat Pesanan</h5>
                        <a href="{{ route('admin.transaction.export') }}" class="btn btn-info btn-sm">Export Data</a>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-between">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="30%">Transaksi</th>
                                <th width="30%">Customer</th>
                                <th style="text-align:right;" width="30%">Total Harga</th>
                                <th style="text-align:center;">Detil</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $transaction)
                            <tr>
                                <td style="vertical-align:middle; text-align:left;">
                                    <h5 class="card-title">{{ formatDateDayIndo($transaction->created_at) }}</h5>
                                </td>
                                <td style="vertical-align:middle; text-align:left;">
                                    <h5 class="card-title">{{ $transaction->user->name }}</h5>
                                </td>
                                <td style="vertical-align:middle; text-align:right;">
                                    <h5 class="card-title">@currency($transaction->total)</h5>
                                </td>
                                <td style="vertical-align:middle; text-align:center;">
                                    <a href="{{ route('admin.transaction.show',['transaction' => $transaction->id]) }}" class="btn btn-success btn-sm"><i class="bi bi-journal-check"></i></a>
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

