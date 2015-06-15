@extends('app')

@section('content')
    <h1>Delete: {!! $account->description !!}</h1>

    <hr/>

    {!! Form::model($account, ['method' => 'DELETE', 'action' => ['AccountsController@destroy', $account->id]]) !!}
    @include ('accounts.form', ['submitButtonText' => 'Click to permanently delete this account'])
    {!! Form::close() !!}

    @include('errors.list')
@stop