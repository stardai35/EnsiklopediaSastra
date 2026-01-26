# Dokumentasi Ensiklopedia Sastra Indonesia

## 📋 Deskripsi Proyek

Ensiklopedia Sastra Indonesia adalah website berbasis Laravel yang menyajikan informasi komprehensif tentang sastra Indonesia. Website ini mencakup informasi tentang pengarang, karya sastra, penerbit, penghargaan, dan lembaga-lembaga sastra Indonesia.

## 🏗️ Struktur Proyek

### Database

**Tabel utama:**
- `categories` - Kategori sastra (Pengarang, Karya Sastra, Media Penyebar, Hadiah/Sayembara, Lembaga Sastra, Gejala Sastra)
- `contents` - Konten artikel dalam setiap kategori
- `images` - Gambar yang terkait dengan konten

**Data yang tersedia:**
- 6 kategori utama
- 27 konten artikel (Pengarang, Karya Sastra, Penerbit, Hadiah, Lembaga, Gejala)

### Models

1. **Category** - Model untuk kategori sastra
   - `id`, `name`, `slug`
   - Relations: `hasMany(Content)`

2. **Content** - Model untuk konten artikel
   - `id`, `cat_id`, `title`, `year`, `text`, `slug`
   - Relations: `belongsTo(Category)`, `hasMany(Image)`

3. **Image** - Model untuk gambar
   - `id`, `content_id`, `path`, `alt_text`
   - Relations: `belongsTo(Content)`

### Controllers

**HomeController** - Menangani semua halaman publik
- `index()` - Halaman beranda dengan kategori dan pengarang populer
- `category($slug)` - Halaman kategori dengan daftar konten
- `detail($slug)` - Halaman detail artikel

### Routes

```
GET  /                      -> home.index
GET  /kategori/{slug}       -> category
GET  /{slug}                -> detail
```

### Views

1. **layouts/app.blade.php** - Layout utama dengan:
   - Navigation bar dengan kategori dropdown
   - Search box
   - Footer dengan informasi kontak

2. **home/index.blade.php** - Halaman beranda menampilkan:
   - Hero section
   - Statistik (Pengarang, Karya, Pembaca)
   - Kategori dengan 3 artikel populer
   - Pengarang populer (grid 4 kolom)
   - FAQ section dengan accordion

3. **home/category.blade.php** - Halaman kategori
   - Breadcrumb navigation
   - Grid artikel dengan pagination
   - Link ke halaman detail

4. **home/detail.blade.php** - Halaman detail artikel
   - Konten artikel lengkap
   - Galeri foto (jika ada)
   - Konten terkait (sidebar)
   - Share buttons

## 🎨 Features

