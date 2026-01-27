@extends('admin.layout')

@section('page-title')
    <i class="fas fa-plus-circle"></i> Tambah Konten Baru
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-edit"></i> Form Tambah Konten
        </div>
        <div class="card-body">
            <form action="{{ route('admin.contents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cat_id" class="form-label">
                                <i class="fas fa-folder"></i> Kategori <span style="color: red;">*</span>
                            </label>
                            <select name="cat_id" id="cat_id" class="form-select @error('cat_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('cat_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cat_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="year" class="form-label">
                                <i class="fas fa-calendar"></i> Tahun <span style="color: red;">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="year" 
                                id="year" 
                                class="form-control @error('year') is-invalid @enderror" 
                                value="{{ old('year') }}"
                                placeholder="Contoh: 2025 atau 1990-2000"
                                required
                            >
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">
                        <i class="fas fa-heading"></i> Judul Konten <span style="color: red;">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="title" 
                        id="title" 
                        class="form-control @error('title') is-invalid @enderror" 
                        value="{{ old('title') }}"
                        placeholder="Masukkan judul konten"
                        required
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="text" class="form-label">
                        <i class="fas fa-align-left"></i> Konten / Artikel <span style="color: red;">*</span>
                    </label>
                    <textarea 
                        name="text" 
                        id="text" 
                        class="form-control summernote @error('text') is-invalid @enderror"
                        placeholder="Masukkan konten lengkap dengan formatting"
                        required
                    >{{ old('text') }}</textarea>
                    @error('text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i> Gunakan editor untuk formatting teks, membuat list, dll
                    </small>
                </div>

                <div class="mb-3">
                    <label for="images" class="form-label">
                        <i class="fas fa-images"></i> Gambar (Multiple)
                    </label>
                    <div class="input-group">
                        <input 
                            type="file" 
                            name="images[]" 
                            id="images" 
                            class="form-control" 
                            multiple
                            accept="image/*"
                        >
                    </div>
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i> Anda bisa upload multiple gambar sekaligus. Format: JPG, PNG, GIF (Max 2MB per gambar)
                    </small>
                    @error('images.*')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    <!-- Image Preview -->
                    <div id="imagePreview" style="margin-top: 1rem;"></div>
                </div>

                <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                    <p style="margin: 0; color: #666;">
                        <i class="fas fa-check-circle" style="color: green;"></i> <strong>Info:</strong> Slug akan dibuat otomatis dari judul konten. Semua gambar akan tersimpan di galeri konten.
                    </p>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Konten
                    </button>
                    <a href="{{ route('admin.contents.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        // Initialize Summernote
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Masukkan konten...',
                height: 400,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                    ['help', ['help']]
                ]
            });
        });

        // Image preview
        document.getElementById('images').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';

            if (this.files.length > 0) {
                const gallery = document.createElement('div');
                gallery.className = 'image-gallery';

                Array.from(this.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const item = document.createElement('div');
                        item.className = 'image-item';
                        item.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                        gallery.appendChild(item);
                    };
                    reader.readAsDataURL(file);
                });

                preview.appendChild(gallery);
            }
        });
    </script>
@endsection
