<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilMasjid;
use App\Models\Keuangan;
use App\Models\Kegiatan;
use App\Models\Galeri;
use App\Models\Takmir;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DisplayMasjidController extends Controller
{
    /**
     * Get saved settings with robust fallback defaults
     */
    protected function getSettings()
    {
        $defaultSettings = [
            'theme' => 'theme-emerald',
            'slide_interval' => 8,
            'petugas_jumat' => [
                'khotib'  => 'Ustadz H. Ahmad Fauzi, Lc.',
                'imam'    => 'Ustadz M. Syarifuddin, S.Pd.I',
                'muadzin' => 'Ustadz Bilal Ramadhan',
                'bilal'   => 'Ustadz Ridwan Al-Hafidz',
                'tema'    => 'Menjaga Keikhlasan & Kemakmuran Masjid',
            ],
            'iqomah_duration' => [
                'subuh'   => 10,
                'dzuhur'  => 10,
                'ashar'   => 8,
                'maghrib' => 7,
                'isya'    => 10,
                'jumat'   => 15,
            ],
            'running_texts' => [
                'Selamat datang di Masjid Al-Ikhlas • Mari makmurkan masjid dengan shalat berjamaah dan menjaga kesucian rumah Allah.',
                'Infaq & Sedekah Pembangunan: Bank Syariah Indonesia No. Rek: 1234567890 a.n Takmir Masjid (Scan QRIS pada layar TV).',
                'Peringatan Ibadah: Harap menonaktifkan atau mengubah mode senyap pada nada dering handphone (HP) saat berada di ruang sholat.'
            ]
        ];

        if (Storage::disk('local')->exists('display_settings.json')) {
            try {
                $saved = json_decode(Storage::disk('local')->get('display_settings.json'), true);
                if (is_array($saved)) {
                    return array_merge($defaultSettings, $saved);
                }
            } catch (\Exception $e) {
                // Return defaults if json is invalid
            }
        }

        return $defaultSettings;
    }

    /**
     * Save settings to storage
     */
    protected function saveSettings(array $data)
    {
        Storage::disk('local')->put('display_settings.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Main Display View for Smart TV
     */
    public function index()
    {
        $settings = $this->getSettings();
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

        // 5. Petugas Sholat & Khutbah Jumat
        $petugasJumat = $settings['petugas_jumat'] ?? [
            'khotib'  => 'Ustadz H. Ahmad Fauzi, Lc.',
            'imam'    => 'Ustadz M. Syarifuddin, S.Pd.I',
            'muadzin' => 'Ustadz Bilal Ramadhan',
            'bilal'   => 'Ustadz Ridwan Al-Hafidz',
            'tema'    => 'Menjaga Keikhlasan & Kemakmuran Masjid'
        ];

        // 6. Kumpulan Mutiara Hadits
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

        // 7. Bacaan Dzikir & Doa Ba'da Sholat
        $dzikirList = [
            [
                'judul' => 'Istighfar & Doa Keselamatan',
                'arab'  => 'أَسْتَغْفِرُ اللَّهَ (٣×) اللَّهُمَّ أَنْتَ السَّلاَمُ وَمِنْكَ السَّلاَمُ تَبَارَكْتَ يَا ذَا الْجَلاَلِ وَالإِكْرَامِ',
                'arti'  => 'Aku memohon ampun kepada Allah (3x). Ya Allah, Engkau adalah Dzat yang memberi keselamatan, dan dari-Mu keselamatan, Maha Suci Engkau wahai Dzat yang memiliki keagungan dan kemuliaan.'
            ],
            [
                'judul' => 'Tasbih, Tahmid & Takbir',
                'arab'  => 'سُبْحَانَ اللَّهِ (٣٣×) • الْحَمْدُ لِلَّهِ (٣٣×) • اللَّهُ أَكْبَرُ (٣٣×)',
                'arti'  => 'Maha Suci Allah (33x) • Segala puji bagi Allah (33x) • Allah Maha Besar (33x).'
            ],
            [
                'judul' => 'Penyempurna Dzikir (Tahlil)',
                'arab'  => 'لاَ إِلَهَ إِلاَّ اللَّهُ وَحْدَهُ لاَ شَرِيكَ لَهُ، لَهُ الْمُلْكُ وَلَهُ الْحَمْدُ وَهُوَ عَلَى كُلِّ شَىْءٍ قَدِيرٌ',
                'arti'  => 'Tidak ada sesembahan yang berhak disembah selain Allah semata, tidak ada sekutu bagi-Nya, milik-Nya segala kerajaan dan bagi-Nya segala pujian, dan Dia Maha Kuasa atas segala sesuatu.'
            ]
        ];

        // 8. Info Cuaca & Lokasi
        $weatherInfo = [
            'temp'      => '28°C',
            'condition' => 'Cerah Berawan',
            'humidity'  => '74%',
            'location'  => 'Karangmulya, Tegal',
            'qibla'     => '294.5°'
        ];

        // 9. Running Text Pengumuman
        $runningTexts = !empty($settings['running_texts']) ? $settings['running_texts'] : [
            'Selamat datang di ' . ($profil->nama_masjid ?? 'Masjid Al-Ikhlas') . ' • Mari makmurkan masjid dengan shalat berjamaah.',
            'Laporan Kas: Saldo Kas Rp ' . number_format($totalSaldo, 0, ',', '.') . ' (Pemasukan Bulan Ini: Rp ' . number_format($pemasukanBulanIni, 0, ',', '.') . ').',
            'Harap menonaktifkan nada dering handphone (HP) saat berada di dalam ruang utama sholat.'
        ];

        if ($kegiatans->isNotEmpty()) {
            $firstKegiatan = $kegiatans->first();
            $runningTexts[] = 'Agenda Terdekat: ' . $firstKegiatan->nama_kegiatan . ' (' . Carbon::parse($firstKegiatan->tanggal)->translatedFormat('d F Y') . ' - Pukul ' . ($firstKegiatan->waktu ?? '09:00') . ' WIB)';
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
            'dzikirList',
            'weatherInfo',
            'runningTexts',
            'settings'
        ));
    }

    /**
     * Admin Setting Page for Smart TV
     */
    public function setting()
    {
        $settings = $this->getSettings();
        $takmirs = Takmir::where('status', 'active')->orderBy('nama_takmir', 'asc')->get();
        $profil = ProfilMasjid::first();

        return view('admin.display.setting', compact('settings', 'takmirs', 'profil'));
    }

    /**
     * Update Smart TV Settings
     */
    public function updateSetting(Request $request)
    {
        $runningTexts = array_filter(array_map('trim', explode("\n", $request->input('running_texts_raw', ''))));

        $data = [
            'theme' => $request->input('theme', 'theme-emerald'),
            'slide_interval' => (int) $request->input('slide_interval', 8),
            'petugas_jumat' => [
                'khotib'  => $request->input('khotib', 'Ustadz H. Ahmad Fauzi, Lc.'),
                'imam'    => $request->input('imam', 'Ustadz M. Syarifuddin, S.Pd.I'),
                'muadzin' => $request->input('muadzin', 'Ustadz Bilal Ramadhan'),
                'bilal'   => $request->input('bilal', 'Ustadz Ridwan Al-Hafidz'),
                'tema'    => $request->input('tema_khutbah', 'Menjaga Keikhlasan & Kemakmuran Masjid'),
            ],
            'iqomah_duration' => [
                'subuh'   => (int) $request->input('iqomah_subuh', 10),
                'dzuhur'  => (int) $request->input('iqomah_dzuhur', 10),
                'ashar'   => (int) $request->input('iqomah_ashar', 8),
                'maghrib' => (int) $request->input('iqomah_maghrib', 7),
                'isya'    => (int) $request->input('iqomah_isya', 10),
                'jumat'   => (int) $request->input('iqomah_jumat', 15),
            ],
            'running_texts' => !empty($runningTexts) ? array_values($runningTexts) : [
                'Selamat datang di Masjid Al-Ikhlas • Mari makmurkan masjid dengan shalat berjamaah.',
                'Harap menonaktifkan nada dering handphone (HP) saat berada di dalam ruang sholat.'
            ]
        ];

        $this->saveSettings($data);

        return redirect()->route('admin.display.setting')
            ->with('success', 'Pengaturan Smart TV Digital Signage berhasil diperbarui!');
    }

    public function apiData()
    {
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
