<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>Sistem Manajemen Masjid Al-Ikhlas</span></strong>. All Rights Reserved
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
{{--  <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>  --}}
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.4/main.min.js"></script>
<!-- Summernote Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>

<!-- DataTables JS & Bootstrap 5 Integration -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- Global DataTables Indonesian Localization Helper -->
<script>
    $.extend(true, $.fn.dataTable.defaults, {
        language: {
            "sEmptyTable": "Tidak ada data yang tersedia pada tabel ini",
            "sProcessing": "<div class='spinner-border spinner-border-sm text-primary' role='status'></div> Memproses...",
            "sLengthMenu": "Tampilkan _MENU_ entri",
            "sZeroRecords": "Tidak ditemukan data yang sesuai",
            "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
            "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
            "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
            "sInfoPostFix": "",
            "sSearch": "Cari:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "Pertama",
                "sPrevious": "Sebelumnya",
                "sNext": "Selanjutnya",
                "sLast": "Terakhir"
            }
        },
        responsive: true
    });
</script>

<!-- Global SweetAlert2 Handlers (Success, Error, Warning, Delete Confirmation, Loading) -->
<script>
    // 1. Toast Notification Helper
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    window.swalToast = function(icon, title) {
        Toast.fire({
            icon: icon,
            title: title
        });
    };

    // 2. Helper Functions
    window.showSwalSuccess = function(text = 'Operasi berhasil dilakukan!', title = 'Berhasil!') {
        return Swal.fire({
            icon: 'success',
            title: title,
            text: text,
            confirmButtonColor: '#198754',
            confirmButtonText: '<i class="bi bi-check-lg me-1"></i> OK',
            timer: 3000,
            timerProgressBar: true
        });
    };

    window.showSwalError = function(text = 'Terjadi kesalahan sistem!', title = 'Gagal!') {
        return Swal.fire({
            icon: 'error',
            title: title,
            text: text,
            confirmButtonColor: '#dc3545',
            confirmButtonText: '<i class="bi bi-x-lg me-1"></i> Tutup'
        });
    };

    window.showSwalWarning = function(text = 'Perhatian!', title = 'Peringatan!') {
        return Swal.fire({
            icon: 'warning',
            title: title,
            text: text,
            confirmButtonColor: '#ffc107',
            confirmButtonText: '<i class="bi bi-exclamation-lg me-1"></i> Mengerti'
        });
    };

    window.showSwalLoading = function(title = 'Memproses Data...', text = 'Mohon tunggu sebentar') {
        Swal.fire({
            title: title,
            text: text,
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    };

    // 3. Global Delete Confirmation Handler (Icon Warning)
    window.confirmDelete = function(e, customMsg = null) {
        e.preventDefault();
        const form = e.target.closest('form');
        const textMsg = customMsg || 'Data yang dihapus tidak dapat dipulihkan kembali!';

        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: textMsg,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-trash me-1"></i> Ya, Hapus!',
            cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Batal',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.showSwalLoading('Menghapus Data...', 'Sedang memproses penghapusan data');
                if (form) {
                    form.submit();
                }
            }
        });
        return false;
    };

    // 4. Intercept All Delete Form Submissions Globally
    document.addEventListener("DOMContentLoaded", function() {
        // Flash Alerts from Session
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{!! addslashes(session('success')) !!}",
                confirmButtonColor: '#198754',
                confirmButtonText: '<i class="bi bi-check-lg me-1"></i> OK',
                timer: 3500,
                timerProgressBar: true
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: "{!! addslashes(session('error')) !!}",
                confirmButtonColor: '#dc3545',
                confirmButtonText: '<i class="bi bi-x-lg me-1"></i> Tutup'
            });
        @endif

        @if (session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: "{!! addslashes(session('warning')) !!}",
                confirmButtonColor: '#f59e0b',
                confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Mengerti'
            });
        @endif

        @if (session('info'))
            Swal.fire({
                icon: 'info',
                title: 'Informasi',
                text: "{!! addslashes(session('info')) !!}",
                confirmButtonColor: '#0dcaf0',
                confirmButtonText: '<i class="bi bi-info-circle me-1"></i> Tutup'
            });
        @endif

        @if (isset($errors) && $errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal!',
                html: `<div class="text-start small mt-2">
                    <p class="mb-1 fw-bold text-danger">Silakan periksa input berikut:</p>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{!! addslashes($error) !!}</li>
                        @endforeach
                    </ul>
                </div>`,
                confirmButtonColor: '#dc3545',
                confirmButtonText: '<i class="bi bi-pencil-square me-1"></i> Perbaiki Input'
            });
        @endif

        // Global Click Interception for Buttons with inline onclick confirm()
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('button, a, input[type="submit"]');
            if (!btn) return;

            const onclickAttr = btn.getAttribute('onclick');
            if (onclickAttr && onclickAttr.includes('confirm(')) {
                e.preventDefault();
                e.stopImmediatePropagation();

                const match = onclickAttr.match(/confirm\(['"](.*?)['"]\)/);
                const confirmText = (match && match[1]) ? match[1] :
                    'Apakah Anda yakin ingin melanjutkan tindakan ini?';
                const form = btn.closest('form');

                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: confirmText,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-check-lg me-1"></i> Ya, Lanjutkan!',
                    cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Batal',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.showSwalLoading('Memproses...',
                        'Sedang memproses tindakan Anda');
                        if (btn.tagName === 'A' && btn.href && btn.href !== '#' && !btn.href
                            .startsWith('javascript:')) {
                            window.location.href = btn.href;
                        } else if (form) {
                            form.setAttribute('data-swal-confirmed', 'true');
                            form.submit();
                        }
                    }
                });
            }
        }, true);

        // Global Event Delegation for Form Submissions (Delete confirmation & Save loading)
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (!form || form.getAttribute('data-swal-confirmed') === 'true') {
                return;
            }

            // Check if form is a DELETE request or has confirm delete class
            const hasDeleteMethod = form.querySelector('input[name="_method"][value="DELETE"]') ||
                form.getAttribute('method')?.toUpperCase() === 'DELETE' ||
                form.classList.contains('form-delete') ||
                (form.getAttribute('onsubmit') && form.getAttribute('onsubmit').includes('confirm'));

            if (hasDeleteMethod) {
                e.preventDefault();
                e.stopImmediatePropagation();

                // Extract custom message from onsubmit or data attribute if present
                let confirmText = form.getAttribute('data-confirm-text') ||
                    'Data yang dihapus tidak dapat dipulihkan kembali!';
                const onsubmitAttr = form.getAttribute('onsubmit');
                if (onsubmitAttr && onsubmitAttr.includes('confirm(')) {
                    const match = onsubmitAttr.match(/confirm\(['"](.*?)['"]\)/);
                    if (match && match[1]) {
                        confirmText = match[1];
                    }
                }

                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: confirmText,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bi bi-trash me-1"></i> Ya, Hapus!',
                    cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Batal',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.setAttribute('data-swal-confirmed', 'true');
                        window.showSwalLoading('Menghapus Data...',
                            'Sedang memproses penghapusan data');
                        form.submit();
                    }
                });
            } else if (!form.classList.contains('no-loading') && !form.classList.contains(
                    'dataTables_filter') && form.getAttribute('target') !== '_blank') {
                // Show saving loading on standard form submission if valid
                if (typeof form.checkValidity === 'function' ? form.checkValidity() : true) {
                    window.showSwalLoading('Menyimpan Data...', 'Mohon tunggu, sedang memproses data');
                }
            }
        }, true);

        // 4. Global Indonesian Currency Formatting Helpers
        window.formatRupiah = function(angka, prefix = 'Rp ') {
            if (angka === null || angka === undefined || angka === '') return prefix + '0';
            const numberString = String(angka).replace(/[^,\d]/g, '');
            const split = numberString.split(',');
            const sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                const separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix ? (prefix + rupiah) : rupiah;
        };

        window.terbilangRupiah = function(n) {
            if (isNaN(n) || n <= 0) return 'Nol Rupiah';
            const satuan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan',
                'Sembilan', 'Sepuluh', 'Sebelas'
            ];

            function kata(angka) {
                angka = Math.floor(angka);
                if (angka < 12) return satuan[angka];
                if (angka < 20) return kata(angka - 10) + ' Belas';
                if (angka < 100) return kata(Math.floor(angka / 10)) + ' Puluh ' + kata(angka % 10);
                if (angka < 200) return 'Seratus ' + kata(angka - 100);
                if (angka < 1000) return kata(Math.floor(angka / 100)) + ' Ratus ' + kata(angka % 100);
                if (angka < 2000) return 'Seribu ' + kata(angka - 1000);
                if (angka < 1000000) return kata(Math.floor(angka / 1000)) + ' Ribu ' + kata(angka % 1000);
                if (angka < 1000000000) return kata(Math.floor(angka / 1000000)) + ' Juta ' + kata(angka %
                    1000000);
                if (angka < 1000000000000) return kata(Math.floor(angka / 1000000000)) + ' Milyar ' + kata(
                    angka % 1000000000);
                return '';
            }
            return (kata(n) + ' Rupiah').replace(/\s+/g, ' ').trim();
        };

        // Universal rupiah mask inputs
        document.querySelectorAll('.rupiah-mask').forEach(input => {
            input.addEventListener('keyup', function(e) {
                this.value = window.formatRupiah(this.value, '');
            });
        });
    });
</script>

@stack('scripts')
@yield('scripts')
@yield('script')

</body>

</html>
