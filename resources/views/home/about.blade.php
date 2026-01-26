@extends('layouts.app')

@section('title', 'Tentang - Ensiklopedia Sastra Indonesia')

@section('content')
    <!-- Hero Section -->
    <div style="background: linear-gradient(135deg, var(--primary-color) 0%, #a78bfa 100%); color: white; padding: 3rem 2rem;">
        <div class="container">
            <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Tentang Ensiklopedia Sastra Indonesia</h1>
            <p style="font-size: 1.2rem; opacity: 0.9;">Prakata dan Deskripsi Ensiklopedia Sastra Indonesia</p>
        </div>
    </div>

    <!-- Content -->
    <div class="container" style="margin-top: 3rem; margin-bottom: 3rem;">
        <div class="row">
            <div class="col-lg-3 d-none d-lg-block">
                <!-- Sidebar -->
                <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: sticky; top: 20px;">
                    <h5 style="color: var(--primary-color); margin-bottom: 1.5rem;">Daftar Isi</h5>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 1rem;">
                            <a href="#pengertian" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">
                                <i class="fas fa-angle-right"></i> Pengertian
                            </a>
                        </li>
                        <li style="margin-bottom: 1rem;">
                            <a href="#tujuan" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">
                                <i class="fas fa-angle-right"></i> Tujuan & Manfaat
                            </a>
                        </li>
                        <li style="margin-bottom: 1rem;">
                            <a href="#ruang-lingkup" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">
                                <i class="fas fa-angle-right"></i> Ruang Lingkup
                            </a>
                        </li>
                        <li style="margin-bottom: 1rem;">
                            <a href="#sejarah" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">
                                <i class="fas fa-angle-right"></i> Sejarah
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-9">
                <!-- Main Content -->
                <article style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); line-height: 1.8;">
                    <h2 id="pengertian" style="color: var(--primary-color); margin-top: 0; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #f0f0f0;">
                        Pengertian
                    </h2>
                    <p>
                        Ensiklopedia Sastra Indonesia adalah sebuah platform komprehensif yang menyediakan informasi lengkap dan terpercaya tentang sastra Indonesia. Ensiklopedia ini mencakup berbagai aspek sastra dari pengarang terkenal, karya-karya monumental, media penyebar, hingga perkembangan gejala sastra Indonesia.
                    </p>
                    <p>
                        Dalam perkembangannya, sastra Indonesia telah memainkan peran penting dalam membentuk identitas budaya bangsa. Melalui karya-karya mereka, para sastrawan Indonesia telah mengekspresikan semangat nasionalisme, mengangkat isu-isu sosial, dan menciptakan warisan budaya yang tak ternilai harganya.
                    </p>

                    <h2 id="tujuan" style="color: var(--primary-color); margin-top: 3rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #f0f0f0;">
                        Tujuan & Manfaat
                    </h2>
                    <p>
                        Tujuan utama dari Ensiklopedia Sastra Indonesia adalah:
                    </p>
                    <ul style="margin-left: 1.5rem;">
                        <li style="margin-bottom: 0.8rem;">Menyediakan sumber referensi komprehensif tentang sastra Indonesia</li>
                        <li style="margin-bottom: 0.8rem;">Memperkenalkan karya-karya sastrawan Indonesia kepada masyarakat luas</li>
                        <li style="margin-bottom: 0.8rem;">Melestarikan warisan budaya sastra Indonesia</li>
                        <li style="margin-bottom: 0.8rem;">Mendukung penelitian dan pendidikan di bidang sastra</li>
                        <li style="margin-bottom: 0.8rem;">Meningkatkan apresiasi masyarakat terhadap sastra nasional</li>
                    </ul>

                    <h2 id="ruang-lingkup" style="color: var(--primary-color); margin-top: 3rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #f0f0f0;">
                        Ruang Lingkup
                    </h2>
                    <p>
                        Ensiklopedia Sastra Indonesia mencakup informasi tentang:
                    </p>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin: 1.5rem 0;">
                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; border-left: 4px solid var(--primary-color);">
                            <h5 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                                <i class="fas fa-user-tie"></i> Pengarang
                            </h5>
                            <p style="margin: 0; font-size: 0.9rem; color: #666;">Biografi dan karya para pengarang ternama</p>
                        </div>
                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; border-left: 4px solid var(--primary-color);">
                            <h5 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                                <i class="fas fa-book"></i> Karya Sastra
                            </h5>
                            <p style="margin: 0; font-size: 0.9rem; color: #666;">Novel, puisi, cerpen, dan drama Indonesia</p>
                        </div>
                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; border-left: 4px solid var(--primary-color);">
                            <h5 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                                <i class="fas fa-newspaper"></i> Media Penyebar
                            </h5>
                            <p style="margin: 0; font-size: 0.9rem; color: #666;">Penerbit dan majalah sastra Indonesia</p>
                        </div>
                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; border-left: 4px solid var(--primary-color);">
                            <h5 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                                <i class="fas fa-trophy"></i> Penghargaan
                            </h5>
                            <p style="margin: 0; font-size: 0.9rem; color: #666;">Hadiah dan sayembara sastra Indonesia</p>
                        </div>
                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; border-left: 4px solid var(--primary-color);">
                            <h5 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                                <i class="fas fa-building"></i> Lembaga Sastra
                            </h5>
                            <p style="margin: 0; font-size: 0.9rem; color: #666;">Organisasi dan institusi sastra Indonesia</p>
                        </div>
                        <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; border-left: 4px solid var(--primary-color);">
                            <h5 style="color: var(--primary-color); margin-bottom: 0.5rem;">
                                <i class="fas fa-lightbulb"></i> Gejala Sastra
                            </h5>
                            <p style="margin: 0; font-size: 0.9rem; color: #666;">Tren dan fenomena dalam sastra Indonesia</p>
                        </div>
                    </div>

                    <h2 id="sejarah" style="color: var(--primary-color); margin-top: 3rem; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 2px solid #f0f0f0;">
                        Sejarah Sastra Indonesia
                    </h2>
                    <p>
                        Sastra Indonesia memiliki sejarah yang kaya dan kompleks. Perkembangannya dimulai sejak abad ke-19 dengan munculnya karya-karya berpengaruh yang mencerminkan perjuangan bangsa. Periode awal sastra Indonesia ditandai dengan dominasi tema-tema nasionalisme dan perlawanan terhadap kolonialisme.
                    </p>
                    <p>
                        Pasca kemerdekaan, sastra Indonesia mengalami perkembangan pesat dengan bermunculnya berbagai aliran dan gaya penulisan baru. Para sastrawan mulai mengeksplorasi tema-tema yang lebih beragam, dari kehidupan sosial hingga isu-isu filosofis yang mendalam. Hal ini mencerminkan kematangan dan kedalaman pemikiran sastrawan Indonesia dalam merespons perubahan zaman.
                    </p>
                    <p>
                        Pada era modern, sastra Indonesia terus berkembang dengan adaptasi terhadap teknologi dan perubahan media. Meskipun menghadapi tantangan globalisasi, sastra Indonesia tetap mempertahankan identitasnya dan terus menghasilkan karya-karya berkualitas yang diakui secara internasional.
                    </p>
                </article>
            </div>
        </div>
    </div>
@endsection
