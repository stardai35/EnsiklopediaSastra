@extends('layouts.app')

@section('title', ($content->lemma->formatted_name ?? $content->lemma->name ?? 'Konten') . ' - Ensiklopedia Sastra Indonesia')

@section('content')
    <!-- Detail Header -->
    <div class="purple-gradient-bg" style="color: white; padding: 2rem;">
        <div class="container">
            <h1>{{ $content->lemma->formatted_name ?? $content->lemma->name ?? 'Konten' }}</h1>
            <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">{{ $content->category->name }} • {{ $content->formatted_year ?? $content->year }}</p>
        </div>
    </div>

    <div class="container" style="margin-top: 2rem;">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" style="margin-bottom: 2rem;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('category', $content->category->slug) }}">{{ $content->category->name }}</a></li>
                <li class="breadcrumb-item active">{{ $content->lemma->formatted_name ?? $content->lemma->name ?? 'Konten' }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <!-- Main Content -->
                <article
                    style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    @if($content->media->first() && $content->media->first()->link)
                        <div style="margin-bottom: 2rem; position: relative;">
                            <div class="image-loading-skeleton"
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 400px; z-index: 1; border-radius: 10px;">
                            </div>
                            <img src="{{ $content->media->first()->image_url }}" alt="{{ $content->lemma->name ?? 'Konten' }}"
                                class="lazy-image"
                                style="width: 100%; border-radius: 10px; max-height: 400px; object-fit: contain; position: relative; z-index: 2; opacity: 0; transition: opacity 0.3s; background: #f8f9fa;"
                                onload="this.style.opacity='1'; this.previousElementSibling.style.display='none';"
                                onerror="this.previousElementSibling.style.display='none';">
                            @if($content->media->first()->caption)
                                <p style="margin-top: 0.5rem; color: #666; font-size: 0.9rem; font-style: italic;">{{ $content->media->first()->caption }}</p>
                            @endif
                        </div>
                    @endif

                    <div style="margin-bottom: 1rem;">
                        <span
                            style="display: inline-block; background: var(--primary-color); color: white; padding: 0.5rem 1rem; border-radius: 5px; font-size: 0.9rem;">
                            {{ $content->category->name }}
                        </span>
                        <span style="display: inline-block; margin-left: 1rem; color: #999; font-size: 0.9rem;">
                            <i class="fas fa-calendar"></i> {{ $content->formatted_year ?? $content->year }}
                        </span>
                    </div>

                    <h2 style="color: var(--primary-color); margin-bottom: 1.5rem;">{{ $content->lemma->formatted_name ?? $content->lemma->name ?? 'Konten' }}</h2>

                    <div class="content-body" style="line-height: 1.8; color: #333; font-size: 1rem; word-break: break-word;">
                        {!! $content->formatted_text !!}
                    </div>

                    @if($content->media->count() > 1)
                        <div style="margin-top: 3rem;">
                            <h3 style="color: var(--primary-color); margin-bottom: 1.5rem;">Galeri Foto</h3>
                            <div
                                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem;">
                                @foreach($content->media->skip(1) as $media)
                                    <div style="position: relative;">
                                        <div class="image-loading-skeleton"
                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 150px; z-index: 1; border-radius: 8px;">
                                        </div>
                                        <img src="{{ $media->image_url }}" alt="{{ $media->caption ?? $content->lemma->name ?? 'Konten' }}"
                                            class="lazy-image"
                                            style="width: 100%; height: 150px; object-fit: contain; border-radius: 8px; cursor: pointer; position: relative; z-index: 2; opacity: 0; transition: opacity 0.3s; background: #f8f9fa;"
                                            onload="this.style.opacity='1'; this.previousElementSibling.style.display='none';"
                                            onerror="this.previousElementSibling.style.display='none';">
                                        @if($media->caption)
                                            <p style="margin-top: 0.5rem; color: #666; font-size: 0.85rem; text-align: center;">{{ $media->caption }}</p>
                                        @endif
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
                                        {{ $related->lemma->formatted_name ?? $related->lemma->name ?? 'Konten' }}
                                    </a>
                                    <div style="color: #999; font-size: 0.85rem; margin-top: 0.3rem;">
                                        {{ $related->formatted_year ?? $related->year }}
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

        /* Content formatting */
        .content-body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .content-body p {
            margin-bottom: 1rem;
            text-align: justify;
        }

        .content-body p:last-child {
            margin-bottom: 0;
        }

        .content-body span.italicword {
            font-style: italic;
            font-weight: 500;
        }

        .content-body strong {
            font-weight: 600;
        }

        .content-body em {
            font-style: italic;
        }

        .content-body ul,
        .content-body ol {
            margin: 1rem 0;
            padding-left: 2rem;
        }

        .content-body li {
            margin-bottom: 0.5rem;
        }

        .content-body h1,
        .content-body h2,
        .content-body h3,
        .content-body h4,
        .content-body h5,
        .content-body h6 {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .content-body h1:first-child,
        .content-body h2:first-child,
        .content-body h3:first-child {
            margin-top: 0;
        }

        .content-body a {
            color: var(--primary-color);
            text-decoration: underline;
        }

        .content-body a:hover {
            color: #6d28d9;
        }

        .content-body blockquote {
            border-left: 4px solid var(--primary-color);
            padding-left: 1rem;
            margin: 1rem 0;
            font-style: italic;
            color: #666;
        }
    </style>
@endsection