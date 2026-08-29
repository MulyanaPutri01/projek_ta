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
                ->addColumn('role_name', function ($row) {
                    return $row->role ? '<span class="badge bg-primary">' . ucfirst($row->role->nama_role) . '</span>' : '-';
                })
                ->addColumn('status_badge', function ($row) {
                    if ($row->status === 'active') {
                        return '<span class="badge bg-success">Aktif</span>';
                    }
                    return '<span class="badge bg-danger">Nonaktif</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('users.edit', $row->id);
                    $deleteUrl = route('users.destroy', $row->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <a href="' . $editUrl . '" class="btn btn-warning btn-sm" title="Edit"><i class="bi bi-pencil-square"></i> Edit</a>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus pengguna ini?\');">
                                ' . $csrf . '
                                ' . $method . '
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="bi bi-trash"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['role_name', 'status_badge', 'action'])
                ->make(true);
        }

        $roles = Role::all();
        return view('users.index', compact('roles'));
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
            'username' => 'required|string|max:30|unique:takmir,username',
            'password' => 'required|string|min:8',
            'status' => 'required|in:active,inactive',
            'role_id' => 'required|exists:role,id',
        ]);

        $selectedRole = Role::findOrFail($request->role_id);

        $takmir = Takmir::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'role_id' => $request->role_id,
            'nama_takmir' => $request->nama_takmir,
        ]);

        $takmir->syncRoles([strtolower($selectedRole->nama_role)]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
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
            'status' => 'required|in:active,inactive',
            'role_id' => 'required|exists:role,id',
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'nama_takmir' => $request->nama_takmir,
            'status' => $request->status,
            'role_id' => $request->role_id,
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

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
