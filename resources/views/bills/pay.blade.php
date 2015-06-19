@extends('app')

@section('content')
    <h1>Pay: {!! $bill->description !!}</h1>

    <hr/>

    {!! Form::open(['method' => 'PATCH', 'action' => ['BillsController@markPaid', $bill->id]]) !!}

    <div class="from-group">
        {!! Form::label('description', $bill->description) !!}
    </div>

    <div class="from-group">
        {!! Form::label('times_per_year', 'Paid '.$bill->times_per_year.' times/year') !!}
    </div>

    <div class="from-group">
        {!! Form::label('last_due', 'Last due '.$bill->last_due->toFormattedDateString()) !!}
    </div>

    <div class="from-group">
        {!! Form::label('next_due', 'Next due '.$bill->next_due->toFormattedDateString()) !!}
    </div>

    {!! Form::submit('Pay', ['class' => 'btn form-control btn-primary']) !!}

    {!! Form::close() !!}

@stop