<!-- Description Form Input -->
<div class="from-group">
    {!! Form::label('description', 'Description: ') !!}
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Last_due Form Input -->
<div class="from-group">
    {!! Form::label('last_due', 'Last due: ') !!}
    {!! Form::input('date', 'last_due', date('Y-m-d'), ['class' => 'form-control']) !!}
</div>

<!-- Times_per_year Form Input -->
<div class="from-group">
    {!! Form::label('times_per_year', 'Times/year: ') !!}
    {!! Form::text('times_per_year', null, ['class' => 'form-control']) !!}
</div>

<!-- Account Form Input -->
<div class="from-group">
    {!! Form::label('account', 'Account: ') !!}
    {!! Form::select('account_id', App\Account::getSelectData(), null, ['class' => 'form-control']) !!}
</div>

<!-- Direct Debit Form Input -->
<div class="form-group">
    {!! Form::label('dd', 'Direct Debit:') !!}
    {!! Form::checkbox('dd', 1, ['class' => 'form-control']) !!}
</div>

<!-- Amount Form Input -->
<div class="from-group">
    {!! Form::label('amount', 'Amount: ') !!}
    {!! Form::text('amount', null, ['class' => 'form-control']) !!}
</div>

<!-- Add Bill Form Input -->
<div class="from-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>