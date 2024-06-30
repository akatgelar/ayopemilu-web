@extends('admin.layouts.app')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    <div class="conatiner-fluid content-inner mt-n5 py-0" style="margin-top: 100px !important;">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="row row-cols-1">
                    <div class="overflow-hidden d-slider1 ">
                        <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <img class="icon" width="60px" src="{{ asset('/assets/admin/images/svg/shield-checkmark-outline.svg') }}">
                                        <div class="progress-detail" style="margin-left: 1rem;">
                                            <p class="mb-2">Total Election</p>
                                            <h4 class="counter" id="counter_election">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <img class="icon" width="60px" src="{{ asset('/assets/admin/images/svg/person-outline.svg') }}">
                                        <div class="progress-detail" style="margin-left: 1rem;">
                                            <p class="mb-2">Total Caleg</p>
                                            <h4 class="counter" id="counter_caleg">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="900">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <img class="icon" width="60px" src="{{ asset('/assets/admin/images/svg/person-outline.svg') }}">
                                        <div class="progress-detail" style="margin-left: 1rem;">
                                            <p class="mb-2">Total Relawan</p>
                                            <h4 class="counter" id="counter_relawan">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <img class="icon" width="60px" src="{{ asset('/assets/admin/images/svg/people-outline.svg') }}">
                                        <div class="progress-detail" style="margin-left: 1rem;">
                                            <p class="mb-2">Total Pemilih</p>
                                            <h4 class="counter" id="counter_pemilih">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1100">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <img class="icon" width="60px;" src="{{ asset('/assets/admin/images/svg/document-text-outline.svg') }}">
                                        <div class="progress-detail" style="margin-left: 1rem;">
                                            <p class="mb-2">Total Laporan</p>
                                            <h4 class="counter" id="counter_laporan">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1200">
                                <div class="card-body">
                                    <div class="progress-widget">
                                        <img class="icon" width="60px" src="{{ asset('/assets/admin/images/svg/create-outline.svg') }}">
                                        <div class="progress-detail" style="margin-left: 1rem;">
                                            <p class="mb-2">Total Survey</p>
                                            <h4 class="counter" id="counter_survey">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="swiper-button swiper-button-next"></div>
                        <div class="swiper-button swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                                <div class="header-title">
                                    <h4 class="card-title">Daily Access (Last 30 Days)</h4>
                                </div>
                            </div>
                            <div class="card-body" style="height: 350px">
                                <canvas id="chart-daily-access"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                                <div class="header-title">
                                    <h4 class="card-title">Top Device</h4>
                                </div>
                            </div>
                            <div class="card-body" style="height: 350px">
                                <canvas id="chart-top-device"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                                <div class="header-title">
                                    <h4 class="card-title">Monthly Access (Last 12 Month)</h4>
                                </div>
                            </div>
                            <div class="card-body" style="height: 350px">
                                <canvas id="chart-monthly-access"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                                <div class="header-title">
                                    <h4 class="card-title">Top Operating System</h4>
                                </div>
                            </div>
                            <div class="card-body" style="height: 350px">
                                <canvas id="chart-top-os"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                                <div class="header-title">
                                    <h4 class="card-title">Top Page</h4>
                                </div>
                            </div>
                            <div class="card-body" style="height: 500px">
                                <canvas id="chart-top-page"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                                <div class="header-title">
                                    <h4 class="card-title">Top Country</h4>
                                </div>
                            </div>
                            <div class="card-body" style="height: 400px">
                                <canvas id="chart-top-country"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" data-aos="fade-up" data-aos-delay="800">
                            <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
                                <div class="header-title">
                                    <h4 class="card-title">Top City</h4>
                                </div>
                            </div>
                            <div class="card-body" style="height: 400px">
                                <canvas id="chart-top-city"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({headers:{'Authorization': "Bearer {{$session_token}}"}});

        // election
        $.ajax({
            url: '/api/election?count=true',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['status'] == true) {
                    $('#counter_election').html(result['data']['count']);
                }
            }
        });

        // caleg
        $.ajax({
            url: '/api/user?count=true&where={"role_id": 2}',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['status'] == true) {
                    $('#counter_caleg').html(result['data']['count']);
                }
            }
        });

        // relawan
        $.ajax({
            url: '/api/user?count=true&where={"role_id": 3}',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['status'] == true) {
                    $('#counter_relawan').html(result['data']['count']);
                }
            }
        });

        // pemilih
        $.ajax({
            url: '/api/voter?count=true',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['status'] == true) {
                    $('#counter_pemilih').html(result['data']['count']);
                }
            }
        });

        // laporan
        $.ajax({
            url: '/api/report?count=true',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['status'] == true) {
                    $('#counter_laporan').html(result['data']['count']);
                }
            }
        });

        // survey
        $.ajax({
            url: '/api/survey?count=true',
            type: "GET",
            dataType: "json",
            processData: false,
            success: function (result) {
                if(result['status'] == true) {
                    $('#counter_survey').html(result['data']['count']);
                }
            }
        });

        setTimeout(function() {
            // access daily
            $.ajax({
                url: '/api/dashboard/access-daily',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function (result) {
                    if(result['status'] == true) {
                        // prepare data
                        var label = [];
                        var data = [];
                        result['data'].forEach(element => {
                            label.push(element['dates_indo']);
                            data.push(Number(element['count']));
                        });

                        // chart
                        new Chart('chart-daily-access', {
                            type: 'line',
                            data: {
                                labels: label,
                                datasets: [{
                                    fill: false,
                                    lineTension: 0,
                                    backgroundColor: "rgba(7,65,115,1.0)",
                                    borderColor: "rgba(7,65,115,0.1)",
                                    data: data,
                                    label: 'Total Count'
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: false,
                                    },
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            },
                        });
                    }
                }
            });

            // access monthly
            $.ajax({
                url: '/api/dashboard/access-monthly',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function (result) {
                    if(result['status'] == true) {
                        // prepare data
                        var label = [];
                        var data = [];
                        result['data'].forEach(element => {
                            label.push(element['months_indo']);
                            data.push(Number(element['count']));
                        });

                        // chart
                        new Chart('chart-monthly-access', {
                            type: 'bar',
                            data: {
                                labels: label,
                                datasets: [{
                                    fill: false,
                                    lineTension: 0,
                                    backgroundColor: "rgba(22,121,171,1.0)",
                                    borderColor: "rgba(22,121,171,0.1)",
                                    data: data,
                                    label: 'Total Count'
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: false,
                                    },
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            },
                        });
                    }
                }
            });

            // top device
            $.ajax({
                url: '/api/dashboard/top-device',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function (result) {
                    if(result['status'] == true) {
                        // prepare data
                        var label = [];
                        var data = [];
                        result['data'].forEach(element => {
                            label.push(element['device']);
                            data.push(Number(element['total']));
                        });

                        // chart
                        new Chart('chart-top-device', {
                            type: 'doughnut',
                            data: {
                                labels: label,
                                datasets: [{
                                    data: data,
                                    label: 'Total Count',
                                    backgroundColor: [
                                        'rgb(243,206,123)',
                                        'rgb(19,170,185)',
                                        'rgb(240,130,95)'
                                    ],
                                    datalabels: {
                                        anchor: 'center',
                                        backgroundColor: null,
                                        borderWidth: 0
                                    }
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'bottom'
                                    },
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            },
                        });
                    }
                }
            });

            // top os
            $.ajax({
                url: '/api/dashboard/top-os',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function (result) {
                    if(result['status'] == true) {
                        // prepare data
                        var label = [];
                        var data = [];
                        result['data'].forEach(element => {
                            label.push(element['os']);
                            data.push(Number(element['total']));
                        });

                        // chart
                        new Chart('chart-top-os', {
                            type: 'pie',
                            data: {
                                labels: label,
                                datasets: [{
                                    data: data,
                                    label: 'Total Count',
                                    backgroundColor: [
                                        'rgb(255,152,0)',
                                        'rgb(44,120,101)',
                                        'rgb(87,85,254)',
                                        'rgb(210,0,98)',
                                    ],
                                }]
                            },
                            options: {
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'bottom'
                                    },
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            },
                        });
                    }
                }
            });

            // top page
            $.ajax({
                url: '/api/dashboard/top-page',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function (result) {
                    if(result['status'] == true) {
                        // prepare data
                        var label = [];
                        var data = [];
                        result['data'].forEach(element => {
                            label.push(element['path']);
                            data.push(Number(element['total']));
                        });

                        // chart
                        new Chart('chart-top-page', {
                            type: 'bar',
                            data: {
                                labels: label,
                                datasets: [{
                                    data: data,
                                    label: 'Total Count',
                                    backgroundColor: 'rgb(215,75,118)'
                                }]
                            },
                            options: {
                                // indexAxis: 'y',
                                plugins: {
                                    legend: {
                                        display: false,
                                        position: 'bottom'
                                    },
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            },
                        });
                    }
                }
            });

            // top country
            $.ajax({
                url: '/api/dashboard/top-country',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function (result) {
                    if(result['status'] == true) {
                        // prepare data
                        var label = [];
                        var data = [];
                        result['data'].forEach(element => {
                            label.push(element['country_name']);
                            data.push(Number(element['total']));
                        });

                        // chart
                        new Chart('chart-top-country', {
                            type: 'bar',
                            data: {
                                labels: label,
                                datasets: [{
                                    data: data,
                                    label: 'Total Count',
                                    backgroundColor: 'rgb(197,255,149)'
                                }]
                            },
                            options: {
                                indexAxis: 'y',
                                plugins: {
                                    legend: {
                                        display: false,
                                        position: 'bottom'
                                    },
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            },
                        });
                    }
                }
            });

            // top city
            $.ajax({
                url: '/api/dashboard/top-city',
                type: "GET",
                dataType: "json",
                processData: false,
                success: function (result) {
                    if(result['status'] == true) {
                        // prepare data
                        var label = [];
                        var data = [];
                        result['data'].forEach(element => {
                            label.push(element['city_name']);
                            data.push(Number(element['total']));
                        });

                        // chart
                        new Chart('chart-top-city', {
                            type: 'bar',
                            data: {
                                labels: label,
                                datasets: [{
                                    data: data,
                                    label: 'Total Count',
                                    backgroundColor: 'rgb(255,250,183)'
                                }]
                            },
                            options: {
                                indexAxis: 'y',
                                plugins: {
                                    legend: {
                                        display: false,
                                        position: 'bottom'
                                    },
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            },
                        });
                    }
                }
            });

        }, 3000);
    </script>
@endsection
