<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RUDE-HZ // CONSOLE</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-gray-200 antialiased flex">
    
    <!-- Includi qui la tua Sidebar che abbiamo scritto prima -->
    <x-admin-sidebar />

    <main class="flex-1 min-h-screen">
        {{ $slot }}
    </main>
</body>
</html>
