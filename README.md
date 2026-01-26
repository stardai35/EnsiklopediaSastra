# 📚 Ensiklopedia Sastra Indonesia

Website ensiklopedia sastra Indonesia yang dibuat dengan **Laravel 12** dan **Bootstrap 5**. Menampilkan informasi lengkap tentang sastra Indonesia dari pengarang, karya sastra, penerbit, hingga penghargaan.

## ✨ Fitur Utama

- 📖 **6 Kategori Sastra** - Pengarang, Karya, Penerbit, Penghargaan, Lembaga, Gejala
- 👥 **27 Artikel Konten** - Data seeded dari database SQL yang disediakan
- 🎨 **Design Modern** - Responsive UI dengan gradient purple dan smooth animations
- 🔍 **Navigasi Intuitif** - Kategori dropdown, breadcrumb, pagination
- 📱 **Mobile Friendly** - Fully responsive di semua ukuran layar
- ⚡ **Performance** - Efficient database queries dengan Eloquent ORM

## 🚀 Quick Start

### 1. Clone/Setup Project
```bash
cd c:\laragon\www\ensa2
composer install
```

### 2. Configure Environment
File `.env` sudah dikonfigurasi

### 3. Run Database
```bash
php artisan migrate:fresh
php artisan db:seed
```

### 4. Start Server
```bash
php artisan serve
```

### 5. Access Website
```
http://127.0.0.1:8000
```

## 📂 Project Structure

```
app/
├── Http/Controllers/HomeController.php    # Main controller dengan 3 methods
├── Models/
│   ├── Category.php
│   ├── Content.php
│   └── Image.php

database/
├── migrations/
│   ├── ...create_categories_table.php
│   ├── ...create_contents_table.php
│   └── ...create_images_table.php
└── seeders/
    └── DatabaseSeeder.php               # 27 artikel + 6 kategori

resources/views/
├── layouts/app.blade.php                # Main layout dengan navbar & footer
└── home/
    ├── index.blade.php                  # Halaman beranda
    ├── category.blade.php               # Halaman kategori
    └── detail.blade.php                 # Halaman detail artikel

routes/web.php                           # 3 routes utama
```

## 🎯 Controllers & Methods

### HomeController

| Method | Route | Description |
|--------|-------|-------------|
| `index()` | `/` | Halaman beranda dengan kategori & pengarang populer |
| `category($slug)` | `/kategori/{slug}` | Halaman kategori dengan pagination |
| `detail($slug)` | `/{slug}` | Halaman detail artikel lengkap |

## 🗄️ Database Schema

### Categories Table
- `id` - Primary Key
- `name` - Nama kategori (e.g., "Pengarang")
- `slug` - URL slug (e.g., "pengarang")

### Contents Table
- `id` - Primary Key
- `cat_id` - Foreign Key ke categories
- `title` - Judul artikel
- `year` - Tahun/periode
- `text` - Isi artikel (longText)
- `slug` - URL slug unik

### Images Table
- `id` - Primary Key
- `content_id` - Foreign Key ke contents
- `path` - Path file gambar
- `alt_text` - Teks alternatif

## 💾 Data Tersedia

Lihat DOKUMENTASI.md untuk daftar lengkap 27 artikel dan 6 kategori.

## 🔗 Routes

```php
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/kategori/{slug}', [HomeController::class, 'category'])->name('category');
Route::get('/{slug}', [HomeController::class, 'detail'])->name('detail');
```

## 🎯 Features Implemented

✅ Multi-category content management  
✅ Full-text article display  
✅ Related articles on detail page  
✅ Pagination untuk kategori  
✅ Breadcrumb navigation  
✅ Social share buttons  
✅ Image gallery support  
✅ Responsive design  
✅ Search bar UI (ready for API)  
✅ FAQ accordion  

## 🛠️ Tech Stack

| Technology | Version | Purpose |
|------------|---------|---------|
| Laravel | 12 | Backend framework |
| PHP | 8.3 | Language |
| MySQL | 8.0 | Database |
| Bootstrap | 5.3 | CSS framework |
| Font Awesome | 6.4 | Icons |

## 📖 Dokumentasi Lengkap

Lihat file **DOKUMENTASI.md** untuk:
- Penjelasan detail setiap komponen
- Cara menambah data baru
- Troubleshooting guide
- Fitur untuk dikembangkan

## 📄 License
**Website aktif di:** http://127.0.0.1:8000

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
