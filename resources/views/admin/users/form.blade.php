@include('admin.layouts.partials.validation-errors')
@include('flash::message')
@inject('role','App\Models\Role')
<?php
$roles = $role->pluck('display_name', 'id')->toArray();
?>

<div class="form-group">
    <label for="name"></label>
    {!! Form::text('name' ,null,[
    'class' => 'form-control',
    'placeholder' => 'الاسم',
]) !!}
</div>

<div class="form-group">
    <label for="email"></label>
    {!! Form::text('email' ,null,[
    'class' => 'form-control',
    'placeholder' => 'الايميل',
]) !!}
</div>
<div class="form-group">
    <label for="password"></label>
    {!! Form::password('password' ,[
    'class' => 'form-control',
    'placeholder' => 'كلمة المرور',
]) !!}
</div>

<div class="form-group">
    <label for="password_confirmation"></label>
    {!! Form::password('password_confirmation' ,[
    'class' => 'form-control',
    'placeholder' => 'تاكيد كلمة المرور',
]) !!}
</div>

<div class="form-group">
    <label for="roles_list">رتب المستخدمين</label>
{!! Form::select('roles_list[]',$roles,null,[
    'class' =>'form-control select2',
    'placeholder' =>'اختر',
    'multiple' =>'multiple',
]  ) !!}
</div>


