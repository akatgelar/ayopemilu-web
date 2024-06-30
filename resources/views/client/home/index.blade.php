@extends('client.layouts.app')

@section('content')

    <!-- home section -->
    <section class="home-3 bg-light" id="home">
        <!-- start container -->
        <div class="container-fluid position-relative">
            <!-- start row -->
            <div class=" side-img img bg-primary">
                <div class="bg-overlay-gradiant"></div>
                <div class="home-slider position-relative" id="home-slider">
                    <!-- slider item -->
                    <div class="item ">
                        <div class="testi-box position-relative overflow-hidden">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-lg-11 ">
                                    <img src="{{ asset('assets/client/images/app/phone-1.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item ">
                        <div class="testi-box position-relative overflow-hidden">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-lg-11">
                                    <img src="{{ asset('assets/client/images/app/phone-2.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item ">
                        <div class="testi-box position-relative overflow-hidden">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-lg-11">
                                    <img src="{{ asset('assets/client/images/app/phone-3.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item ">
                        <div class="testi-box position-relative overflow-hidden">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-lg-11">
                                    <img src="{{ asset('assets/client/images/app/phone-4.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item ">
                        <div class="testi-box position-relative overflow-hidden">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-lg-11">
                                    <img src="{{ asset('assets/client/images/app/phone-5.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="item ">
                        <div class="testi-box position-relative overflow-hidden">
                            <div class="row justify-content-center align-items-center">
                                <div class="col-lg-11">
                                    <img src="{{ asset('assets/client/images/app/phone-6.png') }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- slider item -->
                </div>

            </div>
            <div class="container position-relative hero-img">
                <div class="row">
                    <div class="col-lg-6 col-12 mt-3 pt-2">
                        <div class="content">
                            <h6 class="text-primary">Ayo Pemilu</h6>
                            <h1 class="display-6 fw-bold mt-3">Membantu sukseskan pencalonan Anda di Pemilu 2024.</h1>
                            <p class="text-muted mt-3">
                                Dengan aplikasi <b>Ayo Pemilu</b>, dengan mudah memantau calon pemilih, relawan dan perangkat pemilu lainnya.
                                Sebuah aplikasi dengan berbagai fitur mencatatan proses pemilu.
                            </p>
                            <!-- <div class="content-icon">
                                <div class="d-lg-flex image-logo mt-4">
                                    <img src="{{ asset('assets/client/images/img-appstore.png') }}" alt="" class="img-fluid mb-3">
                                    <img src="{{ asset('assets/client/images/img-googleplay.png') }}" alt="" class="img-fluid mb-3 ps-0 ps-lg-3 mt-sm-0">
                                </div>
                            </div> -->

                        </div>
                        <!-- end about detail -->
                    </div><!-- end col -->
                </div>
                <!--end row-->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- end home section -->


    <!-- start features -->
    <div class="section features" id="layanan">
        <!-- start container -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="title text-center mb-5">
                        <h6 class="mb-0 fw-bold text-primary">Ayo Pemilu</h6>
                        <h2 class="f-40">Layanan dan Fitur  </h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">

                <div class="col-lg-12">

                    <div class="tab-content mt-2" id="pills-tabContent">
                        <div class=" " id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="row align-items-center">
                                <div class="col-lg-4 order-lg-first" style="margin-top: 30px;">
                                    <div class="features-item text-start text-lg-end">
                                        <div class="icon avatar-sm text-center ms-lg-auto rounded-circle">
                                            <i class="mdi mdi-account-group-outline f-24"></i>
                                        </div>
                                        <div class="content">
                                            <h5>Calon Pemilih & Relawan</h5>
                                            <p>Mencatat siapa saja calon pemilih & relawan Anda di Pemilu 2024.</p>
                                        </div>
                                    </div>

                                    <div class="features-item text-start text-lg-end mt-5">
                                        <div class="icon avatar-sm text-center ms-lg-auto rounded-circle">
                                            <i class="mdi mdi-list-status f-24"></i>
                                        </div>
                                        <div class="content">
                                            <h5>Laporan</h5>
                                            <p>Catat laporan kegiatan atau kecurangan pemilu.</p>
                                        </div>
                                    </div>

                                    <div class="features-item text-start text-lg-end mt-5 mb-5">
                                        <div class="icon avatar-sm text-center ms-lg-auto rounded-circle">
                                            <i class="mdi mdi-chart-line f-24"></i>
                                        </div>
                                        <div class="content">
                                            <h5>Survey</h5>
                                            <p>Lakukan survey sendiri dan dapatkan hasilnya saat itu juga.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <img src="{{ asset('assets/client/images/app/phone-1.png') }}" alt="" class="img-fluid">
                                </div>
                                <div class="col-lg-4 order-last">
                                    <div class="features-item">
                                        <div class="icon avatar-sm text-center rounded-circle">
                                            <i class="mdi mdi-clock-time-four-outline f-24"></i>
                                        </div>
                                        <div class="content">
                                            <h5>Quick Count</h5>
                                            <p>Hitung hasil pemilihan dengan cepat dengan laporan oleh relawan/saksi.</p>
                                        </div>
                                    </div>

                                    <div class="features-item mt-5">
                                        <div class="icon avatar-sm text-center rounded-circle">
                                            <i class="mdi mdi-swap-horizontal f-24"></i>
                                        </div>
                                        <div class="content">
                                            <h5>Pengeluaran</h5>
                                            <p>Catat laporan keuangan dan inventaris barang yang dimiliki.</p>
                                        </div>
                                    </div>

                                    <div class="features-item mt-5">
                                        <div class="icon avatar-sm text-center rounded-circle">
                                            <i class="mdi mdi-poll f-24"></i>
                                        </div>
                                        <div class="content">
                                            <h5>Statistik</h5>
                                            <p>Lihat statistik pencalonan Anda dan calon pemilih Anda.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>

                    </div>
                </div>
            </div>
        </div>
        <!-- end container -->
    </div>
    <!-- end features -->



    <!-- pricing section -->
    <section class="section pricing" id="harga">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="title text-center mb-5">
                        <h6 class="mb-0 fw-bold text-primary">Ayo Pemilu</h6>
                        <h2 class="f-40">Biaya Berlangganan</h2>
                    </div>
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="price-item shadow-sm overflow-hidden">
                        <div class="price-up-box active p-4">
                            <div class="badge bg-info fw-normal f-14">Basic</div>
                            <div class="price-tag mt-2">
                                <h2 class="text-white mb-0 f-40"><sup class="f-22 fw-normal">Rp </sup>xxx <sup class="f-16 fw-normal"> ribu / bulan</sup></h2>
                            </div>
                        </div>
                        <div class="border border-3"></div>

                        <div class="price-down-box p-4">
                            <ul class="list-unstyled ">
                                <li><i class="mdi mdi-check-circle-outline f-20 align-middle me-2 text-primary"></i>Kelola relawan tidak terbatas</li>
                                <li class="mt-2"><i class="mdi mdi-check-circle-outline f-20 align-middle me-2 text-primary"></i>Kelola calon pemilih tidak terbatas</li>
                                <li class="mt-2"><i class="mdi mdi-check-circle-outline f-20 align-middle me-2 text-primary"></i>Kelola laporan tidak terbatas</li>
                                <li class="mt-2"><i class="mdi mdi-check-circle-outline f-20 align-middle me-2 text-primary"></i>Kelola pengeluaran tidak terbatas</li>
                                <li class="mt-2"><i class="mdi mdi-check-circle-outline f-20 align-middle me-2 text-primary"></i>Kelola inventaris tidak terbatas</li>
                                <li class="mt-2"><i class="mdi mdi-close-circle-outline f-20 align-middle me-2 text-danger"></i>Kelola survey</li>
                                <li class="mt-2"><i class="mdi mdi-close-circle-outline f-20 align-middle me-2 text-danger"></i>Kelola quick count</li>
                            </ul>
                            <a target="_blank" href="mailto:165indramaulana@gmail.com" class="btn btn-sm text-primary mt-3"><i class="mdi mdi-send me-2"></i>Hubungi admin</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 ">
                    <div class="price-item shadow-sm overflow-hidden mt-4 mt-lg-0">
                        <div class="price-up-box p-4">
                            <div class="badge bg-primary fw-normal f-14">Premium</div>
                            <div class="price-tag mt-2">
                                <h2 class="text-dark mb-0 f-40"><sup class="f-22 fw-normal">Rp </sup>xxx <sup class="f-16 fw-normal"> ribu / bulan</sup></h2>
                                </h2>
                            </div>
                        </div>
                        <div class="border border-3"></div>

                        <div class="price-down-box p-4">
                            <ul class="list-unstyled ">
                                <li><i class="mdi mdi-check-circle-outline f-20 align-middle me-2 text-primary"></i>Kelola relawan tidak terbatas</li>
                                <li class="mt-2"><i class="mdi mdi-check-circle-outline f-20 align-middle me-2 text-primary"></i>Kelola calon pemilih tidak terbatas</li>
                                <li class="mt-2"><i class="mdi mdi-check-circle-outline f-20 align-middle me-2 text-primary"></i>Kelola laporan tidak terbatas</li>
                                <li class="mt-2"><i class="mdi mdi-check-circle-outline f-20 align-middle me-2 text-primary"></i>Kelola pengeluaran tidak terbatas</li>
                                <li class="mt-2"><i class="mdi mdi-check-circle-outline f-20 align-middle me-2 text-primary"></i>Kelola inventaris tidak terbatas</li>
                                <li class="mt-2"><i class="mdi mdi-check-circle-outline f-20 align-middle me-2 text-primary"></i>Kelola survey</li>
                                <li class="mt-2"><i class="mdi mdi-check-circle-outline f-20 align-middle me-2 text-primary"></i>Kelola quick count</li>
                            </ul>
                            <a target="_blank" href="mailto:165indramaulana@gmail.com" class="btn btn-sm text-primary mt-3"><i class="mdi mdi-send me-2"></i>Hubungi admin</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end pricing -->



    <!-- slider section -->
    <section class="section app-slider bg-light" id="aplikasi">
        <!-- start container -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="title text-center mb-5">
                        <h6 class="mb-0 fw-bold text-primary">Ayo Pemilu</h6>
                        <h2 class="f-40">Tampilan aplikasi</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="swiper-container">
                        <div class="fream-phone ">
                            <img src="{{ asset('assets/client/images/app/phone-fream.png') }}" alt="" class="img-fluid">
                        </div>

                        <div class="swiper-wrapper">
                            <div class="swiper-slide border-radius">
                                <img src="{{ asset('assets/client/images/app/1-login.png') }}" alt="" class="img-fluid">
                            </div>
                            <div class="swiper-slide border-radius">
                                <img src="{{ asset('assets/client/images/app/2-home.png') }}" alt="" class="img-fluid">
                            </div>
                            <div class="swiper-slide border-radius">
                                <img src="{{ asset('assets/client/images/app/3.1-pemilih.png') }}" alt="" class="img-fluid">
                            </div>
                            <div class="swiper-slide border-radius">
                                <img src="{{ asset('assets/client/images/app/3.2-relawan.png') }}" alt="" class="img-fluid">
                            </div>
                            <div class="swiper-slide border-radius">
                                <img src="{{ asset('assets/client/images/app/4-laporan.png') }}" alt="" class="img-fluid">
                            </div>
                            <div class="swiper-slide border-radius">
                                <img src="{{ asset('assets/client/images/app/5-survey.png') }}" alt="" class="img-fluid">
                            </div>
                            <div class="swiper-slide border-radius">
                                <img src="{{ asset('assets/client/images/app/6-quick count.png') }}" alt="" class="img-fluid">
                            </div>
                            <div class="swiper-slide border-radius">
                                <img src="{{ asset('assets/client/images/app/7.1-pengeluaran.png') }}" alt="" class="img-fluid">
                            </div>
                            <div class="swiper-slide border-radius">
                                <img src="{{ asset('assets/client/images/app/7.2-inventaris.png') }}" alt="" class="img-fluid">
                            </div>
                            <div class="swiper-slide border-radius">
                                <img src="{{ asset('assets/client/images/app/8-statistik.png') }}" alt="" class="img-fluid">
                            </div>
                            <div class="swiper-slide border-radius">
                                <img src="{{ asset('assets/client/images/app/9-setting.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>

                        <!-- navigation buttons -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
            <!-- end container -->
        </div>
    </section>
    <!-- end section -->


@endsection
