<!DOCTYPE html>
<html lang="it" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RUDE-HZ // CONSOLE</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black font-sans antialiased flex">
    
    <!-- Sidebar -->
    <x-admin-sidebar />

    <!-- Main Content -->
    <main class="flex-1 min-h-screen overflow-y-auto">
        {{ $slot }}
    </main>

</body>
</html>
