@extends('front.master')
@section('content')
    {{--    @inject('cities','App\Models\City')--}}
    {{--    @inject('resturants ','App\Models\Resturant')--}}
    <!-- Start Header Section -->
    <header class="text-center">
        <div class="container">
            <div>
                @include('flash::message')
            </div>
            <div class="header-content">
                <h1>سفرة</h1>
                <p>بتشتري...بتبيع؟ كله عند ام ربيع</p>
                <a class="register main-btn" href="{{url('client/register')}}">
                    <span>سجل الأن</span>
                    <i class="fa fa-code"></i>
                </a>
{{--                @if(auth()->guard('client-web')->check())--}}

{{--                    <button class="register main-btn" onclick= "window.location.href = '{{url('client/logout')}}';">logout</button>--}}
{{--                @else--}}
{{--                    <a class="register main-btn" href="{{url('client/register')}}">--}}
{{--                                        <span>سجل الأن</span>--}}
{{--                                        <i class="fa fa-code"></i>--}}
{{--                    </a>--}}
{{--                @endif--}}
            </div>
        </div>
    </header>
    <!-- End Header Section -->

    <!-- Start Favs Resturants Section -->
    <section class="favs text-center bg-gry">
        <div class="container">
            <h2>Find your favorite restaurant</h2>
            {!! Form::open(['method'=>'get']) !!}
            <div class="row">
                <div class="col-md-5">

                    {!!  Form::select('city',$cities->pluck('name','id')->toArray(),request()->input('city'),[
                     'class' => 'form-control',
                     'placeholder'=>'select city',
                     'style'=>'height: 50px;border-radius: 20px',
                     ]) !!}
                </div>

                <div class="col-md-5">
{{--                    {!!  Form::select('name',$resturants->pluck('name','id')->toArray(),request()->input('name'),[--}}
{{--                      'class' => 'form-control',--}}
{{--                       'placeholder'=>'select favorite restaurant',--}}
{{--                       'style'=>'height: 50px;border-radius: 20px',--}}
{{--                    ]) !!}--}}
                    {!! Form::text('name',request()->input('name'),[
                              'placeholder' => 'اسم المطعم',
                              'class' => 'form-control'
                              ]) !!}
                </div>

                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary "><i class="fa fa-search"></i></button>
                </div>
                {!! Form:: close()!!}
            </div>

            <div class="row mt-5">

                @foreach($resturants as $resturant)
                    <div class="col-md-6">
                        <div class="box text-center">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ file_exists($resturant->image) ? asset($resturant->image) : asset('default.jpg')}}" alt="Favs">

                                </div>
                                <div class="col-md-4">
                                    <h3>{{$resturant->name}} {{$resturant->rate}} </h3>
                                    <ul class="list-unstyled stars">
                                        @for($i=1; $i<=5; $i++)
                                            <li class="@if($resturant->rate >= $i) active @endif">
                                                <i class="fa fa-star"></i>
                                            </li>
                                        @endfor
                                    </ul>

                                    <p>Minimum order : <span>{{$resturant->minimum_charger}}</span> SR</p>
                                    <p>Delivery charge : <span>{{$resturant->delivery_charge}}</span> SR</p>
                                </div>
                                <div class="col-md-4">
                                    @if($resturant->activated == 1)
                                        <span class="status">on</span>
                                    @else
                                        <span class="status2">off</span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                <a href="{{url('resturant/details/'.$resturant->id)}}">تفاصيل منتجات اخري للمطعم </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        </div>
    </section>

    <!-- End Favs Resturants Section -->

    <!-- Start Featues Section -->
    <section class="feats text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="offers">
                        <img src="{{asset('front/images/Group 1036.png')}}" alt="Offers">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <p>لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور
                            أنكايديديونتيوت لابوري ات دولار ماجنا أليكيوا . يوت انيم أد مينيم فينايم,كيواس نوستريد
                            أكسير سيتاشن يللأمكو لابورأس نيسي يت أليكيوب أكس أيا كوممودو كونسيكيوات .</p>
                        <a class="main-btn" href="resturant/all-offers">
                            شاهد العروض
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Featues Section -->

    <!-- Start Download Section -->
    <section class="download">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{asset('front/images/app mockup.png')}}" alt="Offers">
                </div>
                <div class="col-md-6">
                    <div class="card text-center">
                        <h2>قم بتحميل التطبيق الخاص بنا الان</h2>
                        <a class="main-btn" href="#">
                            <span>حمل الأن</span>
                            <i class="fa fa-arrow-down"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Download Section -->


@stop
