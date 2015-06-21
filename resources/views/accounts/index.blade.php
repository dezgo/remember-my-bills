@extends('app')

@section('menu')
    <li><a href="{{ url('accounts/create') }}">Add New Account</a></li>
@endsection

@section('content')
    <h1>Accounts</h1>

    @if ($accounts->count() == 0)
        <div class="alert-info">
            Looks like you haven't added any accounts yet. Click 'Add New Account' above to get started.
        </div>
    @else
        <table class="table table-bordered">
            <Tr>
                <th>Description</th>
                <th>Edit</th>
            </Tr>
            @foreach($accounts as $account)
                <tr>
                    <td>{{ $account->description }}</td>
                    <td>{!! Html::link('accounts/'.$account->id.'/edit', 'Edit') !!}</td>
                </tr>
            @endforeach
        </table>
    @endif
@endsection


