<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Vue Infinite Scroll</title>
        <link rel="stylesheet" type="text/css" href="/css/app.css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet">

    </head>
    <body class="bg-gray-100 font-sans">
        <div id="app">
            <cats></cats>
        </div>

        <script src="/js/app.js"></script>
    </body>
</html>
