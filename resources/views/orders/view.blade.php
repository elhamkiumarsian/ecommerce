@extends('master')
@section('title') نمایش تمام سفارشات @endsection
@section('content')
<?php $i=0; ?>
{{--Beginning of user Section--}}
  @if($role==='user')
    <table class="table">
    <tbody>
    <tr>
        <th> ردیف</th>
        <th> شماره سفارش</th>
        <th>تاریخ</th>
        <th>عملیات</th>
    </tr>
    @foreach($orders as $order)
        <tr>
        <td>{{++$i}}</td>
        <td>{{$order->id}}</td>
        <td>{{jDate::forge($order->created_at)->format('%A  %d  %B  %Y - ساعت: %H:%M')}}</td>
        <td><div class="btn btn-danger" id="{{$order->id}}">نمایش جزئیات</div></td>
        </tr>
    @endforeach

    </tbody>
    </table>

  @endif
{{--End of User secion--}}
  @if($role==='admin')
   <table class="table">
   <tbody>

   <tr>
   <th>row</th>
   <th>order id</th>
   <th>User Name</th>
   <th>date</th>
   <th>actions</th>
   </tr>
   @foreach($orders as $order)
   <tr>
       <td>{{++$i}}</td>
       <td >{{$order->id}}</td>
       <td>{{$order->user->name}}</td>
       <td>{{jDate::forge($order->created_at)->format('%A  %d  %B  %Y - ساعت: %H:%M') }}</td>
       <td><button id="{{$order->id}}">نمایش جزئیات</button></td>
   </tr>
   @endforeach
   </tbody>
   </table>
   {!! $orders->render() !!}
   @endif
 @foreach($orders as $order)
   <div id="dialog_{{$order->id}}" title="view details of order # {{$order->id}}">
   <table class="table">
   <tr>
   <th>نام :</th>
   <th> آیتم</th>
   <th> مقدار</th>
   <th> مجموع هزینه</th>
   </tr>
   @foreach($order->items as $item)
   <tr>
   <td> {{$item->product}}</td>
   <td> {{$item->item}}</td>
   <td>{{$item->quantity}}</td>
   <td>{{$item->total_price}}</td>
   </tr>
   @endforeach
   </table>
   </div>
   @endforeach
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function(){
@foreach($orders as $order)
$('#dialog_{{$order->id}}').dialog({
               autoOpen: false,
               width:500
});
$('#{{$order->id}}').click(function(){
               $( "#dialog_{{$order->id}}" ).dialog( "open" );
});
@endforeach
});

</script>

@stop