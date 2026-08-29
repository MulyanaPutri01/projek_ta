<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Kategori;
use App\Models\Kegiatan;
use App\Models\Donatur;
use App\Models\Takmir;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function __construct()
    {
        // Membatasi seluruh fungsi di controller ini khusus role bendahara
        $this->middleware('role:bendahara');
    }
    
    public function index(Request $request)
    {
        $search = $request->input('search', ''); // Ambil nilai pencarian atau kosong jika tidak ada.

        // 1. Query utama untuk mengambil data keuangan.
        $query = Keuangan::query();

        // Filter pencarian jika ada.
        if (!empty($search)) {
            $query->where('sumber_keuangan', 'LIKE', "%{$search}%")
                ->orWhere('keterangan', 'LIKE', "%{$search}%")
                ->orWhereHas('donatur', function ($q) use ($search) {
                    $q->where('nama_donatur', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('kegiatan', function ($q) use ($search) {
                    $q->where('nama_kegiatan', 'LIKE', "%{$search}%");
                })
                ->orWhere(function ($q) use ($search) {
                    $q->where('kategori_id_kategori', 'K1') // Pemasukan
                        ->where('nominal', 'LIKE', "%{$search}%");
                })
                ->orWhere(function ($q) use ($search) {
                    $q->where('kategori_id_kategori', 'K2') // Pengeluaran
                        ->where('nominal', 'LIKE', "%{$search}%");
                });
        }
        // Pencarian berdasarkan bulan
        if ($request->has('month') && !empty($request->month)) {
            $query->whereRaw('DATE_FORMAT(tanggal, "%m") = ?', [$request->input('month')]);
        }

        // Pencarian berdasarkan tahun
        if ($request->has('year') && !empty($request->year)) {
            $query->whereRaw('DATE_FORMAT(tanggal, "%Y") = ?', [$request->input('year')]);
        }

        // Hitung total pemasukan dan pengeluaran berdasarkan periode
        $today = now()->format('Y-m-d');
        $thisMonth = now()->format('Y-m');
        $thisYear = now()->format('Y');

        $pemasukanHariIni = Keuangan::where('kategori_id_kategori', 'K1')
            ->whereDate('tanggal', $today)
            ->sum('nominal');

        $pemasukanBulanIni = Keuangan::where('kategori_id_kategori', 'K1')
            ->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->sum('nominal');

        $pemasukanTahunIni = Keuangan::where('kategori_id_kategori', 'K1')
            ->whereYear('tanggal', $thisYear)
            ->sum('nominal');

        $pengeluaranHariIni = Keuangan::where('kategori_id_kategori', 'K2')
            ->whereDate('tanggal', $today)
            ->sum('nominal');

        $pengeluaranBulanIni = Keuangan::where('kategori_id_kategori', 'K2')
            ->whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)
            ->sum('nominal');

        $pengeluaranTahunIni = Keuangan::where('kategori_id_kategori', 'K2')
            ->whereYear('tanggal', $thisYear)
            ->sum('nominal');

        // Hitung total pemasukan, pengeluaran, dan saldo dari seluruh data tanpa pagination.
        $totalPemasukan = Keuangan::where('kategori_id_kategori', 'K1')->sum('nominal');
        $totalPengeluaran = Keuangan::where('kategori_id_kategori', 'K2')->sum('nominal');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        // 2. Tentukan Urutan Pengurutan Data
        $query = (clone $query)->orderBy('tanggal', 'asc')->orderBy('id_keuangan', 'asc');
        // Set pagination
        $perPage = 3;
        $keuangan = $query->paginate($perPage);

        // HITUNG SALDO AWAL PERSIS DARI QUERY YANG SAMA
        $currentPage = $keuangan->currentPage();
        $offset = ($currentPage - 1) * $perPage;

        if ($offset > 0) {
            // Gunakan query yang SAMA PERSIS urutannya untuk mengambil data sebelum offset
            $previousItems = (clone $query)->take($offset)->get();

            // Hitung total saldo dari semua baris sebelum halaman ini
            $saldoAwal = $previousItems->sum(function ($item) {
                return $item->kategori_id_kategori === 'K1' ? $item->nominal : -$item->nominal;
            });
        } else {
            $saldoAwal = 0;
        }

        // 4. Hitung statistik ringkasan
        $totalPemasukan = Keuangan::where('kategori_id_kategori', 'K1')->sum('nominal');
        $totalPengeluaran = Keuangan::where('kategori_id_kategori', 'K2')->sum('nominal');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;
       // $totalKeuangan = Keuangan::count();
        $totalKeuangan = $keuangan->total();

        return view('keuangan.index', compact(
            'keuangan',
            'saldoAwal',
            'totalKeuangan',
            'totalPemasukan',
            'totalPengeluaran',
            'totalSaldo',
            'pemasukanHariIni',
            'pemasukanBulanIni',
            'pemasukanTahunIni',
            'pengeluaranHariIni',
            'pengeluaranBulanIni',
            'pengeluaranTahunIni',
            'search'
        ));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $donaturs = Donatur::all();
        $kegiatans = Kegiatan::all();
        $takmirs = Takmir::all();
        return view('keuangan.create', compact('kategoris', 'donaturs', 'kegiatans', 'takmirs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'sumber_keuangan' => 'required|string',
            'keterangan' => 'required|string|max:100',
            'nominal' => 'required|integer',
            'kategori_id_kategori' => 'required|string', 
            'donatur_id_donatur' => 'nullable|string|size:5', // Boleh tidak diisi
            'kegiatan_id_kegiatan' => 'nullable|string|size:4', // Boleh tidak diisi
        ]);

        $data = $request->all();
        $data['takmir_id_takmir'] = auth()->user()->id_takmir;

        // Set nilai NULL jika tidak ada yang dipilih untuk donatur_id_donatur atau kegiatan_id_kegiatan
        $data['donatur_id_donatur'] = $request->donatur_id_donatur ?: null;
        $data['kegiatan_id_kegiatan'] = $request->kegiatan_id_kegiatan ?: null;

        Keuangan::create($data);

        return redirect()->route('keuangan.index')->with('success', 'Keuangan berhasil ditambahkan.');
    }



    public function show(Keuangan $keuangan)
    {
        return view('keuangan.show', compact('keuangan'));
    }

    public function edit($id_keuangan)
    {
        $keuangan = Keuangan::findOrFail($id_keuangan);
        $kategoris = Kategori::all();
        $donaturs = Donatur::all();
        $kegiatans = Kegiatan::all();

        return view('keuangan.edit', compact('keuangan', 'kategoris', 'donaturs', 'kegiatans'));
    }

    public function update(Request $request, $id_keuangan)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'sumber_keuangan' => 'required|string',
            'keterangan' => 'required|string|max:100',
            'nominal' => 'required|integer',
            'kategori_id_kategori' => 'required|string', // Gunakan `size:2` untuk ukuran karakter 2
            'donatur_id_donatur' => 'nullable|string|size:5', // Boleh tidak diisi
            'kegiatan_id_kegiatan' => 'nullable|string|size:4', // Boleh tidak diisi
        ]);

        $data = $request->all();
        $data['takmir_id_takmir'] = auth()->user()->id_takmir;

        // Set nilai NULL jika tidak ada yang dipilih untuk donatur_id_donatur atau kegiatan_id_kegiatan
        $data['donatur_id_donatur'] = $request->donatur_id_donatur ?: null;
        $data['kegiatan_id_kegiatan'] = $request->kegiatan_id_kegiatan ?: null;

        $keuangan = Keuangan::findOrFail($id_keuangan);
        $keuangan->update($data);

        return redirect()->route('keuangan.index')->with('success', 'Keuangan berhasil diperbarui.');
    }


    public function destroy(Keuangan $keuangan)
    {
        $keuangan->delete();

        // Hitung total saldo setelah delete
        //$totalSaldo = Keuangan::where('takmir_id_takmir', $keuangan->takmir_id_takmir)
          //  ->sum('pemasukan') - Keuangan::where('takmir_id_takmir', $keuangan->takmir_id_takmir)
            //->sum('pengeluaran');
        //$keuangan->update(['total_saldo' => $totalSaldo]);

        return redirect()->route('keuangan.index')->with('success', 'Keuangan berhasil dihapus.');
        
    }
}
