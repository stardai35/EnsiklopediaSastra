<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ensiklopedia Sastra') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased text-slate-900 bg-white">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100" x-data="{ open: false }">
            <nav class="mx-auto flex max-w-7xl items-center justify-between p-4 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <a href="{{ route('home') }}" class="-m-1.5 p-1.5 flex items-center gap-2">
                        <span class="text-xl font-bold bg-gradient-to-r from-purple-600 to-blue-500 bg-clip-text text-transparent">Ensiklopedia Sastra</span>
                    </a>
                </div>
                <!-- Mobile menu button -->
                <div class="flex lg:hidden">
                    <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700" @click="open = true">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
                <!-- Desktop menu -->
                <div class="hidden lg:flex lg:gap-x-8">
                    <a href="{{ route('home') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-purple-600">Beranda</a>
                    <a href="#" class="text-sm font-semibold leading-6 text-gray-900 hover:text-purple-600">Pengarang</a>
                    <a href="#" class="text-sm font-semibold leading-6 text-gray-900 hover:text-purple-600">Karya Sastra</a>
                    <a href="#" class="text-sm font-semibold leading-6 text-gray-900 hover:text-purple-600">Tentang Kami</a>
                </div>
                <!-- Login/Search -->
                <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-4">
                    <a href="/admin" class="text-sm font-semibold leading-6 text-gray-900">Log in <span aria-hidden="true">&rarr;</span></a>
                </div>
            </nav>
            
            <!-- Mobile menu -->
            <div class="lg:hidden" x-show="open" @click.away="open = false" style="display: none;">
                <div class="fixed inset-0 z-50"></div>
                <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                    <div class="flex items-center justify-between">
                        <a href="#" class="-m-1.5 p-1.5">
                             <span class="text-xl font-bold text-purple-600">Ensiklopedia Sastra</span>
                        </a>
                        <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" @click="open = false">
                            <span class="sr-only">Close menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-my-6 divide-y divide-gray-500/10">
                            <div class="space-y-2 py-6">
                                <a href="{{ route('home') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Beranda</a>
                                <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Pengarang</a>
                                <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Karya Sastra</a>
                            </div>
                            <div class="py-6">
                                <a href="/admin" class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Log in</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-100">
            <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">
                <div class="mt-8 md:order-1 md:mt-0">
                    <p class="text-center text-xs leading-5 text-gray-500">&copy; {{ date('Y') }} Badan Pengembangan dan Pembinaan Bahasa. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
