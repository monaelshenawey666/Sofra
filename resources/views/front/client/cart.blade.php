
@extends('front.master')
@section('content')
    <!-- start talabaty section -->
    <div class="container">
        <div>
            @include('partials.validation_errors')
            @include('flash::message')
        </div>


        <section class="cart">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 offset-sm-3">
                        <div class="cart-item">
                            <div class="row">
                                <div class="col-sm-5">
                                    <img src="{{asset('front/images/erik-odiin-787777-unsplash.jpg')}}" alt="">
                                </div>
                                <div class="col-sm-7">
                                    <p>بيف برجر 250 جرام</p>
                                    <p>75 ريال</p>
                                    <p>البائع : wild burger</p>
                                    <p>الكيمه : <span>1</span></p>
                                    <a href="#" class="add-new-link"><span class="cricle">X</span> امسح</a>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </section>

@stop
