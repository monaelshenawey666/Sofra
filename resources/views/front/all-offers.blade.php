
@extends('front.master')
@section('content')
    <!-- start talabaty section -->

    <div class="container">
        <div>
            @include('partials.validation_errors')
            @include('flash::message')
        </div>
aaaaaaaaaaaaaaaaaaaaaaaall
        <section class="offers">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>العروض المتاحه الان</h1>
                    </div>
                </div>
                <div class="row">
                    @foreach($offers as $offer)
                        <div class="col-sm-6">
                            <img src="{{$offer->image}}" alt="" width="100%">
                        </div>
                        <div class="col-sm-6">
                            {{$offer->name}}
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

    </div>



@stop
