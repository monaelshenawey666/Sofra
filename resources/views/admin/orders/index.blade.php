@extends('admin.layouts.main',[
                                'page_header'       => ' عرض الطلبات',
                                'page_description'  => 'عرض'
                                ])
@inject('resturant','App\Models\Resturant')
<?php
$resturants = $resturant->pluck('name', 'id')->toArray();
?>
@section('content')


    <div class="box box-primary">
        <div class="box-body">
            <div class="row">
                {!! Form::open([
                    'method' => 'GET'
                ]) !!}
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        {!! Form::text('order_id',request()->input('order_id'),[
                            'class' => 'form-control',
                            'placeholder' => 'رقم الطلب'
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        {!! Form::select('resturant_id',$resturant->get()->pluck('resturant_details','id')->toArray(),
                             request()->input('resturant_id'),[
                            'class' => 'form-control',
                            'placeholder' => 'كل المطاعم'
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        {!! Form::select('state',
                            [
                                'pending' => 'قيد التنفيذ',
                                'accepted' => 'تم تأكيد الطلب',
                                'rejected' => 'مرفوض',
                            ],Request::input('state'),[
                                'class' => 'form-control',
                                'placeholder' => 'كل حالات الطلبات'
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        {!! Form::date('from',request()->input('from'),[
                            'class' => 'form-control datepicker',
                            'placeholder' => 'من'
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        {!! Form::date('to',Request::input('to'),[
                            'class' => 'form-control datepicker',
                            'placeholder' => 'إلى'
                        ]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-flat btn-block btn-primary">بحث</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            @if(count($order))
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>رقم الطلب</th>
                        <th>المطعم</th>
                        <th>الإجمالى</th>
                        <th>ملاحظات</th>
                        <th>الحالة</th>
                        <th>وقت الطلب</th>
                        <th class="text-center">عرض</th>
                        </thead>
                        <tbody>
{{--                        @php $count = 1; @endphp--}}
                        @foreach($order as $ord)
                            <tr id="removable{{$ord->id}}">
{{--                                <td>{{$count}}</td>--}}
                                <td>{{$loop->iteration}}</td>
                                <td><a href="{{url('admin/order/'.$ord->id)}}">#{{$ord->id}}</a></td>
                                <td>
{{--                                    @if(count($ord->resturant)){{$ord->resturant->name}}@endif--}}
                                    {{optional($ord->resturant)->name}}

                                </td>
                                <td>{{$ord->total}}</td>
                                <td>{{$ord->note}}</td>
{{--                                <td>{{$ord->state}}</td>--}}
                                <td class="text-center">
                                    @if($ord->state == 'pending')
                                        <i class="fa fa-circle-o text-green"></i> قيد التنفيذ
                                    @elseif($ord->state == 'accepted')
                                        <i class="fa fa-circle-o text-red"></i> تم تأكيد الطلب
                                    @elseif($ord->state == 'rejected')
                                        <i class="fa fa-circle-o text-red"></i> مرفوض
                                    @endif

                                </td>
                                <td>{{$ord->created_at}}</td>
                                <td>
                                    <a href="{{url(route('order.show',$ord->id))}}" class="btn btn-success btn-block">عرض
                                        الطلب</a>
                                </td>
                            </tr>
{{--                            @php $count ++; @endphp--}}
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    {!! $order->links() !!}
                </div>
            @else
                <div class="col-md-4 col-md-offset-4">
                    <div class="alert alert-error bg-danger text-center">لا يوجد نتائج بحث</div>
                </div>
            @endif
        </div>
    </div>

@endsection
