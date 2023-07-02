<head>
    <meta charset="utf-8">
    <title>Home - SIMKMM | Sistem Informasi Kegiatan Magang Mahasiswa D3 Teknik Informatika UNS</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="assets/images/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">  

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-xxl position-relative p-0">
            <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <h1 class="m-0"><i class="fa fa-graduation-cap me-3"></i>SIMKMM</h1>
                    <!-- <img src="images/logo.png" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="{{ url('/') }}" class="nav-item nav-link active">Home</a>
                        <a href="{{ url('/tentang') }}" class="nav-item nav-link">Tentang</a>
                        <a href="{{ url('/berita') }}" class="nav-item nav-link">Berita</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Dokumen</a>
                            <div class="dropdown-menu m-0">
                                @foreach($d as $doc)
                                <a href="{{ url('/documents/'.$doc->dokumen) }}" class="dropdown-item">{{ $doc->judul }}</a>
                                @endforeach
                            </div>
                        </div>
                        <a href="{{ url('/kontak') }}" class="nav-item nav-link">Hubungi Kami</a>
                    </div>
                    <a href="{{ url('/auth') }}" class="btn btn-secondary py-2 px-4 ms-3">Login</a>
                </div>
            </nav>

            <div class="container-xxl py-5 bg-primary hero-header mb-5">
                <div class="container my-5 py-5 px-lg-5">
                    <div class="row g-5">
                        <div class="col-lg-6 pt-5 text-center text-lg-start">
                            <h1 class="display-4 text-white mb-4 animated slideInLeft">SISTEM INFORMASI KEGIATAN MAGANG MAHASISWA</h1>
                            <p class="text-white animated slideInLeft">D3 TEKNIK INFORMATIKA UNIVERSITAS SEBELAS MARET</p>
                            <a href="{{ url('/auth?register=true') }}" class="btn btn-secondary py-sm-3 px-sm-5 me-3 animated slideInLeft">Register</a>
                        </div>
                        <div class="col-lg-6 text-center text-lg-start">
                            <img class="img-fluid animated zoomIn" src="assets/images/hero.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- Full Screen Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content" style="background: rgba(29, 40, 51, 0.8);">
                    <div class="modal-header border-0">
                        <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center justify-content-center">
                        <div class="input-group" style="max-width: 600px;">
                            <input type="text" class="form-control bg-transparent border-light p-3" placeholder="Type search keyword">
                            <button class="btn btn-light px-4"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Full Screen Search End -->


        <!-- About Start -->
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="section-title position-relative mb-4 pb-4">
                            <h1 class="mb-2">KEGIATAN MAGANG MAHASISWA</h1>
                        </div>
                        <p class="mb-4">Kegiatan Magang Mahasiswa (KMM) merupakan kegiatan yang wajib ditempuh oleh setiap mahasiswa D3 Teknik Informatika UNS sebagai salah satu syarat kelulusan. KMM merupakan suatu mata kuliah yang melibatkan instansi di dalam dan di luar kampus. Di mata kuliah tersebut mahasiswa harus mengimplementasikan ilmu yang telah didapat di bangku kuliah ke dalam dunia kerja nyata dan harus dilakukan disuatu instansi. Kegiatan KMM menghasikan Laporan KMM dapat berbentuk produk dari rekayasa dalam bidang teknologi informasi. Bobot mata kuliah KMM adalah 6 SKS
                        </p>
                        <div class="row g-3">
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.1s">
                                <div class="bg-light rounded text-center p-4">
                                    <i class="fa fa-users-cog fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">{{ $mahasiswa_count }}</h2>
                                    <p class="mb-0">Mahasiswa</p>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.3s">
                                <div class="bg-light rounded text-center p-4">
                                    <i class="fa fa-users fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">{{ $instansi_count }}</h2>
                                    <p class="mb-0">Instansi</p>
                                </div>
                            </div>
                            <div class="col-sm-4 wow fadeIn" data-wow-delay="0.5s">
                                <div class="bg-light rounded text-center p-4">
                                    <i class="fa fa-check fa-2x text-primary mb-2"></i>
                                    <h2 class="mb-1" data-toggle="counter-up">{{ $magang_count }}</h2>
                                    <p class="mb-0">Magang</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="assets/images/about.png">
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Pricing Start -->
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">INSTANSI TEMPAT MAGANG</h1>
                </div>
                <div class="row gy-5 gx-4">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="position-relative shadow rounded border-top border-5 border-primary">
                            <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-50 translate-middle bg-primary rounded-circle" style="width: 45px; height: 45px; margin-top: -3px;">
                                <i class="fa fa-share-alt text-white"></i>
                            </div>
                            <div class="text-center border-bottom p-4 pt-5">
                                <p class="mb-0">Instansi berbadan hukum</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="position-relative shadow rounded border-top border-5 border-secondary">
                            <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-50 translate-middle bg-secondary rounded-circle" style="width: 45px; height: 45px; margin-top: -3px;">
                                <i class="fa fa-server text-white"></i>
                            </div>
                            <div class="text-center border-bottom p-4 pt-5">
                                <p class="mb-0">Mempunyai telepon yang dapat dihubungi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="position-relative shadow rounded border-top border-5 border-primary">
                            <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-50 translate-middle bg-primary rounded-circle" style="width: 45px; height: 45px; margin-top: -3px;">
                                <i class="fa fa-cog text-white"></i>
                            </div>
                            <div class="text-center border-bottom p-4 pt-5">
                                <p class="mb-0">Mempunyai web yang dapat diakses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pricing End -->


        <!-- Comparison Start -->
        <div class="container-xxl py-5">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <h1 class="mb-3">PRODUK YANG DIHASILKAN</h1>
                </div>
                <div class="row g-5 comparison position-relative">
                    <div class="col-lg-6 pe-lg-5">
                        <div class="row gy-3 gx-5">
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                <i class="fa fa-server fa-3x text-primary mb-3"></i>
                                <h5 class="fw-bold">Jaringan Komputer dan Automata</h5>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <i class="fa fa-shield-alt fa-3x text-primary mb-3"></i>
                                <h5 class="fw-bold">Sistem Informasi dan Manajemen Basis Data</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 ps-lg-5">
                        <div class="row gy-3 gx-5">
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                <i class="fa fa-server fa-3x text-secondary mb-3"></i>
                                <h5 class="fw-bold">Multimedia dan Mobile Programming</h5>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <i class="fa fa-shield-alt fa-3x text-secondary mb-3"></i>
                                <h5 class="fw-bold">Multimedia dan Mobile Gaming</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container px-lg-5">
                @if($berita->count() > 1)
                <div class="owl-carousel testimonial-carousel">
                    @foreach($berita as $b)
                    <a href="{{ url('/berita/'.$b->slug) }}" class="text-decoration-none">
                        <div class="testimonial-item position-relative bg-light border-top border-5 border-primary rounded p-4 my-4">
                            <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-0 ms-5 translate-middle bg-primary rounded-circle" style="width: 45px; height: 45px; margin-top: -3px;">
                                <i class="fa fa-quote-left text-white"></i>
                            </div>
                            <p class="mt-3">{!! substr(preg_replace( '/<p\b[^>]*>(.*?)<\/p>/i', '<span>$1</span>', preg_replace('/<img\s[^>]*>/i', '', $berita[0]->deskripsi) ), 0, 100).'...' !!}</p>
                            <div class="d-flex align-items-center">
                                <div class="ps-3">
                                    <h6 class="fw-bold mb-1">{{ $b->judul }}</h6>
                                    <small>{{ $b->tanggal }}</small>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @elseif($berita->count() == 1)
                <a href="{{ url('/berita/'.$berita[0]->slug) }}" class="text-decoration-none">
                    <div class="testimonial-item position-relative bg-light border-top border-5 border-primary rounded p-4 my-4">
                        <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-0 ms-5 translate-middle bg-primary rounded-circle" style="width: 45px; height: 45px; margin-top: -3px;">
                            <i class="fa fa-quote-left text-white"></i>
                        </div>
                        <p class="mt-3">{!! substr(preg_replace( '/<p\b[^>]*>(.*?)<\/p>/i', '<span>$1</span>', preg_replace('/<img\s[^>]*>/i', '', $berita[0]->deskripsi) ), 0, 500).'...' !!}</p>
                        <div class="d-flex align-items-center">
                            <div class="ps-3">
                                <h6 class="fw-bold mb-1">{{ $berita[0]->judul }}</h6>
                                <small>{{ $berita[0]->tanggal }}</small>
                            </div>
                        </div>
                    </div>
                </a>
                @else
                    <div class="testimonial-item position-relative bg-light border-top border-5 border-primary rounded p-4 my-4">
                        <div class="d-flex align-items-center justify-content-center position-absolute top-0 start-0 ms-5 translate-middle bg-primary rounded-circle" style="width: 45px; height: 45px; margin-top: -3px;">
                            <i class="fa fa-quote-left text-white"></i>
                        </div>
                        <p class="mt-3">Tidak ada berita</p>
                    </div>
                @endif
            </div>
        </div>
        <div class="container-fluid bg-primary text-white footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row gy-5 gx-4 pt-5">
                    <div class="col-12">
                    </div>
                    <div class="col-lg-5 col-md-12">
                        <div class="row gy-5 g-4">
                            <div class="col-md-12">
                                <h5 class="fw-bold text-white mb-4">About Us</h5>
                                <p class="mb-2">Program Diploma III Teknik Informatika dengan sumber daya manusia yang cukup, baik kualitas maupun kuantitas dengan sarana dan prasarana yang memadai, siap mendidik calon-calon tenaga profesional menjadi tenaga trampil di bidang teknologi informasi melalui pendidikan profesional 3 tahun.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <h5 class="fw-bold text-white mb-4">Contact Info</h5>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Gedung A, Fakultas Matematika dan Ilmu Pengetahuan Alam. Jl. Ir. Sutami 36 A Surakarta</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>(0271) 663450</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@d3ti.mipa.uns.ac.id</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mt-lg-n5">
                        <div class="bg-light rounded" style="padding: 30px;">
                            <form action="{{ url('/kontak') }}" method="post">
                                @csrf
                                <input type="text" class="form-control border-0 py-2 mb-2" placeholder="Name" name="nama">
                                <input type="email" class="form-control border-0 py-2 mb-2" placeholder="Email" name="email">
                                <textarea class="form-control border-0 mb-2" rows="2" placeholder="Message" name="pesan"></textarea>
                                <button class="btn btn-primary w-100 py-2">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container px-lg-5">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">Universitas Sebelas Maret Surakarta © 2023</a>, All Right Reserved. 
							
							<!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
							Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="">Program Diploma III Teknik Informatika</a>
                                <a href="" >Fakultas Sekolah Vokasi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/lib/wow/wow.min.js"></script>
    <script src="assets/lib/easing/easing.min.js"></script>
    <script src="assets/lib/waypoints/waypoints.min.js"></script>
    <script src="assets/lib/counterup/counterup.min.js"></script>
    <script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="assets/js/main.js"></script>
</body>

</html>