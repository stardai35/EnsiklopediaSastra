@extends('admin.layout')

@section('page-title')
    <i class="fas fa-edit"></i> Edit Konten
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-pencil"></i> Edit: {{ $content->lemma->formatted_name ?? $content->lemma->name ?? 'Konten' }}
        </div>
        <div class="card-body">
            <form action="{{ route('admin.contents.update', $content->id) }}" method="POST" id="content-form" enctype="multipart/form-data">
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
                                <i class="fas fa-calendar"></i> Tahun
                            </label>
                            <input 
                                type="text" 
                                name="year" 
                                id="year" 
                                class="form-control @error('year') is-invalid @enderror" 
                                value="{{ old('year', $content->formatted_year ?? $content->year) }}"
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
                        value="{{ old('lemma_name', $content->lemma->formatted_name ?? $content->lemma->name ?? '') }}"
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
                    >{{ old('text', $content->formatted_text) }}</textarea>
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
                        <i class="fas fa-images"></i> Kelola Gambar
                    </label>
                    
                    <!-- Existing Images -->
                    @if($content->media && $content->media->count() > 0)
                        <div class="row mb-3" id="existing-images">
                            @foreach($content->media as $media)
                                <div class="col-md-3 mb-3 image-item" data-media-id="{{ $media->id }}">
                                    <div class="card">
                                        <img src="{{ $media->image_url }}" alt="Image" class="card-img-top" style="height: 150px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <input 
                                                type="text" 
                                                class="form-control form-control-sm mb-2 media-caption" 
                                                value="{{ $media->caption }}" 
                                                placeholder="Caption"
                                                data-media-id="{{ $media->id }}"
                                            >
                                            <div class="d-flex gap-1">
                                                <button 
                                                    type="button" 
                                                    class="btn btn-sm btn-warning w-100 update-media-btn"
                                                    data-media-id="{{ $media->id }}"
                                                >
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button 
                                                    type="button" 
                                                    class="btn btn-sm btn-danger w-100 delete-media-btn"
                                                    data-media-id="{{ $media->id }}"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Upload New Images -->
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Tambah Gambar Baru</h6>
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
                        <i class="fas fa-info-circle" style="color: #0d6efd;"></i> <strong>Info:</strong> Slug akan diupdate otomatis jika lemma berubah.
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
                        uploadImageToServer(files[0]);
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

            // Log file info before form submission (server will filter empty files)
            $('#content-form').on('submit', function(e) {
                let fileCount = 0;
                let fileInfo = [];
                
                $('.image-file-input').each(function(index) {
                    const fileInput = $(this)[0];
                    if (fileInput && fileInput.files && fileInput.files.length > 0 && fileInput.files[0].size > 0) {
                        fileCount++;
                        fileInfo.push({
                            index: index,
                            name: fileInput.files[0].name,
                            size: fileInput.files[0].size,
                            type: fileInput.files[0].type
                        });
                    }
                });
                
                console.log('Form submitting - Files found:', fileCount, 'File details:', fileInfo);
                
                // Don't remove or disable - let server handle empty files
            });

            // Handle update media caption
            $('.update-media-btn').on('click', function() {
                const mediaId = $(this).data('media-id');
                const caption = $(this).closest('.image-item').find('.media-caption').val();
                updateMedia(mediaId, caption);
            });

            // Handle delete media
            $('.delete-media-btn').on('click', function() {
                if (confirm('Yakin ingin menghapus gambar ini?')) {
                    const mediaId = $(this).data('media-id');
                    deleteMedia(mediaId);
                }
            });
        });

        function uploadImageToServer(file) {
            const formData = new FormData();
            formData.append('file', file);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '{{ route("admin.contents.media.upload", $content->id) }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $('.summernote').summernote('insertImage', response.url);
                    } else {
                        alert('Gagal mengupload gambar');
                    }
                },
                error: function() {
                    alert('Gagal mengupload gambar');
                }
            });
        }


        function updateMedia(mediaId, caption) {
            $.ajax({
                url: '{{ url("admin/contents/{$content->id}/media") }}/' + mediaId,
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                data: {
                    caption: caption
                },
                success: function(response) {
                    alert('Gambar berhasil diperbarui!');
                },
                error: function() {
                    alert('Gagal memperbarui gambar');
                }
            });
        }

        function deleteMedia(mediaId) {
            $.ajax({
                url: '{{ url("admin/contents/{$content->id}/media") }}/' + mediaId,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                success: function(response) {
                    $('.image-item[data-media-id="' + mediaId + '"]').remove();
                    alert('Gambar berhasil dihapus!');
                },
                error: function() {
                    alert('Gagal menghapus gambar');
                }
            });
        }
    </script>

    <style>
        .image-item {
            position: relative;
        }
        .image-item .card {
            border: 1px solid #ddd;
            transition: box-shadow 0.3s;
        }
        .image-item .card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .image-item img {
            width: 100%;
            cursor: pointer;
        }
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
