<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#9b8b6e">
    <title inertia>{{ config('app.name') }}</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'], 'build/admin')
    @inertiaHead
</head>
<body class="bg-pearl-100 antialiased">
@inertia

<x-support-bubble />
@routes
</body>
</html>
