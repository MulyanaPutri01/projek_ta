@section('title', 'Edit Pengguna')
@include('layouts.header')
@include('layouts.sidebar')

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Edit Akun Pengguna</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Manajemen Pengguna</a></li>
                    <li class="breadcrumb-item active">Edit Pengguna</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div><!-- End Page Title -->

    <div class="container-fluid px-0">
        <form action="{{ route('users.update', $takmir->id) }}" method="POST" id="formEditUser">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <!-- ================= LEFT COLUMN: FORM INPUTS ================= -->
                <div class="col-xl-8 col-lg-7">
                    
                    <!-- 1. IDENTITAS PENGGUNA -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-2 me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-person-gear fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Identitas Akun Pengguna</h6>
                                <small class="text-muted">Informasi dasar pengguna untuk akses sistem manajemen masjid</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-dark">Nama Lengkap Pengguna <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
                                        <input type="text" name="nama_takmir" id="input_nama_takmir" class="form-control" 
                                            placeholder="Contoh: Muhammad Rizki, S.Kom" 
                                            value="{{ old('nama_takmir', $takmir->nama_takmir) }}" required maxlength="50" autocomplete="off">
                                    </div>
                                    <small class="text-muted" style="font-size: 0.75rem;">Nama pengguna yang akan ditampilkan pada sistem dan riwayat log.</small>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-dark">Username Login <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted fw-bold">@</span>
                                        <input type="text" name="username" id="input_username" class="form-control" 
                                            placeholder="contoh: m_rizki" 
                                            value="{{ old('username', $takmir->username) }}" required maxlength="30" autocomplete="off">
                                    </div>
                                    <small class="text-muted" style="font-size: 0.75rem;">Username unik untuk proses autentikasi login pengguna.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. STATUS AKUN -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                            <div class="rounded-circle bg-info bg-opacity-10 text-info p-2 me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-toggle-on fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Status Akses Akun <span class="text-danger">*</span></h6>
                                <small class="text-muted">Tentukan apakah akun ini diizinkan login atau ditangguhkan</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="status-card-label d-block cursor-pointer">
                                        <input type="radio" name="status" value="active" class="status-radio d-none" 
                                            {{ old('status', $takmir->status) == 'active' ? 'checked' : '' }} required>
                                        <div class="card border status-card p-3 h-100 transition-all">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="rounded-circle bg-success-subtle text-success p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-check-circle-fill fs-5"></i>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold text-dark mb-0">Aktif (Diberi Izin)</h6>
                                                    <small class="text-muted" style="font-size: 0.75rem;">Pengguna dapat langsung login ke sistem</small>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div class="col-md-6">
                                    <label class="status-card-label d-block cursor-pointer">
                                        <input type="radio" name="status" value="inactive" class="status-radio d-none" 
                                            {{ old('status', $takmir->status) == 'inactive' ? 'checked' : '' }}>
                                        <div class="card border status-card p-3 h-100 transition-all">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="rounded-circle bg-danger-subtle text-danger p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-slash-circle-fill fs-5"></i>
                                                </div>
                                                <div>
                                                    <h6 class="fw-bold text-dark mb-0">Nonaktif (Ditangguhkan)</h6>
                                                    <small class="text-muted" style="font-size: 0.75rem;">Akses login akun diblokir sementara</small>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. PEMILIHAN PERAN & HAK AKSES (VISUAL ROLE CARDS) -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                            <div class="rounded-circle bg-success bg-opacity-10 text-success p-2 me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-shield-lock fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Peran & Tingkat Hak Akses <span class="text-danger">*</span></h6>
                                <small class="text-muted">Pilih wewenang dan izin modul yang diberikan</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                @foreach($roles as $role)
                                    @php
                                        $roleSlug = strtolower($role->nama_role);
                                        $isSelected = (old('role_id', $takmir->role_id) == $role->id);
                                        
                                        $roleIcon = 'bi-shield-check';
                                        $roleColor = 'primary';
                                        $roleTitle = ucfirst($role->nama_role);
                                        $roleDesc = 'Hak akses kustom sesuai penugasan';
                                        $permissionsList = ['Akses Terbatas Sesuai Wewenang'];

                                        if (str_contains($roleSlug, 'admin')) {
                                            $roleIcon = 'bi-shield-lock-fill';
                                            $roleColor = 'primary';
                                            $roleTitle = 'Administrator';
                                            $roleDesc = 'Akses penuh tanpa batas ke seluruh modul, master data, keuangan, dan pengaturan akun';
                                            $permissionsList = ['Kelola Seluruh Modul', 'Kelola Pengguna & Peran', 'Profil & Laporan'];
                                        } elseif (str_contains($roleSlug, 'bendahara')) {
                                            $roleIcon = 'bi-wallet-fill';
                                            $roleColor = 'success';
                                            $roleTitle = 'Bendahara Kas';
                                            $roleDesc = 'Fokus pada pencatatan kas masuk/keluar, buku kas umum, donatur, dan cetak PDF laporan';
                                            $permissionsList = ['Transaksi Kas Masuk & Keluar', 'Kelola Donatur Masjid', 'Cetak Laporan Keuangan PDF'];
                                        } elseif (str_contains($roleSlug, 'sekretaris')) {
                                            $roleIcon = 'bi-calendar-check-fill';
                                            $roleColor = 'warning';
                                            $roleTitle = 'Sekretaris';
                                            $roleDesc = 'Fokus pada manajemen agenda kegiatan, struktur kepanitiaan, inventaris masjid, dan galeri';
                                            $permissionsList = ['Jadwal & Agenda Kegiatan', 'Susunan Kepanitiaan & SK PDF', 'Inventaris Barang & Kondisi'];
                                        }
                                    @endphp

                                    <div class="col-md-12">
                                        <label class="role-card-label d-block cursor-pointer position-relative">
                                            <input type="radio" name="role_id" value="{{ $role->id }}" 
                                                class="role-radio-input d-none" 
                                                data-role-name="{{ $roleTitle }}"
                                                data-role-color="{{ $roleColor }}"
                                                data-role-desc="{{ $roleDesc }}"
                                                data-role-perms="{{ implode(',', $permissionsList) }}"
                                                {{ $isSelected ? 'checked' : '' }} required>
                                            
                                            <div class="card role-card border h-100 p-3 transition-all">
                                                <div class="d-flex align-items-start gap-3">
                                                    <div class="rounded-3 bg-{{ $roleColor }}-subtle text-{{ $roleColor }} p-3 d-flex align-items-center justify-content-center fs-3" style="width: 54px; height: 54px; flex-shrink: 0;">
                                                        <i class="bi {{ $roleIcon }}"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <h6 class="fw-bold text-dark mb-0">{{ $roleTitle }}</h6>
                                                            <span class="role-checked-badge badge bg-{{ $roleColor }} rounded-pill px-2 py-1 small">
                                                                <i class="bi bi-check-lg me-1"></i> Terpilih
                                                            </span>
                                                        </div>
                                                        <p class="small text-muted mb-2">{{ $roleDesc }}</p>
                                                        
                                                        <div class="d-flex flex-wrap gap-1">
                                                            @foreach($permissionsList as $perm)
                                                                <span class="badge bg-light text-secondary border small fw-normal">
                                                                    <i class="bi bi-check2 text-{{ $roleColor }} me-1"></i>{{ $perm }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- 4. KEAMANAN & PASSWORD -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                            <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-2 me-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-key-fill fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Ubah Kata Sandi (Opsional)</h6>
                                <small class="text-muted">Biarkan kolom password kosong jika tidak ingin mengubah kata sandi pengguna</small>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Password Baru</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
                                        <input type="password" name="password" id="input_password" class="form-control" 
                                            placeholder="Kosongkan jika tidak diubah" minlength="8">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="input_password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div class="progress mt-2" style="height: 4px;">
                                        <div id="password_strength_bar" class="progress-bar" role="progressbar" style="width: 0%;"></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-1">
                                        <small id="password_strength_text" class="text-muted" style="font-size: 0.72rem;">Kekuatan: -</small>
                                        <small class="text-muted" style="font-size: 0.72rem;">Minimal 8 karakter</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Konfirmasi Ulang Password Baru</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-lock-fill"></i></span>
                                        <input type="password" name="password_confirmation" id="input_password_confirm" class="form-control" 
                                            placeholder="Ulangi password baru" minlength="8">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="input_password_confirm">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <div class="mt-1">
                                        <small id="password_match_status" class="text-muted" style="font-size: 0.75rem;">
                                            <i class="bi bi-info-circle me-1"></i> Kosongkan jika password tidak diganti.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="d-flex justify-content-end gap-2 mb-5">
                        <a href="{{ route('users.index') }}" class="btn btn-light px-4 border">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm fw-semibold">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan Pengguna
                        </button>
                    </div>

                </div>

                <!-- ================= RIGHT COLUMN: LIVE DIGITAL USER PREVIEW ================= -->
                <div class="col-xl-4 col-lg-5">
                    <div class="sticky-top" style="top: 85px; z-index: 10;">
                        
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="small fw-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">
                                <i class="bi bi-person-badge me-1"></i> Pratinjau ID Pengguna
                            </span>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Live Preview</span>
                        </div>

                        <!-- Card Preview -->
                        <div class="card border-0 shadow rounded-4 overflow-hidden mb-3" style="background: #ffffff;">
                            <!-- Top Decorative Banner -->
                            <div id="preview_banner" class="p-4 text-center text-white position-relative" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                                <div class="position-absolute top-0 end-0 p-3 opacity-25">
                                    <i class="bi bi-shield-check" style="font-size: 4rem;"></i>
                                </div>
                                <small class="text-white-50 text-uppercase fw-semibold letter-spacing-1 d-block" style="font-size: 0.7rem;">SISTEM MANAJEMEN MASJID</small>
                                <h6 class="fw-bold mb-0 text-white">MASJID AL-IKHLAS</h6>
                                <small class="text-white-75" style="font-size: 0.75rem;">Karangmulya, Suradadi, Tegal</small>
                            </div>

                            <!-- Avatar & Details -->
                            <div class="card-body p-4 text-center" style="margin-top: -35px;">
                                <div id="preview_avatar" class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold fs-2 mx-auto shadow border border-3 border-white mb-3" 
                                    style="width: 72px; height: 72px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                                    {{ strtoupper(substr($takmir->nama_takmir, 0, 1)) }}
                                </div>

                                <h5 id="preview_name" class="fw-bold text-dark mb-1">{{ $takmir->nama_takmir }}</h5>
                                <div class="mb-3">
                                    <span id="preview_username" class="badge bg-light text-secondary border px-2 py-1 small">
                                        <i class="bi bi-at"></i>{{ $takmir->username }}
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <span id="preview_role_badge" class="badge bg-primary px-3 py-1.5 text-uppercase fw-semibold shadow-sm">
                                        <i class="bi bi-shield-lock me-1"></i> {{ strtoupper($takmir->role?->nama_role ?? 'PENGGUNA') }}
                                    </span>
                                </div>

                                <div class="bg-light rounded-3 p-3 text-start mb-3 border">
                                    <div class="d-flex justify-content-between align-items-center pb-2 border-bottom mb-2">
                                        <small class="text-muted">Status Akun</small>
                                        @if($takmir->status === 'active')
                                            <span id="preview_status_badge" class="badge bg-success-subtle text-success border border-success-subtle">
                                                <i class="bi bi-check-circle me-1"></i> Aktif Diizinkan
                                            </span>
                                        @else
                                            <span id="preview_status_badge" class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                                <i class="bi bi-slash-circle me-1"></i> Nonaktif
                                            </span>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center pb-2 border-bottom mb-2">
                                        <small class="text-muted">ID Pengguna</small>
                                        <span class="fw-semibold text-dark small">USR-{{ str_pad($takmir->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Terdaftar Pada</small>
                                        <span class="fw-semibold text-dark small">{{ \Carbon\Carbon::parse($takmir->created_at)->translatedFormat('d M Y') }}</span>
                                    </div>
                                </div>

                                <div class="text-start">
                                    <small class="fw-bold text-dark d-block mb-1" style="font-size: 0.75rem;">Cakupan Wewenang Modul:</small>
                                    <ul id="preview_perms_list" class="list-unstyled mb-0 small text-muted">
                                        <li><i class="bi bi-check-circle-fill text-success me-1"></i> Akses Modul Sistem</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-footer bg-light border-top text-center py-2 text-muted" style="font-size: 0.72rem;">
                                <i class="bi bi-shield-check text-success me-1"></i> Terotentikasi SIMAS Manajemen Masjid
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

@include('layouts.footer')

<style>
    .cursor-pointer { cursor: pointer; }
    .transition-all { transition: all 0.2s ease-in-out; }
    
    .role-card, .status-card {
        border-color: #e2e8f0;
        background: #ffffff;
    }
    .role-card:hover, .status-card:hover {
        border-color: #94a3b8;
        transform: translateY(-2px);
    }
    .role-radio-input:checked + .role-card {
        border-color: #0d6efd !important;
        border-width: 2px !important;
        background: #eff6ff !important;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.12) !important;
    }
    .role-radio-input:not(:checked) + .role-card .role-checked-badge {
        display: none !important;
    }

    .status-radio:checked + .status-card {
        border-color: #0d6efd !important;
        border-width: 2px !important;
        background: #f8fafc !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const inputNama = document.getElementById('input_nama_takmir');
        const inputUser = document.getElementById('input_username');
        const inputPass = document.getElementById('input_password');
        const inputPassConfirm = document.getElementById('input_password_confirm');
        
        const previewName = document.getElementById('preview_name');
        const previewUsername = document.getElementById('preview_username');
        const previewAvatar = document.getElementById('preview_avatar');
        const previewRoleBadge = document.getElementById('preview_role_badge');
        const previewPermsList = document.getElementById('preview_perms_list');
        const previewStatusBadge = document.getElementById('preview_status_badge');

        // 1. Live Name & Avatar Update
        inputNama.addEventListener('input', function() {
            const val = this.value.trim();
            previewName.textContent = val || '{{ $takmir->nama_takmir }}';
            previewAvatar.textContent = val ? val.charAt(0).toUpperCase() : '{{ strtoupper(substr($takmir->nama_takmir, 0, 1)) }}';
        });

        // 2. Live Username Update
        inputUser.addEventListener('input', function() {
            this.value = this.value.toLowerCase().replace(/[^a-z0-9_]/g, '');
            previewUsername.innerHTML = `<i class="bi bi-at"></i>${this.value || '{{ $takmir->username }}'}`;
        });

        // 3. Live Status Update
        document.querySelectorAll('.status-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'active') {
                    previewStatusBadge.className = 'badge bg-success-subtle text-success border border-success-subtle';
                    previewStatusBadge.innerHTML = '<i class="bi bi-check-circle me-1"></i> Aktif Diizinkan';
                } else {
                    previewStatusBadge.className = 'badge bg-danger-subtle text-danger border border-danger-subtle';
                    previewStatusBadge.innerHTML = '<i class="bi bi-slash-circle me-1"></i> Nonaktif';
                }
            });
        });

        // 4. Live Role Card Selection Handler
        const roleRadios = document.querySelectorAll('.role-radio-input');
        function updateRolePreview() {
            const checkedRadio = document.querySelector('.role-radio-input:checked');
            if (checkedRadio) {
                const roleName = checkedRadio.getAttribute('data-role-name');
                const roleColor = checkedRadio.getAttribute('data-role-color');
                const perms = checkedRadio.getAttribute('data-role-perms').split(',');

                previewRoleBadge.className = `badge bg-${roleColor} px-3 py-1.5 text-uppercase fw-semibold shadow-sm`;
                previewRoleBadge.innerHTML = `<i class="bi bi-shield-check me-1"></i> ${roleName}`;

                previewPermsList.innerHTML = perms.map(p => `<li><i class="bi bi-check-circle-fill text-${roleColor} me-1"></i> ${p}</li>`).join('');
            }
        }

        roleRadios.forEach(radio => {
            radio.addEventListener('change', updateRolePreview);
        });
        updateRolePreview(); // Init

        // 5. Toggle Show/Hide Password
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'bi bi-eye-slash';
                } else {
                    input.type = 'password';
                    icon.className = 'bi bi-eye';
                }
            });
        });

        // 6. Live Password Strength Meter
        inputPass.addEventListener('input', function() {
            const val = this.value;
            const bar = document.getElementById('password_strength_bar');
            const text = document.getElementById('password_strength_text');

            if (!val) {
                bar.style.width = '0%';
                text.textContent = 'Kekuatan: -';
                text.className = 'text-muted';
                return;
            }

            let strength = 0;
            if (val.length >= 8) strength += 30;
            if (val.length >= 10) strength += 20;
            if (/[A-Z]/.test(val)) strength += 20;
            if (/[0-9]/.test(val)) strength += 15;
            if (/[^A-Za-z0-9]/.test(val)) strength += 15;

            bar.style.width = strength + '%';

            if (strength <= 30) {
                bar.className = 'progress-bar bg-danger';
                text.textContent = 'Kekuatan: Sangat Lemah';
                text.className = 'text-danger fw-semibold';
            } else if (strength <= 70) {
                bar.className = 'progress-bar bg-warning';
                text.textContent = 'Kekuatan: Cukup Kuat';
                text.className = 'text-warning-emphasis fw-semibold';
            } else {
                bar.className = 'progress-bar bg-success';
                text.textContent = 'Kekuatan: Sangat Aman';
                text.className = 'text-success fw-semibold';
            }

            checkPasswordMatch();
        });

        // 7. Live Password Match Checker
        function checkPasswordMatch() {
            const pass = inputPass.value;
            const confirm = inputPassConfirm.value;
            const matchStatus = document.getElementById('password_match_status');

            if (!pass && !confirm) {
                matchStatus.innerHTML = '<i class="bi bi-info-circle me-1"></i> Kosongkan jika password tidak diganti.';
                matchStatus.className = 'text-muted';
                return;
            }

            if (!confirm) {
                matchStatus.innerHTML = '<i class="bi bi-info-circle me-1"></i> Ulangi password baru.';
                matchStatus.className = 'text-muted';
                return;
            }

            if (pass === confirm) {
                matchStatus.innerHTML = '<i class="bi bi-check-circle-fill text-success me-1"></i> Password baru cocok & terkonfirmasi!';
                matchStatus.className = 'text-success fw-semibold';
            } else {
                matchStatus.innerHTML = '<i class="bi bi-x-circle-fill text-danger me-1"></i> Password baru tidak sama!';
                matchStatus.className = 'text-danger fw-semibold';
            }
        }

        inputPassConfirm.addEventListener('input', checkPasswordMatch);
    });
</script>
