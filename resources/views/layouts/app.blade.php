<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-700">📚 Perpustakaan</h1>

        <form method="POST" action="/logout">
            @csrf
            <button class="bg-red-500 text-white px-4 py-2 rounded-lg">
                Logout
            </button>
        </form>
    </nav>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex">

        @include('layouts.sidebar')

        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>

</body>

</html>