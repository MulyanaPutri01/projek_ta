@section('title', 'Pusat Pemulihan Data (Recycle Bin / Trash)')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">
                <i class="bi bi-recycle text-success me-2"></i>Pusat Pemulihan Data (Recycle Bin)
            </h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Pusat Pemulihan Data</li>
                </ol>
            </nav>
        </div>
        @if($totalTrashed > 0)
            <div class="d-flex gap-2">
                <form action="{{ route('trash.empty', 'all') }}" method="POST" onsubmit="return confirm('PERINGATAN: Apakah Anda yakin ingin mengosongkan SELURUH tong sampah secara permanen? Data yang dihapus permanen TIDAK DAPAT dipulihkan lagi!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger rounded-pill shadow-sm px-3 fw-semibold">
                        <i class="bi bi-trash3-fill me-1"></i> Kosongkan Semua Sampah
                    </button>
                </form>
            </div>
        @endif
    </div><!-- End Page Title -->

    <div class="container-fluid px-0">

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.4rem;">
                            <i class="bi bi-trash3"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Total Data Terhapus</small>
                            <h4 class="fw-bold text-dark mb-0">{{ $totalTrashed }} Data</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.4rem;">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Fitur Perlindungan Data</small>
                            <h4 class="fw-bold text-dark mb-0" style="font-size: 1.1rem;">Soft Delete & Restore Aktif</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-3 d-flex align-items-center gap-3">
                        <div class="rounded-3 bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.4rem;">
                            <i class="bi bi-folder-symlink"></i>
                        </div>
                        <div>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Kategori Aktif</small>
                            <h4 class="fw-bold text-dark mb-0" style="font-size: 1.1rem;">{{ $config['label'] ?? 'Semua Kategori' }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-5 me-2 text-success"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-2 text-danger"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Category Nav Tabs -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-3">
                <ul class="nav nav-pills nav-fill flex-column flex-sm-row gap-2" id="trashTabs" role="tablist">
                    @php
                        $tabList = [
                            'keuangan'    => ['icon' => 'bi-wallet2', 'label' => 'Kas Keuangan'],
                            'donatur'     => ['icon' => 'bi-heart-fill', 'label' => 'Donatur'],
                            'kegiatan'    => ['icon' => 'bi-calendar-event', 'label' => 'Kegiatan'],
                            'kepanitiaan' => ['icon' => 'bi-people', 'label' => 'Kepanitiaan'],
                            'inventaris'  => ['icon' => 'bi-box-seam', 'label' => 'Inventaris'],
                            'catatan'     => ['icon' => 'bi-clipboard-check', 'label' => 'Catatan Kondisi'],
                            'galeri'      => ['icon' => 'bi-images', 'label' => 'Galeri Foto'],
                            'takmir'      => ['icon' => 'bi-person-badge', 'label' => 'Takmir / User'],
                            'kategori'    => ['icon' => 'bi-tags', 'label' => 'Kategori'],
                            'posisi'      => ['icon' => 'bi-award', 'label' => 'Posisi'],
                            'kondisi'     => ['icon' => 'bi-patch-check', 'label' => 'Kondisi'],
                        ];
                    @endphp

                    @foreach($tabList as $slug => $tab)
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-nowrap rounded-3 py-2 px-3 {{ $activeTab === $slug ? 'active fw-bold' : 'text-secondary' }}" 
                               href="{{ route('trash.index', ['tab' => $slug]) }}">
                                <i class="bi {{ $tab['icon'] }} me-1"></i> {{ $tab['label'] }}
                                @if($counts[$slug] > 0)
                                    <span class="badge {{ $activeTab === $slug ? 'bg-light text-primary' : 'bg-danger text-white' }} ms-1 rounded-pill">
                                        {{ $counts[$slug] }}
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Trashed Data Table Card -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history text-danger fs-5"></i>
                    <h5 class="fw-bold text-dark mb-0">Data Terhapus: {{ $config['label'] ?? ucfirst($activeTab) }}</h5>
                    <span class="badge bg-secondary-subtle text-secondary border px-2.5 py-1 rounded-pill">
                        {{ $trashedData->total() ?? $trashedData->count() }} Data
                    </span>
                </div>

                @if($trashedData->count() > 0)
                    <div class="d-flex gap-2">
                        <!-- Restore All in this Tab -->
                        <form action="{{ route('trash.restoreAll', $activeTab) }}" method="POST" onsubmit="return confirm('Pulihkan SEMUA data pada kategori {{ $config['label'] }} ini?')">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm fw-semibold">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Pulihkan Semua
                            </button>
                        </form>

                        <!-- Empty this Tab -->
                        <form action="{{ route('trash.empty', $activeTab) }}" method="POST" onsubmit="return confirm('PERINGATAN: Kosongkan seluruh data pada kategori {{ $config['label'] }} secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3 shadow-sm fw-semibold">
                                <i class="bi bi-trash me-1"></i> Kosongkan Tab Ini
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <div class="card-body p-4">
                @if($trashedData->isEmpty())
                    <div class="text-center py-5">
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 80px; height: 80px;">
                            <i class="bi bi-check-circle fs-1 text-success"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Tong Sampah Kosong</h5>
                        <p class="text-muted small mb-0">Tidak ada data <strong>{{ $config['label'] }}</strong> yang sedang berada di tong sampah.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle w-100">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 60px;">No</th>
                                    <th>Informasi Data</th>
                                    <th>Detail / Keterangan</th>
                                    <th style="min-width: 150px;">Dihapus Pada</th>
                                    <th class="text-center" style="width: 190px;">Aksi Pemulihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trashedData as $index => $item)
                                    <tr>
                                        <td class="text-center fw-semibold text-muted">
                                            {{ ($trashedData->currentPage() - 1) * $trashedData->perPage() + $loop->iteration }}
                                        </td>

                                        <!-- Detail Information based on Model Type -->
                                        <td>
                                            @if($activeTab === 'keuangan')
                                                <div class="fw-bold text-dark">Rp {{ number_format($item->nominal, 0, ',', '.') }}</div>
                                                <small class="text-muted d-block"><i class="bi bi-calendar3 me-1"></i>{{ $item->tanggal }} &bull; {{ $item->sumber_keuangan }}</small>
                                            @elseif($activeTab === 'donatur')
                                                <div class="fw-bold text-dark">{{ $item->nama_donatur }}</div>
                                                <small class="text-muted d-block"><i class="bi bi-telephone me-1"></i>{{ $item->telepon ?? '-' }}</small>
                                            @elseif($activeTab === 'kegiatan')
                                                <div class="fw-bold text-dark">{{ $item->nama_kegiatan }}</div>
                                                <small class="text-muted d-block"><i class="bi bi-calendar3 me-1"></i>{{ $item->tanggal }} ({{ $item->mulai_kegiatan }} - {{ $item->akhir_kegiatan }})</small>
                                            @elseif($activeTab === 'kepanitiaan')
                                                <div class="fw-bold text-dark">{{ $item->takmir?->nama_takmir ?? $item->takmir?->username ?? '-' }}</div>
                                                <small class="text-muted d-block"><i class="bi bi-award me-1"></i>{{ $item->posisi?->nama_posisi ?? '-' }} &bull; {{ $item->kegiatan?->nama_kegiatan ?? '-' }}</small>
                                            @elseif($activeTab === 'inventaris')
                                                <div class="fw-bold text-dark">{{ $item->nama_barang }}</div>
                                                <small class="text-muted d-block"><i class="bi bi-geo-alt me-1"></i>{{ $item->lokasi ?? '-' }} &bull; Jml: {{ $item->jumlah }}</small>
                                            @elseif($activeTab === 'catatan')
                                                <div class="fw-bold text-dark">{{ $item->inventaris?->nama_barang ?? 'Barang #'.$item->inventaris_id }}</div>
                                                <small class="text-muted d-block"><i class="bi bi-patch-check me-1"></i>Kondisi: {{ $item->kondisi?->nama_kondisi ?? '-' }} &bull; Tgl: {{ $item->tanggal_catatan }}</small>
                                            @elseif($activeTab === 'galeri')
                                                <div class="fw-bold text-dark">{{ $item->nama_foto }}</div>
                                                <small class="text-muted d-block"><i class="bi bi-calendar3 me-1"></i>{{ $item->tanggal }} &bull; {{ $item->kegiatan?->nama_kegiatan ?? 'Umum' }}</small>
                                            @elseif($activeTab === 'takmir')
                                                <div class="fw-bold text-dark">{{ $item->nama_takmir }}</div>
                                                <small class="text-muted d-block"><i class="bi bi-person me-1"></i>Username: {{ $item->username }} &bull; Role: {{ $item->role?->nama_role ?? '-' }}</small>
                                            @elseif($activeTab === 'kategori')
                                                <div class="fw-bold text-dark">{{ $item->nama_kategori }}</div>
                                            @elseif($activeTab === 'posisi')
                                                <div class="fw-bold text-dark">{{ $item->nama_posisi }}</div>
                                            @elseif($activeTab === 'kondisi')
                                                <div class="fw-bold text-dark">{{ $item->nama_kondisi }}</div>
                                            @endif
                                        </td>

                                        <!-- Extra Info -->
                                        <td>
                                            @if($activeTab === 'keuangan')
                                                <span class="badge bg-light text-dark border">{{ $item->kategori?->nama_kategori ?? 'Tanpa Kategori' }}</span>
                                                <small class="text-muted d-block mt-1">{{ Str::limit($item->keterangan, 40) }}</small>
                                            @elseif($activeTab === 'donatur')
                                                <span class="text-muted small">{{ $item->alamat ?? 'Alamat tidak diisi' }}</span>
                                            @elseif($activeTab === 'kegiatan')
                                                <span class="text-muted small"><i class="bi bi-geo-alt me-1"></i>{{ $item->tempat ?? '-' }} &bull; Pem: {{ $item->pembicara ?? '-' }}</span>
                                            @elseif($activeTab === 'inventaris')
                                                <span class="text-muted small">{{ $item->keterangan ?? 'Tidak ada keterangan' }}</span>
                                            @elseif($activeTab === 'galeri' && !empty($item->gambar))
                                                <span class="badge bg-info-subtle text-info border border-info-subtle"><i class="bi bi-image me-1"></i>Ada Foto Berkas</span>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>

                                        <!-- Deleted Time -->
                                        <td>
                                            <div class="fw-semibold text-danger">
                                                <i class="bi bi-clock me-1"></i>{{ $item->deleted_at->diffForHumans() }}
                                            </div>
                                            <small class="text-muted" style="font-size: 0.75rem;">
                                                {{ $item->deleted_at->format('d M Y, H:i') }}
                                            </small>
                                        </td>

                                        <!-- Action Buttons -->
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <!-- Restore Button -->
                                                <form action="{{ route('trash.restore', [$activeTab, $item->id]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm shadow-sm" title="Pulihkan Data Ini">
                                                        <i class="bi bi-arrow-counterclockwise me-1"></i> Pulihkan
                                                    </button>
                                                </form>

                                                <!-- Force Delete Button -->
                                                <form action="{{ route('trash.forceDelete', [$activeTab, $item->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('PERINGATAN: Hapus data ini secara permanen dari database?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm shadow-sm" title="Hapus Permanen">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                        <small class="text-muted">
                            Menampilkan {{ $trashedData->firstItem() ?? 0 }} - {{ $trashedData->lastItem() ?? 0 }} dari {{ $trashedData->total() ?? 0 }} data terhapus
                        </small>
                        <div>
                            {{ $trashedData->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
</main>

@include('layouts.footer')
