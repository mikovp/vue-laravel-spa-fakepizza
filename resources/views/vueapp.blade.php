<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/app.css">
</head>
<body>
@if(auth()->check())
    <script>
        window.user = {!! auth()->user()  !!}
    </script>
@endif
<div id="app">
    <home></home>
</div>
<script type="text/javascript" src="js/app.js"></script>
</body>
</html>
