@extends('front.master')
@section('content')
    <!-- start talabaty section -->

    <div class="container">
        <div>
            @include('partials.validation_errors')
            @include('flash::message')
        </div>

        <!-- start talabaty section -->
{{--        <section class="orders">--}}
{{--            <div class="order-state py-5 d-flex">--}}
{{--                <div class="container">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-6">--}}
{{--                            <h5 class="text-left"><a href="resturant/current-orders">طلبات حالية</a></h5>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-6">--}}
{{--                            <h5 class="text-right"><a href="my-offers">طلبات سابقة</a></h5>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div><!--End order-state-->--}}
{{--            <div class="order-details">--}}
{{--                <div class="container">--}}
{{--                    @foreach($orders as $order)--}}
{{--                        <div class="order-current my-5">--}}
{{--                            <div class="row text-center">--}}
{{--                                <div class="col-md-3 py-3 px-4">--}}
{{--    --}}{{--                                <img src="images/user-photo.png" class="img-fluid" alt="">--}}
{{--                                </div>--}}
{{--                                <div class="col-md-8 pt-3 text-left">--}}
{{--                                    <p class="py-1"> اسم العميل : <span> {{optional($order->client_id)->name}} </span></p>--}}
{{--                                    <p class="py-1 mncolor">رقم الطلب <span>{{$order->id}}</span></p>--}}
{{--                                    <p class="py-1 mncolor">المجموع :  <span>{{$order->total}}</span> ريال</p>--}}
{{--                                    <p class="py-1 mncolor">العنوان :  <span>{{$order->address_delivery}}</span></p>--}}
{{--                                </div>--}}
{{--                                <div class="col mb-4">--}}
{{--                                    <button class="btn bg-mncolor mx-3 px-5">01006383877</button>--}}
{{--                                    <button class="btn btn-success mx-3 px-5">تأكيد التسليم</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}
    <!-- start talabaty section -->
        <section class="orders">
            <div class="order-state py-5 d-flex">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-left"><a href="resturant/current-orders">طلبات حالية</a></h5>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-right"><a href="#">طلبات سابقة</a></h5>
                        </div>
                    </div>
                </div>
            </div><!--End order-state-->
            <div class="order-details">
                <div class="container">
                    @foreach($orders as $order)
                        <div class="order-info my-5">
                            <div class="row text-center">
                                <div class="col-md-3 py-3 px-4">
                                    <img src="{{asset('front/images/burger.jpg')}}" class="img-fluid" alt="">
                                </div>
                                <div class="col-md-8 py-3 text-left">
                                    <h4 class="py-2">name</h4>
                                    <p class="py-1">رقم الطلب <span>{{$order->id}}</span></p>
                                    <p class="py-1">المجموع :  <span>{{$order->cost}}</span> ريال</p>
                                    <p class="py-1"> التوصيل <span>10</span></p>
                                    <p class="py-1">الإجمالى :  <span>{{$order->total}}</span> ريال</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </div>



@stop
