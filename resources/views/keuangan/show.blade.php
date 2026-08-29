@section('title', 'Detail Transaksi Keuangan')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Bukti Transaksi Keuangan</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('keuangan.index') }}">Keuangan</a></li>
                    <li class="breadcrumb-item active">Detail #{{ $keuangan->id }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('keuangan.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
            <a href="{{ route('keuangan.edit', $keuangan->id) }}" class="btn btn-warning btn-sm shadow-sm text-dark fw-semibold">
                <i class="bi bi-pencil me-1"></i> Edit Transaksi
            </a>
            <button onclick="window.print()" class="btn btn-primary btn-sm shadow-sm">
                <i class="bi bi-printer me-1"></i> Cetak Bukti
            </button>
        </div>
    </div>

    <div class="container-fluid px-0">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3 text-center">
                        <span class="text-success fw-bold">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</span>
                        <h5 class="fw-bold text-dark text-uppercase mb-0 mt-1">BUKTI KAS TRANSAKSI MASJID</h5>
                        <small class="text-muted">Nomor Registrasi: #TRX-{{ str_pad($keuangan->id, 5, '0', STR_PAD_LEFT) }}</small>
                    </div>
                    <div class="card-body p-4">
                        @php $isMasuk = $keuangan->kategori_id == 1; @endphp

                        <div class="text-center my-3 p-3 rounded-3 {{ $isMasuk ? 'bg-success bg-opacity-10 border border-success' : 'bg-danger bg-opacity-10 border border-danger' }}">
                            <span class="badge {{ $isMasuk ? 'bg-success' : 'bg-danger' }} text-uppercase mb-1">
                                {{ $isMasuk ? 'Pemasukan Kas' : 'Pengeluaran Kas' }}
                            </span>
                            <h2 class="fw-bold mb-0 {{ $isMasuk ? 'text-success' : 'text-danger' }}">
                                Rp {{ number_format($keuangan->nominal, 0, ',', '.') }}
                            </h2>
                            <small class="text-muted">({{ $keuangan->kategori ? $keuangan->kategori->nama_kategori : '-' }})</small>
                        </div>

                        <div class="table-responsive mt-3">
                            <table class="table table-borderless align-middle">
                                <tbody>
                                    <tr class="border-bottom">
                                        <th style="width: 200px;" class="text-muted fw-semibold">Tanggal Transaksi</th>
                                        <td class="fw-bold text-dark">{{ \Carbon\Carbon::parse($keuangan->tanggal)->translatedFormat('l, d F Y') }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="text-muted fw-semibold">Nama / Sumber Transaksi</th>
                                        <td class="fw-bold text-dark">{{ $keuangan->sumber_keuangan }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="text-muted fw-semibold">Keterangan / Rincian</th>
                                        <td>{{ $keuangan->keterangan ?? '-' }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="text-muted fw-semibold">Donatur / Sumber</th>
                                        <td>
                                            @if($keuangan->donatur)
                                                <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">
                                                    <i class="bi bi-person-heart me-1"></i> {{ $keuangan->donatur->nama_donatur }}
                                                </span>
                                            @else
                                                <span class="badge bg-light text-secondary border">Hamba Allah / Kas Umum</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="text-muted fw-semibold">Terkait Agenda Kegiatan</th>
                                        <td>
                                            @if($keuangan->kegiatan)
                                                <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle">
                                                    <i class="bi bi-calendar-check me-1"></i> {{ $keuangan->kegiatan->nama_kegiatan }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <th class="text-muted fw-semibold">Dicatat Oleh (Takmir)</th>
                                        <td class="text-dark">
                                            <i class="bi bi-person-circle me-1 text-muted"></i>
                                            {{ $keuangan->takmir ? $keuangan->takmir->nama_takmir : 'Petugas Takmir' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-muted fw-semibold">Waktu Pencatatan</th>
                                        <td class="text-muted small">
                                            {{ \Carbon\Carbon::parse($keuangan->created_at)->translatedFormat('d F Y, H:i') }} WIB
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-4 pt-3 border-top text-center">
                            <div class="col-6">
                                <p class="small text-muted mb-1">Diterima / Diserahkan Oleh</p>
                                <div style="height: 50px;"></div>
                                <p class="fw-bold mb-0">____________________</p>
                            </div>
                            <div class="col-6">
                                <p class="small text-muted mb-1">Bendahara Kas Masjid</p>
                                <div style="height: 50px;"></div>
                                <p class="fw-bold mb-0">{{ $keuangan->takmir ? $keuangan->takmir->nama_takmir : 'Bendahara' }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('layouts.footer')
