<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Home Page - Pelelangan Ikan Banyuwangi</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

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

    <!-- =======================================================
  * Template Name: Active
  * Template URL: https://bootstrapmade.com/active-bootstrap-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">Pelangi</h1>
            </a>

            <nav id="navmenu" class="navmenu ">
                <ul>
                    <li><a href="{{ route('landingpage') }}">Home Page</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('faq') }}">FAQ</a></li>
                    <li><a href="{{ route('register') }}">Daftar</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>

    <main class="main">

        <!-- About Section -->
        <section id="about" class="about section">

            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-7 mb-5 mb-lg-0 order-lg-2" data-aos="fade-up" data-aos-delay="400">
                        <div class="swiper init-swiper">
                            <script type="application/json" class="swiper-config">
                                {
                                    "loop": true
                                    , "speed": 600
                                    , "autoplay": {
                                        "delay": 5000
                                    }
                                    , "slidesPerView": "auto"
                                    , "pagination": {
                                        "el": ".swiper-pagination"
                                        , "type": "bullets"
                                        , "clickable": true
                                    }
                                    , "breakpoints": {
                                        "320": {
                                            "slidesPerView": 1
                                            , "spaceBetween": 40
                                        }
                                        , "1200": {
                                            "slidesPerView": 1
                                            , "spaceBetween": 1
                                        }
                                    }
                                }

                            </script>
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="assets/img/laut 4.jpg" alt="Image" class="img-fluid">
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/img/laut 5.jpg" alt="Image" class="img-fluid">
                                </div>
                                <div class="swiper-slide">
                                    <img src="assets/img/laut 6.jpg" alt="Image" class="img-fluid">
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 order-lg-1">
                        <span class="section-subtitle" data-aos="fade-up">Selamat datang di Pelangi</span>
                        <h1 class="mb-4" data-aos="fade-up">
                            Pusat Pelelangan ikan Banyuwangi
                        </h1>
                        <p data-aos="fade-up">

                            Pusat pelelangan ikan Banyuwangi, gerbang utama menuju
                            kelimpahan hasil laut dari perairan Banyuwangi yang kaya, tempat transaksi cepat
                            dan transparan mempertemukan nelayan dan pembeli, menghadirkan ikan segar berkualitas
                            tinggi dengan harga bersaing, langsung dari nelayan terpercaya, baik secara langsung
                            maupun melalui platform digital yang efisien, untuk memperkuat ekonomi lokal dan
                            mendukung keberlanjutan perikanan.
                        </p>
                        <p class="mt-5" data-aos="fade-up">
                            <a href="{{ route('register') }}" class="btn btn-get-started">Daftar Sekarang</a>
                        </p>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->



        <!-- Blog Posts Section -->
        <section id="blog-posts" class="blog-posts section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Produk</h2>
            </div><!-- End Section Title -->
            <div class="container">

                <div class="row gy-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="post-entry" data-aos="fade-up" data-aos-delay="100">
                            <a href="#" class="thumb d-block"><img src="assets/img/ikan 1.jpg" alt="Image" class="img-fluid rounded"></a>

                            <div class="post-content">
                                <h3><a href="#">Tuna </a></h3>
                                <p>
                                    Tuna adalah ikan laut pelagis yang termasuk dalam famili Scombridae, khususnya genus Thunnus
                                    Ikan ini dikenal sebagai perenang yang tangguh dengan kecepatan luar biasa, bahkan tercatat
                                    mampu mencapai kecepatan 77 km/jam.
                                </p>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="post-entry" data-aos="fade-up" data-aos-delay="200">
                            <a href="#" class="thumb d-block"><img src="assets/img/ikan 2.jpg" alt="Image" class="img-fluid rounded"></a>

                            <div class="post-content">
                                <h3><a href="#">Kakap</a></h3>
                                <p>
                                    Ikan kakap adalah kelompok ikan laut yang termasuk dalam famili Lutjanidae.
                                    Ikan ini dikenal dengan dagingnya yang lezat dan nilai ekonomis yang tinggi.
                                </p>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="post-entry" data-aos="fade-up" data-aos-delay="300">
                            <a href="#" class="thumb d-block"><img src="assets/img/ikan 3.jpg" alt="Image" class="img-fluid rounded"></a>

                            <div class="post-content">
                                <h3><a href="#">Kakap Merah</a></h3>
                                <p>
                                    Ikan kakap merah merupakan salah satu jenis ikan kakap yang populer di Indonesia
                                    karena warna merahnya yang khas dan dagingnya yang lezat. Ikan ini memiliki tubuh
                                    berbentuk lonjong, sedikit memanjang, dan melebar, dengan sisik besar dan kasar.

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Blog Posts Section -->



    </main>

    <footer id="footer" class="footer light-background">
        <div class="container">
            <div class="row g-4">
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
                                <a href="#"><span class="bi bi-linkedin"></span></a>
                            </li>
                            <li>
                                <a href="#"><span class="bi bi-google"></span></a>
                            </li>
                            <li>
                                <a href="#"><span class="bi bi-google-play"></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
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
