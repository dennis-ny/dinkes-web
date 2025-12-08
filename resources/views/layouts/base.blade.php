<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dinas Kesehatan Kota Kediri')</title>

    @vite('resources/css/app.css')

    @stack('styles')
</head>

<body>

    @yield('layout-content')

    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>

    @stack('scripts')
</body>

</html>