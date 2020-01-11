
@extends('front.master')
@section('content')
    <!-- start talabaty section -->

    <div class="container">
        <div>
            @include('partials.validation_errors')
            @include('flash::message')
        </div>

        <section class="meal-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="meal-desc">
                            <h1>{{$product->name}}</h1>
                            <p>{{$product->description}}</p>
                            <p><img src="{{asset('front/images/piggy-bank.png')}}" alt="" width="50px"> السعر : {{$product->price}}</p>
                            <p><img src="{{asset('front/images/piggy-bank.png')}}" alt="" width="50px">  مدة تجهيز الطلب : 20 دقيقة</p>
                            <p><img src="{{asset('front/images/piggy-bank.png')}}" alt="" width="50px"> السعر : 25 ريال</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="meal-img">
                            <img src="{{asset($product->image)}}" alt="meal-img" width="100%" class="meal-img">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Start Cart Section -->
        <section class="add-to-cart-sec">
            <div class="container">
                <a href="#" class="add-to-cart">
                    اضف الي العربة
                </a>
                <div class="cart-info">
                    <i class="fas fa-info"></i>
                    <span>معلومات عن المتجر</span>
                </div>
                <div class="rate-heading">
                    <h2>تقييم المستخدمين</h2>
                    <span>155 تقييم</span>
                </div>
                <!-- Rates Added -->
                <div class="row">
                    @foreach($contacts as $contact)
                        <div class="col-md-6">
                            <div class="rate-com">
                                <ul class="list-unstyled">
                                    <li class="fa fa-star"></li>
                                    <li class="fa fa-star"></li>
                                    <li class="fa fa-star"></li>
                                    <li class="fa fa-star"></li>
                                    <li class="fa fa-star"></li>
                                </ul>
                                <h3>بواسطة :{{$contact->name}}</h3>
                                <p>بواسطة :{{$contact->message}}</p>
                            </div>
                        </div>
                   @endforeach


                </div>

                <!-- Add Rate To Service -->
                <div class="add-rate">
                    <h2>اضف تقييمك</h2>
                    <ul class="list-unstyled">
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                        <li class="fa fa-star"></li>
                    </ul>
                    <form action="">
                        <textarea name="rate" id="rate" cols="30" rows="10" placeholder="اضف تقييمك"></textarea>
                        <input type="submit" value="ارسال" name="submit">
                    </form>
                </div>
            </div>
        </section>
        <!-- End Add Cart Section -->

        <!-- Start More Meals Section -->
        <section class="more-meals">
            <h2>المزيد من أكلات هذا المطعم</h2>
            <div class="meals-imgs">
                <div class="contanier-fluid">
                    <div class="slider">
                        <div class="item">
{{--                            @foreach($product as $product)--}}
                                <img src="{{asset($product->image)}}" alt="item-image" width="100%">
{{--                            @endforeach--}}
{{--                            <img src="{{asset('front/images/erik-odiin-787777-unsplash.jpg')}}" alt="Meal">--}}
                        </div>


                    </div>
                </div>
            </div>
        </section>
        <!-- End More Meals Section -->

    </div>



@stop
