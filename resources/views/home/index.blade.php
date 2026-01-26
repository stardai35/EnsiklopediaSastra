@extends('layouts.app')

@section('title', 'Ensiklopedia Sastra Indonesia')

@section('content')
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-logo">
        </div>
        <div class="container">
            <h1>ENSIKLOPEDIA</h1>
            <p>SASTRA INDONESIA</p>
            
            <!-- Search Box in Hero -->
            <div style="margin-top: 2rem; display: flex; justify-content: center;">
                <form action="{{ route('daftar-isi') }}" method="GET" style="width: 100%; max-width: 500px;">
                    <div style="display: flex; gap: 0.5rem;">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Cari konten sastra..." 
                            style="flex: 1; padding: 12px 20px; border: none; border-radius: 8px 0 0 8px; font-size: 1rem;"
                        >
                        <button 
                            type="submit" 
                            style="background: white; color: var(--primary-color); border: none; padding: 12px 25px; border-radius: 0 8px 8px 0; cursor: pointer; font-weight: 600; transition: all 0.3s;"
                            onmouseover="this.style.background='#f0f0f0';"
                            onmouseout="this.style.background='white';"
                        >
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container">
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
.stats-section{
    background:linear-gradient(135deg,#f5f3ff,#ede9fe);
    border-radius:1.25rem;
    padding:3rem 2rem;
    display:flex;
    justify-content:space-around;
    text-align:center;
}

.stat-number{
    font-size:2.5rem;
    font-weight:700;
    color:#4c1d95;
}

.stat-label{
    margin-top:.25rem;
    color:#6b7280;
    font-size:.95rem;
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
                Informasi meliputi pengarang, karya sastra, penerbit, lembaga sastra, dan gejala sastra.
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
        <div style="width:300px;height:300px;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#9333ea);display:flex;align-items:center;justify-content:center">
          <div style="width:200px;height:200px;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;font-size:6rem;font-weight:700;color:#7c3aed">
            ?
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

    </div>
@endsection
