<x-app-layout>
    <!-- Hero Section -->
    <div class="relative isolate overflow-hidden bg-slate-900 py-24 sm:py-32">
        <img src="https://images.unsplash.com/photo-1519681393798-38e432c35ea8?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2832&q=80" alt="" class="absolute inset-0 -z-10 h-full w-full object-cover opacity-20">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Ensiklopedia Sastra Indonesia</h1>
                <p class="mt-6 text-lg leading-8 text-gray-300">
                    Jelajahi kekayaan sastra Indonesia dari masa ke masa. Temukan profil pengarang, karya sastra, dan sejarah perkembangan sastra di tanah air.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <div class="relative w-full max-w-lg">
                        <input type="text" class="block w-full rounded-full border-0 px-4 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-purple-600 sm:text-sm sm:leading-6" placeholder="Cari artikel, tokoh, atau karya...">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="bg-gray-50 py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Jelajahi Kategori</h2>
                <p class="mt-2 text-lg leading-8 text-gray-600">Temukan artikel berdasarkan klasifikasi sastra.</p>
            </div>
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                    @php
                        $categories = [
                            ['name' => 'Pengarang', 'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z', 'color' => 'bg-blue-500'],
                            ['name' => 'Karya Sastra', 'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25', 'color' => 'bg-purple-500'],
                            ['name' => 'Media Penyebar', 'icon' => 'M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z', 'color' => 'bg-indigo-500'],
                            ['name' => 'Hadiah Sastra', 'icon' => 'M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0V5.625a2.25 2.25 0 00-2.25-2.25h-3.375a2.25 2.25 0 00-2.25 2.25v5.75', 'color' => 'bg-yellow-500'],
                            ['name' => 'Lembaga Sastra', 'icon' => 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z', 'color' => 'bg-slate-500'],
                            ['name' => 'Gejala Sastra', 'icon' => 'M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z', 'color' => 'bg-pink-500'],
                        ];
                    @endphp

                    @foreach($categories as $category)
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                            <div class="h-10 w-10 flex items-center justify-center rounded-lg {{ $category['color'] }}">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $category['icon'] }}" />
                                </svg>
                            </div>
                            {{ $category['name'] }}
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                            <p class="flex-auto">Telusuri artikel-artikel pilihan yang berkaitan dengan {{ strtolower($category['name']) }} dalam khazanah sastra Indonesia.</p>
                            <p class="mt-6">
                                <a href="{{ route('category.show', ['slug' => Str::slug($category['name'])]) }}" class="text-sm font-semibold leading-6 text-purple-600">Lihat semua <span aria-hidden="true">→</span></a>
                            </p>
                        </dd>
                    </div>
                    @endforeach
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
