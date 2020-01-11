@extends('front.master')
@section('content')
    <!-- start talabaty section -->

    <div class="container">
        <div>
            @include('partials.validation_errors')
            @include('flash::message')
        </div>


        <section class="add-new-section product">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 offset-sm-3">
                        <h1 class="text-center form-title">اضف منتج جديد</h1>
                        {{--                        <form action="add-new-product.html">--}}
                        <form action="{{url('resturant/add-new-product-save')}}" enctype="multipart/form-data"
                              method="post" class="p-5 my-3 text-center">
                            {{csrf_field()}}

                            <div class="img-input">
                                <div class="img">
                                    <img src="{{asset('front/images/default-image.jpg')}}" alt="">
                                    <input type="file" name="image">
                                </div>
                                <p>صورة المنتج</p>
                            </div>
                            <div class="input-group">
                                <input type="text" placeholder="اسم المنتج" id="product-name" name="name">
                                <textarea name="description" id="product-short-description"
                                          placeholder="وصف مختصر"></textarea>
                                <input type="text" placeholder="سعر المنتج" id="product-price" name="price">
                                {{--  <input type="text" placeholder="مدة التجهيز" id="product-price" name="price">--}}
                            </div>
                            {{--   <a href="{{url('resturant/add-new-product-save')}}" class="add-new-link">اضافة</a>--}}
                            <button type="submit" class="add-new-link">اضافة</button>

                        </form>
                    </div>
                </div>
            </div>
        </section>

    </div>



@stop
