@extends('front.master')
@section('content')
    <!-- start talabaty section -->

    <div class="container">
        <div>
            @include('partials.validation_errors')
            @include('flash::message')
        </div>


        <section class="add-new-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 offset-sm-3">
                        <h1 class="text-center form-title">اضف عرض جديد</h1>
{{--                        <form action="add-new-offer.html">--}}
                            <form action="{{url('resturant/add-new-offer-save')}}" enctype="multipart/form-data"
                                  method="post" class="p-5 my-3 text-center">
                                {{csrf_field()}}
                            <div class="img-input">
                                <div class="img">
                                    <img src="{{asset('front/images/default-image.jpg')}}" alt="">
                                    <input type="file" name="image" id="offer_image">
                                </div>
                                <p>صورة العرض</p>
                            </div>
                            <div class="input-group">
                                <input type="text" placeholder="اسم العرض" id="offer-name" name="name">
                                <textarea name="description" id="offer-short-description" placeholder="وصف مختصر"></textarea>
                                <input type="text" placeholder="سعر العرض" id="offer-price" name="price">
                            </div>
                            <div class="input-group d-flex date">
                                <div>
                                    <input class="from" name="start_date" placeholder="من"/>
                                </div>
                                <div>
                                    <input class="to" name="end_date" placeholder="الى"/>
                                </div>
                            </div>
{{--                            <a href="#" class="add-new-link">اضافة</a>--}}
                                <button type="submit" class="add-new-link">اضافة</button>

                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>



@stop
