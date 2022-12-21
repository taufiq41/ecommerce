<table>
    <thead>
    <tr>
        <th>Tanggal Transaksi</th>
        <th>Customer</th>
        <th>Total Harga</th>
    </tr>
    </thead>
    <tbody>
    @foreach($transactions as $transaction)
        <tr>
            <td>{{ formatDateDayIndo($transaction->created_at) }}</td>
            <td>{{ $transaction->user->name }}</td>
            <td>@currency($transaction->total)</td>
        </tr>
    @endforeach
    </tbody>
</table>
