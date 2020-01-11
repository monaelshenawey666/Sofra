
@extends('front.master')
@section('content')
    <!-- start talabaty section -->
    <div class="container">
        <div>
            @include('partials.validation_errors')
            @include('flash::message')
        </div>
        <section class=" register-page py-5 my-5">
            <div class="reg1 mx-auto my-5">
                <div><img src="{{asset('front/images/use-img.png')}}" alt="user"></div>

                <form action="{{url('resturant/registerSave')}}" method="post"
                      enctype="multipart/form-data"class="p-5 my-3 text-center">
                        {{csrf_field()}}
                    <p>تسجيل مطعم جديد</p>
                    <input type="text" name="name" class="form-control my-4" placeholder="الاسم">
                    <input type="text" name="phone" class="form-control my-4" placeholder="الجوال">
{{--                    <input type="text" name="city_id" class="form-control my-4" placeholder="المدينة">--}}
                    <input type="email" name="email" class="form-control my-4" placeholder="البريد الاليكترونى">
                    <input type="text" name="region_id" class="form-control my-4" placeholder="الحى">
                    <input type="password" name="password" class="form-control my-4" placeholder="كلمة المرور">
                    <input type="password" name="password_confirmation" class="form-control my-4" placeholder="اعادة كلمة المرور">
{{--                    <select class="form-control form-control-lg">--}}
{{--                        <option value="التصنيفات">التصنيفات</option>--}}
{{--                    </select>--}}
{{--                    @inject('cities', 'App\Models\City')--}}
{{--                    {!! Form::select('city_id', $cities->pluck('name', 'id')->toArray(), null,[--}}
{{--                        'class'=>'form-control',--}}
{{--                        'id'   =>'city',--}}
{{--                        'placeholder'=>'اختر المدينة'--}}
{{--                      ]) !!}--}}
                    @inject('categories', 'App\Models\Category')
                    {!! Form::select('categories[]', $categories->pluck('name', 'id')->toArray(), null,[
                       // 'class'=>'custom-select ',
                        'multiple'=>'multiple ',

                        'placeholder'=>'اختر التصنيفات'
                      ]) !!}

                    <input type="text" name="minimum_charger" class="form-control my-4" placeholder="الحد الادنى">
                    <input type="text" name="delivery_fee" class="form-control my-4" placeholder="رسوم التوصيل">
                    <input type="text" name="whatsNum" class="form-control my-4" placeholder="الواتس اب">

                    <div class="d-flex">
                        <label  for="customFileLang">صورة المتجر</label>
                        <input type="file" name="image" class="bg-transparent" id="customFileLang" >
                    </div>
                    <div class="form-row">
                        <div class="col new-user">
                            <p>  بإنشاء حسابك أن توافق على <a href=""> شروط الاستخدام </a> الخاصة بسفرة</p>
                        </div>
                    </div>
                    <button type="submit" class="btn w-75 mt-4 text-white">تسجيل </button><br><br>
                    :يوجد حساب بالفعل
                    <a class="register main-btn" href="{{url('resturant/login')}}">دخول </a>
                </form>
            </div>
        </section>
    </div>



@stop
