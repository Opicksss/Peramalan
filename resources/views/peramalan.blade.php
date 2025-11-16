<x-layout>
    <x-slot:title>Peramalan</x-slot:title>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">{{ str_replace('_', ' ', config('app.name')) }}</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Peramalan</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0 text-uppercase">Peramalan Produksi Rokok</h6>
            <div class="d-flex align-items-center gap-2">
                <div class="dropdown">
                    <button class="btn btn-light d-flex align-items-center gap-2 dropdown-toggle" type="button"
                        id="alphaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <span>Alpha: <strong>{{ floatval(round($alpha, 1)) }}</strong></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="alphaDropdown">
                        <li class="dropdown-item d-flex justify-content-between align-items-center">
                            <span class="me-5">ALPHA</span>
                            <span class="me-5">MAPE</span>
                            <span class="me-5">MAD</span>
                            <span class="me-5">MSE</span>

                        </li>
                        @foreach ($alphas as $item)
                            <li>
                                <form action="{{ route('alpha.update') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="alpha" value="{{ $item['alpha'] }}">
                                    <button type="submit"
                                        class="dropdown-item d-flex justify-content-between align-items-center {{ $item['alpha'] == $bestMape || $item['alpha'] == $bestmad ? 'bg-success text-white' : ($item['alpha'] == $alpha ? 'bg-secondary text-white' : '') }}">
                                        <span>{{ $item['alpha'] }}</span>
                                        <span>{{ $item['mape'] }}%</span>
                                        <span>{{ $item['mad'] }}</span>
                                        <span>{{ $item['mse'] }}</span>

                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <hr />
        <div class="row">
            <div class="col-lg-2 mb-3">
                <div class="d-flex flex-column gap-3 h-100">
                    <div class="card radius-10 flex-fill">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0">Data Ramalan</p>
                                    <h4 class="my-2 mb-2">
                                        {{ isset($bulan->hasil_peramalan) ? floatval(round($bulan->hasil_peramalan, 2)) : '-' }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card radius-10 flex-fill">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0">Rata-Rata MAPE</p>
                                    <h4 class="my-2 mb-2">{{ floatval(round($mape, 2)) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card radius-10 flex-fill">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0">Rata-Rata MAD</p>
                                    <h4 class="my-2 mb-2">{{ floatval(round($mad, 2)) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card radius-10 flex-fill">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0">Rata-Rata MSE</p>
                                    <h4 class="my-2 mb-2">{{ floatval(round($mse, 2)) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tabel di kanan -->
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable" class="table align-middle mb-0 table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 10px;">No</th>
                                        <th>Tanggal</th>
                                        <th>Penjualan</th>
                                        <th>Peramalan</th>
                                        <th>Absolut Error</th>
                                        <th>MAPE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($peramalans as $peramalan)
                                        <tr>
                                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                                            <td>{{ strftime('%B %Y', strtotime($peramalan->penjualan->tanggal)) }}
                                            </td>
                                            <td>{{ $peramalan->penjualan->jumlah_terjual }}</td>
                                            <td>{{ floatval(round($peramalan->hasil_peramalan, 2)) }}</td>
                                            <td>{{ floatval(round($peramalan->error, 2)) }}</td>
                                            <td>{{ floatval(round($peramalan->mape, 2)) }} %</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout>
