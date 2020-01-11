@inject('city','App\Models\City')
@inject('user','App\User')
@php
$cities = $city->pluck('name','id')->toArray();
@endphp
<style>
    span.select2-container {
        z-index: 10050;
        width: 100% !important;
        padding: 0;
    }
    .select2-container .select2-search--inline {
        float: left;
        width: 100%;
    }
    .restaurant-filter span.select2-container {
        z-index: 999;
        width: 100% !important;
        padding: 0;
    }

    /*.modal-open .modal {*/
        /*overflow-x: hidden;*/
        /*overflow-y: auto;*/
        /*z-index: 99999;*/
    /*}*/
</style>
@extends('admin.layouts.main',[
								'page_header'		=> 'المطاعم',
								'page_description'	=> 'عرض المطاعم'
								])
@section('content')
    <div class="box box-primary">
        <div class="box-header">
                <div class="clearfix"></div>
                <br>
                <div class="restaurant-filter">
                    {!! Form::open([
                    'method' => 'get'
                    ]) !!}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::text('name',request()->input('name'),[
                                'placeholder' => 'اسم المطعم',
                                'class' => 'form-control'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::select('city_id',$cities,request()->input('city_id'),[
                                'class' => 'select2 form-control',
                                'placeholder' => 'المدينة'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
{{--                             'soon' => 'قريبا',--}}
                            <div class="form-group">
                                {!! Form::select('availability',['open' => 'مفتوح', 'closed' => 'مغلق'],request()->input('availability'),[
                                'class' => 'select2 form-control',
                                'placeholder' => 'حالة المطعم'
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
        </div>
        <div class="box-body">
            @include('flash::message')
            @if(count($resturants) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <th>#</th>
                        <th>اسم المطعم</th>
                        <th>المدينة</th>
                        <th class="text-center">العمولات المستحقة</th>
                        <th class="text-center">حالة المطعم</th>
                        <th class="text-center">تفعيل / إيقاف</th>
                        <th class="text-center">حذف</th>
                        </thead>
                        <tbody>
                        @php $count = 1; @endphp
                        @foreach($resturants as $resturant)
                            <tr id="removable{{$resturant->id}}">
                                <td>{{$count}}</td>
                                <td><a style="cursor: pointer" data-toggle="modal" data-target="#myModal{{$resturant->id}}">
                                        {{$resturant->name}}</a>
                                </td>
                                <td>

{{--                                    @if(($resturant->region)->count())--}}
{{--                                        {{optional($resturant->region)->name}}--}}
{{--                                        @if(($resturant->region->city)->count())--}}
{{--                                            {{optional($resturant->region->city)->name}}--}}
{{--                                        @endif--}}
{{--                                    @endif--}}

                                    {{optional($resturant->region)->name}}/
                                    {{optional($resturant->region->city)->name}}
                                </td>
                                <td class="text-center">
                                    {{ $resturant->total_commissions - $resturant->total_payments }}
                                </td>
                                <td class="text-center">
{{--                                    @if($resturant->is-open == 'true')--}}
                                    @if($resturant->is_open == true)
                                         <i class="fa fa-circle-o text-green"></i> مفتوح
                                    @else
                                        <i class="fa fa-circle-o text-red"></i> مغلق
                                    @endif

                                </td>
                                <td class="text-center">
                                    @if($resturant->activated)
                                        <a href="resturant/{{$resturant->id}}/de-activate" class="btn btn-xs btn-danger"><i class="fa fa-close"></i> إيقاف</a>
                                    @else
                                        <a href="resturant/{{$resturant->id}}/activate" class="btn btn-xs btn-success"><i class="fa fa-check"></i> تفعيل</a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button id="{{$resturant->id}}" data-token="{{ csrf_token() }}"
                                            data-route="{{URL::route('resturant.destroy',$resturant->id)}}"
                                            type="button" class="destroy btn btn-danger btn-xs"><i class="fa fa-trash-o"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="myModal{{$resturant->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">{{$resturant->name}}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <ul>
                                                        <li> العنوان :  {{$resturant->address}}</li>
                                                        <li> المدينة :
{{--                                                            @if(count($resturant->region))--}}
{{--                                                                {{$resturant->region->name}}--}}
{{--                                                                @if(count($resturant->region->city))--}}
{{--                                                                    {{$resturant->region->city->name}}--}}
{{--                                                                @endif--}}
{{--                                                            @endif--}}
                                                            {{optional($resturant->region)->name}}/
                                                            {{optional($resturant->region->city)->name}}
                                                        </li>
                                                        <li> الحد الأدنى للطلبات : {{$resturant->minimum_charger}}</li>
                                                        <li> للتواصل : {{$resturant->phone}}</li>
                                                        <hr>
                                                        <li>إجمالي الطلبات : {{$resturant->total_orders_amount}}</li>
                                                        <li>إجمالي العمولات المستحقة : {{$resturant->total_commissions}}</li>
                                                        <li>إجمالي المبالغ المسددة : {{$resturant->total_payments}}</li>
                                                        <li>صافي العمولات المستحقة : {{$resturant->total_commissions - $resturant->total_payments}}</li>
                                                    </ul>
                                                </div>
                                                <div class="col-lg-4">
                                                    <img height="150px" width="150px" src="{{url('/'.$resturant->image.'/')}}"/>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    {!! $resturants->render() !!}
                </div>
            @else
                <div class="col-md-4 col-md-offset-4">
                    <div class="alert alert-info bg-blue text-center">لا يوجد سجلات مطاعم </div>
                </div>
            @endif

        </div>
    </div>


@stop
