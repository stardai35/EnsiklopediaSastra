<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ensiklopedia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>
<body class="bg-gray-50 text-gray-800 font-sans">
    
    <nav class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-900">ENSIKLOPEDIA</a>
            <div class="space-x-4">
                <input type="text" placeholder="Cari..." class="border rounded-full px-4 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            &copy; {{ date('Y') }} Ensiklopedia Digital.
        </div>
    </footer>
</body>
</html>