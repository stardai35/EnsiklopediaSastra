<x-app-layout>
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-12 text-center">
                <span class="text-purple-600 font-semibold tracking-wide uppercase text-sm">Kategori</span>
                <h1 class="mt-2 text-4xl font-bold text-slate-900">{{ $category->name ?? 'Kategori' }}</h1>
                <p class="mt-4 text-slate-600 max-w-2xl mx-auto">Menampilkan artikel terkait kategori ini.</p>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($category->contents as $article)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-shadow duration-300 border border-slate-100 group">
                    <div class="aspect-[16/9] bg-slate-200 relative overflow-hidden">
                        @php
                            $thumbnail = $article->media->first();
                        @endphp
                        @if($thumbnail)
                            <img src="{{ asset('storage/' . $thumbnail->link) }}" 
                                 alt="{{ $article->lemma->name ?? $article->title ?? '' }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            {{-- Image Placeholder --}}
                            <div class="absolute inset-0 flex items-center justify-center text-slate-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-2 py-1 rounded-md bg-purple-50 text-purple-700 text-xs font-medium">{{ $article->year ?? '' }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-purple-700 transition-colors">
                            <a href="{{ route('wiki.show', $article->slug) }}" class="before:absolute before:inset-0">{{ $article->lemma->name ?? $article->title ?? 'Tanpa Judul' }}</a>
                        </h3>
                        <p class="text-slate-500 text-sm line-clamp-3">
                            {{ Str::limit(strip_tags($article->text ?? $article->content ?? ''), 100) }}
                        </p>
                        <div class="mt-4 flex items-center text-sm font-medium text-purple-600">
                            Baca selengkapnya
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-500">Belum ada artikel di kategori ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
