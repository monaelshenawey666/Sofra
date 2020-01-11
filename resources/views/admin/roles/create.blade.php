@extends('admin.layouts.main',[
                                'page_header'       => 'رتب المستخدمين',
                                'page_description'  => 'إضافة رتبة'
                                ])
@inject('model','App\Models\Role')
@section('content')
<div class="box box-danger">
    <!-- form start -->
    {!! Form::model($model,[
                            'action'=>'Admin\RoleController@store',
                            'id'=>'myForm',
                            'role'=>'form',
                            'method'=>'POST'
                            ])!!}
    <div class="box-body">
        @include('admin.roles.form')
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">حفظ</button>
    </div>
    {!! Form::close()!!}
</div>
@stop

@push('scripts')
    <script>
        $("#select-all").click(function(){
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));

        });
    </script>
@endpush
