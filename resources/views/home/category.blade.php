@extends('layouts.app')

@section('title', $category->name . ' - Ensiklopedia Sastra Indonesia')

@section('content')
    <!-- Category Header -->
    <div class="purple-gradient-bg" style="color: white; padding: 2rem;text-align: center;">
        <div class="container">
            <h1>Jelajahi {{ $category->name }}</h1>
            <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Jelajahi semua konten dalam kategori ini</p>
        </div>
    </div>

    <div class="container" style="margin-top: 2rem;">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" style="margin-bottom: 2rem;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active">{{ $category->name }}</li>
            </ol>
        </nav>

        <!-- Contents Grid -->
        <div class="row">
            @forelse($contents as $content)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card category-card" style="height: 100%;">
                        <div class="category-card-img" style="position: relative;">
                            @if($content->images->first())
                                <div class="image-loading-skeleton" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;"></div>
                                <img src="{{ asset('storage/' . $content->images->first()->path) }}" alt="{{ $content->title }}" class="lazy-image"
                                    style="width: 100%; height: 100%; object-fit: contain; position: relative; z-index: 2; opacity: 0; transition: opacity 0.3s; background: #f8f9fa;" onload="this.style.opacity='1'; this.previousElementSibling.style.display='none';" onerror="this.previousElementSibling.style.display='none';">
                            @else
                                <i class="fas fa-file-alt"></i>
                            @endif
                        </div>
                        <div class="category-card-body" style="display: flex; flex-direction: column; height: 100%;">
                            <h5 class="category-card-title">{{ $content->title }}</h5>
                            <p class="category-card-text"><strong>Tahun:</strong> {{ $content->year }}</p>
                            <div class="category-card-text" style="line-height: 1.5; max-height: 3em; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; flex-grow: 1; margin-bottom: 1rem;">{!! $content->text !!}</div>
                            <a href="{{ route('detail', $content->slug) }}" class="btn-primary"
                                style="display: block; margin-top: auto;">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div style="text-align: center; padding: 3rem;">
                        <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem; display: block;"></i>
                        <p>Tidak ada konten dalam kategori ini</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($contents->hasPages())
            <div style="margin-top: 2rem; display: flex; justify-content: center;">
                {{ $contents->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
@endsection

@section('extra-css')
    <style>
        .breadcrumb {
            background: transparent;
            padding: 0;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            text-decoration: underline;
        }
    </style>
@endsection