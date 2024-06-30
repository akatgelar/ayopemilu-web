<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Ayo Pemilu - Sukseskan Pemilu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ayo Pemilu. Membantu sukseskan pencalonan Anda di Pemilu 2024.">
    <meta name="keywords" content="ayo pemilu, pemilu, pemilihan umum, caleg, calon legislatif, aplikasi, quick count, lapor, relawan, saksi, statistik ">
    <meta name="author" content="Ayo Pemilu" >
    <meta name="robots" content="index, follow">

    <meta name="og:title" content="Ayo Pemilu - Sukseskan Pemilu">
    <meta name="og:description" content="Ayo Pemilu. Membantu sukseskan pencalonan Anda di Pemilu 2024.">
    <meta name="og:url" content="https://ayopemilu.id">
    <meta name="og:image" content="{{ asset('assets/client/images/ayopemilu_logo.png') }}">
    <meta name="og:image:alt" content="Ayo Pemilu">

    <link rel="shortcut icon" href="{{ asset('assets/client/images/ayopemilu_logo.png') }}">

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/bootstrap.min.css') }}" type="text/css" id="bootstrap-style">

    <!-- Material Icon Css -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/materialdesignicons.min.css') }}" type="text/css">

    <!-- Unicon Css -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/line.css') }}">

    <!-- Swiper Css -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/tiny-slider.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/client/css/swiper.min.css') }}" type="text/css">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/style.min.css') }}" type="text/css">

    <!-- colors -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/colors/default.css') }}"  type="text/css" id="color-opt">


    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QHTRF5FZBN"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-QHTRF5FZBN');
    </script>

</head>

<body data-bs-spy="scroll" data-bs-target="#navbarCollapse">

    <!-- START  NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-light bg-light" id="navbar">
        <div class="container-fluid">

            <!-- LOGO -->
            <a class="navbar-brand logo text-uppercase" href="index.html">
                <img src="{{ asset('assets/client/images/ayopemilu_logo_title.png') }}" class="logo-light" alt="" height="50">
                <img src="{{ asset('assets/client/images/ayopemilu_logo_title.png') }}" class="logo-dark" alt="" height="50">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="mdi mdi-menu"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ms-auto" id="navbar-navlist">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#layanan">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#harga">Harga</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#aplikasi">Tampilan Aplikasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontak">Kontak</a>
                    </li>
                </ul>
                <div class="ms-auto">
                    <a target="_blank" href="{{url('/mobile')}}" class="btn bg-gradiant">Mobile</a>
                    <a target="_blank" href="{{url('/admin')}}" class="btn bg-gray">Admin</a>
                </div>
            </div>
        </div>
    </nav>
    <!-- END NAVBAR -->



    @yield('content')



    <!-- footer section -->
    <section class=" section footer bg-dark overflow-hidden" id="kontak">
        <div class="bg-arrow">
        </div>
        <!-- container -->
        <div class="container">
            <div class="row ">
                <div class="col-lg-4">
                    <a class="navbar-brand logo text-uppercase" href="index.html">
                        <img src="{{ asset('assets/client/images/ayopemilu_logo_text_white.png') }}" class="logo-light" alt="" height="50">
                    </a>
                    <p class="text-white-50 mt-2 mb-0">Dengan aplikasi Ayo Pemilu, dengan mudah memantau calon pemilih, relawan dan perangkat pemilu lainnya. Sebuah aplikasi dengan berbagai fitur mencatatan proses pemilu.</p>

                    <div class="footer-icon mt-4">
                        <div class=" d-flex align-items-center">
                            <a href="" class="me-2 avatar-sm text-center" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Facebook">
                                <i class="mdi mdi-email f-24 align-middle text-primary"></i>
                            </a>
                            <a href="" class="mx-2 avatar-sm text-center" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Twitter">
                                <i class="mdi mdi-whatsapp f-24 align-middle text-primary"></i>
                            </a>
                            <a href="" class="mx-2 avatar-sm text-center" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Googleplay">
                                <i class="mdi mdi-instagram f-24 align-middle text-primary"></i>
                            </a>
                            <a href="" class="mx-2 avatar-sm text-center" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Linkedin">
                                <i class="mdi mdi-google-play f-24 align-middle text-primary"></i>
                            </a>
                        </div>

                    </div>
                </div>

                <div class="col-md-1 ">
                </div>
                <div class="col-md-3 ">
                    <div class="text-start mt-4 mt-lg-0">
                        <h5 class="text-white fw-bold">Product</h5>
                        <ul class="footer-item list-unstyled footer-link mt-3">
                            <li><a href="#layanan">Layanan</a></li>
                            <li><a href="#harga">Harga</a></li>
                            <li><a href="#aplikasi">Tampilan Aplikasi</a></li>
                            <li><a href="#kontak">Kontak</a></li>
                        </ul>
                    </div>
                </div>


                <div class="col-lg-4">
                    <h5 class="text-white">Hubungi Kami</h5>
                    <div class="input-group my-4">
                        <input type="text" class="form-control p-3" placeholder="" aria-label="subscribe" aria-describedby="basic-addon2">
                        <a target="_blank" href="mailto:165indramaulana@gmail.com" class="input-group-text bg-primary text-white px-4" id="basic-addon2">Kirim email</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end container -->
    </section>


    <section class="bottom-footer py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <p class="mb-0 text-center text-muted">©
                        <script>document.write(new Date().getFullYear())</script> Ayo Pemilu.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- end footer -->

    <!--Bootstrap Js-->
    <script src="{{ asset('assets/client/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Slider Js -->
    <script src="{{ asset('assets/client/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('assets/client/js/swiper.min.js') }}"></script>

    <!-- <script src="{{ asset('assets/client/js/smooth-scroll.polyfills.min.js') }}"></script> -->

    <!-- counter -->
    <!-- <script src="{{ asset('assets/client/js/counter.init.js') }}"></script> -->

    <!-- App Js -->
    <script src="{{ asset('assets/client/js/app.js') }}"></script>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        })
    </script>

    <script>
        var slider = tns({
            container: '.home-slider',
            loop: true,
            autoplay: true,
            mouseDrag: true,
            controls: true,
            navPosition: "bottom",
            nav: true,
            autoplayTimeout: 5000,
            speed: 900,
            center: false,
            animateIn: "fadeIn",
            animateOut: "fadeOut",
            controlsText: ['&#8592;', '&#8594;'],
            autoplayButtonOutput: false,
            gutter: 0,
            items: 1,
            responsive: {

                1550: {
                    gutter: 0,
                    items: 2.5
                },

                1400: {
                    gutter: 0,
                    items: 2
                },

                1200: {
                    gutter: 0,
                    items: 1.8
                },
                1100: {
                    gutter: 0,
                    items: 1.6
                },

                900: {
                    gutter: 0,
                    items: 1.5
                },
                700: {
                    gutter: 0,
                    items: 1.3
                }

            }
        });

    </script>

</body>

</html>
