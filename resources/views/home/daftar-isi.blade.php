@extends('layouts.app')

@section('title', 'Daftar Isi - Ensiklopedia Sastra Indonesia')

@section('content')
    <!-- Header -->
    <div style="background: linear-gradient(135deg, var(--primary-color) 0%, #a78bfa 100%); color: white; padding: 2rem;">
        <div class="container">
            <h1>Daftar Isi</h1>
            <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Jelajahi semua koleksi sastra Indonesia</p>
        </div>
    </div>

    <div class="container" style="margin-top: 2rem;">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" style="margin-bottom: 2rem;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item active">Daftar Isi</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Sidebar Filter -->
            <div class="col-lg-3 mb-4">
                <div style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top: 20px;">
                    <h3 style="color: var(--primary-color); margin-bottom: 1.5rem; font-size: 1.2rem;">
                        <i class="fas fa-filter"></i> Filter & Sorting
                    </h3>

                    <form action="{{ route('daftar-isi') }}" method="GET" id="filterForm">
                        <!-- Filter Kategori -->
                        <div style="margin-bottom: 2rem;">
                            <label style="display: block; font-weight: 600; color: #333; margin-bottom: 0.8rem;">
                                <i class="fas fa-folder"></i> Kategori
                            </label>
                            <select name="category" id="categoryFilter" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 0.95rem; cursor: pointer;">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (request('category') == $cat->id) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort -->
                        <div style="margin-bottom: 2rem;">
                            <label style="display: block; font-weight: 600; color: #333; margin-bottom: 0.8rem;">
                                <i class="fas fa-sort"></i> Urutkan
                            </label>
                            <select name="sort" id="sortFilter" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 0.95rem; cursor: pointer;">
                                <option value="terbaru" {{ (request('sort', 'terbaru') == 'terbaru') ? 'selected' : '' }}>
                                    Terbaru Ditambah
                                </option>
                                <option value="terlama" {{ (request('sort') == 'terlama') ? 'selected' : '' }}>
                                    Terlama
                                </option>
                                <option value="judul_az" {{ (request('sort') == 'judul_az') ? 'selected' : '' }}>
                                    Judul (A-Z)
                                </option>
                                <option value="judul_za" {{ (request('sort') == 'judul_za') ? 'selected' : '' }}>
                                    Judul (Z-A)
                                </option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <button type="submit" class="btn-primary" style="width: 100%; margin-bottom: 0.5rem;">
                            <i class="fas fa-check"></i> Terapkan Filter
                        </button>
                        <a href="{{ route('daftar-isi') }}" class="btn-primary" style="width: 100%; text-align: center; background: #6c757d; display: block; margin-bottom: 0;">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </form>

                    <!-- Filter Info -->
                    <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee;">
                        <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px;">
                            <p style="margin: 0; color: #666; font-size: 0.9rem;">
                                <strong>Total Konten:</strong> {{ $contents->total() }} artikel
                            </p>
                            @if($selectedCategory)
                                <p style="margin: 0.5rem 0 0 0; color: #666; font-size: 0.9rem;">
                                    <strong>Kategori:</strong> {{ $selectedCategory->name }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Results Header -->
                <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        @if($selectedCategory)
                            <h2 style="margin: 0; color: var(--primary-color);">
                                {{ $selectedCategory->name }}
                                <span style="color: #999; font-size: 0.9rem;">({{ $contents->total() }} hasil)</span>
                            </h2>
                        @else
                            <h2 style="margin: 0; color: var(--primary-color);">
                                Semua Konten
                                <span style="color: #999; font-size: 0.9rem;">({{ $contents->total() }} hasil)</span>
                            </h2>
                        @endif
                    </div>
                </div>

                <!-- Grid Konten -->
                @if($contents->count() > 0)
                    <div class="row">
                        @foreach($contents as $content)
                            <div class="col-md-6 col-lg-6 mb-4">
                                <div class="card category-card" style="height: 100%;">
                                    <div class="category-card-img">
                                        @if($content->images->first())
                                            <img src="{{ asset('storage/' . $content->images->first()->path) }}" alt="{{ $content->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: linear-gradient(135deg, var(--primary-color) 0%, #a78bfa 100%);">
                                                <i class="fas fa-book-open" style="font-size: 3rem; color: white;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="category-card-body">
                                        <div style="margin-bottom: 0.8rem;">
                                            <span style="display: inline-block; background: var(--primary-color); color: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                                                {{ $content->category->name }}
                                            </span>
                                        </div>

                                        <h5 class="category-card-title" style="min-height: 2.5rem;">
                                            {{ $content->title }}
                                        </h5>

                                        <p class="category-card-text" style="margin-bottom: 0.5rem;">
                                            <i class="fas fa-calendar"></i> <strong>{{ $content->year }}</strong>
                                        </p>

                                        <p class="category-card-text" style="color: #666; margin-bottom: 1rem;">
                                            {{ Str::limit($content->text, 100, '...') }}
                                        </p>

                                        <a href="{{ route('detail', $content->slug) }}" class="btn-primary" style="display: block; margin-top: 1rem; text-align: center;">
                                            <i class="fas fa-arrow-right"></i> Baca Selengkapnya
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($contents->hasPages())
                        <div style="margin-top: 3rem; display: flex; justify-content: center;">
                            {{ $contents->appends(request()->query())->render('vendor.pagination.custom') }}
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div style="text-align: center; padding: 3rem;">
                        <i class="fas fa-search" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem; display: block;"></i>
                        <h3 style="color: #999;">Tidak ada konten yang sesuai</h3>
                        <p style="color: #bbb;">Coba ubah filter atau kategori Anda</p>
                        <a href="{{ route('daftar-isi') }}" class="btn-primary" style="margin-top: 1rem;">
                            <i class="fas fa-redo"></i> Lihat Semua Konten
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

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
