<?php

namespace App\Http\Controllers;

use App\Models\Takmir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where('nama_takmir', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:30|unique:takmir,username',
            'password' => 'required|string|min:8',
            'status' => 'required|in:aktif,nonaktif',
            'role_id_role' => 'required|exists:role,id_role',
            'nama_takmir' => 'required|string',

        ]);

        Takmir::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'role_id_role' => $request->role_id_role,
            'nama_takmir' => $request->nama_takmir,

        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(Takmir $takmir)
    {
        return view('users.edit', compact('takmir'));
    }

    public function update(Request $request, Takmir $takmir)
    {
        $request->validate([
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $takmir->update([
            'status' => $request->status,
        ]);

        return redirect()->route('users.index')->with('success', 'Status user berhasil diperbarui.');
    }
}

