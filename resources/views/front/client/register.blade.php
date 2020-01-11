
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
                <form action="{{url('client/registerSave')}}" enctype="multipart/form-data"
                      method="post" class="p-5 my-3 text-center">
                    {{csrf_field()}}

                    <input type="text" name="name" class="form-control my-4" placeholder="الاسم">
                    <input type="text" name="phone" class="form-control my-4" placeholder="الجوال">
                    <input type="email" name="email" class="form-control my-4" placeholder="البريد الاليكترونى">
{{--                    <input type="text" name="city_id" class="form-control my-4" placeholder="المدينة">--}}
{{--                    <input type="text" name="region_id" class="form-control my-4" placeholder="الحى">--}}
                    <input type="password" name="password" class="form-control my-4" placeholder="كلمة المرور">
                    <input type="password" name="password_confirmation" class="form-control my-4" placeholder="اعادة كلمة المرور">


                    @inject('city', 'App\Models\City')
                    المدينة{!! Form::select('city_id', $city->pluck('name', 'id')->toArray(), null,[
                        'class'=>'form-control my-4" ',
                        'id'   =>'city',
                        'placeholder'=>'اختر المدينة'
                      ]) !!}
                   @inject('region', 'App\Models\Region')
                    الحى{!! Form::select('region_id', [], null,[
                          'class'=>'form-control my-4" ',
                          'id'   =>'regions',
                          'placeholder'=>' الحى'
                    ]) !!}


                    <div class="d-flex">
                        <label  for="customFileLang">صورة الشخصيه</label>
                        <input type="file" name="profile_image" class="bg-transparent" id="customFileLang" >
                    </div>
                    <div class="form-row">
                        <div class="col new-user">
                            <p>  بإنشاء حسابك أن توافق على <a href=""> شروط الاستخدام </a> الخاصة بسفرة</p>
                        </div>
                    </div>
                    <button type="submit" class="btn w-75 mt-4 text-white">تسجيل</button>
                    <br><br>
                    :يوجد حساب بالفعل<a class="register main-btn" href="{{url('client/login')}}">دخول </a>
                    <a class="register main-btn" href="{{url('resturant/register')}}">تسجيل حساب مطعم جديد</a>

                </form>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            $("#city").change(function (e) {
                //  alert('testtt');
                e.preventDefault();
                var city_id = $("#city").val();
                //console.log(city_id);
                if (city_id) {
                    $.ajax(
                        {
                            url: "{{url('api/v1/regions?city_id=')}}" + city_id,
                            type: 'get',
                            success: function (response) {
                                if (response.status == 1) {
                                    //console.log(data);
                                    $("#regions").empty();
                                    $("#regions").append('<option value="">اختر مدينة</option>');
                                    $.each(response.data, function (index, region) {
                                        console.log(region);
                                        $("#regions").append('<option value="' + region.id + '">' + region.name + '</option>');
                                    });
                                }
                            },
                            error: function (jqXhr, textStatus, errorMessage) {
                                alert(errorMessage);
                            }
                        });
                } else {
                    $("#regions").empty();
                    $("#regions").append('<option value="">اختر مدينة</option>');
                }
            });

        </script>
    @endpush

@stop
