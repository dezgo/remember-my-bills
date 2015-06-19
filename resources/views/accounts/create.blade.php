@extends('app')

@section('content')
    <h1>Add a new account</h1>

    <hr/>

    {!! Form::open(['url' => 'accounts']) !!}
    @include ('accounts.form', ['submitButtonText' => 'Add Account'])
    {!! Form::close() !!}

    @include('errors.list')
@stop