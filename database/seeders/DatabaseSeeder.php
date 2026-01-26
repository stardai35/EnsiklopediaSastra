<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Content;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create demo admin user
        User::create([
            'name' => 'Admin Ensiklopedia',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        // Seeder untuk Category
        $categories = [
            ['id' => 1, 'name' => 'Pengarang', 'slug' => 'pengarang'],
            ['id' => 2, 'name' => 'Karya Sastra', 'slug' => 'karya-sastra'],
            ['id' => 3, 'name' => 'Media Penyebar/Penerbit Sastra', 'slug' => 'media-penyebar-penerbit-sastra'],
            ['id' => 4, 'name' => 'Hadiah/Sayembara Sastra', 'slug' => 'hadiah-sayembara-sastra'],
            ['id' => 5, 'name' => 'Lembaga Sastra', 'slug' => 'lembaga-sastra'],
            ['id' => 6, 'name' => 'Gejala Sastra', 'slug' => 'gejala-sastra'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Seeder untuk Content - Pengarang
        $pengarang = [
            ['cat_id' => 1, 'title' => 'Pramoedya Ananta Toer', 'year' => '1925-2006', 'slug' => 'pramoedya-ananta-toer', 'text' => 'Pramoedya Ananta Toer adalah salah satu sastrawan Indonesia yang paling terkenal dan berpengaruh. Lahir di Blora, Jawa Tengah, pada tanggal 6 Februari 1925, dan meninggal di Jakarta pada tanggal 30 April 2006. Beliau dikenal sebagai penulis yang prolific dan memiliki gaya penulisan yang kuat dan bermakna. Karyanya mencakup novel, cerpen, drama, dan esai.'],
            ['cat_id' => 1, 'title' => 'Chairil Anwar', 'year' => '1922-1949', 'slug' => 'chairil-anwar', 'text' => 'Chairil Anwar adalah seorang penyair Indonesia yang revolusioner. Lahir di Medan pada tanggal 26 Juli 1922 dan meninggal di Jakarta pada tanggal 28 April 1949. Beliau dikenal sebagai pelopor puisi modern Indonesia. Puisi-puisinya mencerminkan gejolak jiwa dan semangat perlawanan dengan tema kebangsaan.'],
            ['cat_id' => 1, 'title' => 'Sutan Takdir Alisjahbana', 'year' => '1908-1994', 'slug' => 'sutan-takdir-alisjahbana', 'text' => 'Sutan Takdir Alisjahbana adalah seorang sastrawan, kritikus sastra, dan pemikir Indonesia yang berpengaruh. Beliau dikenal melalui karya-karya inovatifnya dalam mengembangkan sastra Indonesia modern. Kontribusinya terhadap perkembangan bahasa Indonesia sangat signifikan.'],
            ['cat_id' => 1, 'title' => 'Achdiat Kartamihardja', 'year' => '1924-2005', 'slug' => 'achdiat-kartamihardja', 'text' => 'Achdiat Kartamihardja adalah seorang novelis Indonesia yang terkenal dengan karya-karyanya yang mendalam dan berbobot. Beliau menghasilkan berbagai novel yang mencerminkan kehidupan sosial dan budaya Indonesia dengan perspektif yang unik.'],
            ['cat_id' => 1, 'title' => 'Amir Hamzah', 'year' => '1911-1946', 'slug' => 'amir-hamzah', 'text' => 'Amir Hamzah adalah seorang penyair Indonesia yang dikenal dengan puisi-puisinya yang indah dan penuh makna. Beliau aktif dalam gerakan sastra Indonesia dan memiliki kontribusi penting dalam perkembangan puisi Indonesia modern.'],
            ['cat_id' => 1, 'title' => 'Emha Ainun Nadjib', 'year' => '1952-sekarang', 'slug' => 'emha-ainun-nadjib', 'text' => 'Emha Ainun Nadjib adalah seorang penyair, penulis, dan aktivis sosial Indonesia. Karyanya menggabungkan elemen spiritualitas, humaniora, dan kritik sosial. Beliau juga dikenal sebagai salah satu tokoh intelektual Muslim progresif di Indonesia.'],
            ['cat_id' => 1, 'title' => 'Goenawan Muhammad', 'year' => '1941-sekarang', 'slug' => 'goenawan-muhammad', 'text' => 'Goenawan Muhammad adalah seorang penyair, penulis, dan editor terkemuka Indonesia. Beliau adalah pendiri majalah Tempo dan dikenal dengan puisi-puisinya yang artistik dan bermakna mendalam tentang kehidupan modern.'],
        ];

        foreach ($pengarang as $item) {
            Content::create($item);
        }

        // Seeder untuk Content - Karya Sastra
        $karya = [
            ['cat_id' => 2, 'title' => 'Laskar Pelangi', 'year' => '2005', 'slug' => 'laskar-pelangi', 'text' => 'Laskar Pelangi adalah novel karya Andrea Hirata yang menceritakan kisah anak-anak dari keluarga kurang mampu yang berjuang untuk mengubah nasib mereka melalui pendidikan. Novel ini telah diterjemahkan ke berbagai bahasa dan menjadi bestseller internasional.'],
            ['cat_id' => 2, 'title' => 'Negeri 5 Menara', 'year' => '2009', 'slug' => 'negeri-5-menara', 'text' => 'Negeri 5 Menara adalah novel karya Ahmad Fuadi yang menceritakan petualangan seorang remaja bernama Alif yang melanjutkan pendidikan ke Malaysia. Novel ini menggabungkan elemen adventure, coming-of-age, dan pencarian jati diri.'],
            ['cat_id' => 2, 'title' => 'Sang Pemimpi', 'year' => '2006', 'slug' => 'sang-pemimpi', 'text' => 'Sang Pemimpi adalah novel karya Andrea Hirata yang merupakan lanjutan dari Laskar Pelangi. Novel ini menceritakan tentang perjalanan dua tokoh utama untuk mewujudkan impian mereka dengan setting yang terutama di Paris.'],
            ['cat_id' => 2, 'title' => 'Bumi Manusia', 'year' => '1980', 'slug' => 'bumi-manusia', 'text' => 'Bumi Manusia adalah novel pertama dari tetralogi Pulau Buru karya Pramoedya Ananta Toer. Novel ini menceritakan tentang perjalanan seorang pemuda Jawa dalam menghadapi kehidupan dan masyarakat modern pada awal abad ke-20.'],
            ['cat_id' => 2, 'title' => 'Anak Semua Bangsa', 'year' => '1980', 'slug' => 'anak-semua-bangsa', 'text' => 'Anak Semua Bangsa adalah novel kedua dari tetralogi Pulau Buru karya Pramoedya Ananta Toer. Novel ini melanjutkan perjalanan tokoh utama dalam perjuangan melawan penjajahan dengan latar belakang gerakan nasionalisme.'],
            ['cat_id' => 2, 'title' => 'Pertemuan Jatuh Cinta', 'year' => '1992', 'slug' => 'pertemuan-jatuh-cinta', 'text' => 'Pertemuan Jatuh Cinta adalah novel karya Suman Andi Agurto yang menceritakan tentang percintaan remaja di era modern dengan sentuhan budaya lokal dan pesan moral yang mendalam.'],
            ['cat_id' => 2, 'title' => 'Ayat-Ayat Cinta', 'year' => '2008', 'slug' => 'ayat-ayat-cinta', 'text' => 'Ayat-Ayat Cinta adalah novel karya Habiburrahman El Shirazy yang menceritakan kisah cinta seorang mahasiswa Indonesia di Kairo. Novel ini menggabungkan tema cinta, agama, dan persahabatan dengan cerita yang menyentuh hati.'],
            ['cat_id' => 2, 'title' => 'Ketika Cinta Bertasbih', 'year' => '2007', 'slug' => 'ketika-cinta-bertasbih', 'text' => 'Ketika Cinta Bertasbih adalah novel karya Habiburrahman El Shirazy yang melanjutkan cerita dari Ayat-Ayat Cinta. Novel ini mengeksplorasi hubungan cinta dan pengambilan keputusan hidup yang sulit dengan nilai-nilai spiritual.'],
        ];

        foreach ($karya as $item) {
            Content::create($item);
        }

        // Seeder untuk Content - Media Penyebar
        $media = [
            ['cat_id' => 3, 'title' => 'Penerbit Gramedia', 'year' => '1974-sekarang', 'slug' => 'penerbit-gramedia', 'text' => 'PT Gramedia adalah penerbit buku terkemuka di Indonesia yang telah memainkan peran penting dalam penyebaran sastra Indonesia. Penerbit ini telah menerbitkan ribuan judul buku dari berbagai genre dan penulis ternama.'],
            ['cat_id' => 3, 'title' => 'Majalah Sastra Indonesia', 'year' => '1970-sekarang', 'slug' => 'majalah-sastra-indonesia', 'text' => 'Majalah Sastra Indonesia adalah publikasi penting yang berfokus pada sastra dan budaya Indonesia. Majalah ini telah menerbitkan karya-karya dari banyak penulis terkenal dan menjadi platform bagi penulis baru.'],
            ['cat_id' => 3, 'title' => 'Penerbit Kepustakaan Populer Gramedia', 'year' => '1998-sekarang', 'slug' => 'penerbit-kpg', 'text' => 'Penerbit Kepustakaan Populer Gramedia adalah bagian dari grup Gramedia yang fokus pada penerbitan buku sastra dan budaya dengan jangkauan pembaca yang luas di seluruh Indonesia.'],
            ['cat_id' => 3, 'title' => 'Tempo Magazine', 'year' => '1971-sekarang', 'slug' => 'tempo-magazine', 'text' => 'Tempo Magazine adalah majalah berita dan budaya terkemuka di Indonesia yang didirikan oleh Goenawan Muhammad. Majalah ini menjadi platform penting untuk publikasi karya sastra dan kritik budaya.'],
        ];

        foreach ($media as $item) {
            Content::create($item);
        }

        // Seeder untuk Content - Hadiah/Sayembara
        $hadiah = [
            ['cat_id' => 4, 'title' => 'Penghargaan Sastra Asia', 'year' => '1985-sekarang', 'slug' => 'penghargaan-sastra-asia', 'text' => 'Penghargaan Sastra Asia adalah ajang penghargaan bergengsi yang mengakui karya-karya sastra terbaik dari berbagai negara Asia termasuk Indonesia. Penghargaan ini telah membantu mengangkat profil penulis Indonesia di tingkat internasional.'],
            ['cat_id' => 4, 'title' => 'Sayembara Novel Dewan Kesenian Jakarta', 'year' => '1975-sekarang', 'slug' => 'sayembara-novel-dkj', 'text' => 'Sayembara Novel Dewan Kesenian Jakarta adalah ajang pencarian karya sastra yang rutin diadakan untuk mengapresiasi dan mendorong penulis muda Indonesia menghasilkan karya berkualitas.'],
            ['cat_id' => 4, 'title' => 'Penghargaan Ramadhan', 'year' => '1980-sekarang', 'slug' => 'penghargaan-ramadhan', 'text' => 'Penghargaan Ramadhan adalah penghargaan bergengsi untuk karya-karya sastra yang diterbitkan selama bulan Ramadhan. Penghargaan ini memiliki prestise tinggi dalam dunia sastra Indonesia.'],
        ];

        foreach ($hadiah as $item) {
            Content::create($item);
        }

        // Seeder untuk Content - Lembaga Sastra
        $lembaga = [
            ['cat_id' => 5, 'title' => 'Dewan Kesenian Jakarta', 'year' => '1968-sekarang', 'slug' => 'dewan-kesenian-jakarta', 'text' => 'Dewan Kesenian Jakarta adalah lembaga seni dan budaya tertua di Indonesia yang didirikan untuk mempromosikan perkembangan seni dan sastra. Lembaga ini telah memainkan peran penting dalam mengorganisir festival sastra dan penghargaan.'],
            ['cat_id' => 5, 'title' => 'Persatuan Pengarang Indonesia', 'year' => '1950-sekarang', 'slug' => 'persatuan-pengarang-indonesia', 'text' => 'Persatuan Pengarang Indonesia adalah organisasi profesional yang mewadahi para penulis dan pengarang Indonesia. Organisasi ini berkomitmen untuk melindungi hak-hak penulis dan mempromosikan kualitas sastra Indonesia.'],
            ['cat_id' => 5, 'title' => 'Institut Kesenian Jakarta', 'year' => '1967-sekarang', 'slug' => 'institut-kesenian-jakarta', 'text' => 'Institut Kesenian Jakarta adalah lembaga pendidikan seni yang mendidik generasi seniman dan sastrawan Indonesia. Lembaga ini telah menghasilkan banyak figur penting dalam dunia seni dan sastra Indonesia.'],
        ];

        foreach ($lembaga as $item) {
            Content::create($item);
        }

        // Seeder untuk Content - Gejala Sastra
        $gejala = [
            ['cat_id' => 6, 'title' => 'Puisi Modern Indonesia', 'year' => '1950-an', 'slug' => 'puisi-modern-indonesia', 'text' => 'Puisi modern Indonesia berkembang pesat setelah kemerdekaan. Gejala sastra ini ditandai dengan pergeseran dari puisi tradisional ke bentuk dan isi yang lebih modern, ekspresif, dan berani bereksperimen dengan tema serta teknik penulisan baru.'],
            ['cat_id' => 6, 'title' => 'Sastra Engagement', 'year' => '1945-an', 'slug' => 'sastra-engagement', 'text' => 'Sastra Engagement atau sastra berkomitmen adalah gejala sastra yang berkembang pasca kemerdekaan Indonesia. Sastra jenis ini mengutamakan pesan sosial dan politis dalam setiap karya. Penulis-penulis mencoba menggunakan sastra sebagai alat untuk mengubah masyarakat.'],
        ];

        foreach ($gejala as $item) {
            Content::create($item);
        }
    }
}
