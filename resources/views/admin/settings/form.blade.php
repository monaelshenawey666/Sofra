@include('admin.layouts.partials.validation-errors')
@include('flash::message')

<h3>اعدادات التطبيق</h3>

<h4>بيانات التواصل الاجتماعي</h4>
<label>فيس بوك</label>
{!! Form::text('facebook' ,null,['class'=>'form-control','placeholder'=> 'فيس بوك']) !!}
<br/>

<label>تويتر</label>
{!! Form::text('twitter',null,['class'=>'form-control','placeholder'=> 'تويتر']) !!}
<br/>

<label>انستجرام</label>
{!! Form::text('instagram',null,['class'=>'form-control','placeholder'=> 'انستجرام']) !!}


<hr>
<label>عمولة التطبيق</label>
{!! Form::number('commission',null,['class'=>'form-control','placeholder'=> 'عمولة التطبيق']) !!}
<br/>

<label>عن التطبيق</label>
{!! Form::textarea('about_app',null,['class'=>'form-control','placeholder'=> 'عن التطبيق']) !!}
<br/>

<label>الشروط والأحكام</label>
{!! Form::textarea('terms',null,['class'=>'form-control','placeholder'=> 'الشروط والأحكام']) !!}

<hr>
<h4>بيانات صفحة العمولة</h4>
<label>نص العمولة</label>
{!! Form::textarea('commissions_text',null,['class'=>'form-control','placeholder'=> 'نص العمولة']) !!}
<br/>

<label>الحسابات البنكية</label>
{!! Form::textarea('account_bank',null,['class'=>'form-control','placeholder'=> 'الحسابات البنكية']) !!}




