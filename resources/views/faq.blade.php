<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>FAQ- Pelelangan Ikan Banyuwangi</title>
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
                <h1>FAQ PELANGI</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="{{ route('landingpage') }}">Home</a></li>
                        <li class="current">Faq</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <main class="main">

            <!-- Faq Section -->
            <section id="faq" class="faq section">
                <!-- Section Title -->
                <div class="container section-title" data-aos="fade-up">
                    <h2>Pertanyaan yang Sering Diajukan</h2>
                </div><!-- End Section Title -->

                <div class="container" data-aos="fade-up">
                    <div class="row">
                        <div class="col-12">
                            <div class="custom-accordion" id="accordion-faq">




                                <div class="accordion-item">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-1">
                                            Apa itu pelangi ?
                                        </button>
                                    </h2>

                                    <div id="collapse-faq-1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion-faq">
                                        <div class="accordion-body">

                                            PELANGI adalah singkatan dari Pelelangan Ikan Banyuwangi,
                                            sebuah platform online yang menghubungkan nelayan, penjual ikan,
                                            dan pembeli dalam satu sistem pelelangan ikan digital yang terpercaya
                                            di wilayah Banyuwangi.
                                        </div>
                                    </div>
                                </div>
                                <!-- .accordion-item -->

                                <div class="accordion-item">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-2">
                                            Bagaimana cara untuk mengikuti lelang?

                                        </button>
                                    </h2>

                                    <div id="collapse-faq-2" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-faq">
                                        <div class="accordion-body">
                                            Setelah melakukan login maasuk ke menu "lelang" untuk melihat semua
                                            lelang yang sedang berlangsung. pilih lelang yang Anda minati, lihat
                                            detail dan foro ikannya, kemudian masukkan penawaran Anda.
                                        </div>
                                    </div>
                                </div>
                                <!-- .accordion-item -->

                                <div class="accordion-item">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-3">
                                            Apa yang terjadi jika saya telah memenangkan lelang?
                                        </button>
                                    </h2>

                                    <div id="collapse-faq-3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion-faq">
                                        <div class="accordion-body">
                                            Jika anda memenangkan lelang, maka anda akan mendapatkan
                                            notifikasi dengan instruksi pembayaran dan pengambilan ikan.
                                        </div>
                                    </div>
                                </div>
                                <!-- .accordion-item -->


                                <div class="accordion-item">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-4">
                                            Apakah penawaran bisa dibatalkan?
                                        </button>
                                    </h2>

                                    <div id="collapse-faq-4" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-faq">
                                        <div class="accordion-body">
                                            Demi menjaga integritas sistem lelang kami,
                                            penawaran yang sudah diajukan tidak bisa dibatalkan,
                                            jadi pastikan Anda yakin sebelum memasukkan jumlah penawaran.
                                        </div>
                                    </div>
                                </div>
                                <!-- .accordion-item -->

                                <div class="accordion-item">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-5">
                                            Bagaimana cara mendaftar di PELANGI?
                                        </button>
                                    </h2>

                                    <div id="collapse-faq-5" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-faq">
                                        <div class="accordion-body">
                                            Cukup klik tombol "Daftar" di pojok kanan atas halaman utama,
                                            Isi formulir data diri Anda, verifikasi email, dan akun Anda
                                            siap digunakan.
                                        </div>
                                    </div>
                                </div>
                                <!-- .accordion-item -->

                                <div class="accordion-item">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-6">
                                            Jika lupa kata sandi akun, bagaimana cara meresetnya?
                                        </button>
                                    </h2>

                                    <div id="collapse-faq-6" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-faq">
                                        <div class="accordion-body">
                                            Masuk pada halaman login klik "Lupa Password"
                                            lalu masukkan email yang terdaftar dan Anda akan
                                            menerima tautan untuk mengatur ulang kata sandi.
                                            Jika email tidak masuk dalam 5 menit coba periksa pada folder spam.
                                        </div>
                                    </div>
                                </div>
                                <!-- .accordion-item -->

                                <div class="accordion-item">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-7">
                                            Kenapa akun saya belum diverifikasi padahal sudah menunggu beberapa hari?
                                        </button>
                                    </h2>

                                    <div id="collapse-faq-7" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-faq">
                                        <div class="accordion-body">
                                            Proses verifikasi biasanya memakan waktu 1-2 hari kerja.
                                            Jika sudah lebih dari waktu tersebut, kemungkinan ada dokumen yang kurang
                                            jelas atau informasi yang perlu dilengkapi.
                                        </div>
                                    </div>
                                </div>
                                <!-- .accordion-item -->

                                <div class="accordion-item">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-8">
                                            Bagaimana jika saya mengalami masalah teknis saat menggunakan platform?
                                        </button>
                                    </h2>

                                    <div id="collapse-faq-8" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-faq">
                                        <div class="accordion-body">
                                            jika anda mengalami masalah teknis kunjungi halaman
                                            FAQ atau Contact untuk melaporkan masalah anda
                                        </div>
                                    </div>
                                </div>
                                <!-- .accordion-item -->

                                <div class="accordion-item">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-9">
                                            Siapa saja yang bisa menggunakan layanan pelangi?
                                        </button>
                                    </h2>

                                    <div id="collapse-faq-9" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-faq">
                                        <div class="accordion-body">
                                            PELANGI terbuka untuk berbagai pihak, mulai dari nelayan lokal,
                                            pengepul ikan, pedagang pasar, pemilik restoran, hingga masyarakat
                                            umum yang ingin membeli hasil laut segar dengan harga transparan.
                                        </div>
                                    </div>
                                </div>
                                <!-- .accordion-item -->

                                <div class="accordion-item">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-10">
                                            Apakah pelangi sudah tersedia versi aplikasi mobile?
                                        </button>
                                    </h2>

                                    <div id="collapse-faq-10" class="collapse" aria-labelledby="headingThree" data-parent="#accordion-faq">
                                        <div class="accordion-body">
                                            Saat ini pelangi tersedia dalam versi website dan
                                            dapat diakses melalui browser mobile.
                                        </div>
                                    </div>
                                </div>
                                <!-- .accordion-item -->


                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- /Faq Section -->


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
