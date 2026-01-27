@extends('admin.layout')

@section('page-title')
    <i class="fas fa-edit"></i> Edit Konten
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-pencil"></i> Edit: {{ $content->title }}
        </div>
        <div class="card-body">
            <form action="{{ route('admin.contents.update', $content->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cat_id" class="form-label">
                                <i class="fas fa-folder"></i> Kategori <span style="color: red;">*</span>
                            </label>
                            <select name="cat_id" id="cat_id" class="form-select @error('cat_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $content->cat_id == $category->id ? 'selected' : '' }}>
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
                                value="{{ old('year', $content->year) }}"
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
                        value="{{ old('title', $content->title) }}"
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
                    >{{ old('text', $content->text) }}</textarea>
                    @error('text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i> Gunakan editor untuk formatting teks, membuat list, dll
                    </small>
                </div>

                <!-- Existing Images -->
                @if($content->images->count() > 0)
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-image"></i> Gambar Terkini ({{ $content->images->count() }} gambar)
                        </label>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem; margin-bottom: 1rem;">
                            @foreach($content->images as $image)
                                <div style="position: relative; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                    <div class="image-loading-skeleton" style="position: absolute; top: 0; left: 0; width: 100%; height: 120px; z-index: 1;"></div>
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->alt_text }}" class="lazy-image" style="width: 100%; height: 120px; object-fit: contain; position: relative; z-index: 2; opacity: 0; transition: opacity 0.3s; background: #f8f9fa;" onload="this.style.opacity='1'; this.previousElementSibling.style.display='none';" onerror="this.previousElementSibling.style.display='none';">
                                    <button 
                                        type="button" 
                                        class="btn btn-danger btn-sm" 
                                        style="position: absolute; top: 5px; right: 5px; z-index: 3;"
                                        onclick="deleteImage({{ $image->id }}, '{{ $image->alt_text }}')"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- New Images -->
                <div class="mb-3">
                    <label for="images" class="form-label">
                        <i class="fas fa-images"></i> Tambah Gambar Baru (Multiple)
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
                        <i class="fas fa-info-circle"></i> Anda bisa tambah gambar baru. Format: JPG, PNG, GIF (Max 2MB per gambar)
                    </small>
                    @error('images.*')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    <!-- Image Preview -->
                    <div id="imagePreview" style="margin-top: 1rem;"></div>
                </div>

                <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                    <p style="margin: 0; color: #666;">
                        <i class="fas fa-info-circle" style="color: #0d6efd;"></i> <strong>Info:</strong> Slug akan diupdate otomatis jika judul berubah. Anda bisa hapus gambar yang ada dengan tombol X pada setiap gambar.
                    </p>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Konten
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

        // Image preview untuk image baru
        document.getElementById('images').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';

            if (this.files.length > 0) {
                const gallery = document.createElement('div');
                gallery.className = 'image-gallery';
                gallery.innerHTML = '<h6 style="margin-bottom: 1rem;"><i class="fas fa-plus"></i> Preview Gambar Baru</h6>';

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

        // Delete image
        function deleteImage(imageId, altText) {
            if (confirm(`Hapus gambar "${altText}"?`)) {
                fetch(`/admin/images/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Gambar berhasil dihapus');
                        location.reload();
                    } else {
                        alert('Gagal menghapus gambar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan');
                });
            }
        }
    </script>
@endsection
