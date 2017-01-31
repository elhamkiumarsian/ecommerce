@extends('master')
@section('title') ثبت سفارش @endsection
@section('content')

<table class="table">
<tbody>
<tr>
<th> ردیف</th><th>محصول</th><th>آیتم</th><th>تعداد</th> <th>قیمت</th><th>جمع واحد</th><th>عملیات ها</th>
</tr>
@if(Session::has('message'))
 <div class="alert alert-success">{{Session::get('message')}}</div>
@endif
<?php $i=0;?>
<?php $totalPrice=0 ?>
@if(Session::has('basket'))
  @foreach($basket as $id=>$specs)
   <tr>
   <td>{{++$i}}</td>
   <td>{{$specs['product']}}</td>
   <td>{{$specs['item']}}</td>
   <td>{{$specs['quantity']}}</td>
   <td>{{$specs['price']}}</td>
   <td>{{$specs['total_price']}}</td>
   <td><a href="{{url('Orders/Delete/'.$id)}}" class="btn btn-danger" onclick="return confirm('Are you sure?')">حذف</a>
       <a href="{{url('Orders/Update/'.$id)}}" class="btn btn-info" id="update{{$id}}">بروز رسانی</a>
   </td>
   </tr>
   <?php $totalPrice=$totalPrice+$specs['total_price'] ?>
  @endforeach
@endif
</tbody>
</table>
<hr>
<p>قیمت کل:{{$totalPrice}} ریال</p>
<a href="{{url('Orders/Finalize')}}" class="label-success"><strong>اتمام خرید</strong></a><br>
<a href="{{url('Products')}}" ><strong>بازگشت به محصولات</strong></a>



    
@stop