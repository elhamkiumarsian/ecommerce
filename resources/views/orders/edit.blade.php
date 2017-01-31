
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>مشاهده محصولات</title>

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" href="{{asset('/css/bootstrap-rtl.min.css')}}">
	<link rel="stylesheet" href="{{asset('/css/style.css')}}">
	<link rel="stylesheet" href="{{asset('/css/font-awesome.css')}}">

</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">سامانه ثبت سفارش تتافون</a>
			</div>

			<div class="collapse navbar-collapse" id="navbar">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">خوش آمدید</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if(auth()->guest())
						@if(!Request::is('auth/login'))
							<li><a href="{{ url('/auth/login') }}">ورود</a></li>
						@endif
						@if(!Request::is('auth/register'))
							<li><a href="{{ url('/auth/register') }}">ثبت نام</a></li>
						@endif
					@else
					    <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">عملیات<span class="caret"></span></a>
                            <ul  class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/Products') }}">دیدن محصولات</a></li>
                            <li><a href="{{ url('/Orders') }}">اضافه کردن سفارش</a></li>

                            </ul>
                        </li>
						<li class="dropdown pull-right">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ auth()->user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">خروج</a></li>
							</ul>
						</li>

                            <ul class="nav navbar-nav">
							<li>
						    <a   href="{{url('Orders')}}">
							نمایش سبد خرید شما
							<i class="icon-shopping-cart"></i>
							</a>

					     </li>
					     </ul>

					@endif
				</ul>
			</div>
		</div>
	</nav>
<p> نام محصول :<b>{{$item['product']}} </b></p>
<p> {{$item['item']}}</p>
<p> قیمت : {{$item['price']}}</p>
{!! Form::open() !!}
<input type="number" name='quantity' value="{{$item['quantity']}}">
<input hidden="hidden" name="record_id" type="text" value="{{$id}}">
<input type="submit" value="change">
{!! Form::close() !!}

