<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- ==========================================
             Dynamic Dashboard Navigation
             ========================================== -->
        <li class="nav-heading">MENU UTAMA</li>
        @php
            $currentRoleName = strtolower(Auth::user()?->role?->nama_role ?? (Auth::user()?->roles->first()?->name ?? ''));
        @endphp
        @if ($currentRoleName === 'admin' || Auth::user()?->hasRole('admin') || Auth::user()?->can('role-list') || Auth::user()?->can('user-list'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? '' : 'collapsed' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard Admin</span>
                </a>
            </li>
        @elseif($currentRoleName === 'bendahara' || Auth::user()?->hasRole('bendahara') || Auth::user()?->can('keuangan-list'))
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('bendahara.dashboard') ? '' : 'collapsed' }}"
                    href="{{ route('bendahara.dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard Bendahara</span>
                </a>
            </li>
        @else
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('sekretaris.dashboard') ? '' : 'collapsed' }}"
                    href="{{ route('sekretaris.dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard Sekretaris</span>
                </a>
            </li>
        @endif

        <!-- ==========================================
             Manajemen Pengguna & Hak Akses
             ========================================== -->
        @canany(['user-list', 'role-list'])
            <li class="nav-heading">MANAJEMEN PENGGUNA</li>
            @can('user-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('takmir.*') ? '' : 'collapsed' }}"
                        href="{{ route('takmir.index') }}">
                        <i class="bi bi-people"></i>
                        <span>Kelola Takmir</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.*') ? '' : 'collapsed' }}"
                        href="{{ route('users.index') }}">
                        <i class="bi bi-person-gear"></i>
                        <span>Kelola Pengguna</span>
                    </a>
                </li>
            @endcan

            @can('role-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('roles.*') ? '' : 'collapsed' }}"
                        href="{{ route('roles.index') }}">
                        <i class="bi bi-shield-lock"></i>
                        <span>Kelola Peran (Roles)</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('permissions.*') ? '' : 'collapsed' }}"
                        href="{{ route('permissions.index') }}">
                        <i class="bi bi-key"></i>
                        <span>Kelola Hak Akses (Permissions)</span>
                    </a>
                </li>
            @endcan
        @endcanany

        <!-- ==========================================
             Manajemen Keuangan
             ========================================== -->
        @canany(['keuangan-list', 'donatur-list', 'kategori-list', 'laporan-view'])
            <li class="nav-heading">MANAJEMEN KEUANGAN</li>
            @php
                $isKeuanganActive =
                    request()->routeIs('keuangan.*') ||
                    request()->routeIs('donatur.*') ||
                    request()->routeIs('laporan.*') ||
                    request()->routeIs('kategori.*');
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ $isKeuanganActive ? '' : 'collapsed' }}" data-bs-target="#keuangan-nav"
                    data-bs-toggle="collapse" href="#">
                    <i class="bi bi-cash-stack"></i><span>Kas & Keuangan</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="keuangan-nav" class="nav-content collapse {{ $isKeuanganActive ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    @can('keuangan-list')
                        <li>
                            <a href="{{ route('keuangan.index') }}"
                                class="{{ request()->routeIs('keuangan.*') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Transaksi Keuangan</span>
                            </a>
                        </li>
                    @endcan
                    @can('donatur-list')
                        <li>
                            <a href="{{ route('donatur.index') }}"
                                class="{{ request()->routeIs('donatur.*') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Data Donatur</span>
                            </a>
                        </li>
                    @endcan
                    @can('kategori-list')
                        <li>
                            <a href="{{ route('kategori.index') }}"
                                class="{{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Kategori Kas</span>
                            </a>
                        </li>
                    @endcan
                    @can('laporan-view')
                        <li>
                            <a href="{{ route('laporan.keuangan') }}"
                                class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Laporan Keuangan</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany

        <!-- ==========================================
             Agenda & Kegiatan
             ========================================== -->
        @canany(['kegiatan-list', 'kepanitiaan-list', 'posisi-manage', 'kegiatan-calendar'])
            <li class="nav-heading">AGENDA & KEGIATAN</li>
            @php
                $isKegiatanActive =
                    request()->routeIs('kegiatan.*') ||
                    request()->routeIs('kepanitiaan.*') ||
                    request()->routeIs('posisi.*');
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ $isKegiatanActive ? '' : 'collapsed' }}" data-bs-target="#kegiatan-nav"
                    data-bs-toggle="collapse" href="#">
                    <i class="bi bi-calendar-event"></i><span>Kegiatan & Acara</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="kegiatan-nav" class="nav-content collapse {{ $isKegiatanActive ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    @can('kegiatan-list')
                        <li>
                            <a href="{{ route('kegiatan.index') }}"
                                class="{{ request()->routeIs('kegiatan.index') || request()->routeIs('kegiatan.create') || request()->routeIs('kegiatan.edit') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Jadwal Kegiatan</span>
                            </a>
                        </li>
                    @endcan
                    @can('kepanitiaan-list')
                        <li>
                            <a href="{{ route('kepanitiaan.index') }}"
                                class="{{ request()->routeIs('kepanitiaan.*') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Kepanitiaan</span>
                            </a>
                        </li>
                    @endcan
                    @can('posisi-manage')
                        <li>
                            <a href="{{ route('posisi.index') }}"
                                class="{{ request()->routeIs('posisi.*') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Master Posisi</span>
                            </a>
                        </li>
                    @endcan
                    @can('kegiatan-calendar')
                        <li>
                            <a href="{{ route('kegiatan.calendar') }}"
                                class="{{ request()->routeIs('kegiatan.calendar') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Kalender Agenda</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany

        <!-- ==========================================
             Inventaris Masjid
             ========================================== -->
        @canany(['inventaris-list', 'catatan-list', 'kondisi-manage'])
            <li class="nav-heading">INVENTARIS MASJID</li>
            @php
                $isInventarisActive =
                    request()->routeIs('inventaris.*') ||
                    request()->routeIs('catatan.*') ||
                    request()->routeIs('kondisi.*');
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ $isInventarisActive ? '' : 'collapsed' }}" data-bs-target="#inventaris-nav"
                    data-bs-toggle="collapse" href="#">
                    <i class="bi bi-box-seam"></i><span>Inventaris Barang</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="inventaris-nav" class="nav-content collapse {{ $isInventarisActive ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">
                    @can('inventaris-list')
                        <li>
                            <a href="{{ route('inventaris.index') }}"
                                class="{{ request()->routeIs('inventaris.*') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Data Barang</span>
                            </a>
                        </li>
                    @endcan
                    @can('catatan-list')
                        <li>
                            <a href="{{ route('catatan.index') }}"
                                class="{{ request()->routeIs('catatan.*') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Catatan Kondisi</span>
                            </a>
                        </li>
                    @endcan
                    @can('kondisi-manage')
                        <li>
                            <a href="{{ route('kondisi.index') }}"
                                class="{{ request()->routeIs('kondisi.*') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i><span>Master Kondisi</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany

        <!-- ==========================================
             Informasi & Publikasi
             ========================================== -->
        @canany(['profilmasjid-view', 'galeri-list'])
            <li class="nav-heading">INFORMASI & PUBLIKASI</li>
            @can('profilmasjid-view')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profilmasjid.*') ? '' : 'collapsed' }}"
                        href="{{ route('profilmasjid.index') }}">
                        <i class="ri-building-2-line"></i>
                        <span>Profil Masjid</span>
                    </a>
                </li>
            @endcan
            @can('galeri-list')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('galeri.*') ? '' : 'collapsed' }}"
                        href="{{ route('galeri.index') }}">
                        <i class="bi bi-images"></i>
                        <span>Galeri Dokumentasi</span>
                    </a>
                </li>
            @endcan
        @endcanany

        <!-- ==========================================
             Smart TV Digital Signage
             ========================================== -->
        <li class="nav-heading">SMART TV SIGNAGE</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.display.*') ? '' : 'collapsed' }}"
                href="{{ route('admin.display.setting') }}">
                <i class="bi bi-tv"></i>
                <span>Pengaturan Smart TV</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" target="_blank"
                href="{{ route('display.index') }}">
                <i class="bi bi-box-arrow-up-right text-success"></i>
                <span>Buka Layar Smart TV</span>
            </a>
        </li>

        <!-- ==========================================
             Pusat Pemulihan Data (Recycle Bin / Trash)
             ========================================== -->
        <li class="nav-heading">PEMULIHAN DATA</li>
        <li class="nav-item">
            @php
                $trashedCount = \App\Models\Keuangan::onlyTrashed()->count()
                    + \App\Models\Donatur::onlyTrashed()->count()
                    + \App\Models\Kegiatan::onlyTrashed()->count()
                    + \App\Models\Inventaris::onlyTrashed()->count()
                    + \App\Models\Takmir::onlyTrashed()->count();
            @endphp
            <a class="nav-link {{ request()->routeIs('trash.*') ? '' : 'collapsed' }}"
                href="{{ route('trash.index') }}">
                <i class="bi bi-recycle text-success"></i>
                <span>Pusat Pemulihan (Trash)</span>
                @if($trashedCount > 0)
                    <span class="badge bg-danger text-white rounded-pill ms-auto px-2 py-0.5" style="font-size: 0.7rem;">
                        {{ $trashedCount }}
                    </span>
                @endif
            </a>
        </li>

    </ul>
</aside><!-- End Sidebar-->
