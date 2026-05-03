<!DOCTYPE html>
<html lang="fr">

<head> 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 antialiased">
    <div class="flex min-h-screen">
        @include('layouts.partials.navbar')
        <main class="flex-1 p-8">
            @if(session('success'))
            <div class="bg-green-100 p-4 rounded mb-4">{{ session('success') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>

</html>