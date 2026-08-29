<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Admin-specific menu items -->
        @if(Auth::check() && Auth::user()->role->nama_role == 'admin')
        <li class="nav-item">
            <a class="nav-link collapsed" href="/admin-dashboard">
                <i class="bi bi-house-door"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('takmir.index') }}">
                <i class="bi bi-people"></i>
                <span>Kelola Pengguna</span>
            </a>
        </li>
        <!---<li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-cash"></i><span>Keuangan</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('keuangan.index') }}">
                        <i class="bi bi-circle"></i><span>Keuangan Umum</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('donatur.index') }}">
                        <i class="bi bi-circle"></i><span>Donatur</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.keuangan') }}">
                        <i class="bi bi-circle"></i><span>Laporan</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-calendar-week"></i><span>Kegiatan</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('kegiatan.index') }}">
                        <i class="bi bi-circle"></i><span>Jadwal Kegiatan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kepanitiaan.index') }}">
                        <i class="bi bi-circle"></i><span>Kepanitiaan</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-clipboard-check"></i><span>Inventaris</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('inventaris.index') }}">
                        <i class="bi bi-circle"></i><span>Data Barang</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('catatan.index') }}">
                        <i class="bi bi-circle"></i><span>Catatan Barang</span>
                    </a>
                </li>
            </ul>
        </li>-->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('profilmasjid.index') }}">
                <i class="ri-building-2-line"></i>
                <span>Profil Masjid</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('galeri.index') }}">
                <i class="bi bi-images"></i>
                <span>Galeri</span>
            </a>
        </li>
        @endif

        <!-- Bendahara-specific menu items -->
        @if(Auth::check() && Auth::user()->role->nama_role == 'bendahara')
        <li class="nav-item">
            <a class="nav-link collapsed" href="/bendahara-dashboard">
                <i class="bi bi-house-door"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-cash"></i><span>Keuangan</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('keuangan.index') }}">
                        <i class="bi bi-circle"></i><span>Keuangan Umum</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('donatur.index') }}">
                        <i class="bi bi-circle"></i><span>Donatur</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.keuangan') }}">
                        <i class="bi bi-circle"></i><span>Laporan</span>
                    </a>
                </li>
            </ul>
        </li>
        @endif

        <!-- Sekretaris-specific menu items -->
        @if(Auth::check() && Auth::user()->role->nama_role == 'sekretaris')
        <li class="nav-item">
            <a class="nav-link collapsed" href="/sekretaris-dashboard">
                <i class="bi bi-house-door"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-calendar-week"></i><span>Kegiatan</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('kegiatan.index') }}">
                        <i class="bi bi-circle"></i><span>Jadwal Kegiatan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kepanitiaan.index') }}">
                        <i class="bi bi-circle"></i><span>Kepanitiaan</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-clipboard-check"></i><span>Inventaris</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('inventaris.index') }}">
                        <i class="bi bi-circle"></i><span>Data Barang</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('catatan.index') }}">
                        <i class="bi bi-circle"></i><span>Catatan Barang</span>
                    </a>
                </li>
            </ul>
        </li>
        <!--<li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('galeri.index') }}">
                <i class="bi bi-images"></i>
                <span>Galeri</span>
            </a>
        </li>-->
        @endif



    </ul>
</aside><!-- End Sidebar-->
