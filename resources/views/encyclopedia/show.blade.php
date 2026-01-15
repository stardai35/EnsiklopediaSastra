@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow">
    <div class="text-sm text-blue-600 mb-2 uppercase tracking-wide font-semibold">
        {{ $content->category->name }}
    </div>

    <h1 class="text-4xl font-bold mb-4 text-gray-900">{{ $content->lemma->name }}</h1>
    
    @if($content->year)
        <span class="inline-block bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded mb-6">Tahun: {{ $content->year }}</span>
    @endif

    @php
        $mainImage = $content->media->first(); 
    @endphp

    @if($mainImage)
        <figure class="mb-8">
            <img src="{{ asset('storage/' . $mainImage->link) }}" alt="{{ $content->lemma->name }}" class="w-full h-auto rounded-lg shadow-sm">
            @if($mainImage->caption)
                <figcaption class="text-center text-gray-500 text-sm mt-2 italic">{{ $mainImage->caption }}</figcaption>
            @endif
        </figure>
    @endif

    <article class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
        {!! nl2br(e($content->text)) !!}
    </article>

    @if($content->refLinks->count() > 0)
        <div class="mt-12 pt-6 border-t">
            <h3 class="text-lg font-bold mb-3">Referensi & Tautan Luar</h3>
            <ul class="list-disc list-inside space-y-1">
                @foreach($content->refLinks as $ref)
                    <li>
                        <a href="{{ $ref->link }}" target="_blank" class="text-blue-600 hover:underline">
                            {{ $ref->name }}
                        </a>
                        <a href="{{ $ref->link }}" target=""></a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection