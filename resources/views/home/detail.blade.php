@extends('layouts.app')

@section('title', $content->title . ' - Ensiklopedia Sastra Indonesia')

@section('content')
    <!-- Detail Header -->
    <div class="purple-gradient-bg" style="color: white; padding: 2rem;">
        <div class="container">
            <h1>{{ $content->title }}</h1>
            <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">{{ $content->category->name }} • {{ $content->year }}</p>
        </div>
    </div>

    <div class="container" style="margin-top: 2rem;">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" style="margin-bottom: 2rem;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('category', $content->category->slug) }}">{{ $content->category->name }}</a></li>
                <li class="breadcrumb-item active">{{ $content->title }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <!-- Main Content -->
                <article
                    style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    @if($content->images->first())
                        <div style="margin-bottom: 2rem; position: relative;">
                            <div class="image-loading-skeleton"
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 400px; z-index: 1; border-radius: 10px;">
                            </div>
                            <img src="{{ asset('storage/' . $content->images->first()->path) }}" alt="{{ $content->title }}"
                                class="lazy-image"
                                style="width: 100%; border-radius: 10px; max-height: 400px; object-fit: contain; position: relative; z-index: 2; opacity: 0; transition: opacity 0.3s; background: #f8f9fa;"
                                onload="this.style.opacity='1'; this.previousElementSibling.style.display='none';"
                                onerror="this.previousElementSibling.style.display='none';">
                        </div>
                    @endif

                    <div style="margin-bottom: 1rem;">
                        <span
                            style="display: inline-block; background: var(--primary-color); color: white; padding: 0.5rem 1rem; border-radius: 5px; font-size: 0.9rem;">
                            {{ $content->category->name }}
                        </span>
                        <span style="display: inline-block; margin-left: 1rem; color: #999; font-size: 0.9rem;">
                            <i class="fas fa-calendar"></i> {{ $content->year }}
                        </span>
                    </div>

                    <h2 style="color: var(--primary-color); margin-bottom: 1.5rem;">{{ $content->title }}</h2>

                    <div style="line-height: 1.8; color: #333; font-size: 1rem; word-break: break-word;">
                        {!! $content->text !!}
                    </div>

                    @if($content->images->count() > 1)
                        <div style="margin-top: 3rem;">
                            <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">Galeri Foto</h3>
                            <div
                                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem;">
                                @foreach($content->images->skip(1) as $image)
                                    <div style="position: relative;">
                                        <div class="image-loading-skeleton"
                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 150px; z-index: 1; border-radius: 8px;">
                                        </div>
                                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->alt_text }}"
                                            class="lazy-image"
                                            style="width: 100%; height: 150px; object-fit: contain; border-radius: 8px; cursor: pointer; position: relative; z-index: 2; opacity: 0; transition: opacity 0.3s; background: #f8f9fa;"
                                            data-bs-toggle="modal" data-bs-target="#imageModal"
                                            onclick="showImage('{{ asset('storage/' . $image->path) }}')"
                                            onload="this.style.opacity='1'; this.previousElementSibling.style.display='none';"
                                            onerror="this.previousElementSibling.style.display='none';">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Related Articles -->
                @if($relatedContents->count() > 0)
                    <div
                        style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 2rem;">
                        <h3 style="color: var(--primary-color); margin-bottom: 1.5rem; font-size: 1.2rem;">
                            <i class="fas fa-bookmark"></i> Konten Terkait
                        </h3>
                        <ul style="list-style: none; padding: 0;">
                            @foreach($relatedContents as $related)
                                <li style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #eee;">
                                    <a href="{{ route('detail', $related->slug) }}"
                                        style="color: var(--primary-color); text-decoration: none; font-weight: 500;">
                                        {{ $related->title }}
                                    </a>
                                    <div style="color: #999; font-size: 0.85rem; margin-top: 0.3rem;">
                                        {{ $related->year }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Category Info -->
                <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h3 style="color: var(--primary-color); margin-bottom: 1rem; font-size: 1.2rem;">
                        <i class="fas fa-folder"></i> Kategori
                    </h3>
                    <p style="margin: 0; color: #666;">{{ $content->category->name }}</p>
                    <a href="{{ route('category', $content->category->slug) }}" class="btn-primary"
                        style="margin-top: 1rem; display: block; text-align: center;">
                        Lihat Semuanya
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="" style="width: 100%; border-radius: 8px;">
                </div>
            </div>
        </div>
    </div>

    <script>
        function showImage(src) {
            document.getElementById('modalImage').src = src;
        }
    </script>
@endsection

@section('extra-css')
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
@endsection