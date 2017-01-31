<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('/css/bootstrap.css')}}">
    {{--<link rel="stylesheet" href="{{asset('/css/bootstrap-rtl.min.css')}}">--}}
    <link rel="stylesheet" href="{{asset('/css/bootstrap-theme.css')}}">
    <link rel="stylesheet" href="{{asset('/css/jquery-ui.css')}}">
    <link rel="stylesheet" href="{{asset('/css/jquery-ui.theme.css')}}">
    <link rel="stylesheet" href="{{asset('/css/jquery-ui.structure.css')}}">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    @yield('head')
</head>
<body >
@yield('content')


<script type="text/javascript" src="{{asset('/Js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('/Js/bootstrap.js')}}"></script>
<script type="text/javascript" src="{{asset('/Js/jquery-ui.js')}}"></script>
<script type="text/javascript" src="{{asset('/Js/nestedSortable.js')}}"></script>

@yield('js')


</body>
</html>