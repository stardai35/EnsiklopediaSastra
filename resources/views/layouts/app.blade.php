<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ensiklopedia Sastra Indonesia')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #692D91;
            --secondary-color: #ec4899;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Navigation */
        .navbar-wrapper {
            padding: 0;
            margin: 0;
            width: 100%;
        }

        .navbar {
            background: #692D91;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 0;
            position: relative;
            margin: 0;
            width: 100%;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            color: white !important;
            font-size: 1.5rem;
        }

        .navbar-brand img {
            height: 40px;
        }

        .navbar-nav .nav-link {
            color: white !important;
            margin: 0 10px;
            font-weight: 500;
            transition: opacity 0.3s;
        }

        .navbar-nav .nav-link:hover {
            opacity: 0.8;
        }

        .search-box {
            display: flex;
            gap: 0;
            align-items: center;
            position: relative;
        }

        .search-box .search-icon-wrapper {
            position: absolute;
            left: 12px;
            color: #9ca3af;
            z-index: 1;
            pointer-events: none;
        }

        .search-box input {
            border: 1px solid var(--primary-color);
            padding: 8px 15px 8px 40px;
            border-radius: 6px 0 0 6px;
            width: 250px;
            max-width: 250px;
            outline: none;
            background: white;
            font-size: 0.9rem;
            color: #333;
            flex: 0 0 auto;
        }
        
        @media (max-width: 1200px) {
            .search-box input {
                width: 200px;
                max-width: 200px;
            }
        }
        
        @media (max-width: 992px) {
            .search-box input {
                width: 100%;
                max-width: 100%;
            }
        }

        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(105, 45, 145, 0.1);
        }

        .search-box input::placeholder {
            color: #9ca3af;
        }

        .search-box button {
            background: #4f246c;
            border: 1px solid var(--primary-color);
            border-left: none;
            padding: 8px 20px;
            border-radius: 0 6px 6px 0;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .search-box button:hover {
            background: rgb(111, 43, 148);
            border-color: rgb(111, 43, 148);
        }

        /* Hero Section */
        .hero-section {
            background: #ffffff;
            padding: 0.2rem 0;
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero-section p {
            font-size: 1.5rem;
            font-weight: 300;
            opacity: 0.95;
        }

        /* Cards */
        .category-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }

        .hero-container {
            max-width: 1300px;
            margin: auto;
            padding: 0 8rem;
            display: flex;
            align-items: center;
            gap: 4rem;
        }


        .hero-logo {
            flex: 1;
        }

        .hero-logo img {
            width: 100%;
            max-width: 380px;
        }

        .hero-content {
            flex: 1.2;
        }

        .hero-content h1 {
            font-size: 4rem;
            font-weight: 800;
            letter-spacing: 3px;
            margin: 0;
        }

        .hero-content h2 {
            font-size: 2.4rem;
            font-weight: 400;
            letter-spacing: 6px;
            margin: 1rem 0 2.5rem;
        }

        /* Search box */
        .hero-search {
            display: flex;
            align-items: center;
            max-width: 600px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .hero-search .search-icon {
            padding: 0 1.2rem;
            color: #9ca3af;
            font-size: 1.1rem;
        }

        .hero-search input {
            flex: 1;
            padding: 16px 10px;
            border: none;
            font-size: 1rem;
            outline: none;
        }

        .hero-search button {
            background: linear-gradient(135deg, #7c3aed, #ec4899);
            color: #ffffff;
            border: none;
            padding: 16px 36px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .hero-container {
                flex-direction: column;
                text-align: center;
            }

            .hero-search {
                margin: auto;
            }
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .category-card-img {
            height: 250px;
            background: #692D91;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }

        .category-card-body {
            padding: 1.5rem;
        }

        .category-card-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }

        .category-card-text {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Popular People */
        .people-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }

        .person-card {
            text-align: center;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }

        .person-image {
            width: 100%;
            height: 250px;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 1rem;
        }

        .person-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #f8f9fa;
        }

        .person-name {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .person-year {
            color: #999;
            font-size: 0.9rem;
        }

        /* Statistics */
        .stats-section {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin: 3rem 0;
            gap: 2rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-label {
            color: #666;
            margin-top: 0.5rem;
        }

        /* FAQ Section */
        .faq-section {
            margin: 3rem 0;
        }

        .accordion-button {
            background: white;
            color: #333;
            border: 1px solid #ddd;
            font-weight: 500;
        }

        .accordion-button:not(.collapsed) {
            background: #f8f9fa;
            color: var(--primary-color);
            box-shadow: none;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: var(--primary-color);
        }

        /* Purple Background with Noise Texture */
        .purple-gradient-bg {
            background: 
                url('{{ asset("Noise__Texture.png") }}'),
                var(--primary-color);
            background-blend-mode: overlay;
            background-size: contain, 100% 100%;
            background-position: center, center;
            background-repeat: repeat, no-repeat;
            position: relative;
        }

        .purple-gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('{{ asset("Noise__Texture.png") }}');
            background-size: contain;
            background-repeat: repeat;
            background-position: center;
            opacity: 0.3;
            mix-blend-mode: overlay;
            pointer-events: none;
            z-index: 0;
        }

        .purple-gradient-bg > * {
            position: relative;
            z-index: 1;
        }

        /* Footer */
        .footer {
            background: var(--primary-color);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }

        .footer h5 {
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: block;
            margin: 0.5rem 0;
            transition: color 0.3s;
        }

        .footer a:hover {
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
            padding-top: 1.5rem;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .footer-icon {
            display: inline-block;
            width: 30px;
            height: 30px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            line-height: 30px;
            text-align: center;
            margin-right: 0.5rem;
            transition: background 0.3s;
        }

        .footer-icon:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        /* Section Title */
        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 1rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 4px;
            background: var(--primary-color);
            border-radius: 2px;
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: #692D91;
            color: white;
        }

        /* Responsive */
        .navbar .search-box-mobile {
            display: none;
        }
        
        @media (max-width: 991px) {
            .navbar .container-fluid>div:first-child .search-box {
                display: none;
            }
            
            .navbar .search-box-mobile {
                display: block;
                width: 100%;
                margin: 0.75rem 0;
            }
            
            .navbar .search-box-mobile .search-box {
                display: flex;
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-section p {
                font-size: 1rem;
            }

            .navbar-wrapper {
                padding: 0;
            }

            .navbar {
                padding: 0.75rem 0;
                border-radius: 0;
            }

            .navbar .container-fluid>div:first-child {
                width: 100%;
            }
            
            .navbar-brand {
                margin-right: auto;
            }

            .navbar .search-box-mobile {
                width: 100%;
                margin-top: 0.75rem;
            }

            .navbar .search-box-mobile .search-box {
                width: 100%;
            }

            .navbar .search-box-mobile input {
                flex: 1;
                min-width: 0;
                font-size: 0.85rem;
                padding: 8px 12px 8px 35px;
            }

            .navbar .search-box-mobile button {
                padding: 8px 12px;
                font-size: 0.8rem;
            }

            .stats-section {
                flex-direction: column;
                gap: 1rem;
            }

            .people-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .container {
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #FFC107;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            border: none;
            z-index: 1000;
            font-size: 1.5rem;
        }

        .back-to-top:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .back-to-top.show {
            display: flex;
        }

        @media (max-width: 768px) {
            .back-to-top {
                bottom: 20px;
                right: 20px;
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
            }
        }

        /* Image Loading Animation */
        .image-loading-container {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .image-loading-skeleton {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s ease-in-out infinite;
            border-radius: inherit;
            z-index: 1;
        }

        .image-loading-skeleton::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            border: 3px solid rgba(105, 45, 145, 0.2);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        img.loading-image {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        img.loaded-image {
            opacity: 1;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }

        @keyframes spin {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }
            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }
    </style>
    @yield('extra-css')
</head>

<body>
    <!-- Navigation -->
    <div class="navbar-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
            <div class="d-flex align-items-center flex-wrap" style="flex: 1;">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="https://vicious-purple-krocduknct.edgeone.app/logo-logo%20template_badan%20Bahasa_20205-01.png"
                        style="max-width: 50px; height: auto;">
                </a>
                @if(!request()->routeIs('home'))
                    <div class="ms-3 d-none d-lg-block">
                        <form action="{{ route('daftar-isi') }}" method="GET" class="search-box">
                            <span class="search-icon-wrapper">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" placeholder="Masukan Pencarian..."
                                value="{{ request('search') }}">
                            <button type="submit">CARI</button>
                        </form>
                    </div>
                @endif
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @if(!request()->routeIs('home'))
                <div class="search-box-mobile">
                    <form action="{{ route('daftar-isi') }}" method="GET" class="search-box" style="width: 100%;">
                        <span class="search-icon-wrapper">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" placeholder="Masukan Pencarian..."
                            value="{{ request('search') }}">
                        <button type="submit">CARI</button>
                    </form>
                </div>
                @endif
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('daftar-isi') }}">Daftar Isi</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contributors') }}">Penyusun</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Tentang</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="https://vicious-purple-krocduknct.edgeone.app/logo-logo%20template_badan%20Bahasa_20205-01.png"
                        alt="Logo" class="img-fluid mb-2" style="max-width: 80px;">
                    <h6><b>Pusat Pengembangan Bahasa dan Sastra</b></h6>
                    <p>Badan Pengembangan dan Pembinaan Bahasa <br>
                        Kementrian Pendidikan Dasar dan Menengah</p>
                </div>
                <div class="col-md-4">
                    <h5>Peta Situs</h5>
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('daftar-isi') }}">Daftar Isi</a>
                    <a href="{{ route('contributors') }}">Penyusun</a>
                    <a href="{{ route('about') }}">Tentang</a>
                </div>
                <div class="col-md-4">
                    <h5>Kontak Kami</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i>
                        Jalan Anyar Km.4, Kec. Citeureup,
                        Kab. Bogor, Jawa Barat 16810</p>
                    <p><i class="fas fa-envelope me-2"></i>pusbanglin@kemdikbud.go.id</p>
                    <div style="margin-top: 1rem;">

                        <span class="footer-icon">
                            <a href="https://www.instagram.com/pusbanglin_kemdikdasmen/"
                                style="color:inherit; text-decoration:none; display:inline-flex; align-items:center;">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </span>

                        <span class="footer-icon">
                            <a href="https://www.youtube.com"
                                style="color:inherit; text-decoration:none; display:inline-flex; align-items:center;">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </span>
                        <span class="footer-icon">
                            <a href="https://www.facebook.com/Badan.Bahasa"
                                style="color:inherit; text-decoration:none; display:inline-flex; align-items:center;">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </span>

                        <span class="footer-icon">
                            <a href="https://x.com/BadanBahasa"
                                style="color:inherit; text-decoration:none; display:inline-flex; align-items:center;">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </span>

                    </div>

                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; Copyrights 2026 Ensiklopedia Sastra Indonesia. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" title="Kembali ke atas">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Back to Top Button
        const backToTopBtn = document.getElementById('backToTop');

        window.addEventListener('scroll', function () {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.add('show');
            } else {
                backToTopBtn.classList.remove('show');
            }
        });

        backToTopBtn.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Image Loading Animation - Handle images that load after DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            const lazyImages = document.querySelectorAll('img.lazy-image');
            
            lazyImages.forEach(function(img) {
                // If image is already loaded
                if (img.complete && img.naturalHeight !== 0) {
                    img.style.opacity = '1';
                    const skeleton = img.previousElementSibling;
                    if (skeleton && skeleton.classList.contains('image-loading-skeleton')) {
                        skeleton.style.display = 'none';
                    }
                }
            });
        });
    </script>
    @yield('extra-js')
</body>

</html>