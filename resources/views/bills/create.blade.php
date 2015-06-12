@extends('app')

@section('content')
    <h1>Add a new bill</h1>

    <hr/>

    {!! Form::open(['url' => 'bills']) !!}
        @include ('bills.form', ['submitButtonText' => 'Add Bill'])
    {!! Form::close() !!}

    @include('errors.list')
@stop