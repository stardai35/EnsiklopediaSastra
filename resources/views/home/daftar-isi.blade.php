@extends('layouts.app')

@section('title', 'Daftar Isi - Ensiklopedia Sastra Indonesia')

@section('content')
    <!-- Header -->
    <div class="purple-gradient-bg" style="color: white; padding: 2rem;">
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

        <!-- Filter Section - Centered Above Results -->
        <div style="margin-bottom: 2rem;">
            <div style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <h3 style="color: var(--primary-color); margin-bottom: 1.5rem; font-size: 1.2rem; text-align: center;">
                    <i class="fas fa-filter"></i> Filter & Sorting
                </h3>

                <form action="{{ route('daftar-isi') }}" method="GET" id="filterForm">
                    <div class="row g-3">
                        <!-- Search -->
                        <div class="col-md-4">
                            <label style="display: block; font-weight: 600; color: #333; margin-bottom: 0.5rem;">
                                <i class="fas fa-search"></i> Cari Konten
                            </label>
                            <input type="text" name="search" placeholder="Cari judul atau kategori..."
                                value="{{ $search ?? '' }}"
                                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 0.95rem;">
                        </div>

                        <!-- Filter Kategori -->
                        <div class="col-md-4">
                            <label style="display: block; font-weight: 600; color: #333; margin-bottom: 0.5rem;">
                                <i class="fas fa-folder"></i> Kategori
                            </label>
                            <select name="category" id="categoryFilter"
                                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 0.95rem; cursor: pointer;">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (request('category') == $cat->id) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort -->
                        <div class="col-md-4">
                            <label style="display: block; font-weight: 600; color: #333; margin-bottom: 0.5rem;">
                                <i class="fas fa-sort"></i> Urutkan
                            </label>
                            <select name="sort" id="sortFilter"
                                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 0.95rem; cursor: pointer;">
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
                        <div class="col-md-6">
                            <button type="submit" class="btn-primary" style="width: 100%; margin-top: 1.5rem;">
                                <i class="fas fa-check"></i> Terapkan Filter
                            </button>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('daftar-isi') }}" class="btn-primary"
                                style="width: 100%; text-align: center; background: #6c757d; display: block; margin-top: 1.5rem;">
                                <i class="fas fa-redo"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results Header -->
        <div style="margin-bottom: 2rem;">
            @if($search)
                <div
                    style="background: #e7f3ff; border-left: 4px solid var(--primary-color); padding: 1rem; border-radius: 5px; margin-bottom: 1.5rem;">
                    <p style="margin: 0; color: #0c5460;">
                        <i class="fas fa-search"></i>
                        <strong>Hasil pencarian untuk:</strong> "{{ $search }}"
                        <span style="color: #666;">({{ $contents->total() }} hasil ditemukan)</span>
                    </p>
                </div>
            @endif

            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom:1rem;">
                <div>
                    @if($selectedCategory)
                        <h2 style="margin: 0; color: var(--primary-color);">
                            {{ $selectedCategory->name }}
                            <span style="color: #999; font-size: 0.9rem;">({{ $contents->total() }} hasil)</span>
                        </h2>
                    @else
                        <h2 style="margin: 0; color: var(--primary-color);">
                            Semua Konten
                            <span style="color: #999; font-size: 0.9rem;">({{ $contents->total() }}
                                hasil)</span>
                        </h2>
                    @endif
                </div>
            </div>

            <!-- Grid Konten -->
            @if($contents->count() > 0)
                <div class="row">
                    @foreach($contents as $content)
                        <div class="col-md-4 col-lg-4 mb-4">
                            <div class="card category-card" style="height: 100%;">
                                <div class="category-card-img" style="position: relative;">
                                    @if($content->images->first())
                                        <div class="image-loading-skeleton"
                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 1;">
                                        </div>
                                        <img src="{{ asset('storage/' . $content->images->first()->path) }}"
                                            alt="{{ $content->title }}" class="lazy-image"
                                            style="width: 100%; height: 100%; object-fit: contain; position: relative; z-index: 2; opacity: 0; transition: opacity 0.3s; background: #f8f9fa;"
                                            onload="this.style.opacity='1'; this.previousElementSibling.style.display='none';"
                                            onerror="this.previousElementSibling.style.display='none';">
                                    @else
                                        <div class="purple-gradient-bg"
                                            style="display: flex; align-items: center; justify-content: center; height: 100%;">
                                            <i class="fas fa-book-open" style="font-size: 3rem; color: white;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="category-card-body"
                                    style="display: flex; flex-direction: column; height: 100%;">
                                    <div style="margin-bottom: 0.8rem;">
                                        <span
                                            style="display: inline-block; background: var(--primary-color); color: white; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                                            {{ $content->category->name }}
                                        </span>
                                    </div>

                                    <h5 class="category-card-title" style="min-height: 2.5rem;">
                                        {{ $content->title }}
                                    </h5>

                                    <p class="category-card-text" style="margin-bottom: 0.5rem;">
                                        <i class="fas fa-calendar"></i> <strong>{{ $content->year }}</strong>
                                    </p>

                                    <div class="category-card-text"
                                        style="color: #666; margin-bottom: 1rem; line-height: 1.5; max-height: 3em; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; flex-grow: 1;">
                                        {!! $content->text !!}
                                    </div>

                                    <a href="{{ route('detail', $content->slug) }}" class="btn-primary"
                                        style="display: block; margin-top: auto; text-align: center;">
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
                <i class="fas fa-search"
                    style="font-size: 3rem; color: #ccc; margin-bottom: 1rem; display: block;"></i>
                <h3 style="color: #999;">Tidak ada konten yang sesuai</h3>
                @if($search)
                    <p style="color: #bbb;">Tidak ditemukan konten dengan pencarian "<strong>{{ $search }}</strong>"</p>
                @else
                    <p style="color: #bbb;">Coba ubah filter atau kategori Anda</p>
                @endif
                <a href="{{ route('daftar-isi') }}" class="btn-primary" style="margin-top: 1rem;">
                    <i class="fas fa-redo"></i> Lihat Semua Konten
                </a>
            </div>
        @endif
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
    </div>
@endsection