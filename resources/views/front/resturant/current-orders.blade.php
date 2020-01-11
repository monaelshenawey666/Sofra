@extends('front.master')
@section('content')
    <!-- start talabaty section -->

    <div class="container">
        <div>
            @include('partials.validation_errors')
            @include('flash::message')
        </div>

        <!-- start talabaty section -->
        <section class="orders">
            <div class="order-state py-5 d-flex">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-left"><a href="#">طلبات حالية</a></h5>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-right"><a href="previous-orders">طلبات سابقة</a></h5>
                        </div>
                    </div>
                </div>
            </div><!--End order-state-->
            <div class="order-details">
                <div class="container">
                    @foreach($orders as $order)
                        <div class="order-current my-5">
                            <div class="row text-center">
                                <div class="col-md-3 py-3 px-4">
    {{--                                <img src="images/user-photo.png" class="img-fluid" alt="">--}}
                                </div>
                                <div class="col-md-8 pt-3 text-left">
                                    <p class="py-1"> اسم العميل : <span> {{optional($order->client_id)->name}} </span></p>
                                    <p class="py-1 mncolor">رقم الطلب <span>{{$order->id}}</span></p>
                                    <p class="py-1 mncolor">المجموع :  <span>{{$order->total}}</span> ريال</p>
                                    <p class="py-1 mncolor">العنوان :  <span>{{$order->address_delivery}}</span></p>
                                </div>
                                <div class="col mb-4">
                                    <button class="btn bg-mncolor mx-3 px-5">01006383877</button>
                                    <button class="btn btn-success mx-3 px-5">تأكيد التسليم</button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>

    </div>



@stop
