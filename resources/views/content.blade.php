@extends('layouts.app')
@section('title',$content->slug)

@section('content')

<h3 class="fw-bold mb-2">{{ $content->slug }}</h3>
<p class="text-muted small mb-4">
    Tahun: {{ $content->year ?? '-' }} | Kategori: {{ $content->category->name }}
</p>

{{-- MEDIA ATAS --}}
@foreach($content->media as $media)
@if($media->position->position == 'top' && $media->type->type == 'image')
<img src="{{ $media->link }}" class="img-fluid mb-3 rounded">
@endif
@endforeach

<div class="content-text">
    {!! nl2br(e($content->text)) !!}
</div>

{{-- MEDIA BAWAH --}}
@foreach($content->media as $media)
@if($media->position->position == 'bottom')
<div class="mt-3">
    <a href="{{ $media->link }}" target="_blank">
        {{ $media->caption ?? 'Lihat Media' }}
    </a>
</div>
@endif
@endforeach

<hr>

<h6 class="fw-bold">Referensi</h6>
<ul>
    @foreach($content->references as $ref)
    <li>
        <a href="{{ $ref->link }}" target="_blank">
            {{ $ref->name }}
        </a>
    </li>
    @endforeach
</ul>

@endsection
