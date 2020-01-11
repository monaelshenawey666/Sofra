@extends('front.master')
@section('content')
    <!-- start talabaty section -->

    <div class="container">
        <div>
            @include('partials.validation_errors')
            @include('flash::message')
        </div>

        <section class="offers">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>العروض المتاحه الان</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <a href="{{url('resturant/add-new-offer')}}" class="btn minu-btn my-5 px-5">اضف عرضا جديداً</a>

                    </div>
                </div>
                @foreach($offers as $offer)
                    <div class="row">
                            <div class="col-sm-6">
                                <img src="{{$offer->image}}" alt="" width="100%"><br>
                                الاسم :{{$offer->name}}<br>
                                السعر في العرض:  {{$offer->price}}<br>
                                الوصف: {{$offer->description}}
                            </div>

                    </div>
                @endforeach
            </div>
        </section>

    </div>



@stop
