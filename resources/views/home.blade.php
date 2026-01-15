@extends('layouts.app')
@section('title','Beranda')

@section('content')
<h4 class="fw-bold text-ungu mb-3">
    ENSIKLOPEDIA SASTRA INDONESIA
</h4>

<div class="row">
    @foreach($latest as $item)
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="fw-bold">{{ $item->slug }}</h6>
                <p class="text-muted small">
                    {{ Str::limit(strip_tags($item->text),150) }}
                </p>
                <a href="/konten/{{ $item->slug }}" class="text-ungu fw-bold">
                    Baca selengkapnya →
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
