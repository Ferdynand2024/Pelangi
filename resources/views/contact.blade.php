<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Contact - Pelelangan Ikan Banyuwangi</title>
  <meta name="description" content="Hubungi Pusat Pelelangan Ikan Banyuwangi (PELANGI) - Terhubung dengan tim kami untuk pertanyaan dan dukungan.">
  <meta name="keywords" content="kontak pelangi, hubungi, pelelangan ikan, Banyuwangi, TPI Muncar">
  <link href="assets/img/logo.jpg" rel="icon">
  <link href="assets/img/logo.jpg" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Lato&display=swap" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="contact-page">
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl d-flex justify-content-between align-items-center">
      <a href="{{ route('landingpage') }}" class="logo d-flex align-items-center">
        <h1 class="sitename">Pelangi</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="{{ route('landingpage') }}">Home Page</a></li>
          <li><a href="{{ route('contact') }}" class="active">Contact</a></li>
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
    <div class="page-title light-background">
      <div class="container">
        <h1>Contact Us</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="{{ route('landingpage') }}">Home</a></li>
            <li class="current">Contact</li>
          </ol>
        </nav>
      </div>
    </div>

    <section id="contact" class="contact section">
      <div class="container">
        <div class="row gy-4 justify-content-center">
          <div class="col-lg-5 d-flex flex-column">
            <div class="info-item d-flex align-items-center" data-aos="fade-up">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h4>Lokasi:</h4>
                <p>TPI Muncar, Banyuwangi, Jawa Timur, Indonesia</p>
              </div>
            </div>
            <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="100">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h4>Email:</h4>
                <p>info@pelangi-bwi.id</p>
              </div>
            </div>
            <div class="info-item d-flex align-items-center" data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-phone flex-shrink-0"></i>
              <div>
                <h4>Telepon:</h4>
                <p>+62 812-3456-7890</p>
              </div>
            </div>
          </div>

          <div class="col-lg-7" data-aos="fade-up" data-aos-delay="300">
            <form onsubmit="return showSuccessMessage()" class="php-email-form">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <input type="text" name="name" class="form-control" placeholder="Nama Anda" required>
                </div>
                <div class="col-md-6 mb-3">
                  <input type="email" name="email" class="form-control" placeholder="Email Anda" required>
                </div>
              </div>
              <div class="mb-3">
                <input type="text" name="subject" class="form-control" placeholder="Subjek" required>
              </div>
              <div class="mb-3">
                <textarea name="message" rows="5" class="form-control" placeholder="Pesan Anda" required></textarea>
              </div>
              <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary">Kirim Pesan</button>
              </div>
              <div id="success-message" class="alert alert-success text-center d-none">
                Pesan berhasil dikirim. Terima kasih telah menghubungi kami!
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer sama seperti sebelumnya -->
  <!-- ... (biarkan bagian footer tetap sama sesuai template kamu) ... -->

  <!-- Scroll Top dan JS -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/js/main.js"></script>
  <script>
    function showSuccessMessage() {
      const messageDiv = document.getElementById('success-message');
      messageDiv.classList.remove('d-none');
      messageDiv.scrollIntoView({
        behavior: 'smooth'
      });
      // Reset form input
      document.querySelector('.php-email-form').reset();
      return false; // mencegah form terkirim ke server
    }
  </script>

</body>

</html>