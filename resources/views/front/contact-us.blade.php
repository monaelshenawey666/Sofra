
@extends('front.master')
@section('content')
    <!-- start talabaty section -->

    <div class="container">
        <div>
            @include('partials.validation_errors')
            @include('flash::message')
        </div>

        <!-- Start Contact Section-->
        <section class="contact-us">
            <div class="container">
                <form action="{{url('contact-us-save')}}" method="post" class="contact-info">
                    {{csrf_field()}}
{{--                <form action="add-new-offer.html" class="contact-info">--}}
                    <h1 class="text-center form-title">تواصل معنا</h1>
                    <div class="input-group">
                        <input type="text" placeholder="الاسم" id="offer-name" name="name">
                        <input type="text" placeholder="البريد" id="email" name="email">
                        <input type="text" placeholder="الجوال" id="phone" name="phone">
                        <textarea name="message" id="msg" rows="10" placeholder="ما هي رسالتك"></textarea>
                    </div>
                    <div class="input-group buttons">
                        <label class="d-flex flex-row"><span>شكوى</span> <input class="w-auto ml-2" type="radio" name="state" value="Complaint"></label>
                        <label class="d-flex flex-row"><span>اقتراح</span> <input class="w-auto ml-2" type="radio" name="state"  value="Suggestion"></label>
                        <label class="d-flex flex-row"><span>استعلام</span> <input class="w-auto ml-2" type="radio" name="state"  value="Enquiry"></label>
                    </div>
{{--                    <a href="#" class="add-new-link">اضافة</a>--}}
                    <button type="submit" class="add-new-link">اضافة</button>

                </form>
            </div>
        </section>

        <!-- End Contact Section-->

    </div>



@stop
