@extends('layouts.app')

@section('title', 'Ensiklopedia Sastra Indonesia')

@section('content')
    <!-- Hero Section -->
<div class="hero-section">
    <div class="hero-container">

        <!-- Logo kiri -->
        <div class="hero-logo">
            <img src="{{ asset('https://zippy-white-isy941v3v7.edgeone.app/unnamed%201.png') }}" alt="Ensiklopedia Sastra Indonesia">
        </div>

        <!-- Konten kanan -->
        <div class="hero-content">
            <h1>ENSIKLOPEDIA</h1>
            <h2>SASTRA INDONESIA</h2>

            <!-- Search -->
            <form action="{{ route('daftar-isi') }}" method="GET" class="hero-search">
                <span class="search-icon">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" name="search" placeholder="Apa yang ingin dipelajari hari ini?">
                <button type="submit">Mencari</button>
            </form>
        </div>

    </div>
</div>


    <!-- Main Container -->
    <div class="container">
        <div class="container my-5">
            <h2 class="section-title">Telusuri melalui Kategori</h2>

            <div class="row g-4">
                @foreach($categories as $category)
                    @if(!empty($categoryContents[$category->id]))
                        <div class="col-md-6 col-lg-4">
                            <div class="category-box">
                                <div class="category-thumb-grid">
                                    @php
                                        $categoryImages = [
                                            1 => 'https://joint-amaranth-okxmdkvefa.edgeone.app/pengarang.png',
                                            2 => 'https://joint-amaranth-okxmdkvefa.edgeone.app/hadiah-sastra.png',
                                            3 => 'https://joint-amaranth-okxmdkvefa.edgeone.app/karyasastra.png',
                                            4 => 'https://joint-amaranth-okxmdkvefa.edgeone.app/lembaga-sastra.png',
                                            5 => 'https://joint-amaranth-okxmdkvefa.edgeone.app/media-sastra.png',
                                            6 => 'https://joint-amaranth-okxmdkvefa.edgeone.app/gejala-sastra.png',
                                        ];
                                    @endphp

                                    <img src="{{ $categoryImages[$category->id] ?? asset('images/default-category.jpg') }}"
                                        alt="{{ $category->name }}">
                                </div>
                                <!-- Text -->
                                <div class="category-content">
                                    <h5>{{ $category->name }}</h5>
                                    @php
                                        $text = match ($category->slug) {
                                            'pengarang' => 'Daftar tokoh pengarang sastra Indonesia beserta karya dan profil singkatnya.',
                                            'karya-sastra' => 'Kumpulan karya sastra berupa novel, cerpen, puisi, dan naskah drama.',
                                            'gejala-sastra' => 'Fenomena dan perkembangan sastra di berbagai periode.',
                                            'lembaga-sastra' => 'Lorem Ipsum dolor sit amet, consectetur adipiscing elit.',
                                            'media-penyebar-penerbit-sastra' => '2 Lorem Ipsum dolor sit amet, ',
                                            'hadiah-sayembara-sastra' => '3 Lorem Ipsum dolor sit amet, '
                                        };
                                    @endphp

                                    <p>{{ $text }}</p>

                                    <a href="{{ route('category', $category->slug) }}" class="category-link">
                                        Lihat selengkapnya →
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>


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
                        <a href="{{ route('detail', $person->slug) }}" class="btn-primary"
                            style="margin-top: 1rem; font-size: 0.9rem;">
                            Lihat Profil
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-section">
            <div class="stat-item">
                <div class="stat-number" data-target="{{ $totalCategories }}">0</div>
                <div class="stat-label">Kelompok Lema</div>
            </div>

            <div class="stat-item">
                <div class="stat-number" data-target="{{ $totalContent }}">0</div>
                <div class="stat-label">Karya Sastra</div>
            </div>

            <div class="stat-item">
                <div class="stat-number" data-target="104" data-suffix="K+">0</div>
                <div class="stat-label">Pembaca</div>
            </div>
        </div>

        <style>
            
            .stats-section {
                background: linear-gradient(135deg, #f5f3ff, #ede9fe);
                border-radius: 1.25rem;
                padding: 3rem 2rem;
                display: flex;
                justify-content: space-around;
                text-align: center;
            }

            .stat-number {
                font-size: 2.5rem;
                font-weight: 700;
                color: #4c1d95;
            }

            .stat-label {
                margin-top: .25rem;
                color: #6b7280;
                font-size: .95rem;
            }

            .category-box {
                display: flex;
                gap: 16px;
                padding: 20px;
                border-radius: 16px;
                background: #fff;
                box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
                height: 100%;
            }

            .category-thumb-grid {
                display: flex;
                gap: 6px;
            }

            .category-thumb-grid img {
                width: 120px;
                height: 120px;
                object-fit: cover;
                border-radius: 2px;
            }

            .category-content h5 {
                font-weight: 700;
                margin-bottom: 6px;
            }

            .category-content p {
                font-size: 14px;
                color: #6b7280;
                margin-bottom: 8px;
            }

            .category-link {
                font-weight: 600;
                color: #2563eb;
                text-decoration: none;
            }

        </style>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const counters = document.querySelectorAll(".stat-number");

                const countUp = (el) => {
                    const target = +el.dataset.target;
                    const suffix = el.dataset.suffix || "";
                    let start = 0;
                    const duration = 1500;
                    const step = target / (duration / 16);

                    function update() {
                        start += step;
                        if (start < target) {
                            el.innerText = Math.floor(start).toLocaleString() + suffix;
                            requestAnimationFrame(update);
                        } else {
                            el.innerText = target.toLocaleString() + suffix;
                        }
                    }
                    update();
                };

                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            countUp(entry.target);
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.5 });

                counters.forEach(counter => observer.observe(counter));
            });
        </script>

        <section style="padding:5rem 0;background:#fff">
            <div class="container">
                <div class="row align-items-center gy-5">

                    <!-- LEFT FAQ -->
                    <div class="col-lg-6">
                        <h2 style="font-size:2rem;font-weight:700;margin-bottom:2.5rem;color:#111827">
                            Pertanyaan yang Sering Ditanyakan
                        </h2>

                        <div style="border-top:1px solid #e5e7eb">

                            <!-- ITEM -->
                            <div style="padding:1.2rem 0;border-bottom:1px solid #e5e7eb">
                                <button data-bs-toggle="collapse" data-bs-target="#faq1"
                                    style="width:100%;background:none;border:none;padding:0;display:flex;justify-content:space-between;align-items:center;font-size:1rem;font-weight:500;color:#111827">
                                    <span>1. Apa itu Ensiklopedia Sastra Indonesia?</span>
                                    <i class="fas fa-chevron-down" style="color:#6b7280"></i>
                                </button>
                                <div id="faq1" class="collapse show">
                                    <p style="margin-top:.8rem;font-size:.95rem;color:#4b5563;line-height:1.7">
                                        Ensiklopedia Sastra Indonesia merupakan sumber informasi tepercaya
                                        yang memuat data pengarang, karya, lembaga, dan perkembangan sastra Indonesia.
                                    </p>
                                </div>
                            </div>

                            <!-- DUPLIKASI ITEM -->
                            <div style="padding:1.2rem 0;border-bottom:1px solid #e5e7eb">
                                <button data-bs-toggle="collapse" data-bs-target="#faq2" class="collapsed"
                                    style="width:100%;background:none;border:none;padding:0;display:flex;justify-content:space-between;align-items:center;font-size:1rem;font-weight:500;color:#111827">
                                    <span>2. Apa tujuan dibuatnya Ensiklopedia Sastra Indonesia?</span>
                                    <i class="fas fa-chevron-down" style="color:#6b7280"></i>
                                </button>
                                <div id="faq2" class="collapse">
                                    <p style="margin-top:.8rem;font-size:.95rem;color:#4b5563;line-height:1.7">
                                        Untuk mendokumentasikan dan melestarikan kekayaan sastra Indonesia
                                        agar mudah diakses oleh masyarakat luas.
                                    </p>
                                </div>
                            </div>

                            <div style="padding:1.2rem 0;border-bottom:1px solid #e5e7eb">
                                <button data-bs-toggle="collapse" data-bs-target="#faq3" class="collapsed"
                                    style="width:100%;background:none;border:none;padding:0;display:flex;justify-content:space-between;align-items:center;font-size:1rem;font-weight:500;color:#111827">
                                    <span>3. Informasi apa saja yang tersedia?</span>
                                    <i class="fas fa-chevron-down" style="color:#6b7280"></i>
                                </button>
                                <div id="faq3" class="collapse">
                                    <p style="margin-top:.8rem;font-size:.95rem;color:#4b5563;line-height:1.7">
                                        Informasi meliputi pengarang, karya sastra, penerbit, lembaga sastra, dan gejala
                                        sastra.
                                    </p>
                                </div>
                            </div>

                            <div style="padding:1.2rem 0;border-bottom:1px solid #e5e7eb">
                                <button data-bs-toggle="collapse" data-bs-target="#faq4" class="collapsed"
                                    style="width:100%;background:none;border:none;padding:0;display:flex;justify-content:space-between;align-items:center;font-size:1rem;font-weight:500;color:#111827">
                                    <span>4. Apakah semua konten dapat diakses gratis?</span>
                                    <i class="fas fa-chevron-down" style="color:#6b7280"></i>
                                </button>
                                <div id="faq4" class="collapse">
                                    <p style="margin-top:.8rem;font-size:.95rem;color:#4b5563;line-height:1.7">
                                        Ya, seluruh konten dapat diakses secara gratis oleh publik.
                                    </p>
                                </div>
                            </div>

                            <div style="padding:1.2rem 0">
                                <button data-bs-toggle="collapse" data-bs-target="#faq5" class="collapsed"
                                    style="width:100%;background:none;border:none;padding:0;display:flex;justify-content:space-between;align-items:center;font-size:1rem;font-weight:500;color:#111827">
                                    <span>5. Bagaimana cara memberikan saran atau koreksi?</span>
                                    <i class="fas fa-chevron-down" style="color:#6b7280"></i>
                                </button>
                                <div id="faq5" class="collapse">
                                    <p style="margin-top:.8rem;font-size:.95rem;color:#4b5563;line-height:1.7">
                                        Anda dapat menyampaikan masukan melalui halaman kontak yang tersedia di situs ini.
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- RIGHT VISUAL -->
                    <div class="col-lg-6 d-none d-lg-flex justify-content-center">
                        <div
                            style="width:300px;height:300px;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#9333ea);display:flex;align-items:center;justify-content:center">
                            <div
                                style="width:200px;height:200px;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;font-size:6rem;font-weight:700;color:#7c3aed">
                                ?
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div>
@endsection