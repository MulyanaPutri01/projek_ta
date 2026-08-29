@section('title', 'Kalender Agenda Kegiatan')
@include('layouts.header')
@include('layouts.sidebar')

<!-- FullCalendar 6 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/id.global.min.js"></script>

<main id="main" class="main">
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="fw-bold fs-3 text-dark mb-1">Kalender Agenda Kegiatan</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="bi bi-house-door me-1"></i> Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kegiatan.index') }}">Jadwal Kegiatan</a></li>
                    <li class="breadcrumb-item active">Tampilan Kalender</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('kegiatan.index') }}" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-table me-1"></i> Tampilan Tabel
            </a>
            <a href="{{ route('kegiatan.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-calendar-plus-fill me-1"></i> Tambah Agenda
            </a>
        </div>
    </div><!-- End Page Title -->

    <div class="container-fluid px-0">

        <!-- Summary Metric Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-4 col-md-4">
                <div class="card border-0 shadow-sm h-100 mb-0" style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; font-size: 1.5rem;">
                                <i class="bi bi-calendar-range-fill"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-primary fw-bold small text-uppercase letter-spacing-1">Total Agenda</span>
                                <h3 class="fw-extrabold text-dark mb-0 fs-2">{{ $totalKegiatan }}</h3>
                                <small class="text-muted">Semua Kegiatan Terjadwal</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-4">
                <div class="card border-0 shadow-sm h-100 mb-0" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 bg-success text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; font-size: 1.5rem;">
                                <i class="bi bi-calendar-month-fill"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-success fw-bold small text-uppercase letter-spacing-1">Bulan Ini</span>
                                <h3 class="fw-extrabold text-dark mb-0 fs-2">{{ $bulanIni }}</h3>
                                <small class="text-muted">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-4">
                <div class="card border-0 shadow-sm h-100 mb-0" style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 bg-warning text-dark d-flex align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; font-size: 1.5rem;">
                                <i class="bi bi-hourglass-split"></i>
                            </div>
                            <div class="ps-3">
                                <span class="text-warning-emphasis fw-bold small text-uppercase letter-spacing-1">Agenda Mendatang</span>
                                <h3 class="fw-extrabold text-dark mb-0 fs-2">{{ $mendatang }}</h3>
                                <small class="text-muted">Akan Datang / Hari Ini</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Calendar Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-calendar3 me-2 text-primary"></i>Kalender Kegiatan Masjid</h5>
                    
                    <!-- Event Categories Legend -->
                    <div class="d-flex align-items-center gap-2 flex-wrap" style="font-size: 0.78rem;">
                        <span class="badge rounded-pill text-white px-2.5 py-1" style="background-color: #059669;"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Kajian Rutin</span>
                        <span class="badge rounded-pill text-white px-2.5 py-1" style="background-color: #2563eb;"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Sholat Jumat</span>
                        <span class="badge rounded-pill text-white px-2.5 py-1" style="background-color: #d97706;"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Hari Besar</span>
                        <span class="badge rounded-pill text-white px-2.5 py-1" style="background-color: #db2777;"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Muslimah</span>
                        <span class="badge rounded-pill text-white px-2.5 py-1" style="background-color: #7c3aed;"><i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>Remaja / IRMA</span>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <div id="calendar" style="min-height: 650px;"></div>
            </div>
        </div>

    </div>
</main>

