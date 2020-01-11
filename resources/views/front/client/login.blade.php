
@extends('front.master')
@section('content')
    <!-- start talabaty section -->

    <div class="container">
        <div>
            @include('partials.validation_errors')
            @include('flash::message')
        </div>
        <section class=" register-page py-5 my-5">
            <div class="reg mx-auto my-5">
                <div><img src="{{asset('front/images/use-img.png')}}" alt="user"></div>
                <form action="{{url('client/loginSave')}}" method="post" class="p-5 my-3 text-center">
                    {{csrf_field()}}

{{--                        <input type="text" name="name" class="form-control my-4" placeholder="الاسم">--}}
                        <input type="email" name="email" class="form-control my-4" placeholder="البريد الاليكترونى">
                        <input type="password" name="password" class="form-control my-4" placeholder="كلمه المرور">

                    <button type="submit" class="btn w-75 my-4 text-white">دخول</button>
                        <div class="form-row my-3">
                            <div class="col new-user">
                                <a href="{{url('client/register')}}">مستخدم جديد ؟</a>
                            </div>
                            <div class="col pass">
                                <a href="password-reset">نسيت كلمة السر ؟</a>
                            </div>
                        </div>
                    <a class="register main-btn" href="{{url('client/register')}}">
                        انشيء حساب الآن
                    </a>
                </form>
            </div>
        </section>
    </div>



@stop
