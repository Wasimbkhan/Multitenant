<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CRUD-LARAVEL-VUE</title>
    @vite('resources/sass/app.scss')
</head>

<body>
    <div id="main-view"></div>

    @vite('resources/js/main.js')
</body>

</html>