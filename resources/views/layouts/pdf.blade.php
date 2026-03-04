<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'PDF')</title>
    <style>
        @page { margin: 0; }
        html, body { margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; }
        .page { width: 100%; height: 100%; position: relative; }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
