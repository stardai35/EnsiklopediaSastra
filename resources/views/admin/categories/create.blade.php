@extends('admin.layout')

@section('page-title')
    <i class="fas fa-plus-circle"></i> Tambah Kategori
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit"></i> Form Tambah Kategori
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="fas fa-folder"></i> Nama Kategori <span style="color: red;">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control @error('name') is-invalid @enderror" 
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama kategori"
                        required
                    >
                    <small class="text-muted">Slug akan dibuat otomatis dari nama</small>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                    <p style="margin: 0; color: #666;">
                        <i class="fas fa-info-circle" style="color: #0d6efd;"></i> <strong>Info:</strong> Slug dibuat otomatis untuk URL-friendly identifier kategori.
                    </p>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Kategori
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
