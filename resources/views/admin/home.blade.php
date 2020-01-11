@extends('admin.layouts.main',[
                                'page_header'       => 'تطبيييق سفرة',
                                'page_description'  => 'لوحة التحكم'
                                ])
@inject('resturant','App\Models\Resturant')
@inject('order','App\Models\Order')
@inject('client','App\Models\Client')
@inject('order','App\Models\Order')
@inject('contact','App\Models\Contact')
@inject('region','App\Models\Region')
<?php
$usersCount = $client->all()->count();
$ordersCount = $order->where('state','!=','pending')->get()->count();
$resturantCount = $resturant->all()->count();
$orderCount = $order->all()->count();
$contactCount = $contact->all()->count();
$regionCount = $region->all()->count();
?>
@section('content')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-cutlery"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">عدد المطاعم</span>
                    <span class="info-box-number">{{$resturantCount}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-tasks"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">عدد الطلبات المكتملة</span>
                    <span class="info-box-number">{{$ordersCount}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">عدد المستخدمين</span>
                    <span class="info-box-number">{{$usersCount}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

    </div>
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-list-ol"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">عدد العروض</span>
                    <span class="info-box-number">{{$orderCount}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-envelope"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">الرسائل</span>
                    <span class="info-box-number">{{$contactCount}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-building-o"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">عدد المناطق</span>
                    <span class="info-box-number">{{$regionCount}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

    </div>
    <!-- /.row -->
@endsection

