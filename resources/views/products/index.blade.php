@extends('master')
@section('title') نمایش تمام محصولات @endsection
@section('head')
    <style rel="stylesheet">
        .glyphicon {
            margin-right: 5px;
        }

        .thumbnail {
            margin-bottom: 20px;
            padding: 0px;
            -webkit-border-radius: 0px;
            -moz-border-radius: 0px;
            border-radius: 0px;
        }

        .item.list-group-item {
            float: none;
            width: 100%;
            background-color: #fff;
            margin-bottom: 10px;
        }

        .item.list-group-item:nth-of-type(odd):hover, .item.list-group-item:hover {
            background: #428bca;
        }

        .item.list-group-item .list-group-image {
            margin-right: 10px;
        }

        .item.list-group-item .thumbnail {
            margin-bottom: 0px;
        }

        .item.list-group-item .caption {
            padding: 9px 9px 0px 9px;
        }

        .item.list-group-item:nth-of-type(odd) {
            background: #eeeeee;
        }

        .item.list-group-item:before, .item.list-group-item:after {
            display: table;
            content: " ";
        }

        .item.list-group-item img {
            float: left;
        }

        .item.list-group-item:after {
            clear: both;
        }

        .list-group-item-text {
            margin: 0 0 11px;
        }
    </style>
@endsection
@section('content')
    <br>
    @if(Session::has('message'))
        <div class="alert alert-success">{{Session::get('message')}}</div>
    @endif
    <center>
        <a href="{{url('Orders')}}">
            <div class="btn btn-primary">مشاهده سبد خرید شما</div>
        </a>
        <a href="{{url('Orders/View')}}">
            <div class="btn btn-warning">مشاهده سوابق سفارشات</div>
        </a>
         <a href="{{url('Products/Add')}}">
            <div class="btn btn-warning">ایجاد محصول</div>
        </a>
    </center>
<br>



    <div class="container">
        <div class="well well-sm">

            <center>
                <strong style="color: red;">Fire360Boy</strong><br>
            <div class="btn-group">
                <a href="#" id="list" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list">
            </span>لیست</a> <a href="#" id="grid" class="btn btn-default btn-sm"><span
                            class="glyphicon glyphicon-th"></span>جدول</a>
            </div></center>
        </div>

        <div id="categories-list" class="row list-group">
        @foreach($mainProducts as $mainProduct)




                <a href="{{url('Products/Show/'.$mainProduct->id)}}">
                <div class="item  col-xs-4 col-lg-4">
                    <div class="thumbnail">
                        @if(array_key_exists($mainProduct->id,$filesList))
                            {{--<img src="" width="200" height="200">--}}
                            <img class="group list-group-image"
                                 src="{{url('images/Product/'.$filesList[$mainProduct->id]['basename'])}}" alt=""/>
                        @endif


                        <div class="caption">
                            <h4 class="group inner list-group-item-heading">
                                {{$mainProduct->name}}</h4>

                            <p class="group inner list-group-item-text">
                                {{$mainProduct->desc}}</p>


                        </div>
                    </div>
                </div>
                </a>

        @endforeach
    </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#list').click(function (event) {
                event.preventDefault();
                $('#categories-list .item').addClass('list-group-item');
            });
            $('#grid').click(function (event) {
                event.preventDefault();
                $('#categories-list .item').removeClass('list-group-item');
                $('#categories-list .item').addClass('grid-group-item');
            });
        });
    </script>
@endsection
