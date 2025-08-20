<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <title>{{ str_replace('_', ' ', config('app.name')) }} | Dashboard </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="assets/images/logoo.png" type="image/png" />
    <!--plugins-->
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/npm/select2%404.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="assets/npm/select2-bootstrap-5-theme%401.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">
    <link href="assets/css/style.min.css" rel="stylesheet" type="text/css" />

    <style>
        .apexcharts-menu {
            background-color: #1e1e1e !important;
            border: 1px solid #1e1e1e !important;
        }

        .apexcharts-menu-item {
            color: #e0e0e0 !important;
        }

        .apexcharts-menu-item:hover {
            background-color: #404040 !important;
        }

        .chart-container {
            position: relative;
        }

        .chart-controls {
            position: absolute;
            right: 5px;
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0);
            z-index: 10;
        }

        .chart-controls select option {
            background: #1e1e1e
        }
    </style>

</head>

<body class="bg-theme bg-theme9">
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <x-sidebar></x-sidebar>
        <!--end sidebar wrapper -->
        <!--start header -->
        <x-header></x-header>
        <!--end header -->
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-sm-8">
                                    <div class="card-body mb-4 text-white">
                                        <h5 class="card-title">Selamat Datang {{ strtoupper(Auth::user()->name) }} 🎉
                                        </h5>
                                        <p class="mb-4">
                                            Optimalkan peramalan permintaan produksi <span class="fw-bold">Rokok</span>
                                            di Lenteng dengan metode
                                            <span class="fw-bold">Single Exponential Smoothing</span> untuk pengambilan
                                            keputusan yang lebih akurat dan efisien.
                                        </p>

                                    </div>
                                </div>
                                <div class="col-sm-4 text-center text-sm-left">
                                    <div class="card-body pb-0 px-0 px-md-4">
                                        <img src="../assets/images/icons/user-interface.png" height="140"
                                            alt="View Badge User"
                                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                            data-app-light-img="icons/user-interface.png" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex gap-4">
                        <div class="card radius-10 w-100 position-relative">
                            <div class="card-body">
                                <div class="chart-container">
                                    <div class="chart-controls gap-2">
                                        <select id="bulan" class="form-select form-select-sm" style="min-width: 120px;">
                                            @foreach ($namaBulan as $key => $nama)
                                                <option value="{{ $key }}"
                                                    {{ $key == $bulanTerpilih ? 'selected' : '' }}>
                                                    {{ $nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select id="tahun" class="form-select form-select-sm">
                                            @foreach ($tahunList as $tahun)
                                                <option value="{{ $tahun }}"
                                                    {{ $tahun == $tahunTerpilih ? 'selected' : '' }}>{{ $tahun }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="chart2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <x-footer></x-footer>
    </div>
    <!--end wrapper-->
    <x-toast></x-toast>
    <!--start switcher-->
    <!--end switcher-->
    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
    <script src="assets/npm/select2%404.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="assets/plugins/select2/js/select2-custom.js"></script>
    <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        document.getElementById('tahun').addEventListener('change', updateChart);
        document.getElementById('bulan').addEventListener('change', updateChart);

        function updateChart() {
            const tahun = document.getElementById('tahun').value;
            const bulan = document.getElementById('bulan').value;
            window.location.href = `?tahun=${tahun}&bulan=${bulan}`;
        }

        var penjualan = @json(array_values($penjualan));
        var peramalan = @json(array_values($peramalan));
        var hariLabels = @json($hariLabels);

        var optionsLine = {
            chart: {
                foreColor: 'rgb(255, 255, 255)',
                height: 420,
                type: 'line',
                zoom: {
                    enabled: false
                },
                dropShadow: {
                    enabled: true,
                    top: 3,
                    left: 2,
                    blur: 4,
                    opacity: 0.1
                },
                toolbar: {
                    show: false,
                    tools: {
                        download: true
                    }
                }
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            colors: ["#d2f3e4", "#9fb0fe"],
            series: [{
                    name: "Penjualan",
                    data: penjualan
                },
                {
                    name: "Peramalan",
                    data: peramalan
                },
            ],
            title: {
                text: 'Data Perbandingan Antara Penjualan Dengan Peramalan',
                align: 'left',
                offsetX: 5
            },
            subtitle: {
                text: 'Forecasting PR Istana Jaya',
                offsetY: 40,
                offsetX: 5
            },
            markers: {
                size: 4,
                strokeWidth: 0,
                hover: {
                    size: 7
                }
            },
            grid: {
                show: true,
                borderColor: 'rgba(255, 255, 255, 0.12)',
                strokeDashArray: 4
            },
            tooltip: {
                theme: 'dark'
            },
            labels: hariLabels,
            xaxis: {
                tooltip: {
                    enabled: false
                },
                title: {
                    text: 'Tanggal'
                }
            },
            yaxis: {
                title: {
                    text: 'Kilogram'
                },
                labels: {
                    formatter: function(value) {
                        return Number.isInteger(value) ? value : parseFloat(value.toFixed(2));
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                offsetY: -20
            }
        };

        var chartLine = new ApexCharts(document.querySelector('#chart2'), optionsLine);
        chartLine.render();
    </script>


    @if (session('success') || session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const toastLiveExample = document.getElementById('liveToast');
                const toastTime = document.getElementById('toastTime');

                // Set waktu saat ini
                const currentTime = new Date();
                const formattedTime = currentTime.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                toastTime.textContent = formattedTime;

                const toast = new bootstrap.Toast(toastLiveExample);
                toast.show();
            });
        </script>
    @endif

    <!--app JS-->
    <script src="assets/js/app.js"></script>
    <script>
        new PerfectScrollbar('.product-list');
        new PerfectScrollbar('.customers-list');
    </script>

</body>

</html>
