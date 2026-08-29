<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Masjid Al-Ikhlas Desa Karangmmulya</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets-landing/img/favicon.png" rel="icon">
  <link href="assets-landing/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets-landing/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets-landing/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets-landing/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets-landing/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets-landing/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets-landing/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets-landing/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="ri-map-pin-fill "><a href="mailto:contact@example.com">Desa Karangmulya, Tegal, Jawa Tengah 52182</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 5589 55488 55</span></i>

        </div>
        <div class="contact-info d-md-flex align-items-center">
            <i class="bi bi-calendar d-flex align-items-center ms-4"><span>Hari ini: {{ $tanggal }}</span></i>
        </div>

      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center me-auto">
          <!-- Uncomment the line below if you also wish to use an image logo -->
         <!--<img src="assets-landing/img/logo.png" alt="">-->
          <h1 class="sitename">Masjid Al-Ikhlas</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>

            <li><a href="#beranda" class="active">Beranda<br></a></li>
            <li><a href="#about">Profil Masjid</a></li>
            <li><a href="#kegiatan">Kegiatan</a></li>
            <li><a href="#keuangan">Keuangan Masjid</a></li>
            <li><a href="#galeri">Galeri</a></li>
            <li><a href="#kontak">Kontak Kami</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="cta-btn d-none d-sm-block" href="{{ route('login') }}">Login</a>

      </div>

    </div>

  </header>

  <main class="main">

    <!-- hero Section -->
    <section id="beranda" class="hero section light-background">

      <img src="assets-landing/img/hero-bg.jpg" alt="" data-aos="fade-in">

      <div class="container position-relative">

        <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
          <h2>Selamat datang di Masjid Al-Ikhlas Karangmulya</h2>
          <!--<p>We are team of talented designers making websites with Bootstrap</p>-->
        </div><!-- End Welcome -->

        <div class="content row gy-4 ">
            <div class="col-lg-4 d-flex justify-content-center">
                <div class="why-box" data-aos="zoom-out" data-aos-delay="200" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <h3>Why Choose Medilab?</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit
                        Asperiores dolores sed et. Tenetur quia eos. Autem tempore quibusdam vel necessitatibus optio ad corporis.
                    </p>
                    <div class="text-center">
                        <a href="#about" class="more-btn"><span>Learn More</span> <i class="bi bi-chevron-right"></i></a>
                    </div>
                </div>
            </div><!-- End Why Box -->
        </div><!-- End Content-->


      </div>

    </section><!-- /hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4 gx-5">

          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
            <img src="assets-landing/img/about.jpg" class="img-fluid" alt="">
            <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a>
          </div>

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <h3>About Us</h3>
            <p>
              Dolor iure expedita id fuga asperiores qui sunt consequatur minima. Quidem voluptas deleniti. Sit quia molestiae quia quas qui magnam itaque veritatis dolores. Corrupti totam ut eius incidunt reiciendis veritatis asperiores placeat.
            </p>
            <ul>
              <li>
                <i class="fa-solid fa-vial-circle-check"></i>
                <div>
                  <h5>Ullamco laboris nisi ut aliquip consequat</h5>
                  <p>Magni facilis facilis repellendus cum excepturi quaerat praesentium libre trade</p>
                </div>
              </li>
              <li>
                <i class="fa-solid fa-pump-medical"></i>
                <div>
                  <h5>Magnam soluta odio exercitationem reprehenderi</h5>
                  <p>Quo totam dolorum at pariatur aut distinctio dolorum laudantium illo direna pasata redi</p>
                </div>
              </li>
              <li>
                <i class="fa-solid fa-heart-circle-xmark"></i>
                <div>
                  <h5>Voluptatem et qui exercitationem</h5>
                  <p>Et velit et eos maiores est tempora et quos dolorem autem tempora incidunt maxime veniam</p>
                </div>
              </li>
            </ul>
          </div>

        </div>

      </div>

    </section><!-- /About Section -->



     <!-- Services Section -->
     <section id="kegiatan" class="services section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Services</h2>
          <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <div class="container">

          <div class="row gy-4">

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="service-item  position-relative">
                <div class="icon">
                  <i class="fas fa-heartbeat"></i>
                </div>
                <a href="#" class="stretched-link">
                  <h3>Nesciunt Mete</h3>
                </a>
                <p>Provident nihil minus qui consequatur non omnis maiores. Eos accusantium minus dolores iure perferendis tempore et consequatur.</p>
              </div>
            </div><!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="fas fa-pills"></i>
                </div>
                <a href="#" class="stretched-link">
                  <h3>Eosle Commodi</h3>
                </a>
                <p>Ut autem aut autem non a. Sint sint sit facilis nam iusto sint. Libero corrupti neque eum hic non ut nesciunt dolorem.</p>
              </div>
            </div><!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="fas fa-hospital-user"></i>
                </div>
                <a href="#" class="stretched-link">
                  <h3>Ledo Markt</h3>
                </a>
                <p>Ut excepturi voluptatem nisi sed. Quidem fuga consequatur. Minus ea aut. Vel qui id voluptas adipisci eos earum corrupti.</p>
              </div>
            </div><!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="fas fa-dna"></i>
                </div>
                <a href="#" class="stretched-link">
                  <h3>Asperiores Commodit</h3>
                </a>
                <p>Non et temporibus minus omnis sed dolor esse consequatur. Cupiditate sed error ea fuga sit provident adipisci neque.</p>
                <a href="#" class="stretched-link"></a>
              </div>
            </div><!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="fas fa-wheelchair"></i>
                </div>
                <a href="#" class="stretched-link">
                  <h3>Velit Doloremque</h3>
                </a>
                <p>Cumque et suscipit saepe. Est maiores autem enim facilis ut aut ipsam corporis aut. Sed animi at autem alias eius labore.</p>
                <a href="#" class="stretched-link"></a>
              </div>
            </div><!-- End Service Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
              <div class="service-item position-relative">
                <div class="icon">
                  <i class="fas fa-notes-medical"></i>
                </div>
                <a href="#" class="stretched-link">
                  <h3>Dolori Architecto</h3>
                </a>
                <p>Hic molestias ea quibusdam eos. Fugiat enim doloremque aut neque non et debitis iure. Corrupti recusandae ducimus enim.</p>
                <a href="#" class="stretched-link"></a>
              </div>
            </div><!-- End Service Item -->

          </div>

        </div>

      </section><!-- /Services Section -->


    <!-- Stats Section -->


    <!-- Departments Section -->
    <section id="keuangan" class="departments section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Keuangan Masjid Al-Ikhlas</h2>
          <p>Rincian Keuangan Masjid AL-Ikhlas Dukuh Semendot Periode 2023/2024</p>
        </div><!-- End Section Title -->

        <!-- Stats Section -->
        <section id="stats" class="stats section light-background">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4 justify-content-center">

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        <i class="bi bi-cash-stack"></i>
                        <div class="stats-item">
                            <h5>Total Pemasukan</h5>
                            <span>Rp{{ number_format($totalPemasukan, 0, ',', '.') }}.-</span>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        <i class="bi bi-cash-stack"></i>
                        <div class="stats-item">
                            <h5>Total Pengeluaran</h5>
                            <span>Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}.-</span>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        <i class="bi bi-cash-stack"></i>
                        <div class="stats-item">
                            <h5>Total Saldo Saat Ini</h5>
                            <span>Rp{{ number_format($totalSaldo, 0, ',', '.') }}.-</span>
                        </div>
                    </div><!-- End Stats Item -->
                </div>

            </div>

        </section><!-- /Stats Section -->


        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <br>
            <br>
            <br>
          <div class="card">
              <div class="card-body">
                  <br>
                  @if($keuangan->isEmpty())
                      <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show" role="alert">
                              <h5 class="text-center">Tidak ada data keuangan yang dicari.</h5>
                      </div>
                  @else
                  <div class="table-responsive">
                    <h5> Data Keuangan : data terbaru 5 teratas berdasarkan tanggal</h5>
                      <table class="table table-bordered">
                          <thead class="sticky-top bg-white">
                              <tr>
                                  <th style="text-align: center;">No</th>
                                  <th style="text-align: center;">Tanggal</th>
                                  <th style="text-align: center;">Sumber Keuangan</th>
                                  <th style="text-align: center;">Keterangan</th>

                                  <th style="text-align: center;">Nama Donatur</th>
                                  <th style="text-align: center;">Nama Kegiatan</th>
                                  <th style="text-align: center;">Pemasukan</th>
                                  <th style="text-align: center;">Pengeluaran</th>

                              </tr>
                          </thead>
                          <tbody>
                              @php
                                  $totalPemasukan = 0;
                                  $totalPengeluaran = 0;
                                  $saldoAkhir = 0;
                              @endphp
                              @foreach($keuangan as $item)
                              <tr>
                                  <td>{{ $loop->iteration }}</td>
                                  <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                  <td>{{ $item->sumber_keuangan }}</td>
                                  <td>{{ $item->keterangan }}</td>

                                  <td>{{ $item->donatur_id_donatur ? $item->donatur->nama_donatur : '-' }}</td>
                                  <td>{{ $item->kegiatan_id_kegiatan ? $item->kegiatan->nama_kegiatan : '-' }}</td>
                                  <td>Rp{{ number_format($item->kategori_id_kategori === 'D' ? $item->nominal : 0, 0, ',', '.') }}</td>
                                  <td>Rp{{ number_format($item->kategori_id_kategori === 'K' ? $item->nominal : 0, 0, ',', '.') }}</td>



                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>

                  @endif
              </div>
          </div>



        </div>

      </section><!-- /Departments Section -->


    <!-- Gallery Section -->
    <section id="galeri" class="gallery section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
          <h2>Galeri Kegiatan Masjid Al-Ikhlas</h2>
          <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

          <div class="row g-0">

            @foreach($galeri as $item)
            <div class="col-lg-3 col-md-4">
              <div class="gallery-item">
                <a href="{{ asset('storage/' . $item->gambar) }}" class="glightbox" data-gallery="images-gallery">
                    <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" alt="Gambar" style="height: 200px; object-fit: cover;">
                </a>
              </div>
            </div><!-- End Gallery Item -->
            @endforeach

          </div>

        </div>

    </section><!-- /Gallery Section -->

    <!-- Appointment Section -->
    <section id="appointment" class="appointment section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Appointment</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <form action="forms/appointment.php" method="post" role="form" class="php-email-form">
          <div class="row">
            <div class="col-md-4 form-group">
              <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required="">
            </div>
            <div class="col-md-4 form-group mt-3 mt-md-0">
              <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required="">
            </div>
            <div class="col-md-4 form-group mt-3 mt-md-0">
              <input type="tel" class="form-control" name="phone" id="phone" placeholder="Your Phone" required="">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 form-group mt-3">
              <input type="datetime-local" name="date" class="form-control datepicker" id="date" placeholder="Appointment Date" required="">
            </div>
            <div class="col-md-4 form-group mt-3">
              <select name="department" id="department" class="form-select" required="">
                <option value="">Select Department</option>
                <option value="Department 1">Department 1</option>
                <option value="Department 2">Department 2</option>
                <option value="Department 3">Department 3</option>
              </select>
            </div>
            <div class="col-md-4 form-group mt-3">
              <select name="doctor" id="doctor" class="form-select" required="">
                <option value="">Select Doctor</option>
                <option value="Doctor 1">Doctor 1</option>
                <option value="Doctor 2">Doctor 2</option>
                <option value="Doctor 3">Doctor 3</option>
              </select>
            </div>
          </div>

          <div class="form-group mt-3">
            <textarea class="form-control" name="message" rows="5" placeholder="Message (Optional)"></textarea>
          </div>
          <div class="mt-3">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your appointment request has been sent successfully. Thank you!</div>
            <div class="text-center"><button type="submit">Make an Appointment</button></div>
          </div>
        </form>

      </div>

    </section><!-- /Appointment Section -->

    <!-- Contact Section -->
    <section id="kontak" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
        <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3032.4361612730095!2d109.23886407356817!3d-6.922493993077196!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fc7acd5292c5f%3A0xb89abf11b3f0d3d0!2sMasjid%20Al%20Ikhlas%20Dk%20Simendot!5e1!3m2!1sen!2sid!4v1776051556955!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div><!-- End Google Maps -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-4">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Lokasi</h3>
                <p>Karangmulya, Kec. Suradadi, Kabupaten Tegal, Jawa Tengah 52182</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Call Us</h3>
                <p>+1 5589 55488 55</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email Us</h3>
                <p>info@example.com</p>
              </div>
            </div><!-- End Info Item -->

          </div>

          <div class="col-lg-8">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer light-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">Medilab</span>
          </a>
          <div class="footer-contact pt-3">
            <p>A108 Adam Street</p>
            <p>New York, NY 535022</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
            <p><strong>Email:</strong> <span>info@example.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">Marketing</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Hic solutasetp</h4>
          <ul>
            <li><a href="#">Molestiae accusamus iure</a></li>
            <li><a href="#">Excepturi dignissimos</a></li>
            <li><a href="#">Suscipit distinctio</a></li>
            <li><a href="#">Dilecta</a></li>
            <li><a href="#">Sit quas consectetur</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Nobis illum</h4>
          <ul>
            <li><a href="#">Ipsam</a></li>
            <li><a href="#">Laudantium dolorum</a></li>
            <li><a href="#">Dinera</a></li>
            <li><a href="#">Trodelas</a></li>
            <li><a href="#">Flexo</a></li>
          </ul>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Medilab</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed by <a href=“https://themewagon.com>ThemeWagon
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets-landing/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets-landing/vendor/php-email-form/validate.js"></script>
  <script src="assets-landing/vendor/aos/aos.js"></script>
  <script src="assets-landing/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets-landing/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets-landing/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets-landing/js/main.js"></script>

</body>

</html>
