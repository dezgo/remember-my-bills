@extends('app')

@section('content')
    <h1>Edit: {!! $account->description !!}</h1>

    <hr/>

    {!! Form::model($account, ['method' => 'PATCH', 'action' => ['AccountsController@update', $account->id]]) !!}
    @include ('accounts.form', ['submitButtonText' => 'Update Account'])
    {!! Form::close() !!}
    <br>
    {!! Form::model($account, ['method' => 'DELETE', 'action' => ['AccountsController@destroy', $account->id]]) !!}

    <!-- Add Account Form Input -->
    <div class="from-group">
        {!! Form::submit('Click to permanently delete this account', ['class' => 'btn btn-danger form-control']) !!}
    </div>

    {!! Form::close() !!}

    @include('errors.list')
@stop