### UI/UX
- **Responsive Design** - Kompatibel dengan desktop, tablet, dan mobile
- **Color Scheme** - Purple gradient (#7c3aed ke #a78bfa)
- **Bootstrap 5** - Framework CSS untuk responsive layout
- **Font Awesome** - Icons untuk UI elements
- **Smooth Transitions** - Hover effects dan animations

### Functionality
✅ Navigasi kategori  
✅ Pencarian (struktur siap, bisa dikembangkan)  
✅ Pagination konten  
✅ Related articles  
✅ FAQ accordion  
✅ Breadcrumb navigation  
✅ Share functionality  
✅ Image gallery  

## 🚀 Cara Menggunakan

### Prerequisites
- PHP 8.3+
- MySQL 8.0+
- Composer
- Laravel 12

### Setup

1. **Install dependencies:**
   ```bash
   composer install
   ```

2. **Setup environment:**
   ```bash
   cp .env.example .env
   ```

3. **Update .env dengan database credentials:**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=suzzxrkz_ensisa
   DB_USERNAME=root
   DB_PASSWORD=faradil
   ```

4. **Generate APP_KEY:**
   ```bash
   php artisan key:generate
   ```

5. **Run migrations:**
   ```bash
   php artisan migrate
   ```

6. **Seed database:**
   ```bash
   php artisan db:seed
   ```

7. **Start development server:**
   ```bash
   php artisan serve
   ```

8. **Access website:**
   Open `http://127.0.0.1:8000` di browser

## 📁 File Structure

```
ensa2/
├── app/
│   ├── Http/Controllers/HomeController.php
│   └── Models/
│       ├── Category.php
│       ├── Content.php
│       └── Image.php
├── database/
│   ├── migrations/
│   │   ├── 2025_01_26_000001_create_categories_table.php
│   │   ├── 2025_01_26_000002_create_contents_table.php
│   │   └── 2025_01_26_000000_create_images_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/views/
│   ├── layouts/app.blade.php
│   └── home/
│       ├── index.blade.php
│       ├── category.blade.php
│       └── detail.blade.php
├── routes/
│   └── web.php
└── .env
```

## 🎯 Fitur yang Sudah Diimplementasikan

✅ **Homepage**
- Hero section dengan gradient background
- Statistik jumlah pengarang, karya, pembaca
- Display kategori dengan preview artikel
- Pengarang populer dalam grid layout
- FAQ accordion section

✅ **Navigasi**
- Navbar responsif dengan dropdown kategori
- Search box (siap untuk dikembangkan)
- Breadcrumb di halaman kategori dan detail

✅ **Kategori**
- Tampil semua artikel dalam kategori
- Pagination untuk performa optimal
- Link ke halaman detail

✅ **Detail Artikel**
- Konten lengkap
- Informasi tahun dan kategori
- Konten terkait (related articles)
- Gallery gambar
- Social media share buttons

✅ **Design**
- Responsive di semua ukuran layar
- Color scheme purple yang konsisten
- Smooth animations dan transitions
- Modern UI dengan card layouts

## 🔧 Cara Menambah Data

### Tambah Kategori
```php
Category::create([
    'name' => 'Nama Kategori',
    'slug' => 'slug-kategori'
]);
```

### Tambah Konten
```php
Content::create([
    'cat_id' => 1,
    'title' => 'Judul Konten',
    'year' => '2025',
    'text' => 'Isi konten...',
    'slug' => 'judul-konten'
]);
```

### Upload Gambar
Letakkan gambar di `storage/app/public/` dan create Image record:
```php
Image::create([
    'content_id' => 1,
    'path' => 'images/nama-gambar.jpg',
    'alt_text' => 'Deskripsi gambar'
]);
```

## 📝 Database Seeding

File `database/seeders/DatabaseSeeder.php` berisi:
- 6 kategori sastra
- 7 pengarang Indonesia ternama
- 8 karya sastra populer
- 4 media penyebar/penerbit
- 3 hadiah/sayembara sastra
- 3 lembaga sastra
- 2 gejala sastra modern

Total 27 konten artikel

## 🎓 Pengembangan Lebih Lanjut

Fitur yang bisa ditambahkan:
1. **Search functionality** - Implementasi pencarian artikel
2. **Admin panel** - CRUD untuk mengelola konten
3. **User authentication** - Login untuk user khusus
4. **Comments** - Sistem komentar pada artikel
5. **Ratings** - Rating artikel oleh pembaca
6. **Newsletter** - Subscription email
7. **Social sharing** - Implementasi API social media
8. **SEO optimization** - Meta tags dan sitemap
9. **API** - REST API untuk mobile app
10. **Caching** - Redis caching untuk performa

## 🛠️ Troubleshooting

### Database connection error
- Pastikan MySQL running
- Cek credentials di .env
- Pastikan database sudah dibuat

### View not found error
- Pastikan file blade ada di `resources/views/`
- Check spelling nama file dan folder

### Asset not loading
- Run `php artisan storage:link` untuk symlink storage
- Check path di blade files

## 📄 License

MIT License - Bebas digunakan untuk tujuan komersial dan non-komersial

---

**Dibuat dengan ❤️ menggunakan Laravel 12 dan Bootstrap 5**
