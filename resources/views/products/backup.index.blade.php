@extends('master')
@section('title') نمایش تمام محصولات @endsection
@section('content')
@if(Session::has('message'))
 <div class="alert alert-success">{{Session::get('message')}}</div>
@endif
  <a href="{{url('Orders')}}">مشاهده سبد خرید شما</a>
  <a href="{{url('Orders/View')}}">مشاهده سوابق سفارشات</a>
 @foreach($mainProducts as $mainProduct)
    <a href="{{url('Products/Show/'.$mainProduct->id)}}"> {{$mainProduct->name}}</a><br>
    @if(array_key_exists($mainProduct->id,$filesList))
    <img src="{{url('images/Product/'.$filesList[$mainProduct->id]['basename'])}}" width="200" height="200">
    @endif
 @endforeach
@stop