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
            --primary-color: #7c3aed;
            --secondary-color: #a78bfa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, #a78bfa 100%);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
        }

        .search-box input {
            border: none;
            padding: 8px 15px;
            border-radius: 4px 0 0 4px;
            width: 250px;
        }

        .search-box button {
            background: white;
            border: none;
            padding: 8px 15px;
            border-radius: 0 4px 4px 0;
            color: var(--primary-color);
            cursor: pointer;
            transition: background 0.3s;
        }

        .search-box button:hover {
            background: #f0f0f0;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #a78bfa 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
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

        .hero-logo {
            position: absolute;
            left: 3%;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.8;
        }

        .hero-logo img {
            height: 150px;
        }

        /* Cards */
        .category-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .category-card-img {
            height: 150px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #a78bfa 100%);
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
            object-fit: cover;
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

        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--primary-color) 0%, #a78bfa 100%);
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
            background: #6d28d9;
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-section p {
                font-size: 1rem;
            }

            .hero-logo {
                display: none;
            }

            .search-box {
                display: none;
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
    </style>
    @yield('extra-css')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-book-open"></i>
                ENSIKLOPEDIA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('daftar-isi') }}">Daftar Isi</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Kontak</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown">
                            Kategori
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                            @php
                                $categories = \App\Models\Category::all();
                            @endphp
                            @foreach($categories as $cat)
                                <li><a class="dropdown-item" href="{{ route('category', $cat->slug) }}">{{ $cat->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
                <div class="search-box">
                    <input type="text" placeholder="Cari...">
                    <button><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Tentang Kami</h5>
                    <p>Ensiklopedia Sastra Indonesia adalah platform komprehensif yang menghadirkan informasi lengkap tentang sastra Indonesia, dari pengarang, karya, hingga penghargaan.</p>
                </div>
                <div class="col-md-4">
                    <h5>Menu</h5>
                    <a href="{{ route('home') }}">Beranda</a>
                    <a href="{{ route('home') }}">Tentang</a>
                    <a href="{{ route('home') }}">Kontak</a>
                </div>
                <div class="col-md-4">
                    <h5>Hubungi Kami</h5>
                    <p>Email: <a href="mailto:info@ensaiklopediasastra.com">info@ensaiklopediasastra.com</a></p>
                    <p>Telepon: +62 123 456 789</p>
                    <div style="margin-top: 1rem;">
                        <span class="footer-icon"><i class="fab fa-facebook"></i></span>
                        <span class="footer-icon"><i class="fab fa-twitter"></i></span>
                        <span class="footer-icon"><i class="fab fa-instagram"></i></span>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Ensiklopedia Sastra Indonesia. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('extra-js')
</body>
</html>
