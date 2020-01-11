
    @include('admin.layouts.partials.validation-errors')
    @include('flash::message')

    @inject('city','App\Models\City')
    @php
        $cities = $city->pluck('name','id')->toArray();
    @endphp

    {!! Form::text('name',null,[
        'class' => 'form-control'
    ]) !!}
    <br>
    {!! Form::select('city_id',$cities,null,[
        'class' => 'form-control',
    ]) !!}

