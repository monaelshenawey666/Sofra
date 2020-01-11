@include('admin.layouts.partials.validation-errors')
@include('flash::message')
@inject('perm','App\Models\Permission')
<?php
$permissions = $perm->pluck('display_name', 'id')->toArray();
?>
{!! Form::text('name' ,null,[
    'class' =>'form-control',
    'placeholder' =>'الاسم',
]) !!}
<br>

{!! Form::text('display_name' ,null,[
    'class' =>'form-control',
    'placeholder' =>'الاسم المعروض',
]) !!}
<br>

{!! Form::textarea('description' ,null,[
    'class' =>'form-control',
    'placeholder' =>'الوصف',
]) !!}
<br>

<div class="form-group">
    <label>الصلاحيات</label>
    <br>
    <input id="select-all" type="checkbox">  <label for='select-all'> اختيار الكل </label>
    <br>
    <div class="row">
        @foreach($perm->all() as $permission)
            <div class="col-sm-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions_list[]" value="{{$permission->id}}"
                          @if($model->hasPermission($permission->name))
                              checked
                          @endif
                        >
                        {{$permission->display_name}}
                    </label>
                </div>
            </div>
            @endforeach
    </div>
</div>






