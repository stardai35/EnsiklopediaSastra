<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-12 text-center">
                <span class="text-purple-600 font-semibold tracking-wide uppercase text-sm">Ensiklopedia Sastra</span>
                <h1 class="mt-2 text-4xl font-bold text-slate-900">Daftar Isi</h1>
                <p class="mt-4 text-slate-600 max-w-2xl mx-auto">Jelajahi seluruh artikel dalam ensiklopedia berdasarkan kategori.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar -->
                <aside class="lg:w-64 flex-shrink-0">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-6">
                        <h2 class="text-lg font-bold text-slate-900 mb-4">Kategori</h2>
                        <nav class="space-y-2">
                            <!-- All Categories Link -->
                            <a href="{{ route('daftar_isi.index') }}" 
                               class="block px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ !$selectedCategory ? 'bg-purple-50 text-purple-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                    Semua Kategori
                                </div>
                            </a>

                            <!-- Dynamic Category Links -->
                            @foreach($categories as $category)
                            <a href="{{ route('daftar_isi.index', ['category' => $category->slug]) }}" 
                               class="block px-4 py-2.5 rounded-lg text-sm font-medium transition-colors {{ $selectedCategory === $category->slug ? 'bg-purple-50 text-purple-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                {{ $category->name }}
                            </a>
                            @endforeach
                        </nav>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="flex-1">
                    @if($contents->count() > 0)
                        <!-- Content Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                            @foreach($contents as $article)
                            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300 border border-slate-100 group">
                                <div class="aspect-[16/9] bg-slate-200 relative overflow-hidden">
                                    {{-- Image Placeholder --}}
                                    <div class="absolute inset-0 flex items-center justify-center text-slate-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="px-2 py-1 rounded-md bg-purple-50 text-purple-700 text-xs font-medium">
                                            {{ $article->category->name ?? 'Umum' }}
                                        </span>
                                        @if($article->year)
                                        <span class="px-2 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-medium">
                                            {{ $article->year }}
                                        </span>
                                        @endif
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-purple-700 transition-colors">
                                        <a href="{{ route('wiki.show', $article->slug) }}" class="before:absolute before:inset-0">
                                            {{ $article->title }}
                                        </a>
                                    </h3>
                                    <p class="text-slate-500 text-sm line-clamp-3">
                                        {{ Str::limit(strip_tags($article->content), 100) }}
                                    </p>
                                    <div class="mt-4 flex items-center text-sm font-medium text-purple-600">
                                        Baca selengkapnya
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="flex justify-center">
                            {{ $contents->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-12 text-center">
                            <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-slate-900 mb-2">Belum Ada Artikel</h3>
                            <p class="text-slate-500">Belum ada artikel di kategori ini. Silakan pilih kategori lain.</p>
                        </div>
                    @endif
                </main>
            </div>
        </div>
    </div>
</x-app-layout>
