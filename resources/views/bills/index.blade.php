@extends('app')

@section('menu')
        <li><a href="{{ url('bills/create') }}">Add New Bill</a></li>
        <li><a href="{{ url('accounts') }}">Accounts</a></li>
        <li><a href="{{ url('bills/export') }}">Export</a></li>
        <li><a href="{{ url('bills/import') }}">Import</a></li>
        <li><a href="{{ url('payments') }}">Payment History</a></li>
@endsection

@section('content')
    @if ($bills->count() == 0)
       <div class="alert-info">
           Looks like you haven't added any bills yet. Click 'Add New Bill' above to get started.
       </div>
    @else
        <h1>Bills</h1>

        <table class="table table-bordered">
            <Tr>
                <th>Description</th>
                <th>Last Due</th>
                <th>Amount</th>
                <th>Payments p/a</th>
                <th>Monthly</th>
                <th>Account</th>
                <th>Auto</th>
                <th>Next Due</th>
                <th>In Days</th>
                <th>Actions</th>
            </Tr>
        @foreach($bills as $bill)
            <tr class="{{ $bill->severityCSS }}">
                <td>{{ $bill->description }}</td>
                <td>{{ $bill->last_due->formatLocalized('%a %d %b %Y') }}</td>
                <td>{{ number_format($bill->amount, 2) }}</td>
                <td>{{ $bill->times_per_year }}</td>
                <td>{{ number_format($bill->monthly, 2) }}</td>
                <td>{{ $bill->account->description }}</td>
                <td>{{ $bill->dd ? 'Yes' : 'No' }}</td>
                <td>{{ $bill->next_due->formatLocalized('%a %d %b %Y') }}</td>
                <td>{{ $bill->in_days }}</td>
                <td>
                    {!! Html::link('bills/'.$bill->id.'/edit', 'Edit') !!}
                    {!! Html::link('bills/'.$bill->id.'/pay', 'Pay') !!}
                </td>
            </tr>
        @endforeach
        </table>
    @endif
@endsection

