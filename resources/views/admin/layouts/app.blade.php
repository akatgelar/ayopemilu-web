<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Ayo Pemilu</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/client/images/ayopemilu_logo.png') }}">

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/core/libs.min.css') }}">

    <!-- Aos Animation Css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/aos/dist/aos.css') }}">

    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/hope-ui.min.css?v=4.0.0') }}">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/custom.min.css?v=4.0.0') }}">

    <!-- Dark Css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/dark.min.css') }}">

    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/customizer.min.css') }}">

    <!-- RTL Css -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/rtl.min.css') }}">

    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/admin/js/core/libs.min.js') }}"></script>

    <!-- Function Script -->
    <script src="{{ asset('assets/admin/js/function.js') }}"></script>

    <!-- WYSIWYG Script -->
    <script src="{{ asset('assets/admin/vendor/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>

    <!-- Material Icon Css -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/materialdesignicons.min.css') }}" type="text/css">
</head>

<body class="  ">
    <!-- loader Start -->
    {{-- <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body">
            </div>
        </div>
    </div> --}}
    <div class="loader"></div>
    <!-- loader END -->

    <aside class="sidebar sidebar-default sidebar-base navs-rounded-all sidebar-dark">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <a href="{{ url('/admin/dashboard') }}" class="navbar-brand">
                <!--Logo start-->
                <div class="logo-main">
                    <div class="logo-normal">
                        <img src="{{ asset('assets/client/images/ayopemilu_logo.png') }}" style="height: 50px;">
                    </div>
                    <div class="logo-mini">
                        <img src="{{ asset('assets/client/images/ayopemilu_logo.png') }}" style="height: 50px;">
                    </div>
                </div>
                <!--logo End-->

                <h4 class="logo-title">Ayo Pemilu</h4>
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </i>
            </div>
        </div>
        <div class="sidebar-body pt-0 data-scrollbar">
            <div class="sidebar-list">
                <!-- Sidebar Menu Start -->
                <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Home</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'dashboard')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/dashboard') }}">
                            <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/home-outline.svg') }}">
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <hr class="hr-horizontal" style="background-color: white">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'election')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/election') }}">
                            <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/shield-checkmark-outline.svg') }}">
                            <span class="item-name">Election</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'Caleg')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/Caleg') }}">
                            <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/person-outline.svg') }}">
                            <span class="item-name">Caleg</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'relawan')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/relawan') }}">
                            <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/person-outline.svg') }}">
                            <span class="item-name">Relawan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'pemilih')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/pemilih') }}">
                            <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/people-outline.svg') }}">
                            <span class="item-name">Pemilih</span>
                        </a>
                    </li>
                    <li>
                        <hr class="hr-horizontal" style="background-color: white">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'laporan')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/laporan') }}">
                            <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/document-text-outline.svg') }}">
                            <span class="item-name">Laporan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'survey')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/survey') }}">
                            <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/create-outline.svg') }}">
                            <span class="item-name">Survey</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'quickcount')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/quickcount') }}">
                            <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/bar-chart-outline.svg') }}">
                            <span class="item-name">Quick Count</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'pengeluaran')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/pengeluaran') }}">
                            <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/cash-outline.svg') }}">
                            <span class="item-name">Pengeluaran</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'inventaris')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/inventaris') }}">
                            <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/briefcase-outline.svg') }}">
                            <span class="item-name">Inventaris</span>
                        </a>
                    </li>
                    <li>
                        <hr class="hr-horizontal" style="background-color: white">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'area_provinsi')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/area_provinsi') }}">
                            <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/apps-outline.svg') }}">
                            <span class="item-name">Area Provinsi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'area_kota')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/area_kota') }}">
                            <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/apps-outline.svg') }}">
                            <span class="item-name">Area Kota</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'area_kecamatan')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/area_kecamatan') }}">
                            <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/apps-outline.svg') }}">
                            <span class="item-name">Area Kecamatan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'area_kelurahan')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/area_kelurahan') }}">
                            <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/apps-outline.svg') }}">
                            <span class="item-name">Area Kelurahan</span>
                        </a>
                    </li>
                    <li>
                        <hr class="hr-horizontal" style="background-color: white">
                    </li>
                    @if ($session_data['user_level_id'] == 1)
                        <li class="nav-item">
                            <a class="nav-link @if (str_contains($menu, 'role')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/role') }}">
                                <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/options-outline.svg') }}">
                                <span class="item-name">Role</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if (str_contains($menu, 'user')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/user') }}">
                                <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/person-add-outline.svg') }}">
                                <span class="item-name">User</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link @if (str_contains($menu, 'setting')) {{'active'}} @endif" aria-current="page" href="{{ url('/admin/setting') }}">
                            <img class="icon" width="24px;" style="filter: invert(1);" src="{{ asset('/assets/admin/images/svg/settings-outline.svg') }}">
                            <span class="item-name">Setting</span>
                        </a>
                    </li>
                    <li style="margin-bottom: 40px">
                        <hr class="hr-horizontal">
                    </li>
                </ul>
                <!-- Sidebar Menu End -->
            </div>
        </div>
        <div class="sidebar-footer"></div>
    </aside>
    <main class="main-content">
        <div class="position-relative iq-banner">
            <!--Nav Start-->
            <nav class="nav navbar navbar-expand-lg navbar-light iq-navbar navs-sticky menu-sticky">
                <div class="container-fluid navbar-inner">
                    <a href="{{ url('/admin/dashboard') }}" class="navbar-brand">
                        <!--Logo start-->
                        <div class="logo-main">
                            <div class="logo-normal">
                                <img src="{{ asset('assets/client/images/ayopemilu_logo.png') }}" style="height: 50px">
                            </div>
                            <div class="logo-mini">
                                <img src="{{ asset('assets/client/images/ayopemilu_logo.png') }}" style="height: 50px">
                            </div>
                        </div>
                        <!--logo End-->
                        <h4 class="logo-title">Ayo Pemilu</h4>
                    </a>
                    <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                        <i class="icon">
                            <svg width="20px" class="icon-20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                            </svg>
                        </i>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">
                            <span class="mt-2 navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="py-0 nav-link d-flex align-items-center" href="#"
                                    id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <img src="{{ asset('/uploads/thumb/' . $session_data['user_picture']) }}" class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                                    <div class="caption ms-3 d-none d-md-block ">
                                        <h6 class="mb-0 caption-title">{{ $session_data['user_name'] }}</h6>
                                        <p class="mb-0 caption-sub-title">{{ $session_data['user_level_name'] }}</p>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item" href="{{ url('/admin/profile') }}">Profile</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ url('/admin/auth/logout') }}">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            {{-- <div class="iq-navbar-header" style="height: 70px;">
            </div>   --}}
            <!--Nav End-->
        </div>


        @yield('content')


        <!-- Footer Section Start -->
        <footer class="footer">
            <div class="footer-body">
                <div class="right-panel">
                    {{ $setting['copyright'] }}
                </div>
            </div>
        </footer>
        <!-- Footer Section End -->
    </main>

    <!-- Validation -->
    <script src="{{ asset('assets/admin/js/plugins/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/plugins/additional-methods.min.js') }}"></script>

    <!-- Alert -->
    <script src="{{ asset('assets/admin/js/sweetalert2@11.js') }}"></script>

    <!-- External Library Bundle Script -->
    <script src="{{ asset('assets/admin/js/core/external.min.js') }}"></script>

    <!-- Widgetchart Script -->
    <script src="{{ asset('assets/admin/js/charts/widgetcharts.js') }}"></script>

    <!-- mapchart Script -->
    <script src="{{ asset('assets/admin/js/charts/vectore-chart.js') }}"></script>
    <script src="{{ asset('assets/admin/js/charts/dashboard.js') }}"></script>

    <!-- fslightbox Script -->
    <script src="{{ asset('assets/admin/js/plugins/fslightbox.js') }}"></script>

    <!-- Settings Script -->
    <script src="{{ asset('assets/admin/js/plugins/setting.js') }}"></script>

    <!-- Slider-tab Script -->
    <script src="{{ asset('assets/admin/js/plugins/slider-tabs.js') }}"></script>

    <!-- Form Wizard Script -->
    <script src="{{ asset('assets/admin/js/plugins/form-wizard.js') }}"></script>

    <!-- AOS Animation Plugin-->
    <script src="{{ asset('assets/admin/vendor/aos/dist/aos.js') }}"></script>

    <!-- App Script -->
    <script src="{{ asset('assets/admin/js/hope-ui.js') }}" defer></script>

</body>

</html>
