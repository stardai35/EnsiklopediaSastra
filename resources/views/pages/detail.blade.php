<x-app-layout>
    <div class="bg-white min-h-screen">
        <!-- Reader Container -->
        <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <!-- Header -->
            <header class="mb-10 border-b border-slate-100 pb-10">
                <div class="flex items-center gap-3 text-sm font-medium text-slate-500 mb-6">
                    <a href="{{ route('home') }}" class="hover:text-purple-600 transition-colors">Beranda</a>
                    <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <a href="#" class="hover:text-purple-600 transition-colors">{{ $article->category->name ?? 'Kategori' }}</a>
                </div>

                <h1 class="text-4xl md:text-5xl font-bold text-slate-900 leading-tight mb-6">
                    {{ $article->lemma->name ?? $article->title ?? 'Tanpa Judul' }} <span class="text-slate-400 font-normal">@if($article->year)({{ $article->year }})@endif</span>
                </h1>

                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">
                           A
                        </div>
                        <span class="text-sm font-medium text-slate-700">Admin</span>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <div class="prose prose-lg prose-slate max-w-none prose-headings:font-bold prose-headings:text-slate-900 prose-p:text-slate-600 prose-a:text-purple-600 prose-img:rounded-xl prose-img:shadow-lg">
                @php
                    $mainImage = $article->media->first();
                @endphp
                @if($mainImage)
                <div class="relative float-right ml-8 mb-8 w-1/3 min-w-[250px]">
                    <div class="bg-gray-100 rounded-xl overflow-hidden shadow-md">
                        <div class="aspect-[3/4] bg-gray-200">
                            <img src="{{ asset('storage/' . $mainImage->link) }}" 
                                 alt="{{ $article->lemma->name ?? $article->title ?? '' }}" 
                                 class="w-full h-full object-cover">
                        </div>
                        @if($mainImage->caption)
                        <div class="p-3 bg-white border-t border-gray-100">
                            <p class="text-xs text-center text-gray-500 italic">{{ $mainImage->caption }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {!! nl2br(e($article->text ?? $article->content ?? '')) !!}
            </div>

            <!-- Galeri Foto (Jika ada lebih dari 1 gambar atau untuk menampilkan semua) -->
            @if($article->media->count() > 0)
                <div class="mt-16 border-t border-slate-100 pt-10">
                    <h2 class="text-2xl font-bold text-slate-900 mb-6">Galeri Foto</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($article->media as $item)
                        <div class="group relative overflow-hidden rounded-xl bg-slate-100 aspect-square">
                            <img src="{{ asset('storage/' . $item->link) }}" 
                                 alt="{{ $item->caption ?? $article->lemma->name ?? '' }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @if($item->caption)
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                <p class="text-white text-xs">{{ $item->caption }}</p>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Tags/Footer of Article -->
            <div class="mt-16 pt-8 border-t border-slate-100">
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-slate-100 text-slate-700">#EnsiklopediaSastra</span>
                </div>
            </div>
        </article>
    </div>
</x-app-layout>
