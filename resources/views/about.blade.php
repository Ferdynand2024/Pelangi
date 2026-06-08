<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>About - Pelelangan Ikan Banyuwangi</title>
    <meta name="description" content="Tentang Pusat Pelelangan Ikan Banyuwangi (PELANGI) - Kerjasama dengan TPI Muncar dan Dinas Perikanan">
    <meta name="keywords" content="pelelangan ikan, Banyuwangi, TPI, Muncar, Dinas Perikanan, hasil laut">
    <!-- Favicons -->
    <link href="assets/img/logo.jpg" rel="icon">
    <link href="assets/img/logo.jpg" rel="apple-touch-icon">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">
</head>
<body class="about-page">
    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
            <a href="{{ route('landingpage') }}" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">Pelangi</h1>
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('landingpage') }}">Home Page</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('faq') }}">Faq</a></li>
                    <li><a href="{{ route('register') }}">Daftar</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </header>

    <main class="main">
        <!-- Page Title -->
        <div class="page-title light-background">
            <div class="container">
                <h1>ABOUT PELANGI</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ route('landingpage') }}">Home</a></li>
                        <li class="current">About</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- About 2 Section -->
        <section id="about-2" class="about-2 section">
            <div class="container">
                <div class="content">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 col-md-5 col-lg-4 col-xl-4 order-lg-2 offset-xl-1 mb-4">
                            <div class="img-wrap text-center text-md-left" data-aos="fade-up" data-aos-delay="100">
                                <div class="img">
                                    <img src="assets/img/laut 5.jpg" alt="Pemandangan laut Banyuwangi" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="offset-md-0 offset-lg-1 col-sm-12 col-md-5 col-lg-5 col-xl-4" data-aos="fade-up">
                            <div class="px-3">
                                <span class="content-subtitle">Misi Kami</span>
                                <h2 class="content-title text-start">
                                    Menghubungkan Nelayan dan Pembeli dengan Teknologi Modern
                                </h2>
                                <p class="lead">
                                    PELANGI (Pelelangan Ikan Banyuwangi) adalah platform digital yang menghubungkan nelayan lokal dengan pembeli secara efisien dan transparan.
                                </p>
                                <p class="mb-5">
                                    Bekerja sama dengan TPI (Tempat Pelelangan Ikan) di Muncar dan Dinas Perikanan Banyuwangi, kami berkomitmen untuk mendukung perekonomian nelayan lokal dan memastikan keberlanjutan hasil laut Banyuwangi.
                                </p>
                                <p>
                                    <a href="{{ route('register') }}" class="btn-get-started">Bergabung Sekarang</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /About 2 Section -->

        <!-- Services Section -->
        <section id="services" class="services section light-background">
            <div class="container">
                <div class="row gy-4 justify-content-center">
                    <div class="col-lg-3">
                        <div class="services-item" data-aos="fade-up">
                            <div class="services-icon">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <div>
                                <h3>Kesegaran Terjamin</h3>
                                <p>Ikan langsung dari nelayan ke pembeli, memastikan kualitas dan kesegaran terbaik untuk setiap produk</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="services-item" data-aos="fade-up" data-aos-delay="100">
                            <div class="services-icon">
                                <i class="bi bi-currency-exchange"></i>
                            </div>
                            <div>
                                <h3>Transaksi Transparan</h3>
                                <p>Sistem lelang yang adil dan terbuka untuk nelayan dan pembeli dengan harga yang kompetitif</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="services-item" data-aos="fade-up" data-aos-delay="200">
                            <div class="services-icon">
                                <i class="bi bi-globe"></i>
                            </div>
                            <div>
                                <h3>Keberlanjutan</h3>
                                <p>Mendukung praktik penangkapan ikan yang bertanggung jawab untuk kelestarian sumber daya laut</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Services Section -->

        <!-- Kerjasama Section -->
        <section id="stats" class="stats section">
            <div class="container">
                <div class="row gy-4 justify-content-center">
                    <div class="col-lg-5">
                        <div class="images-overlap">
                            <img src="assets/img/laut 4.jpg" alt="Kegiatan di TPI Muncar" class="img-fluid img-1" data-aos="fade-up">
                        </div>
                    </div>
                    <div class="col-lg-4 ps-lg-5">
                        <span class="content-subtitle">Kerjasama</span>
                        <h2 class="content-title">Kolaborasi untuk Memperkuat Ekonomi Maritim</h2>
                        <p class="lead">
                            PELANGI adalah hasil kerjasama antara TPI Muncar dan Dinas Perikanan Kabupaten Banyuwangi.
                        </p>
                        <p class="mb-5">
                            Dengan menggabungkan pengalaman TPI dalam pengelolaan lelang tradisional dan pengawasan Dinas Perikanan, kami menghadirkan solusi digital yang memenuhi kebutuhan pasar modern sekaligus menjaga nilai-nilai tradisional.
                        </p>
                        <div class="row mb-5 count-numbers">
                            <!-- Start Stats Item -->
                            <div class="col-4 counter" data-aos="fade-up" data-aos-delay="100">
                                <span data-purecounter-separator="true" data-purecounter-start="0" data-purecounter-end="500" data-purecounter-duration="1" class="purecounter number"></span>
                                <span class="d-block">Nelayan</span>
                            </div>
                            <!-- End Stats Item -->

                            <!-- Start Stats Item -->
                            <div class="col-4 counter" data-aos="fade-up" data-aos-delay="200">
                                <span data-purecounter-separator="true" data-purecounter-start="0" data-purecounter-end="300" data-purecounter-duration="1" class="purecounter number"></span>
                                <span class="d-block">Pembeli</span>
                            </div>
                            <!-- End Stats Item -->
                            <!-- Start Stats Item -->
                            <div class="col-4 counter" data-aos="fade-up" data-aos-delay="300">
                                <span data-purecounter-separator="true" data-purecounter-start="0" data-purecounter-end="1000" data-purecounter-duration="1" class="purecounter number"></span>
                                <span class="d-block">Transaksi</span>
                            </div>
                            <!-- End Stats Item -->
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Kerjasama Section -->

        <!-- Program Section -->
        <section id="programs" class="about-2 section light-background">
            <div class="container">
                <!-- Section Title -->
                <div class="container section-title" data-aos="fade-up">
                    <h2>Program Keberlanjutan</h2>
                </div><!-- End Section Title -->
                <div class="content">
                    <div class="row justify-content-center">
                        <div class="col-lg-8" data-aos="fade-up">
                            <div class="px-3">
                                <p class="lead">
                                    PELANGI berkomitmen untuk mendukung praktik perikanan yang berkelanjutan melalui berbagai program:
                                </p>
                                <ul class="feature-list">
                                    <li><strong>Sertifikasi Produk</strong> - Kerjasama dengan lembaga sertifikasi untuk menjamin kualitas dan keberlanjutan</li>
                                    <li><strong>Pengurangan Limbah</strong> - Inisiatif untuk mengurangi limbah plastik dalam proses pelelangan dan distribusi</li>
                                    <p class="mt-4">
                                        Dengan menggabungkan teknologi modern dan nilai-nilai keberlanjutan, PELANGI bertujuan menciptakan ekosistem perikanan yang menguntungkan bagi semua pihak dan berkelanjutan untuk generasi mendatang.
                                    </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Program Section -->
    </main>

    <footer id="footer" class="footer light-background">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3 mb-3 mb-md-0">
                    <div class="widget">
                        <h3 class="widget-heading">Tentang Kami</h3>
                        <p class="mb-4">
                            PELANGI adalah platform digital untuk pelelangan ikan di Banyuwangi yang menghubungkan nelayan dengan pembeli melalui kerjasama dengan TPI Muncar dan Dinas Perikanan.
                        </p>
                        <p class="mb-0">
                            <a href="{{ route('about') }}" class="btn-learn-more">Selengkapnya</a>
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 ps-lg-5 mb-3 mb-md-0">
                    <div class="widget">
                        <h3 class="widget-heading">Navigasi</h3>
                        <ul class="list-unstyled float-start me-5">
                            <li><a href="{{ route('landingpage') }}">Home</a></li>
                            <li><a href="{{ route('about') }}">Tentang Kami</a></li>
                            <li><a href="">Daftar Lelang</a></li>
                        </ul>
                        <ul class="list-unstyled float-start">
                            <li><a href="{{ route('contact') }}">Kontak</a></li>
                            <li><a href="{{ route('register') }}">Daftar</a></li>
                            <li><a href="{{ route('login') }}">Login</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 pl-lg-5">
                    <div class="widget">
                        <h3 class="widget-heading">Connect</h3>
                        <ul class="list-unstyled social-icons light mb-3">
                            <li>
                                <a href="#"><span class="bi bi-facebook"></span></a>
                            </li>
                            <li>
                                <a href="#"><span class="bi bi-twitter-x"></span></a>
                            </li>
                            <li>
                                <a href="#"><span class="bi bi-instagram"></span></a>
                            </li>
                            <li>
                                <a href="#"><span class="bi bi-whatsapp"></span></a>
                            </li>
                            <li>
                                <a href="#"><span class="bi bi-youtube"></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 pl-lg-5">
                    <div class="widget">
                        <div class="footer-subscribe">
                            <h3 class="widget-heading">Berlangganan</h3>
                            <form action="forms/newsletter.php" method="post" class="php-email-form">
                                <div class="mb-2">
                                    <input type="text" class="form-control" name="email" placeholder="Masukkan email Anda">
                                    <button type="submit" class="btn btn-link">
                                        <span class="bi bi-arrow-right"></span>
                                    </button>
                                </div>
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">
                                    Permintaan berlangganan Anda telah terkirim. Terima kasih!
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright d-flex flex-column flex-md-row align-items-center justify-content-md-between">
                <p>© <span>Copyright</span> <strong class="px-1 sitename">PELANGI.</strong> <span>All Rights Reserved</span></p>
            </div>
        </div>
    </footer>
    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <!-- Preloader -->
    <div id="preloader"></div>
    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
</body>
</html>
