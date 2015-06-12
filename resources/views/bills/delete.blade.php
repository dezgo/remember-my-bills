@extends('app')

@section('content')
    <h1>Delete: {!! $bill->description !!}</h1>

    <hr/>

    {!! Form::model($bill, ['method' => 'DELETE', 'action' => ['BillsController@destroy', $bill->id]]) !!}
    @include ('bills.form', ['submitButtonText' => 'Click to permanently delete this bill'])
    {!! Form::close() !!}

    @include('errors.list')
@stop