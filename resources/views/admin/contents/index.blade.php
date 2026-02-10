@extends('admin.layout')

@section('page-title')
    <i class="fas fa-file-alt"></i> Kelola Konten
@endsection

@section('content')
    <!-- Filter Section -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-header">
            <i class="fas fa-filter"></i> Filter & Pencarian
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.contents.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Konten</label>
                    <input 
                        type="text" 
                        name="search" 
                        id="search" 
                        class="form-control" 
                        placeholder="Judul atau deskripsi..."
                        value="{{ $searchQuery ?? '' }}"
                    >
                </div>

                <div class="col-md-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ ($selectedCategory ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="sort" class="form-label">Urutkan</label>
                    <select name="sort" id="sort" class="form-select">
                        <option value="newest" {{ ($sortBy ?? 'newest') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ ($sortBy ?? '') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="title_az" {{ ($sortBy ?? '') === 'title_az' ? 'selected' : '' }}>Judul A-Z</option>
                        <option value="title_za" {{ ($sortBy ?? '') === 'title_za' ? 'selected' : '' }}>Judul Z-A</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('admin.contents.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list"></i> Daftar Konten ({{ $contents->total() }})</span>
            <a href="{{ route('admin.contents.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah Konten
            </a>
        </div>
        <div class="card-body">
            @if($contents->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover" style="width: 100%; table-layout: auto;">
                        <thead>
                            <tr>
                                <th style="width: 5%;">ID</th>
                                <th style="width: auto;">Judul</th>
                                <th style="width: 12%;">Kategori</th>
                                <th style="width: 10%;">Tahun</th>
                                <th style="width: 8%;">Gambar</th>
                                <th style="width: 25%; text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contents as $content)
                                <tr>
                                    <td>#{{ $content->id }}</td>
                                    <td style="word-wrap: break-word;">
                                        <strong style="display: block; margin-bottom: 0.25rem;">{{ $content->title }}</strong>
                                        <small style="color: #999; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; line-height: 1.4; word-wrap: break-word;">{!! strip_tags($content->text) !!}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">{{ $content->category->name }}</span>
                                    </td>
                                    <td>{{ $content->year }}</td>
                                    <td>
                                        @if($content->images->count() > 0)
                                            <span class="badge bg-success">{{ $content->images->count() }}</span>
                                        @else
                                            <span class="badge bg-secondary">0</span>
                                        @endif
                                    </td>
                                    <td style="white-space: nowrap; text-align: right;">
                                        <div style="display: flex; gap: 0.25rem; justify-content: flex-end; flex-wrap: wrap;">
                                            <a href="{{ route('admin.contents.edit', $content) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="{{ route('detail', $content->slug) }}" target="_blank" class="btn btn-sm btn-info" title="Lihat">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                            <form action="{{ route('admin.contents.destroy', $content) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($contents->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" style="margin-top: 2rem;">
                        <ul style="gap: 0.5rem; list-style: none; display: flex; align-items: center; justify-content: center; flex-wrap: wrap;">
                            {{-- Previous Page Link --}}
                            @if ($contents->currentPage() > 1)
                                <li>
                                    <a href="{{ $contents->previousPageUrl() }}" rel="prev" style="background: white; color: var(--primary-color); border: 1px solid var(--primary-color); padding: 0.6rem 1rem; border-radius: 6px; cursor: pointer; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center;">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            @else
                                <li style="opacity: 0.5;">
                                    <span style="background: #f0f0f0; color: #ccc; border: 1px solid #ddd; padding: 0.6rem 1rem; border-radius: 6px; cursor: not-allowed; display: inline-flex; align-items: center;">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                </li>
                            @endif

                            {{-- First Page Link --}}
                            @if ($contents->currentPage() > 3)
                                <li>
                                    <a href="{{ $contents->url(1) }}" style="background: white; color: #666; border: 1px solid #ddd; padding: 0.6rem 0.9rem; border-radius: 6px; cursor: pointer; min-width: 2.5rem; text-align: center; text-decoration: none; display: inline-block;">1</a>
                                </li>
                                @if ($contents->currentPage() > 4)
                                    <li><span style="padding: 0.6rem 0.9rem;">...</span></li>
                                @endif
                            @endif

                            {{-- Page Links Around Current --}}
                            @for ($i = max(1, $contents->currentPage() - 2); $i <= min($contents->lastPage(), $contents->currentPage() + 2); $i++)
                                @if ($i == $contents->currentPage())
                                    <li>
                                        <span style="background: var(--primary-color); color: white; border: 1px solid var(--primary-color); padding: 0.6rem 0.9rem; border-radius: 6px; font-weight: 600; min-width: 2.5rem; text-align: center; display: inline-block; box-shadow: 0 2px 8px rgba(124, 58, 237, 0.2);">{{ $i }}</span>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $contents->url($i) }}" style="background: white; color: #666; border: 1px solid #ddd; padding: 0.6rem 0.9rem; border-radius: 6px; cursor: pointer; min-width: 2.5rem; text-align: center; text-decoration: none; display: inline-block;">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            {{-- Last Page Link --}}
                            @if ($contents->currentPage() < $contents->lastPage() - 2)
                                @if ($contents->currentPage() < $contents->lastPage() - 3)
                                    <li><span style="padding: 0.6rem 0.9rem;">...</span></li>
                                @endif
                                <li>
                                    <a href="{{ $contents->url($contents->lastPage()) }}" style="background: white; color: #666; border: 1px solid #ddd; padding: 0.6rem 0.9rem; border-radius: 6px; cursor: pointer; min-width: 2.5rem; text-align: center; text-decoration: none; display: inline-block;">{{ $contents->lastPage() }}</a>
                                </li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($contents->currentPage() < $contents->lastPage())
                                <li>
                                    <a href="{{ $contents->nextPageUrl() }}" rel="next" style="background: white; color: var(--primary-color); border: 1px solid var(--primary-color); padding: 0.6rem 1rem; border-radius: 6px; cursor: pointer; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center;">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li style="opacity: 0.5;">
                                    <span style="background: #f0f0f0; color: #ccc; border: 1px solid #ddd; padding: 0.6rem 1rem; border-radius: 6px; cursor: not-allowed; display: inline-flex; align-items: center;">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                @endif
            @else
                <div style="text-align: center; padding: 3rem; color: #999;">
                    <i class="fas fa-folder-open" style="font-size: 3rem; opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
                    <p>Belum ada konten</p>
                    <a href="{{ route('admin.contents.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Konten Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('extra-css')
<style>
    .table-responsive {
        overflow-x: auto;
        width: 100%;
    }
    
    .table {
        width: 100% !important;
        margin-bottom: 0;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .table td strong {
        word-break: break-word;
    }
    
    .table thead th:last-child,
    .table tbody td:last-child {
        text-align: right;
    }
</style>
@endsection
