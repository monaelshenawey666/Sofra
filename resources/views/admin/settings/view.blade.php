@extends('admin.layouts.main',[
                                'page_header'       => 'الاعدادات',
                                'page_description'  => 'اعدادات الموقع'
                                ])
@section('content')
        <!-- general form elements -->
<div class="box box-primary">
    <!-- form start -->
    {!! Form::model($model,[
                            'action'=>['Admin\SettingsController@update',$model->id],
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'put',
                            'files'=>true
                            ])!!}

    <div class="box-body">

        @include('admin.settings.form',compact('model'))

        <div class="box-footer">
            <button type="submit" class="btn btn-primary">حفظ</button>
        </div>

    </div>
    {!! Form::close()!!}

</div><!-- /.box -->

@endsection
