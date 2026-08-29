<?php

namespace App\Http\Controllers;

use App\Models\Takmir;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list')->only(['index', 'show']);
        $this->middleware('permission:user-create')->only(['create', 'store']);
        $this->middleware('permission:user-edit')->only(['edit', 'update']);
        $this->middleware('permission:user-delete')->only(['destroy']);
    }

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
                        return '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1.5"><i class="bi bi-shield-lock-fill me-1"></i> Administrator</span>';
                    } elseif ($roleName === 'bendahara') {
                        return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5"><i class="bi bi-wallet-fill me-1"></i> Bendahara</span>';
                    } elseif ($roleName === 'sekretaris') {
                        return '<span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2.5 py-1.5"><i class="bi bi-file-earmark-text-fill me-1"></i> Sekretaris</span>';
                    }
                    return '<span class="badge bg-light text-secondary border px-2.5 py-1.5">' . ucfirst($row->role->nama_role) . '</span>';
                })
                ->addColumn('status_badge', function ($row) {
                    if ($row->status === 'active') {
                        return '<span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-check-circle me-1"></i> Aktif</span>';
                    }
                    return '<span class="badge bg-danger-subtle text-danger border border-danger-subtle"><i class="bi bi-x-circle me-1"></i> Nonaktif</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('users.edit', $row->id);
                    $deleteUrl = route('users.destroy', $row->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <a href="' . $editUrl . '" class="btn btn-warning btn-sm shadow-sm" title="Edit Pengguna"><i class="bi bi-pencil-square me-1"></i> Edit</a>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus pengguna ini?\');">
                                ' . $csrf . '
                                ' . $method . '
                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" title="Hapus Pengguna"><i class="bi bi-trash me-1"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['user_info', 'role_name', 'status_badge', 'action'])
                ->make(true);
        }

        $totalUsers = Takmir::count();
        $totalActive = Takmir::where('status', 'active')->count();
        $totalInactive = Takmir::where('status', 'inactive')->count();
        $roles = Role::all();

        return view('users.index', compact('roles', 'totalUsers', 'totalActive', 'totalInactive'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_takmir' => 'required|string|max:50',
            'username'    => 'required|string|max:30|unique:takmir,username',
            'password'    => 'required|string|min:8|confirmed',
            'status'      => 'required|in:active,inactive',
            'role_id'     => 'required|exists:role,id',
        ], [
            'nama_takmir.required' => 'Nama lengkap pengguna wajib diisi.',
            'username.required'    => 'Username wajib diisi.',
            'username.unique'      => 'Username ini sudah digunakan, silakan pilih username lain.',
            'password.required'    => 'Password akun wajib diisi.',
            'password.min'         => 'Password minimal harus 8 karakter.',
            'password.confirmed'   => 'Konfirmasi password tidak cocok.',
            'role_id.required'     => 'Silakan tentukan peran / role pengguna.',
        ]);

        $selectedRole = Role::findOrFail($request->role_id);

        $takmir = Takmir::create([
            'username'    => $request->username,
            'password'    => Hash::make($request->password),
            'status'      => $request->status,
            'role_id'     => $request->role_id,
            'nama_takmir' => $request->nama_takmir,
        ]);

        $takmir->syncRoles([strtolower($selectedRole->nama_role)]);

        return redirect()->route('users.index')->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $takmir = Takmir::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('takmir', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $takmir = Takmir::findOrFail($id);

        $request->validate([
            'nama_takmir' => 'required|string|max:50',
            'username'    => 'required|string|max:30|unique:takmir,username,' . $id . ',id',
            'status'      => 'required|in:active,inactive',
            'role_id'     => 'required|exists:role,id',
            'password'    => 'nullable|string|min:8|confirmed',
        ], [
            'nama_takmir.required' => 'Nama lengkap pengguna wajib diisi.',
            'username.required'    => 'Username wajib diisi.',
            'username.unique'      => 'Username ini sudah digunakan, silakan pilih username lain.',
            'password.min'         => 'Password minimal harus 8 karakter.',
            'password.confirmed'   => 'Konfirmasi password tidak cocok.',
            'role_id.required'     => 'Silakan tentukan peran / role pengguna.',
        ]);

        $data = [
            'nama_takmir' => $request->nama_takmir,
            'username'    => $request->username,
            'status'      => $request->status,
            'role_id'     => $request->role_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $takmir->update($data);

        $selectedRole = Role::find($request->role_id);
        if ($selectedRole) {
            $takmir->syncRoles([strtolower($selectedRole->nama_role)]);
        }

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $takmir = Takmir::findOrFail($id);
        $takmir->delete();

        return redirect()->route('users.index')->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
