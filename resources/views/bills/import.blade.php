@extends('app')

@section('content')
    <h1>Import CSV</h1>

    <hr/>

    {!! Form::open(['method' => 'PUT', 'action' => 'BillsController@import_result']) !!}
    <!-- Sel Form Input -->
    <div class="from-group">
        {!! Form::label('filename_label', 'Select file to upload: ') !!}
        {!! Form::file('filename', ['class' => 'form-control']) !!}
    </div>

    <div class="from-group">
        {!! Form::submit('Start', ['class' => 'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}

    @include('errors.list')
@stop