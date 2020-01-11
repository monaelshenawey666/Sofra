
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
{{--                <form action="add-new-offer.html" class="contact-info">--}}
                {!! Form::model($client,[
                'action' => ['Front\Client\AuthController@updatClientAccount',$client->id],
                'method' =>'put'
                ]) !!}
                    <div class="text-center my-3"><i class="fas fa-user-circle"></i></div>
                    <div class="input-group">
                       {!! form::text('name',null) !!}
                    </div>
{{--                    <a href="#" class="add-new-link">احفظ التعديلات</a>--}}
                    <button type="submit" class="add-new-link">احفظ التعديلات</button>

               {!! Form::close() !!}
            </div>
        </section>
    </div>



@stop
