@section('title', 'Kelola Peran & Hak Akses')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Peran & Hak Akses (Role & Permissions)</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item active">Peran & Hak Akses</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('roles.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-shield-plus me-1"></i> Tambah Peran Baru
        </a>
    </div>

    <div class="container-fluid px-0">

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

        <!-- Role Cards Grid -->
        <div class="row g-4 mb-4">
            @foreach($roles as $role)
                @php
                    $isSystem = in_array(strtolower($role->name), ['admin', 'bendahara', 'sekretaris']);
                    $colorMap = [
                        'admin' => ['bg' => 'bg-primary-light', 'text' => 'text-primary', 'icon' => 'bi-shield-lock-fill', 'badge' => 'bg-primary'],
                        'bendahara' => ['bg' => 'bg-success-light', 'text' => 'text-success', 'icon' => 'bi-cash-coin', 'badge' => 'bg-success'],
                        'sekretaris' => ['bg' => 'bg-warning-light', 'text' => 'text-warning', 'icon' => 'bi-file-earmark-text-fill', 'badge' => 'bg-warning'],
                    ];
                    $theme = $colorMap[strtolower($role->name)] ?? ['bg' => 'bg-info-light', 'text' => 'text-info', 'icon' => 'bi-shield-check', 'badge' => 'bg-info'];
                @endphp
                <div class="col-xl-4 col-md-6 col-12">
                    <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="rounded-3 {{ $theme['bg'] }} {{ $theme['text'] }} d-flex align-items-center justify-content-center shadow-sm" style="width: 50px; height: 50px; font-size: 1.5rem;">
                                    <i class="bi {{ $theme['icon'] }}"></i>
                                </div>
                                <span class="badge {{ $theme['badge'] }} px-3 py-2 rounded-pill text-uppercase">
                                    {{ $role->name }}
                                </span>
                            </div>

                            <h5 class="fw-bold text-dark mb-1">{{ ucfirst($role->name) }}</h5>
                            <p class="text-muted small mb-3">
                                <i class="bi bi-people me-1"></i> Digunakan oleh <strong>{{ $role->users->count() }}</strong> pengguna takmir
                            </p>

                            <hr class="my-2">

                            <div class="my-2 flex-grow-1">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small fw-bold text-muted text-uppercase">Hak Akses Aktif:</span>
                                    <span class="badge bg-secondary rounded-pill">{{ $role->permissions->count() }} Izin</span>
                                </div>
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse($role->permissions->take(6) as $perm)
                                        <span class="badge bg-light text-dark border small">{{ $perm->name }}</span>
                                    @empty
                                        <span class="text-muted small italic">Belum ada izin khusus</span>
                                    @endforelse
                                    @if($role->permissions->count() > 6)
                                        <span class="badge bg-light text-primary border small">+{{ $role->permissions->count() - 6 }} lainnya</span>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-3 mt-3 border-top">
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm px-3 shadow-sm">
                                    <i class="bi bi-sliders me-1"></i> Atur Hak Akses
                                </a>
                                @if(!$isSystem)
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Hapus peran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small"><i class="bi bi-lock-fill me-1"></i>Peran Sistem</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</main>

@include('layouts.footer')