<!-- Detail Event Modal -->
<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <!-- Modal Header / Photo Banner -->
            <div id="modal_banner_container" class="position-relative" style="background: linear-gradient(135deg, #065f46 0%, #047857 100%);">
                <img id="modal_flyer_img" src="" alt="Brosur" class="w-100 d-none" style="max-height: 220px; object-fit: cover;">
                <div id="modal_default_banner" class="p-4 text-center text-white">
                    <span class="badge bg-warning text-dark px-3 py-1 fw-bold rounded-pill text-uppercase mb-2 shadow-sm" style="font-size: 0.7rem;">
                        DETAIL AGENDA KEGIATAN
                    </span>
                    <h5 class="fw-bold mb-0 text-white">MASJID AL-IKHLAS</h5>
                    <small class="text-white-75" style="font-size: 0.75rem;">Karangmulya, Suradadi, Tegal</small>
                </div>
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 shadow" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <!-- Date Banner -->
                <div class="bg-light border rounded-3 p-2.5 text-center mb-3">
                    <div class="small text-uppercase fw-bold text-success" id="modal_day_name" style="font-size: 0.72rem;">WAKTU PELAKSANAAN</div>
                    <h5 class="fw-bold text-dark mb-0" id="modal_date_text">-</h5>
                </div>

                <h5 class="fw-bold text-dark mb-3" id="modal_title">-</h5>

                <div class="d-flex flex-column gap-2 mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                            <i class="bi bi-clock-fill small"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block" style="font-size: 0.7rem;">Waktu / Jam</small>
                            <span class="fw-semibold text-dark small" id="modal_time">-</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                            <i class="bi bi-geo-alt-fill small"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block" style="font-size: 0.7rem;">Lokasi / Tempat</small>
                            <span class="fw-semibold text-dark small" id="modal_place">-</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2" id="modal_speaker_row">
                        <div class="rounded-circle bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                            <i class="bi bi-mic-fill small"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block" style="font-size: 0.7rem;">Penceramah / Khotib</small>
                            <span class="fw-semibold text-dark small" id="modal_speaker">-</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                            <i class="bi bi-people-fill small"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block" style="font-size: 0.7rem;">Sasaran Jamaah</small>
                            <span class="fw-semibold text-dark small" id="modal_audience">Jamaah Umum</span>
                        </div>
                    </div>
                </div>

                <div class="p-2.5 rounded-3 bg-success-subtle text-success border border-success-subtle text-center small fw-semibold">
                    <i class="bi bi-check-circle-fill me-1"></i> Terbuka Untuk Umum • Gratis
                </div>
            </div>

            <div class="modal-footer bg-light border-top d-flex justify-content-between p-3">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                <a href="#" id="modal_edit_btn" class="btn btn-warning btn-sm shadow-sm">
                    <i class="bi bi-pencil-square me-1"></i> Edit Agenda Ini
                </a>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')

<style>
    .fc {
        font-family: inherit;
    }
    .fc .fc-toolbar-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
    }
    .fc .fc-button-primary {
        background-color: #065f46;
        border-color: #065f46;
        font-size: 0.85rem;
        padding: 0.35rem 0.75rem;
        font-weight: 600;
        border-radius: 6px;
    }
    .fc .fc-button-primary:hover, .fc .fc-button-primary:focus {
        background-color: #047857 !important;
        border-color: #047857 !important;
    }
    .fc .fc-button-primary:disabled {
        background-color: #94a3b8;
        border-color: #94a3b8;
    }
    .fc .fc-button-active {
        background-color: #044e3a !important;
        border-color: #044e3a !important;
    }
    .fc-event {
        cursor: pointer;
        border-radius: 4px;
        padding: 2px 4px;
        font-size: 0.78rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: transform 0.15s ease;
    }
    .fc-event:hover {
        transform: scale(1.02);
        opacity: 0.92;
    }
    .fc-day-today {
        background-color: #f0fdf4 !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        if (!calendarEl || typeof FullCalendar === 'undefined') return;

        var modalElement = document.getElementById('eventDetailModal');
        var eventModal = new bootstrap.Modal(modalElement);

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'id',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            buttonText: {
                today: 'Hari Ini',
                month: 'Bulan',
                week: 'Minggu',
                day: 'Hari',
                list: 'Daftar Agenda'
            },
            events: '{{ route('kegiatan.api') }}',
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            eventClick: function(info) {
                var props = info.event.extendedProps;
                
                document.getElementById('modal_title').textContent = props.nama_kegiatan;
                document.getElementById('modal_date_text').textContent = props.tanggal_indo;
                
                var timeText = props.jam;
                if (props.nama_waktu) {
                    timeText += ' (' + props.nama_waktu + ')';
                }
                document.getElementById('modal_time').textContent = timeText;
                document.getElementById('modal_place').textContent = props.tempat;
                document.getElementById('modal_audience').textContent = props.audience || 'Jamaah Umum';

                // Speaker / Khotib
                var speakerText = props.pembicara;
                if (props.nama_khotib) {
                    speakerText = speakerText ? speakerText + ' (Khotib: ' + props.nama_khotib + ')' : 'Khotib: ' + props.nama_khotib;
                }
                document.getElementById('modal_speaker').textContent = speakerText || 'Terbuka / Belum Ditentukan';

                // Photo flyer
                var flyerImg = document.getElementById('modal_flyer_img');
                var defaultBanner = document.getElementById('modal_default_banner');
                if (props.foto_url) {
                    flyerImg.src = props.foto_url;
                    flyerImg.classList.remove('d-none');
                    defaultBanner.classList.add('d-none');
                } else {
                    flyerImg.src = '';
                    flyerImg.classList.add('d-none');
                    defaultBanner.classList.remove('d-none');
                }

                // Edit Button
                document.getElementById('modal_edit_btn').href = props.edit_url;

                eventModal.show();
            }
        });

        calendar.render();
    });
</script>
