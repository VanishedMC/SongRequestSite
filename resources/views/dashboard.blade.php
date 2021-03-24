<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="user" content="{{ isset($user) ? json_encode($user) : '{"guest": true}' }}">
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        
        <title>Beat Saber Song Requests</title>
    </head>
    <body>
       <div id="app"></div>

       <script src="/js/app.js"></script>
    </body>
</html>