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
                <div class="header-desc">
                    <img class="website-name" src="{{asset('front/images/res-img.png ')}}" alt=""
                         style="margin: 0 auto;">
                    <h1 class="res-name">دجاج كنتاكي</h1>
                    <ul class="list-unstyled">
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                    </ul>
                </div>
            </div>
        </section>


        <section class="food">
            <div class="container">
                <div class="row text-center">
                    <div class="col-sm-12">
                        <h1><a href="">قائمة الطعام</a>/ <span>منتجاتى</span></h1>
                    </div>
                    <div class="col-sm-12">
                        <a href="{{url('resturant/add-new-product')}}" class="btn minu-btn my-5 px-5">اضف منتج جديد</a>
                        <a href="{{url('resturant/add-new-offer')}}" class="btn minu-btn my-5 px-5">اضف عرض جديد</a>
                    </div>
                </div>
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-sm-4">
                            <div class="item-holder">
                                {{--  <img src="{{asset('front/images/burger.jpg')}}" alt="item-image" width="100%">--}}
                                <img src="{{asset($product->image)}}" alt="item-image" width="100%">
                                <div class="item-data text-center">
                                    <h3 class="item-title">{{$product->name}}</h3>
                                    <p class="item-description">{{$product->description}}</p>
                                </div>
                                <div class="features">
                                    <div>
                                        <img src="{{asset('front/images/piggy-bank.png')}}" alt="" width="30px;">
                                        <span class="delevery-time">  {{$product->price}} </span>
                                    </div>
                                </div>
                                <div class="closed"><i class="fas fa-times-circle"></i></div>
                            </div>
                        </div>
                    @endforeach
                </div>
               <center>
                   <a href="{{url('resturant/my-offers')}}" class="main-btn">كل عروض مطعمنا</a>
                   <a href="{{url('resturant/current-orders')}}" class="main-btn">الطلبات الحاليه</a>

               </center>



            </div>

        </section>

    </div>



@stop
