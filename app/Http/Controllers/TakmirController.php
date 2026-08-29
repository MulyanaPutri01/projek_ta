<?php

namespace App\Http\Controllers;

use App\Models\Takmir;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class TakmirController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list')->only(['index', 'show']);
        $this->middleware('permission:user-create')->only(['create', 'store']);
        $this->middleware('permission:user-edit')->only(['edit', 'update', 'toggleStatus']);
        $this->middleware('permission:user-delete')->only(['destroy']);
    }

    // Menampilkan daftar takmir
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Takmir::with('role')->select('takmir.*');

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('role_id')) {
                $query->where('role_id', $request->role_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('user_info', function ($row) {
                    $initial = strtoupper(substr($row->nama_takmir, 0, 1));
                    $bgColors = ['bg-primary', 'bg-success', 'bg-info', 'bg-warning', 'bg-danger'];
                    $color = $bgColors[$row->id % count($bgColors)];
                    
                    return '
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle ' . $color . ' text-white d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 40px; height: 40px; font-size: 1rem; flex-shrink: 0;">
                                ' . $initial . '
                            </div>
                            <div>
                                <div class="fw-bold text-dark">' . e($row->nama_takmir) . '</div>
                                <small class="text-muted"><i class="bi bi-person me-1"></i>' . e($row->username) . '</small>
                            </div>
                        </div>
                    ';
                })
                ->addColumn('role_name', function ($row) {
                    if (!$row->role) return '-';
                    $roleName = strtolower(trim($row->role->nama_role));
                    if ($roleName === 'admin') {
                        return '<span class="badge bg-primary"><i class="bi bi-shield-lock me-1"></i> Admin</span>';
                    } elseif ($roleName === 'bendahara') {
                        return '<span class="badge bg-success"><i class="bi bi-cash-coin me-1"></i> Bendahara</span>';
                    } elseif ($roleName === 'sekretaris') {
                        return '<span class="badge bg-warning"><i class="bi bi-file-earmark-text me-1"></i> Sekretaris</span>';
                    }
                    return '<span class="badge bg-secondary">' . ucfirst($row->role->nama_role) . '</span>';
                })
                ->addColumn('status_badge', function ($row) {
                    return ($row->status === 'active')
                        ? '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Aktif</span>'
                        : '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Nonaktif</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('takmir.edit', $row->id);
                    $toggleUrl = route('takmir.toggleStatus', $row->id);
                    $deleteUrl = route('takmir.destroy', $row->id);
                    $csrf = csrf_field();
                    $putMethod = method_field('PUT');
                    $deleteMethod = method_field('DELETE');

                    $toggleBtn = ($row->status === 'active')
                        ? '<form action="' . $toggleUrl . '" method="POST" class="d-inline">' . $csrf . $putMethod . '<button type="submit" class="btn btn-secondary btn-sm" title="Nonaktifkan Akun" onclick="return confirm(\'Nonaktifkan akun ini?\')"><i class="bi bi-slash-circle me-1"></i> Nonaktifkan</button></form>'
                        : '<form action="' . $toggleUrl . '" method="POST" class="d-inline">' . $csrf . $putMethod . '<button type="submit" class="btn btn-success btn-sm" title="Aktifkan Akun"><i class="bi bi-check-circle me-1"></i> Aktifkan</button></form>';

                    return '
                        <div class="d-flex justify-content-center gap-1 flex-wrap">
                            <a href="' . $editUrl . '" class="btn btn-warning btn-sm" title="Edit Akun"><i class="bi bi-pencil-square me-1"></i> Edit</a>
                            ' . $toggleBtn . '
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus akun takmir ini?\')">
                                ' . $csrf . '
                                ' . $deleteMethod . '
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus Akun"><i class="bi bi-trash me-1"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['user_info', 'role_name', 'status_badge', 'action'])
                ->make(true);
        }

        $totalTakmir = Takmir::count();
        $totalActive = Takmir::where('status', 'active')->count();
        $totalInactive = Takmir::where('status', 'inactive')->count();
        $roles = Role::all();

        return view('admin.takmir.index', compact('totalTakmir', 'totalActive', 'totalInactive', 'roles'));
    }

    // Menampilkan form tambah takmir
    public function create()
    {
        $roles = Role::all();
        return view('admin.takmir.create', compact('roles'));
    }

    // Menyimpan data takmir baru
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:30|unique:takmir,username',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:role,id',
            'nama_takmir' => 'required|string|max:50',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        $selectedRole = Role::findOrFail($request->role_id);

        $takmir = Takmir::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status' => 'active',
            'role_id' => $request->role_id,
            'nama_takmir' => $request->nama_takmir,
        ]);

        $takmir->syncRoles([strtolower($selectedRole->nama_role)]);

        return redirect()->route('takmir.index')->with('success', 'Takmir berhasil ditambahkan');
    }

    // Menampilkan form edit takmir
    public function edit($id)
    {
        $takmir = Takmir::findOrFail($id);
        $roles = Role::all();
        return view('admin.takmir.edit', compact('takmir', 'roles'));
    }

    // Memperbarui data takmir
    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string|max:30|unique:takmir,username,' . $id . ',id',
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:role,id',
            'nama_takmir' => 'required|string|max:50',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'role_id.required' => 'Role wajib dipilih.',
            'nama_takmir.required' => 'Nama takmir wajib diisi.',
        ]);

        $takmir = Takmir::findOrFail($id);
        $takmir->username = $request->username;

        if ($request->filled('password')) {
            $takmir->password = Hash::make($request->password);
        }

        $takmir->role_id = $request->role_id;
        $takmir->nama_takmir = $request->nama_takmir;
        $takmir->save();

        $selectedRole = Role::find($request->role_id);
        if ($selectedRole) {
            $takmir->syncRoles([strtolower($selectedRole->nama_role)]);
        }

        return redirect()->route('takmir.index')->with('success', 'Data Takmir berhasil diperbarui.');
    }

    // Menghapus data takmir
    public function destroy($id)
    {
        $takmir = Takmir::findOrFail($id);
        $takmir->delete();

        return redirect()->route('takmir.index')->with('success', 'Takmir berhasil dihapus');
    }

    public function toggleStatus($id)
    {
        $takmir = Takmir::findOrFail($id);
        $takmir->status = ($takmir->status == 'active') ? 'inactive' : 'active';
        $takmir->save();

        return redirect()->route('takmir.index')->with('success', 'Status takmir berhasil diubah');
    }
}
