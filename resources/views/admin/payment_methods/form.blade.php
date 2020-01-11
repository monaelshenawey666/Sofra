@include('admin.layouts.partials.validation-errors')
@include('flash::message')

{!! Form::text('name' ,null,
[
'class' => 'form-control'
]) !!}


