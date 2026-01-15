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
                    {{ $article->title }} <span class="text-slate-400 font-normal">({{ $article->year }})</span>
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
                <div class="relative float-right ml-8 mb-8 w-1/3 min-w-[250px]">
                    <div class="bg-gray-100 rounded-xl overflow-hidden shadow-md">
                        <div class="aspect-[3/4] bg-gray-200 flex items-center justify-center text-gray-400">
                             <!-- Image -->
                             <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="p-3 bg-white border-t border-gray-100">
                            <p class="text-xs text-center text-gray-500 italic">Gambar Ilustrasi</p>
                        </div>
                    </div>
                </div>

                {!! $article->content !!}
            </div>

            <!-- Tags/Footer of Article -->
            <div class="mt-16 pt-8 border-t border-slate-100">
                <div class="flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-slate-100 text-slate-700">#EnsiklopediaSastra</span>
                </div>
            </div>
        </article>
    </div>
</x-app-layout>
