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
            <form action="{{ route('admin.contents.store') }}" method="POST" id="content-form" enctype="multipart/form-data">
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
                                <i class="fas fa-calendar"></i> Tahun
                            </label>
                            <input 
                                type="text" 
                                name="year" 
                                id="year" 
                                class="form-control @error('year') is-invalid @enderror" 
                                value="{{ old('year') }}"
                                placeholder="Contoh: 2025 atau 1990-2000"
                            >
                            @error('year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="lemma_name" class="form-label">
                        <i class="fas fa-heading"></i> Lemma (Judul) <span style="color: red;">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="lemma_name" 
                        id="lemma_name" 
                        class="form-control @error('lemma_name') is-invalid @enderror" 
                        value="{{ old('lemma_name') }}"
                        placeholder="Masukkan nama lemma/judul"
                        required
                    >
                    @error('lemma_name')
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

                <!-- Image Management Section -->
                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-images"></i> Gambar
                    </label>
                    
                    <!-- Upload New Image -->
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Tambah Gambar</h6>
                            <div id="image-uploads-container">
                                <div class="image-upload-item mb-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input 
                                                type="file" 
                                                name="images[]" 
                                                class="form-control image-file-input" 
                                                accept="image/*"
                                            >
                                            <div class="image-preview-container mt-2" style="display: none;">
                                                <img src="" alt="Preview" class="image-preview" style="max-width: 100%; max-height: 200px; border: 1px solid #ddd; border-radius: 4px; padding: 5px;">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <input 
                                                type="text" 
                                                name="image_captions[]" 
                                                class="form-control" 
                                                placeholder="Caption (opsional)"
                                            >
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-danger btn-sm remove-image-btn" style="display: none;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-image-btn">
                                <i class="fas fa-plus"></i> Tambah Gambar Lain
                            </button>
                        </div>
                    </div>
                </div>

                <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                    <p style="margin: 0; color: #666;">
                        <i class="fas fa-check-circle" style="color: green;"></i> <strong>Info:</strong> Slug akan dibuat otomatis dari nama lemma.
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
        // Initialize Summernote with image upload
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
                    ['insert', ['link', 'picture', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                    ['help', ['help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        // Note: Images uploaded via editor will be saved after content creation
                        // For now, we'll just insert the image URL placeholder
                        const file = files[0];
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('.summernote').summernote('insertImage', e.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            // Add image preview functionality
            $(document).on('change', '.image-file-input', function() {
                const file = this.files[0];
                const previewContainer = $(this).siblings('.image-preview-container');
                const previewImg = previewContainer.find('.image-preview');
                
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.attr('src', e.target.result);
                        previewContainer.show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.hide();
                }
            });

            // Add image upload field
            $('#add-image-btn').on('click', function() {
                const newItem = `
                    <div class="image-upload-item mb-2">
                        <div class="row">
                            <div class="col-md-6">
                                <input 
                                    type="file" 
                                    name="images[]" 
                                    class="form-control image-file-input" 
                                    accept="image/*"
                                >
                                <div class="image-preview-container mt-2" style="display: none;">
                                    <img src="" alt="Preview" class="image-preview" style="max-width: 100%; max-height: 200px; border: 1px solid #ddd; border-radius: 4px; padding: 5px;">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <input 
                                    type="text" 
                                    name="image_captions[]" 
                                    class="form-control" 
                                    placeholder="Caption (opsional)"
                                >
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm remove-image-btn">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                $('#image-uploads-container').append(newItem);
                updateRemoveButtons();
            });

            // Remove image upload field
            $(document).on('click', '.remove-image-btn', function() {
                const item = $(this).closest('.image-upload-item');
                item.find('.image-file-input').val('');
                item.find('.image-preview-container').hide();
                item.remove();
                updateRemoveButtons();
            });

            function updateRemoveButtons() {
                const items = $('.image-upload-item');
                items.each(function(index) {
                    if (items.length > 1) {
                        $(this).find('.remove-image-btn').show();
                    } else {
                        $(this).find('.remove-image-btn').hide();
                    }
                });
            }

            updateRemoveButtons();

            // Remove empty file inputs before form submission
            $('#content-form').on('submit', function(e) {
                $('.image-file-input').each(function() {
                    const fileInput = $(this)[0];
                    if (!fileInput || !fileInput.files || fileInput.files.length === 0 || fileInput.files[0].size === 0) {
                        // Remove the entire upload item if file is empty
                        $(this).closest('.image-upload-item').remove();
                    }
                });
                // Allow form to submit normally
            });
        });

    </script>

    <style>
        .image-upload-item {
            padding: 0.5rem;
            border: 1px dashed #ddd;
            border-radius: 4px;
            background: #f9f9f9;
        }
        .image-upload-item:hover {
            background: #f5f5f5;
        }
        .image-preview-container {
            margin-top: 0.5rem;
        }
        .image-preview {
            max-width: 100%;
            max-height: 200px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
@endsection
