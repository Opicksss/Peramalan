<x-layout>
    <x-slot:title>Penjualan</x-slot:title>

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">{{ str_replace('_', ' ', config('app.name')) }}</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="mb-0 text-uppercase">Penjualan Hasil Tembakau</h6>
            <!-- Button trigger modal -->
            <div>
                {{-- <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exel"><i
                        class="bx bx-plus bx-spin-hover"></i>Penjualan Exel</button> --}}
                <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#create"><i
                        class="bx bx-plus bx-spin-hover"></i>Penjualan</button>
            </div>
        </div>

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table align-middle mb-0 table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th>Tanggal</th>
                                <th>Jumlah Penjualan</th>
                                @if (auth()->user() && auth()->user()->role == 'admin')
                                    <th class="no-export" style="width: 80px;">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualans as $penjualan)
                                <tr>
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td>{{ strftime('%B %Y', strtotime($penjualan->tanggal)) }}</td>
                                    <td>{{ $penjualan->jumlah_terjual }}</td>
                                    @if (auth()->user() && auth()->user()->role == 'admin')
                                        <td style="text-align: center;">
                                            <div class="d-flex order-actions">
                                                <button type="button" style="padding: 3px 6px; "
                                                    class="ms-2 flip-animation btn btn-light border-secondary"
                                                    title="Update" data-bs-toggle="modal"
                                                    data-bs-target="#update{{ $penjualan->id }}">
                                                    <i class="bx bx-edit-alt me-0"></i>
                                                </button>
                                                <button type="button" style="padding: 3px 6px; "
                                                    class="ms-2 flip-animation btn btn-light border-secondary "
                                                    title="Delete" data-bs-toggle="modal"
                                                    data-bs-target="#delete{{ $penjualan->id }}">
                                                    <i class="bx bx-trash text-danger me-0"></i>
                                                </button>
                                            </div>
                                        </td>
                                    @endif
                                </tr>

                                <!-- Modal update -->
                                <div class="modal fade" id="update{{ $penjualan->id }}" tabindex="-1"
                                    data-bs-backdrop="static" data-bs-keyboard="false"
                                    aria-labelledby="update{{ $penjualan->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Update Data Penjualan
                                                    {{ ucwords($penjualan->name) }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('penjualan.update', $penjualan->id) }}"
                                                    method="POST" enctype="multipart/form-data" class="row g-3 ">
                                                    @csrf
                                                    @method('PUT')
                                                    {{-- <input type="date" class="form-control" id="tanggal"
                                                        name="tanggal" value="{{ $penjualan->tanggal }}" hidden> --}}
                                                    <div class="mt-3 mb-3">
                                                        <label for="tanggal" class="form-label">Bulan Penjualan</label>
                                                        <input type="month" class="form-control" id="tanggal"
                                                            name="tanggal"
                                                            value="{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('Y-m') }}"
                                                            required>
                                                    </div>
                                                    <div class="mt-3 mb-3">
                                                        <label for="jumlah_terjual" class="form-label">Jumlah
                                                            Terjual</label>
                                                        <input type="number" class="form-control" id="jumlah_terjual"
                                                            value="{{ $penjualan->jumlah_terjual }}"
                                                            name="jumlah_terjual" placeholder="Jumlah Terjual" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="reset"
                                                            class="btn btn-outline-secondary">Reset</button>
                                                        <button type="submit"
                                                            class="btn btn-outline-light">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- //Modal update -->
                                <!-- Modal delete -->
                                <div class="modal fade" id="delete{{ $penjualan->id }}" tabindex="-1"
                                    data-bs-backdrop="static" data-bs-keyboard="false"
                                    aria-labelledby="delete{{ $penjualan->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header justify-content-center">
                                                <h5 class="modal-title text-danger">
                                                    Konfirmasi Penghapusan
                                                </h5>
                                            </div>

                                            <!-- Modal Body -->
                                            <div class="modal-body text-center">
                                                <p class="mb-4">
                                                    Apakah Anda yakin ingin menghapus Data Penjualan Pada Tanggal
                                                    <strong
                                                        style="font-size: 1rem;">{{ strftime('%d %B %Y', strtotime($penjualan->tanggal)) }}
                                                        ?</strong>
                                                    Tindakan ini tidak dapat dibatalkan.
                                                </p>
                                                <div class="d-flex justify-content-center">
                                                    <i class="bx bx-alarm-exclamation bx-tada bx-flip-horizontal text-warning"
                                                        style="font-size: 7rem;"></i>
                                                </div>
                                            </div>

                                            <!-- Modal Footer -->
                                            <div class="modal-footer justify-content-center gap-3">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">Close
                                                </button>
                                                <form action="{{ route('penjualan.destroy', $penjualan->id) }}"
                                                    method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- //Modal delete -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal create -->
    <div class="modal fade" id="create" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="create" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Data Penjualan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('penjualan.store') }}" method="POST" enctype="multipart/form-data"
                        class="row g-3 needs-validation" novalidate>
                        @csrf
                        {{-- <input type="date" class="form-control" id="tanggal" name="tanggal"
                            value="{{ date('Y-m-d') }}" hidden> --}}
                        <div>
                            <label for="tanggal" class="form-label">Bulan Penjualan</label> <input type="month"
                                class="form-control" id="tanggal" name="tanggal" placeholder="Bulan Penjualan"
                                required>
                            <div class="invalid-feedback"> Masukkan Bulan Penjualan! </div>
                        </div>
                        <div>
                            <label for="jumlah_terjual" class="form-label">Jumlah Penjualan</label>
                            <input type="number" class="form-control" id="jumlah_terjual" name="jumlah_terjual"
                                placeholder="Jumlah Penjualan" required>
                            <div class="invalid-feedback">
                                Masukkan Jumlah Penjualan!
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            <button type="submit" class="btn btn-outline-light">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- //Modal create -->

    <!-- Modal exel -->
    <div class="modal fade" id="exel" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="exel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Data Penjualan dengan Exel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('penjualan.import') }}" method="POST" enctype="multipart/form-data"
                        class="row g-3 needs-validation" novalidate>
                        @csrf
                        <div>
                            <label for="file" class="form-label">Penjualan Exel</label>
                            <input type="file" class="form-control" id="file" name="file"
                                accept=".xls,.xlsx" required>
                            <div class="invalid-feedback">
                                Upload Foto Anda!
                            </div>
                        </div>`
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            <button type="submit" class="btn btn-outline-light">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- //Modal exel -->

</x-layout>
