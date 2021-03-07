<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>家庭動態調查樣本名單管理系統-@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css"/>
</head>
<body>
    <div class="top">
        <img style="float: left;" src="{{ asset('img/PSFD_logo1.png')}}">
        <div class="webname">樣本名單資料庫</div>
    </div>
    @section('menu')
        
    @endsection
    <hr>
    <div class="content">
    @section('content')
    
    @show
</div> 


</body>
</html>