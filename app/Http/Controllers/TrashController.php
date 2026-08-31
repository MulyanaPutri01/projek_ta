<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\Donatur;
use App\Models\Kegiatan;
use App\Models\Kepanitiaan;
use App\Models\Inventaris;
use App\Models\Catatan;
use App\Models\Galeri;
use App\Models\Takmir;
use App\Models\Kategori;
use App\Models\Posisi;
use App\Models\Kondisi;

class TrashController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Map type slug to model class and human label
     */
    protected function getModelConfig($type)
    {
        $map = [
            'keuangan'    => ['model' => Keuangan::class, 'label' => 'Transaksi Kas Keuangan', 'relations' => ['kategori', 'donatur', 'kegiatan', 'takmir']],
            'donatur'     => ['model' => Donatur::class, 'label' => 'Data Donatur', 'relations' => ['takmir']],
            'kegiatan'    => ['model' => Kegiatan::class, 'label' => 'Agenda & Kegiatan', 'relations' => []],
            'kepanitiaan' => ['model' => Kepanitiaan::class, 'label' => 'Kepanitiaan Acara', 'relations' => ['kegiatan', 'posisi', 'takmir']],
            'inventaris'  => ['model' => Inventaris::class, 'label' => 'Barang Inventaris', 'relations' => []],
            'catatan'     => ['model' => Catatan::class, 'label' => 'Catatan Kondisi Barang', 'relations' => ['inventaris', 'kondisi', 'takmir']],
            'galeri'      => ['model' => Galeri::class, 'label' => 'Foto Dokumentasi Galeri', 'relations' => ['kegiatan', 'takmir']],
            'takmir'      => ['model' => Takmir::class, 'label' => 'Akun Takmir / Pengguna', 'relations' => ['role']],
            'kategori'    => ['model' => Kategori::class, 'label' => 'Kategori Kas', 'relations' => []],
            'posisi'      => ['model' => Posisi::class, 'label' => 'Master Posisi Panitia', 'relations' => []],
            'kondisi'     => ['model' => Kondisi::class, 'label' => 'Master Kondisi Inventaris', 'relations' => []],
        ];

        return $map[$type] ?? null;
    }

    /**
     * Display centralized Trash & Recovery Center
     */
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'keuangan');

        // Counts per category for badges
        $counts = [
            'keuangan'    => Keuangan::onlyTrashed()->count(),
            'donatur'     => Donatur::onlyTrashed()->count(),
            'kegiatan'    => Kegiatan::onlyTrashed()->count(),
            'kepanitiaan' => Kepanitiaan::onlyTrashed()->count(),
            'inventaris'  => Inventaris::onlyTrashed()->count(),
            'catatan'     => Catatan::onlyTrashed()->count(),
            'galeri'      => Galeri::onlyTrashed()->count(),
            'takmir'      => Takmir::onlyTrashed()->count(),
            'kategori'    => Kategori::onlyTrashed()->count(),
            'posisi'      => Posisi::onlyTrashed()->count(),
            'kondisi'     => Kondisi::onlyTrashed()->count(),
        ];

        $totalTrashed = array_sum($counts);

        // Fetch trashed data for active tab
        $trashedData = collect();
        $config = $this->getModelConfig($activeTab);

        if ($config) {
            $query = $config['model']::onlyTrashed()->latest('deleted_at');
            if (!empty($config['relations'])) {
                $query->with($config['relations']);
            }
            $trashedData = $query->paginate(15)->withQueryString();
        }

        return view('admin.trash.index', compact('activeTab', 'counts', 'totalTrashed', 'trashedData', 'config'));
    }

    /**
     * Restore a specific trashed record
     */
    public function restore($type, $id)
    {
        $config = $this->getModelConfig($type);
        if (!$config) {
            return back()->with('error', 'Kategori pemulihan tidak valid.');
        }

        $item = $config['model']::onlyTrashed()->findOrFail($id);
        $item->restore();

        return back()->with('success', "Data {$config['label']} berhasil dipulihkan (restore) ke sistem!");
    }

    /**
     * Restore all trashed records for a specific category
     */
    public function restoreAll($type)
    {
        $config = $this->getModelConfig($type);
        if (!$config) {
            return back()->with('error', 'Kategori pemulihan tidak valid.');
        }

        $count = $config['model']::onlyTrashed()->count();
        if ($count === 0) {
            return back()->with('info', 'Tidak ada data terhapus pada kategori ini.');
        }

        $config['model']::onlyTrashed()->restore();

        return back()->with('success', "Seluruh data {$config['label']} ({$count} data) berhasil dipulihkan!");
    }

    /**
     * Force delete a specific trashed record permanently
     */
    public function forceDelete($type, $id)
    {
        $config = $this->getModelConfig($type);
        if (!$config) {
            return back()->with('error', 'Kategori data tidak valid.');
        }

        $item = $config['model']::onlyTrashed()->findOrFail($id);

        // Delete physical files if model contains images
        if ($type === 'galeri' && !empty($item->gambar) && file_exists(public_path('storage/' . $item->gambar))) {
            @unlink(public_path('storage/' . $item->gambar));
        }

        if ($type === 'kegiatan' && !empty($item->foto) && file_exists(public_path('storage/' . $item->foto))) {
            @unlink(public_path('storage/' . $item->foto));
        }

        $item->forceDelete();

        return back()->with('success', "Data {$config['label']} berhasil dihapus secara permanen.");
    }

    /**
     * Empty entire trash for a specific category or all categories
     */
    public function emptyTrash($type)
    {
        if ($type === 'all') {
            $types = ['keuangan', 'donatur', 'kegiatan', 'kepanitiaan', 'inventaris', 'catatan', 'galeri', 'takmir', 'kategori', 'posisi', 'kondisi'];
            foreach ($types as $t) {
                $this->emptyCategoryTrash($t);
            }
            return back()->with('success', 'Seluruh tong sampah (semua kategori) berhasil dikosongkan secara permanen.');
        }

        $config = $this->getModelConfig($type);
        if (!$config) {
            return back()->with('error', 'Kategori data tidak valid.');
        }

        $count = $this->emptyCategoryTrash($type);

        return back()->with('success', "Tong sampah {$config['label']} ({$count} data) berhasil dikosongkan.");
    }

    /**
     * Helper to empty trash for a single category
     */
    protected function emptyCategoryTrash($type)
    {
        $config = $this->getModelConfig($type);
        if (!$config) return 0;

        $items = $config['model']::onlyTrashed()->get();
        $count = $items->count();

        foreach ($items as $item) {
            if ($type === 'galeri' && !empty($item->gambar) && file_exists(public_path('storage/' . $item->gambar))) {
                @unlink(public_path('storage/' . $item->gambar));
            }
            if ($type === 'kegiatan' && !empty($item->foto) && file_exists(public_path('storage/' . $item->foto))) {
                @unlink(public_path('storage/' . $item->foto));
            }
            $item->forceDelete();
        }

        return $count;
    }
}
