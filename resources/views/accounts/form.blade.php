<div class="from-group">
    {!! Form::label('description', 'Description: ') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<div class="from-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>