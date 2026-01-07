<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Truyền biến từ Laravel sang JavaScript -->
    <script>
        // Định nghĩa biến global để Vue có thể truy cập
        window.APP_CONFIG = {
            APP_URL: "{{ config('app.url') }}",
            API_URL: "{{ config('app.url') }}/api",
            APP_NAME: "{{ config('app.name') }}",
            APP_ENV: "{{ config('app.env') }}",
            CSRF_TOKEN: "{{ csrf_token() }}"
        };

        // Hoặc đơn giản hơn:
        window.APP_URL = "{{ config('app.url') }}";
        window.API_URL = "{{ config('app.url') }}/api";
    </script>

    <!-- CSS và JS assets -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <app></app>
    </div>

    <!-- Load Vue app -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
