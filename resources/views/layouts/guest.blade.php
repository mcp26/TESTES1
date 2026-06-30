<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-4">
        <div class="mb-4 text-center">
            <i class="bi bi-tools text-dark" style="font-size:3rem;"></i>
            <h4 class="mt-2 fw-bold">{{ config('app.name') }}</h4>
        </div>
        <div class="card shadow-sm" style="width:100%;max-width:420px;">
            <div class="card-body p-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
