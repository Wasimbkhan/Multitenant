<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/sass/app.scss')
</head>

<body>
    <div id="tenant-view">
        <page-title :title="pageTitle"></page-title>
    </div>


    @vite('resources/js/tenant.js')
</body>

</html>