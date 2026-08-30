<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kalender Agenda Kegiatan - Masjid Jami Al-Ikhlas</title>
  <meta name="description" content="Kalender lengkap jadwal agenda kegiatan ibadah, kajian, dan peringatan hari besar Islam di Masjid Jami Al-Ikhlas Karangmulya Tegal.">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="{{ asset('assets-landing/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets-landing/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets-landing/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/id.global.min.js"></script>
  <style>
    *{box-sizing:border-box}
    body{font-family:'Plus Jakarta Sans',sans-serif;background:#f8fafc;margin:0;padding:0}
    .pub-navbar{background:linear-gradient(135deg,#0d2b18,#1a4d2e);padding:14px 0;position:sticky;top:0;z-index:1000;box-shadow:0 4px 20px rgba(0,0,0,.2)}
    .pub-navbar .brand-name{color:#fff;font-weight:800;font-size:1.1rem}
    .pub-navbar .brand-sub{color:rgba(255,255,255,.5);font-size:.72rem}
    .pub-back-btn{background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.25);color:#fff;border-radius:50px;padding:7px 18px;font-size:.85rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:7px;transition:all .25s ease}
    .pub-back-btn:hover{background:rgba(255,255,255,.22);color:#ffd750}
    .pub-hero{background:linear-gradient(135deg,#064e3b 0%,#0f766e 100%);padding:44px 0 52px;position:relative;overflow:hidden}
    .pub-hero::before{content:'';position:absolute;top:-80px;right:-80px;width:400px;height:400px;background:radial-gradient(circle,rgba(52,211,153,.2),transparent 70%);pointer-events:none}
    .pub-hero-badge{display:inline-flex;align-items:center;gap:7px;background:rgba(255,215,80,.15);border:1px solid rgba(255,215,80,.35);color:#ffd750;font-size:.72rem;font-weight:700;letter-spacing:2px;padding:5px 16px;border-radius:50px;text-transform:uppercase;margin-bottom:14px}
    .pub-hero h1{color:#fff;font-weight:800;font-size:clamp(1.4rem,3vw,2rem);margin-bottom:8px}
    .pub-hero p{color:rgba(255,255,255,.65);font-size:.92rem;max-width:560px}
    .pub-stat-card{background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);border-radius:16px;padding:18px 14px;color:#fff;backdrop-filter:blur(8px);text-align:center}
    .pub-stat-num{font-size:1.9rem;font-weight:800;line-height:1}
    .pub-stat-label{font-size:.75rem;color:rgba(255,255,255,.6);margin-top:4px}
    .pub-main{padding:36px 0 60px}
    .cal-card{background:#fff;border-radius:20px;box-shadow:0 6px 30px rgba(0,0,0,.07);overflow:hidden}
    .cal-card-header{background:#fff;border-bottom:1px solid #e2e8f0;padding:18px 26px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px}
    .cal-card-title{font-size:1rem;font-weight:700;color:#0f172a;margin:0}
    .cal-card-body{padding:22px 26px}
    .legend-badge{display:inline-flex;align-items:center;gap:5px;font-size:.7rem;font-weight:600;padding:3px 10px;border-radius:50px;color:#fff}
    .fc{font-family:inherit}
    .fc .fc-toolbar-title{font-size:1.1rem;font-weight:700;color:#1e293b}
    .fc .fc-button-primary{background-color:#065f46;border-color:#065f46;font-size:.8rem;padding:.28rem .65rem;font-weight:600;border-radius:6px}
    .fc .fc-button-primary:hover,.fc .fc-button-primary:focus{background-color:#047857!important;border-color:#047857!important;box-shadow:none!important}
    .fc .fc-button-active{background-color:#044e3a!important;border-color:#044e3a!important}
    .fc-event{cursor:pointer;border-radius:4px;padding:2px 4px;font-size:.76rem;box-shadow:0 1px 3px rgba(0,0,0,.1);transition:transform .15s ease}
    .fc-event:hover{transform:scale(1.02);opacity:.92}
    .fc-day-today{background-color:#f0fdf4!important}
    .pub-footer{background:linear-gradient(160deg,#051a0e,#0d2b18);color:rgba(255,255,255,.5);text-align:center;padding:24px;font-size:.82rem}
    .pub-footer a{color:#48bb78;text-decoration:none}
    .pub-footer a:hover{color:#6ee7b7}
  </style>
</head>
<body>

  {{-- Navbar --}}
  <nav class="pub-navbar">
    <div class="container d-flex align-items-center justify-content-between">
      <a href="{{ url('/') }}" class="d-flex align-items-center gap-3 text-decoration-none">
        <div style="width:40px;height:40px;background:linear-gradient(135deg,#1e5e35,#2d8a50);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.15rem">
          <i class="fa-solid fa-mosque text-white"></i>
        </div>
        <div>
          <div class="brand-name">Masjid Jami Al-Ikhlas</div>
          <div class="brand-sub">Dukuh Semendot, Karangmulya, Tegal</div>
        </div>
      </a>
      <a href="{{ url('/') }}#kegiatan" class="pub-back-btn">
        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
      </a>
    </div>
  </nav>

  {{-- Hero --}}
  <section class="pub-hero">
    <div class="container position-relative" style="z-index:1">
      <div class="row align-items-end g-4">
        <div class="col-lg-7">
          <div class="pub-hero-badge"><i class="bi bi-calendar3"></i> KALENDER AGENDA MASJID</div>
          <h1>Jadwal &amp; Agenda Kegiatan<br>Masjid Jami Al-Ikhlas</h1>
          <p class="mb-0">Seluruh jadwal kegiatan ibadah, kajian keilmuan, peringatan hari besar Islam, dan kegiatan kemasyarakatan yang dapat diikuti seluruh jamaah.</p>
        </div>
        <div class="col-lg-5">
          <div class="row g-3">
            <div class="col-4">
              <div class="pub-stat-card">
                <div class="pub-stat-num text-warning">{{ $totalKegiatan }}</div>
                <div class="pub-stat-label">Total Agenda</div>
              </div>
            </div>
            <div class="col-4">
              <div class="pub-stat-card">
                <div class="pub-stat-num" style="color:#6ee7b7">{{ $bulanIni }}</div>
                <div class="pub-stat-label">Bulan Ini</div>
              </div>
            </div>
            <div class="col-4">
              <div class="pub-stat-card">
                <div class="pub-stat-num" style="color:#fbbf24">{{ $mendatang }}</div>
                <div class="pub-stat-label">Mendatang</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Main Calendar --}}
  <main class="pub-main">
    <div class="container">
      <div class="cal-card">
        <div class="cal-card-header">
          <h5 class="cal-card-title"><i class="bi bi-calendar3 me-2 text-success"></i>Kalender Kegiatan Masjid</h5>
          <div class="d-flex flex-wrap gap-2">
            <span class="legend-badge" style="background:#059669"><i class="bi bi-circle-fill" style="font-size:.4rem"></i> Kajian Rutin</span>
            <span class="legend-badge" style="background:#2563eb"><i class="bi bi-circle-fill" style="font-size:.4rem"></i> Sholat Jumat</span>
            <span class="legend-badge" style="background:#d97706"><i class="bi bi-circle-fill" style="font-size:.4rem"></i> Hari Besar</span>
            <span class="legend-badge" style="background:#db2777"><i class="bi bi-circle-fill" style="font-size:.4rem"></i> Muslimah</span>
            <span class="legend-badge" style="background:#7c3aed"><i class="bi bi-circle-fill" style="font-size:.4rem"></i> Remaja</span>
          </div>
        </div>
        <div class="cal-card-body">
          <div id="calendar" style="min-height:640px"></div>
        </div>
      </div>

      <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:50px;padding:10px 22px;font-size:.83rem;color:#475569;display:flex;align-items:center;gap:8px">
          <i class="bi bi-info-circle-fill text-success"></i> Klik agenda untuk melihat detail
        </div>
        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:50px;padding:10px 22px;font-size:.83rem;color:#475569;display:flex;align-items:center;gap:8px">
          <i class="bi bi-whatsapp text-success"></i> Hubungi Takmir via WhatsApp untuk info
        </div>
      </div>
    </div>
  </main>

  {{-- Event Detail Modal --}}
  <div class="modal fade" id="eventDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
        <div id="modal_banner_container" class="position-relative" style="background:linear-gradient(135deg,#065f46 0%,#047857 100%)">
          <img id="modal_flyer_img" src="" alt="Brosur" class="w-100 d-none" style="max-height:220px;object-fit:cover">
          <div id="modal_default_banner" class="p-4 text-center text-white">
            <span class="badge bg-warning text-dark px-3 py-1 fw-bold rounded-pill mb-2 shadow-sm" style="font-size:.7rem">DETAIL AGENDA KEGIATAN</span>
            <h5 class="fw-bold mb-0 text-white">MASJID JAMI AL-IKHLAS</h5>
            <small style="font-size:.75rem;color:rgba(255,255,255,.75)">Karangmulya, Suradadi, Tegal</small>
          </div>
          <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 shadow" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <div class="bg-light border rounded-3 p-3 text-center mb-3">
            <div class="small text-uppercase fw-bold text-success" style="font-size:.72rem">WAKTU PELAKSANAAN</div>
            <h5 class="fw-bold text-dark mb-0" id="modal_date_text">-</h5>
          </div>
          <h5 class="fw-bold text-dark mb-3" id="modal_title">-</h5>
          <div class="d-flex flex-column gap-2 mb-3">
            <div class="d-flex align-items-center gap-2">
              <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width:32px;height:32px;flex-shrink:0"><i class="bi bi-clock-fill small"></i></div>
              <div><small class="text-muted d-block" style="font-size:.7rem">Waktu / Jam</small><span class="fw-semibold text-dark small" id="modal_time">-</span></div>
            </div>
            <div class="d-flex align-items-center gap-2">
              <div class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width:32px;height:32px;flex-shrink:0"><i class="bi bi-geo-alt-fill small"></i></div>
              <div><small class="text-muted d-block" style="font-size:.7rem">Lokasi / Tempat</small><span class="fw-semibold text-dark small" id="modal_place">-</span></div>
            </div>
            <div class="d-flex align-items-center gap-2">
              <div class="rounded-circle bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center" style="width:32px;height:32px;flex-shrink:0"><i class="bi bi-mic-fill small"></i></div>
              <div><small class="text-muted d-block" style="font-size:.7rem">Penceramah / Khotib</small><span class="fw-semibold text-dark small" id="modal_speaker">-</span></div>
            </div>
            <div class="d-flex align-items-center gap-2">
              <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width:32px;height:32px;flex-shrink:0"><i class="bi bi-people-fill small"></i></div>
              <div><small class="text-muted d-block" style="font-size:.7rem">Sasaran Jamaah</small><span class="fw-semibold text-dark small" id="modal_audience">Jamaah Umum</span></div>
            </div>
          </div>
          <div class="p-3 rounded-3 bg-success-subtle text-success border border-success-subtle text-center small fw-semibold">
            <i class="bi bi-check-circle-fill me-1"></i> Terbuka Untuk Umum &bull; Gratis
          </div>
        </div>
        <div class="modal-footer bg-light border-top d-flex justify-content-between p-3">
          <button type="button" class="btn btn-secondary btn-sm rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
          <a href="{{ url('/') }}#kegiatan" class="btn btn-outline-success btn-sm rounded-pill">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- Footer --}}
  <footer class="pub-footer">
    <p class="mb-1">&copy; {{ date('Y') }} <strong style="color:rgba(255,255,255,.7)">Masjid Jami Al-Ikhlas</strong> &mdash; Dukuh Semendot, Karangmulya, Tegal</p>
    <p class="mb-0">Sistem Informasi Manajemen Masjid (SIMAS) &bull; <a href="{{ url('/') }}">Kembali ke Beranda</a></p>
  </footer>

  <script src="{{ asset('assets-landing/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
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
          right: 'dayGridMonth,timeGridWeek,listMonth'
        },
        buttonText: { today: 'Hari Ini', month: 'Bulan', week: 'Minggu', list: 'Daftar Agenda' },
        events: '{{ route("kegiatan.api") }}',
        eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
        eventClick: function(info) {
          var props = info.event.extendedProps;
          document.getElementById('modal_title').textContent = props.nama_kegiatan || info.event.title;
          document.getElementById('modal_date_text').textContent = props.tanggal_indo || info.event.startStr;
          var timeText = props.jam || '';
          if (props.nama_waktu) timeText += ' (' + props.nama_waktu + ')';
          document.getElementById('modal_time').textContent = timeText || '-';
          document.getElementById('modal_place').textContent = props.tempat || '-';
          document.getElementById('modal_audience').textContent = props.audience || 'Jamaah Umum';
          var speakerText = props.pembicara || '';
          if (props.nama_khotib) {
            speakerText = speakerText
              ? speakerText + ' (Khotib: ' + props.nama_khotib + ')'
              : 'Khotib: ' + props.nama_khotib;
          }
          document.getElementById('modal_speaker').textContent = speakerText || 'Terbuka / Belum Ditentukan';
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
          eventModal.show();
        }
      });

      calendar.render();
    });
  </script>
</body>
</html>
