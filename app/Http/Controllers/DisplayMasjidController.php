<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilMasjid;
use App\Models\Keuangan;
use App\Models\Kegiatan;
use App\Models\Galeri;
use App\Models\Takmir;
use Carbon\Carbon;

class DisplayMasjidController extends Controller
{
    public function index()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // 1. Profil Masjid
        $profil = ProfilMasjid::first();

        // 2. Transparansi Kas Terkini
        $keuanganStats = Keuangan::selectRaw("
            SUM(CASE WHEN kategori_id = 1 THEN nominal ELSE 0 END) as total_pemasukan,
            SUM(CASE WHEN kategori_id = 2 THEN nominal ELSE 0 END) as total_pengeluaran,
            SUM(CASE WHEN kategori_id = 1 AND YEAR(tanggal) = ? AND MONTH(tanggal) = ? THEN nominal ELSE 0 END) as pemasukan_bulan_ini,
            SUM(CASE WHEN kategori_id = 2 AND YEAR(tanggal) = ? AND MONTH(tanggal) = ? THEN nominal ELSE 0 END) as pengeluaran_bulan_ini
        ", [$currentYear, $currentMonth, $currentYear, $currentMonth])->first();

        $totalPemasukan      = (float) ($keuanganStats->total_pemasukan ?? 0);
        $totalPengeluaran    = (float) ($keuanganStats->total_pengeluaran ?? 0);
        $totalSaldo          = $totalPemasukan - $totalPengeluaran;
        $pemasukanBulanIni   = (float) ($keuanganStats->pemasukan_bulan_ini ?? 0);
        $pengeluaranBulanIni = (float) ($keuanganStats->pengeluaran_bulan_ini ?? 0);

        // 3. Agenda Kegiatan Terdekat
        $kegiatans = Kegiatan::where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal', 'asc')
            ->take(5)
            ->get();

        if ($kegiatans->isEmpty()) {
            $kegiatans = Kegiatan::orderBy('tanggal', 'desc')->take(4)->get();
        }

        // 4. Galeri Foto Dokumentasi Masjid Terbaru
        $galeris = Galeri::with('kegiatan')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        // 5. Petugas Sholat & Khutbah Jumat Pekan Ini
        $takmirs = Takmir::where('status', 'active')->orderBy('id', 'asc')->get();
        
        $petugasJumat = [
            'khotib'  => $takmirs->skip(0)->first()?->nama_takmir ?? 'Ustadz Tamu / Takmir Masjid',
            'imam'    => $takmirs->skip(1)->first()?->nama_takmir ?? ($takmirs->first()?->nama_takmir ?? 'Imam Rawatib Masjid'),
            'muadzin' => $takmirs->skip(2)->first()?->nama_takmir ?? ($takmirs->skip(1)->first()?->nama_takmir ?? 'Muadzin Masjid'),
            'bilal'   => $takmirs->skip(3)->first()?->nama_takmir ?? ($takmirs->first()?->nama_takmir ?? 'Petugas Bilal'),
        ];

        // 6. Kumpulan Mutiara Hadits & Doa
        $haditsList = [
            [
                'arab' => 'مَنْ بَنَى مَسْجِدًا لِلَّهِ بَنَى اللَّهُ لَهُ فِي الْجَنَّةِ مِثْلَهُ',
                'terjemah' => 'Barangsiapa membangun masjid karena Allah, maka Allah akan membangunkan baginya rumah serupa di surga.',
                'riwayat' => 'HR. Bukhari & Muslim'
            ],
            [
                'arab' => 'صَلاَةُ الْجَمَاعَةِ تَفْضُلُ صَلاَةَ الْفَذِّ بِسَبْعٍ وَعِشْرِينَ دَرَجَةً',
                'terjemah' => 'Shalat berjamaah lebih utama daripada shalat sendirian dengan selisih dua puluh tujuh derajat.',
                'riwayat' => 'HR. Bukhari & Muslim'
            ],
            [
                'arab' => 'خَيْرُكُمْ مَنْ تَعَلَّمَ الْقُرْآنَ وَعَلَّمَهُ',
                'terjemah' => 'Sebaik-baik kalian adalah orang yang belajar Al-Qur\'an dan mengajarkannya.',
                'riwayat' => 'HR. Bukhari'
            ],
            [
                'arab' => 'إِنَّمَا الأَعْمَالُ بِالنِّيَّاتِ وَإِنَّمَا لِكُلِّ امْرِئٍ مَا نَوَى',
                'terjemah' => 'Sesungguhnya setiap amalan tergantung pada niatnya, dan setiap orang akan mendapatkan sesuai apa yang ia niatkan.',
                'riwayat' => 'HR. Bukhari & Muslim'
            ],
            [
                'arab' => 'مَا نَقَصَتْ صَدَقَةٌ مِنْ مَالٍ',
                'terjemah' => 'Sedekah itu tidak akan pernah mengurangi harta sama sekali.',
                'riwayat' => 'HR. Muslim'
            ]
        ];

        // 7. Running Text Pengumuman
        $runningTexts = [
            'Selamat datang di ' . ($profil->nama_masjid ?? 'Masjid Al-Ikhlas') . ' • Mari makmurkan masjid dengan shalat berjamaah dan menjaga kebersihan rumah Allah.',
            'Laporan Kas Terkini: Total Saldo Kas Rp ' . number_format($totalSaldo, 0, ',', '.') . ' (Pemasukan Bulan Ini: Rp ' . number_format($pemasukanBulanIni, 0, ',', '.') . ') • Transparan & Amanah.',
            'Infaq & Donasi Pembangunan: ' . ($profil->nama_bank ?? 'Bank Syariah Indonesia') . ' No. Rek: ' . ($profil->nomor_rekening ?? '1234567890') . ' a.n ' . ($profil->atas_nama ?? 'Takmir Masjid'),
            'Harap menonaktifkan atau mengubah mode senyap pada nada dering handphone (HP) saat berada di dalam ruang utama shalat.',
        ];

        if ($kegiatans->isNotEmpty()) {
            $firstKegiatan = $kegiatans->first();
            $runningTexts[] = 'Agenda Terdekat: ' . $firstKegiatan->nama_kegiatan . ' (' . Carbon::parse($firstKegiatan->tanggal)->translatedFormat('d F Y') . ' - Pukul ' . ($firstKegiatan->waktu ?? '09:00') . ' WIB) • Tempat: ' . ($firstKegiatan->lokasi ?? 'Masjid');
        }

        return view('display.index', compact(
            'profil',
            'totalSaldo',
            'totalPemasukan',
            'totalPengeluaran',
            'pemasukanBulanIni',
            'pengeluaranBulanIni',
            'kegiatans',
            'galeris',
            'petugasJumat',
            'haditsList',
            'runningTexts'
        ));
    }

    public function apiData()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $profil = ProfilMasjid::first();

        $keuanganStats = Keuangan::selectRaw("
            SUM(CASE WHEN kategori_id = 1 THEN nominal ELSE 0 END) as total_pemasukan,
            SUM(CASE WHEN kategori_id = 2 THEN nominal ELSE 0 END) as total_pengeluaran
        ")->first();

        $totalPemasukan = (float) ($keuanganStats->total_pemasukan ?? 0);
        $totalPengeluaran = (float) ($keuanganStats->total_pengeluaran ?? 0);
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        $kegiatans = Kegiatan::where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal', 'asc')
            ->take(5)
            ->get();

        return response()->json([
            'status' => 'success',
            'timestamp' => Carbon::now()->toIso8601String(),
            'saldo' => $totalSaldo,
            'saldo_formatted' => 'Rp ' . number_format($totalSaldo, 0, ',', '.'),
            'kegiatan_count' => $kegiatans->count(),
            'nama_masjid' => $profil->nama_masjid ?? 'Masjid Al-Ikhlas'
        ]);
    }
}
