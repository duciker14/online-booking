<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    @include('layouts.auth.particials.header')
    <title>@yield('title')</title>
    @yield('css')
</head>
<body>
    @yield('content')

    @yield('script')
</body>
</html>
