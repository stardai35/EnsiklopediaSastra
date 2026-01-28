@extends('admin.layout')

@section('page-title')
    <i class="fas fa-chart-line"></i> Dashboard
@endsection

@section('content')
    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
                <div class="stat-number">{{ $totalContents }}</div>
                <div class="stat-label">Total Konten</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-folder"></i></div>
                <div class="stat-number">{{ $totalCategories }}</div>
                <div class="stat-label">Kategori</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-image"></i></div>
                <div class="stat-number">{{ $totalImages }}</div>
                <div class="stat-label">Total Gambar</div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-search"></i></div>
                <div class="stat-number">{{ $totalContents }}</div>
                <div class="stat-label">Data Pencarian</div>
            </div>
        </div>
    </div>

    <!-- Recent Contents -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-history"></i> Konten Terbaru
        </div>
        <div class="card-body">
            @if($recentContents->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tahun</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentContents as $content)
                            <tr>
                                <td>
                                    <strong>{{ $content->title }}</strong>
                                </td>
                                <td>
                                    <span class="badge badge-primary">{{ $content->category->name }}</span>
                                </td>
                                <td>{{ $content->year }}</td>
                                <td>
                                    @if($content->images->count() > 0)
                                        <span class="badge bg-success">{{ $content->images->count() }} gambar</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak ada</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.contents.edit', $content) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="text-align: center; padding: 2rem; color: #999;">
                    <i class="fas fa-inbox" style="font-size: 2rem; opacity: 0.5; display: block; margin-bottom: 1rem;"></i>
                    Belum ada konten. <a href="{{ route('admin.contents.create') }}">Buat konten baru</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-lightning-bolt"></i> Aksi Cepat
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.contents.create') }}" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-plus"></i> Tambah Konten Baru
                    </a>
                    <a href="{{ route('admin.contents.index') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-list"></i> Kelola Semua Konten
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Informasi
                </div>
                <div class="card-body">
                    <p style="margin: 0.5rem 0;">
                        <strong>Versi:</strong> 1.0.0
                    </p>
                    <p style="margin: 0.5rem 0;">
                        <strong>Platform:</strong> Laravel 12
                    </p>
                    <p style="margin: 0;">
                        <strong>Database:</strong> MySQL 8.0
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
