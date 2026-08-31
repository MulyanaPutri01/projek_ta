<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of permissions with DataTables and filters.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Permission::with('roles')->select('permissions.*');

            if ($request->filled('role')) {
                $query->whereHas('roles', function ($q) use ($request) {
                    $q->where('name', $request->role);
                });
            }

            if ($request->filled('module')) {
                $query->where('name', 'LIKE', $request->module . '-%');
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return '
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1.5 font-monospace fw-semibold fs-7">
                                ' . e($row->name) . '
                            </span>
                        </div>
                    ';
                })
                ->addColumn('module_badge', function ($row) {
                    $parts = explode('-', $row->name);
                    $prefix = $parts[0] ?? 'lainnya';
                    $moduleMap = [
                        'user'         => ['label' => 'Pengguna', 'badge' => 'bg-info-subtle text-info border-info-subtle', 'icon' => 'bi-person'],
                        'role'         => ['label' => 'Peran (Role)', 'badge' => 'bg-primary-subtle text-primary border-primary-subtle', 'icon' => 'bi-shield-lock'],
                        'permission'   => ['label' => 'Hak Akses', 'badge' => 'bg-dark-subtle text-dark border-dark-subtle', 'icon' => 'bi-key'],
                        'keuangan'     => ['label' => 'Keuangan Kas', 'badge' => 'bg-success-subtle text-success border-success-subtle', 'icon' => 'bi-wallet2'],
                        'laporan'      => ['label' => 'Laporan Kas', 'badge' => 'bg-success-subtle text-success border-success-subtle', 'icon' => 'bi-file-earmark-text'],
                        'donatur'      => ['label' => 'Data Donatur', 'badge' => 'bg-success-subtle text-success border-success-subtle', 'icon' => 'bi-heart-fill'],
                        'kategori'     => ['label' => 'Kategori Kas', 'badge' => 'bg-success-subtle text-success border-success-subtle', 'icon' => 'bi-tags'],
                        'kegiatan'     => ['label' => 'Agenda Kegiatan', 'badge' => 'bg-warning-subtle text-warning-emphasis border-warning-subtle', 'icon' => 'bi-calendar-event'],
                        'kepanitiaan'  => ['label' => 'Kepanitiaan', 'badge' => 'bg-warning-subtle text-warning-emphasis border-warning-subtle', 'icon' => 'bi-people'],
                        'posisi'       => ['label' => 'Master Posisi', 'badge' => 'bg-warning-subtle text-warning-emphasis border-warning-subtle', 'icon' => 'bi-person-badge'],
                        'inventaris'   => ['label' => 'Inventaris Barang', 'badge' => 'bg-info-subtle text-info border-info-subtle', 'icon' => 'bi-box-seam'],
                        'catatan'      => ['label' => 'Catatan Kondisi', 'badge' => 'bg-info-subtle text-info border-info-subtle', 'icon' => 'bi-clipboard-check'],
                        'kondisi'      => ['label' => 'Master Kondisi', 'badge' => 'bg-info-subtle text-info border-info-subtle', 'icon' => 'bi-patch-check'],
                        'profilmasjid' => ['label' => 'Profil Masjid', 'badge' => 'bg-secondary-subtle text-secondary border-secondary-subtle', 'icon' => 'bi-building'],
                        'galeri'       => ['label' => 'Galeri Foto', 'badge' => 'bg-secondary-subtle text-secondary border-secondary-subtle', 'icon' => 'bi-images'],
                    ];

                    $m = $moduleMap[$prefix] ?? ['label' => ucfirst($prefix), 'badge' => 'bg-secondary-subtle text-secondary border-secondary-subtle', 'icon' => 'bi-shield-check'];
                    return '<span class="badge ' . $m['badge'] . ' border px-2.5 py-1 fw-semibold"><i class="bi ' . $m['icon'] . ' me-1"></i>' . e($m['label']) . '</span>';
                })
                ->addColumn('roles_list', function ($row) {
                    if ($row->roles->isEmpty()) {
                        return '<span class="text-muted small fst-italic">Belum ada peran</span>';
                    }
                    $badges = '';
                    foreach ($row->roles as $role) {
                        $roleName = strtolower($role->name);
                        $bg = 'bg-secondary-subtle text-secondary border border-secondary-subtle';
                        if ($roleName === 'admin') $bg = 'bg-primary-subtle text-primary border border-primary-subtle';
                        elseif ($roleName === 'bendahara') $bg = 'bg-success-subtle text-success border border-success-subtle';
                        elseif ($roleName === 'sekretaris') $bg = 'bg-warning-subtle text-warning-emphasis border border-warning-subtle';

                        $badges .= '<span class="badge ' . $bg . ' me-1 mb-1 px-2 py-1">' . ucfirst($role->name) . '</span>';
                    }
                    return '<div class="d-flex flex-wrap align-items-center">' . $badges . '</div>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('permissions.edit', $row->id);
                    $deleteUrl = route('permissions.destroy', $row->id);
                    $csrf = csrf_field();
                    $deleteMethod = method_field('DELETE');

                    return '
                        <div class="d-flex justify-content-center gap-1">
                            <a href="' . $editUrl . '" class="btn btn-warning btn-sm shadow-sm" title="Edit Hak Akses"><i class="bi bi-pencil-square me-1"></i> Edit</a>
                            <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus permission ' . e($row->name) . '?\')">
                                ' . $csrf . '
                                ' . $deleteMethod . '
                                <button type="submit" class="btn btn-danger btn-sm shadow-sm" title="Hapus Hak Akses"><i class="bi bi-trash me-1"></i> Hapus</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['name', 'module_badge', 'roles_list', 'action'])
                ->make(true);
        }

        $totalPermissions = Permission::count();
        $roles = Role::all();
        $totalRoles = $roles->count();

        return view('admin.permissions.index', compact('totalPermissions', 'totalRoles', 'roles'));
    }

    /**
     * Show the form for creating a new permission.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.permissions.create', compact('roles'));
    }

    /**
     * Store a newly created permission in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:permissions,name',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ], [
            'name.required' => 'Nama permission wajib diisi.',
            'name.unique'   => 'Nama permission sudah ada di sistem.',
        ]);

        $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9\-_]+/', '-', $request->name)));

        $permission = Permission::create([
            'name' => $slug,
            'guard_name' => 'web',
        ]);

        // Auto assign to selected roles
        if ($request->filled('roles')) {
            $selectedRoles = Role::whereIn('id', $request->roles)->get();
            foreach ($selectedRoles as $role) {
                $role->givePermissionTo($permission);
            }
        }

        // Ensure Admin role has the permission
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole && !$adminRole->hasPermissionTo($permission)) {
            $adminRole->givePermissionTo($permission);
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('permissions.index')->with('success', "Hak akses (Permission) '{$permission->name}' berhasil ditambahkan.");
    }

    /**
     * Show the form for editing the specified permission.
     */
    public function edit($id)
    {
        $permission = Permission::with('roles')->findOrFail($id);
        $roles = Role::all();
        $assignedRoleIds = $permission->roles->pluck('id')->toArray();

        return view('admin.permissions.edit', compact('permission', 'roles', 'assignedRoleIds'));
    }

    /**
     * Update the specified permission in storage.
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:permissions,name,' . $id . ',id',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ], [
            'name.required' => 'Nama permission wajib diisi.',
            'name.unique'   => 'Nama permission sudah digunakan.',
        ]);

        $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9\-_]+/', '-', $request->name)));
        $permission->name = $slug;
        $permission->save();

        // Sync with roles
        $targetRoles = Role::all();
        $selectedRoleIds = $request->roles ?? [];

        foreach ($targetRoles as $role) {
            if (in_array($role->id, $selectedRoleIds)) {
                if (!$role->hasPermissionTo($permission)) {
                    $role->givePermissionTo($permission);
                }
            } else {
                if ($role->name !== 'admin' && $role->hasPermissionTo($permission)) {
                    $role->revokePermissionTo($permission);
                }
            }
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('permissions.index')->with('success', "Hak akses '{$permission->name}' berhasil diperbarui.");
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $name = $permission->name;

        $permission->delete();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('permissions.index')->with('success', "Hak akses '{$name}' berhasil dihapus.");
    }
}
