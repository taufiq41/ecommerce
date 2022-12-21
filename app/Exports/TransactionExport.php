<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionExport implements FromView
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.transaction', [
            'transactions' => Transaction::with(['user'])->get(),
        ]);
    }
}
