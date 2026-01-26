@extends('admin.layout')

@section('page-title')
    <i class="fas fa-edit"></i> Edit Kategori
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-pencil"></i> Edit: {{ $category->name }}
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="fas fa-folder"></i> Nama Kategori <span style="color: red;">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control @error('name') is-invalid @enderror" 
                        value="{{ old('name', $category->name) }}"
                        placeholder="Masukkan nama kategori"
                        required
                    >
                    <small class="text-muted">Slug akan diupdate otomatis jika nama berubah</small>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-link"></i> Slug (Auto-generated)
                    </label>
                    <input 
                        type="text" 
                        class="form-control" 
                        value="{{ $category->slug }}"
                        disabled
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-file-alt"></i> Jumlah Konten
                    </label>
                    <input 
                        type="text" 
                        class="form-control" 
                        value="{{ $category->contents->count() }} konten"
                        disabled
                    >
                </div>

                <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                    <p style="margin: 0; color: #666;">
                        <i class="fas fa-info-circle" style="color: #0d6efd;"></i> <strong>Info:</strong> Slug akan diupdate otomatis jika nama kategori diubah. Anda tidak bisa menghapus kategori yang masih memiliki konten.
                    </p>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Kategori
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
