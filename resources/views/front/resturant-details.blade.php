
@extends('front.master')
@section('content')
    <!-- start talabaty section -->

    <div class="container">
        <div>
            @include('partials.validation_errors')
            @include('flash::message')
        </div>

        <section id="header">
            <div class="container">
{{--                @foreach($resturants as $resturant)--}}
                    <div class="header-desc">
                        <img class="website-name" src="{{asset('front/images/res-img.png ')}}" alt="" style="margin: 0 auto;">
{{--                        <img class="website-name" src="{{$resturant->image}}" alt="" style="margin: 0 auto;">--}}
{{--                        <h1 class="res-name">{{$resturant->name}}</h1>--}}
                        <ul class="list-unstyled">
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                        </ul>
                    </div>
{{--                @endforeach--}}
            </div>
        </section>

        <section class="food">
            <div class="container">
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-sm-4">
                            <div class="item-holder">
                                <img src="{{asset($product->image)}}" alt="item-image" width="100%">
                                <div class="item-data text-center">
                                    <h3 class="item-title">{{$product->name}}</h3>
                                    <p class="item-description">{{$product->description}}</p>
                                </div>
                                <div class="features">
                                    <div>
                                        <img src="{{asset('front/images/piggy-bank.png')}}" alt="" width="30px;">
                                        <span class="delevery-time">
                                        30 دقيقة تقريبا
                                    </span>
                                    </div>
                                    <div>
                                        <img src="{{asset('front/images/piggy-bank.png')}}" alt="" width="30px;">
                                        <span class="delevery-time"> {{$product->price}}</span>
                                    </div>
                                    <a href="{{url('resturant/product-details')}}" class="d-block">اضغط للتفاصيل</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


            </div>
        </section>

    </div>



@stop
