@extends('app')

@section('content')
    <h1>Edit: {!! $bill->description !!}</h1>

    <hr/>

    {!! Form::model($bill, ['method' => 'PATCH', 'action' => ['BillsController@update', $bill->id]]) !!}
    @include ('bills.form', ['submitButtonText' => 'Update Bill'])
    {!! Form::close() !!}
    <br>
    {!! Form::model($bill, ['method' => 'DELETE', 'action' => ['BillsController@destroy', $bill->id]]) !!}

    <!-- Add Bill Form Input -->
    <div class="from-group">
        {!! Form::submit('Click to permanently delete this bill', ['class' => 'btn btn-danger form-control']) !!}
    </div>

    {!! Form::close() !!}

    @include('errors.list')
@stop