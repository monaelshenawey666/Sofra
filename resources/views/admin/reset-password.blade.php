@extends('admin.layouts.main',[
                                'page_header'       => 'المستخدمين',
                                'page_description'  => 'تغيير كلمة المرور'
                                ])
@section('content')
        <!-- general form elements -->
<div class="box box-primary">
    <!-- form start -->
    {!! Form::open([
                            'action'=>'Admin\UserController@changePasswordSave',
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'POST'
                            ])!!}

    <div class="box-body">
        @include('flash::message')
        @include('admin.layouts.partials.validation-errors')
        {!! Form::password('old-password',['class'=>'form-control','placeholder'=>'كلمة المرور القديمة']) !!}
        <br/>
        {!! Form::password('password',['class'=>'form-control','placeholder'=>'كلمة المرور الجديدة']) !!}
        <br/>
        {!! Form::password('password_confirmation',['class'=>'form-control','placeholder'=>'تأكيد كلمة المرور الجديدة']) !!}

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
        </div>

    </div>
    {!! Form::close()!!}

</div><!-- /.box -->

@endsection
