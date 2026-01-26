@extends('layouts.app')

@section('title', 'Ensiklopedia Sastra Indonesia')

@section('content')
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-logo">
            <i class="fas fa-book-open" style="font-size: 150px; color: white;"></i>
        </div>
        <div class="container">
            <h1>ENSIKLOPEDIA</h1>
            <p>SASTRA INDONESIA</p>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container">
        <!-- Statistics -->
        <div class="stats-section">
            <div class="stat-item">
                <div class="stat-number">{{ $totalAuthors }}</div>
                <div class="stat-label">Pengarang Terkenal</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $totalContent }}</div>
                <div class="stat-label">Karya Sastra</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">104K+</div>
                <div class="stat-label">Pembaca Aktif</div>
            </div>
        </div>

        <!-- Category Sections -->
        @foreach($categories as $category)
            @if(isset($categoryContents[$category->id]) && count($categoryContents[$category->id]) > 0)
                <div style="margin: 4rem 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                        <h2 class="section-title">{{ $category->name }}</h2>
                        <a href="{{ route('category', $category->slug) }}" class="btn-primary">Lihat Semuanya</a>
                    </div>

                    <div class="row">
                        @foreach($categoryContents[$category->id] as $content)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card category-card">
                                    <div class="category-card-img">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="category-card-body">
                                        <h5 class="category-card-title">{{ $content->title }}</h5>
                                        <p class="category-card-text"><strong>Tahun:</strong> {{ $content->year }}</p>
                                        <p class="category-card-text">{{ Str::limit($content->text, 80, '...') }}</p>
                                        <a href="{{ route('detail', $content->slug) }}" class="btn-primary" style="display: block; margin-top: 1rem;">
                                            Baca Selengkapnya
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach

        <!-- Popular People Section -->
        <div style="margin: 4rem 0;">
            <h2 class="section-title">Pengarang Populer</h2>
            <div class="people-grid">
                @foreach($popularPeople as $person)
                    <div class="person-card">
                        <div class="person-image">
                            @if($person->images->first())
                                <img src="{{ asset('storage/' . $person->images->first()->path) }}" alt="{{ $person->title }}">
                            @else
                                <i class="fas fa-user" style="font-size: 80px; color: #ccc;"></i>
                            @endif
                        </div>
                        <div class="person-name">{{ $person->title }}</div>
                        <div class="person-year">{{ $person->year }}</div>
                        <a href="{{ route('detail', $person->slug) }}" class="btn-primary" style="margin-top: 1rem; font-size: 0.9rem;">
                            Lihat Profil
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="faq-section" style="margin: 4rem 0;">
            <h2 class="section-title">Pertanyaan yang Sering Ditanyakan</h2>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            Apa itu Ensiklopedia Sastra Indonesia?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Ensiklopedia Sastra Indonesia adalah platform komprehensif yang menyediakan informasi lengkap tentang sastra Indonesia, mencakup profil pengarang, karya sastra, penerbit, penghargaan, dan lembaga-lembaga sastra.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Apa saja kategori yang tersedia?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Kami menyediakan enam kategori utama: Pengarang, Karya Sastra, Media Penyebar/Penerbit Sastra, Hadiah/Sayembara Sastra, Lembaga Sastra, dan Gejala Sastra.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            Bagaimana cara mencari informasi tertentu?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Anda dapat menggunakan fitur pencarian di bagian atas halaman atau menjelajahi melalui kategori. Setiap kategori menampilkan daftar lengkap konten yang terkait.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            Apakah informasi di sini selalu diperbarui?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Ya, kami secara teratur memperbarui informasi untuk memastikan akurasi dan kelengkapan. Jika Anda menemukan informasi yang tidak akurat, silakan hubungi kami.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                            Bagaimana cara menghubungi tim support?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Anda dapat menghubungi kami melalui email atau formulir kontak yang tersedia di halaman kontak. Tim kami siap membantu Anda.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
