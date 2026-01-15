@extends('layouts.app')
@section('title',$category->name)

@section('content')
<h5 class="fw-bold mb-3">
    {{ $category->name }}
</h5>

@foreach($category->contents as $content)
<div class="card mb-3">
    <div class="card-body">
        <h6 class="fw-bold">{{ $content->slug }}</h6>
        <p class="small text-muted">
            {{ Str::limit(strip_tags($content->text),200) }}
        </p>
        <a href="/konten/{{ $content->slug }}" class="btn btn-sm btn-outline-primary">
            Detail
        </a>
    </div>
</div>
@endforeach
@endsection
