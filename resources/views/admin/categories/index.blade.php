@extends('admin.layout')

@section('page-title')
    <i class="fas fa-folder"></i> Kelola Kategori
@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list"></i> Daftar Kategori ({{ $categories->total() }})</span>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah Kategori
            </a>
        </div>
        <div class="card-body">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 5%;">ID</th>
                                <th style="width: 40%;">Nama Kategori</th>
                                <th style="width: 20%;">Slug</th>
                                <th style="width: 15%;">Jumlah Konten</th>
                                <th style="width: 20%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>#{{ $category->id }}</td>
                                    <td>
                                        <strong>{{ $category->name }}</strong>
                                    </td>
                                    <td>
                                        <code style="background: #f5f5f5; padding: 0.25rem 0.5rem; border-radius: 4px;">{{ $category->slug }}</code>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $category->contents_count }} konten</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($categories->hasPages())
                    <nav role="navigation" aria-label="Pagination Navigation" style="margin-top: 2rem;">
                        <ul style="gap: 0.5rem; list-style: none; display: flex; align-items: center; justify-content: center; flex-wrap: wrap;">
                            {{-- Previous Page Link --}}
                            @if ($categories->onFirstPage())
                                <li style="opacity: 0.5;">
                                    <span style="background: #f0f0f0; color: #ccc; border: 1px solid #ddd; padding: 0.6rem 1rem; border-radius: 6px; cursor: not-allowed; display: inline-flex; align-items: center;">
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $categories->previousPageUrl() }}" rel="prev" style="background: white; color: var(--primary-color); border: 1px solid var(--primary-color); padding: 0.6rem 1rem; border-radius: 6px; cursor: pointer; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center;" onmouseover="this.style.background='var(--primary-color)'; this.style.color='white';" onmouseout="this.style.background='white'; this.style.color='var(--primary-color)';">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- Page Links --}}
                            @foreach ($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                                @if ($page == $categories->currentPage())
                                    <li>
                                        <span style="background: var(--primary-color); color: white; border: 1px solid var(--primary-color); padding: 0.6rem 0.9rem; border-radius: 6px; font-weight: 600; min-width: 2.5rem; text-align: center; display: inline-block; box-shadow: 0 2px 8px rgba(124, 58, 237, 0.2);">
                                            {{ $page }}
                                        </span>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $url }}" style="background: white; color: #666; border: 1px solid #ddd; padding: 0.6rem 0.9rem; border-radius: 6px; cursor: pointer; transition: all 0.3s; min-width: 2.5rem; text-align: center; text-decoration: none; display: inline-block;" onmouseover="this.style.background='var(--primary-color)'; this.style.color='white'; this.style.borderColor='var(--primary-color)';" onmouseout="this.style.background='white'; this.style.color='#666'; this.style.borderColor='#ddd';">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($categories->hasMorePages())
                                <li>
                                    <a href="{{ $categories->nextPageUrl() }}" rel="next" style="background: white; color: var(--primary-color); border: 1px solid var(--primary-color); padding: 0.6rem 1rem; border-radius: 6px; cursor: pointer; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center;" onmouseover="this.style.background='var(--primary-color)'; this.style.color='white';" onmouseout="this.style.background='white'; this.style.color='var(--primary-color)';">
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
                <div style="text-align: center; padding: 2rem;">
                    <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                    <p style="color: #999; margin: 1rem 0;">Tidak ada kategori.</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Kategori Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
