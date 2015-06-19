@extends('app')

@section('menu')
    <li><a href="{{ url('payments/export') }}">Export</a></li>
    <li><a href="{{ url('payments/import') }}">Import</a></li>
@endsection

@section('content')
    <h1>Payments</h1>

    <table class="table table-bordered">
        <Tr>
            <th>Description</th>
            <th>Payment Date</th>
            <th>Amount</th>
            <th>Account</th>
        </Tr>
        @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->description }}</td>
                <td>{{ $payment->payment_date->formatLocalized('%a %d %b %Y') }}</td>
                <td>{{ number_format($payment->amount, 2) }}</td>
                <td>{{ $payment->account->description }}</td>
            </tr>
        @endforeach
    </table>
@endsection

