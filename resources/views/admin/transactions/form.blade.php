@include('admin.layouts.partials.validation-errors')
@include('flash::message')

@inject('resturant','App\Models\Resturant')

{!! Form::select('resturant_id',$resturant->get()->pluck('resturant_details','id'),null,[
        'class' => 'form-control',
]) !!}
<br/>
{!! Form::number('amount',null,['class'=>'form-control','placeholder'=>'المبلغ']) !!}
<br/>
{!! Form::text('note',null,['class'=>'form-control','placeholder'=>'بيان العملية']) !!}

