# Panduan Import Konten dari Excel

## Instalasi Package Laravel Excel

Sebelum menggunakan fitur import, pastikan Anda sudah menginstall package Laravel Excel:

```bash
composer require maatwebsite/excel
```

## Cara Menggunakan Fitur Import

### 1. Download Template Excel

1. Login ke admin panel
2. Buka halaman "Tambah Konten" (`/admin/contents/create`)
3. Klik tombol **"Download Template"** di bagian atas
4. Template Excel akan terdownload dengan nama `template_konten.xlsx`

### 2. Isi Template Excel

Template memiliki 6 kolom:

| Kolom | Deskripsi | Wajib/Opsional |
|-------|-----------|----------------|
| **Kategori** | Nama kategori konten | **Wajib** |
| **Lemma/Judul** | Judul atau nama lemma untuk konten | **Wajib** |
| **Tahun** | Tahun publikasi (bisa single: "2024" atau range: "2020-2025") | Opsional |
| **Konten** | Isi lengkap konten/artikel | **Wajib** |
| **URL Gambar** | URL gambar dari internet (http/https) | Opsional |
| **Caption Gambar** | Caption/keterangan untuk gambar | Opsional |

#### Contoh Isi Template:

```
| Kategori    | Lemma/Judul         | Tahun      | Konten                                    | URL Gambar                                | Caption Gambar               |
|-------------|---------------------|------------|-------------------------------------------|-------------------------------------------|------------------------------|
| Olahraga    | Sepak Bola          | 2024       | Sepak bola adalah olahraga yang...        | https://example.com/image1.jpg            | Pertandingan sepak bola      |
| Teknologi   | Kecerdasan Buatan   | 2023-2025  | Kecerdasan Buatan atau AI adalah...       | https://example.com/ai1.jpg;https://...   | Robot AI;Teknologi AI Modern |
| Sejarah     | Perang Dunia II     | 1939-1945  | Perang Dunia II adalah konflik...         |                                           |                              |
```

#### Format Multiple Gambar:

Untuk menambahkan **lebih dari 1 gambar**, pisahkan URL dan caption dengan cara:
- **Semicolon (;)**: `url1;url2;url3`
- **Enter/Newline**: Tekan Alt+Enter di Excel untuk membuat baris baru dalam cell yang sama
- **Comma (,)**: `url1,url2,url3`

**Contoh Multiple Images:**
```
URL Gambar: 
https://example.com/image1.jpg
https://example.com/image2.jpg

Caption Gambar:
Gambar pertama
Gambar kedua
```

Atau dengan semicolon:
```
URL Gambar: https://example.com/img1.jpg;https://example.com/img2.jpg
Caption Gambar: Caption 1;Caption 2
```

### 3. Import Data

1. Setelah mengisi template, kembali ke halaman "Tambah Konten"
2. Di bagian **"Import Konten dari Excel"**, klik tombol **"Choose File"**
3. Pilih file Excel yang sudah diisi
4. Klik tombol **"Import Data"**
5. Sistem akan memproses file dan menampilkan hasil import

## Fitur Import

### ✅ Fitur yang Didukung:

- **Auto-create Kategori**: Jika kategori belum ada, sistem akan otomatis membuatnya
- **Auto-create Lemma**: Jika lemma/judul belum ada, sistem akan otomatis membuatnya
- **Auto-generate Slug**: Slug untuk URL akan dibuat otomatis dari lemma
- **Import Gambar dari URL**: Sistem akan otomatis download gambar dari URL yang diberikan
- **Multiple Images**: Mendukung import multiple gambar per konten
- **Validasi Data**: Sistem akan memvalidasi setiap baris data
- **Error Handling**: Jika ada baris yang error, baris lainnya tetap akan diproses
- **Laporan Import**: Menampilkan jumlah data yang berhasil dan gagal diimport

### ⚙️ Validasi:

- **Kategori**: Wajib diisi
- **Lemma/Judul**: Wajib diisi
- **Konten**: Wajib diisi
- **File Excel**: Maksimal 10MB, format .xlsx atau .xls

### ⚠️ Catatan Penting:

1. **Format Konten**: Konten bisa berisi teks HTML untuk formatting (bold, italic, list, dll)
2. **Kategori Duplikat**: Jika kategori sudah ada, sistem akan menggunakan kategori yang sudah ada
3. **Lemma Duplikat**: Setiap konten bisa memiliki lemma yang sama, sistem akan membuat entry terpisah
4. **Slug Duplikat**: Jika slug sudah ada, sistem akan menambahkan angka di belakangnya (contoh: judul-1, judul-2)
5. **Error Reporting**: Maksimal 5 error pertama akan ditampilkan di halaman, cek log untuk detail lengkap
6. **URL Gambar**: 
   - Harus URL lengkap dengan http:// atau https://
   - Gambar akan di-download dan disimpan di server
   - Format yang didukung: JPG, PNG, GIF, WEBP, SVG
   - Jika download gagal, konten tetap akan dibuat tanpa gambar
7. **Caption Gambar**: Urutan caption harus sama dengan urutan URL gambar
8. **Timeout Download**: Download gambar memiliki timeout 30 detik per gambar

## Troubleshooting

### Error: "Class 'Maatwebsite\Excel\Facades\Excel' not found"
**Solusi**: Jalankan `composer require maatwebsite/excel` dan clear cache dengan `php artisan config:clear`

### Error: "The file must be a file of type: xlsx, xls"
**Solusi**: Pastikan file yang diupload memiliki ekstensi .xlsx atau .xls

### Error: "The excel file must not be greater than 10240 kilobytes"
**Solusi**: File Excel terlalu besar, coba kurangi jumlah baris atau pisahkan menjadi beberapa file

### Import berhasil tapi konten tidak muncul
**Solusi**: Cek log Laravel di `storage/logs/laravel.log` untuk melihat error detail

### Gambar tidak ter-download/ter-import
**Solusi**: 
- Pastikan URL gambar valid dan accessible (buka di browser untuk test)
- Cek apakah server bisa akses internet
- Beberapa website memblokir download otomatis, gunakan URL dari image hosting yang reliable
- Cek log Laravel untuk melihat error detail download gambar

### Error: "Failed to download image"
**Solusi**: 
- URL gambar tidak valid atau tidak bisa diakses
- Server memblokir request ke URL tersebut
- Timeout karena file terlalu besar atau koneksi lambat
- Gunakan image hosting yang reliable seperti Imgur, Cloudinary, atau host sendiri

## File-file yang Dibuat

1. **app/Imports/ContentsImport.php** - Class untuk memproses import Excel
2. **app/Exports/ContentTemplateExport.php** - Class untuk generate template Excel
3. **routes/web.php** - Ditambahkan route untuk import dan download template
4. **app/Http/Controllers/Admin/ContentController.php** - Ditambahkan method `import()` dan `downloadTemplate()`
5. **resources/views/admin/contents/create.blade.php** - Ditambahkan UI untuk import Excel

## Support

Jika mengalami masalah, silakan cek:
- Log Laravel: `storage/logs/laravel.log`
- PHP error log
- Browser console untuk error JavaScript
