@extends('layouts.app')

@section('title', $category->name . ' - Ensiklopedia Sastra Indonesia')

@section('content')
    <!-- Category Header -->
    <div style="background: linear-gradient(135deg, var(--primary-color) 0%, #a78bfa 100%); color: white; padding: 2rem;">
        <div class="container">
            <h1>{{ $category->name }}</h1>
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
                    <div class="card category-card">
                        <div class="category-card-img">
                            @if($content->images->first())
                                <img src="{{ asset('storage/' . $content->images->first()->path) }}" alt="{{ $content->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="fas fa-file-alt"></i>
                            @endif
                        </div>
                        <div class="category-card-body">
                            <h5 class="category-card-title">{{ $content->title }}</h5>
                            <p class="category-card-text"><strong>Tahun:</strong> {{ $content->year }}</p>
                            <p class="category-card-text">{{ Str::limit($content->text, 100, '...') }}</p>
                            <a href="{{ route('detail', $content->slug) }}" class="btn-primary" style="display: block; margin-top: 1rem;">
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
                {{ $contents->links() }}
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
