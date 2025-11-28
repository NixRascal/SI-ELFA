<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminManagementController extends Controller
{
    /**
     * Tampilkan daftar admin.
     */
    public function index(): View
    {
        $admins = Admin::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.manajemen.index', compact('admins'));
    }

    /**
     * Tampilkan formulir untuk membuat admin baru.
     */
    public function create(): View
    {
        return view('admin.manajemen.create');
    }

    /**
     * Simpan admin yang baru dibuat ke penyimpanan.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        Admin::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('dashboard.admin.index')
            ->with('success', 'Admin berhasil ditambahkan');
    }

    /**
     * Tampilkan formulir untuk mengedit admin yang ditentukan.
     */
    public function edit(Admin $admin): View
    {
        return view('admin.manajemen.edit', compact('admin'));
    }

    /**
     * Perbarui admin yang ditentukan di penyimpanan.
     */
    public function update(Request $request, Admin $admin): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email,' . $admin->id,
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $admin->nama = $validated['nama'];
        $admin->email = $validated['email'];

        if ($request->filled('password')) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return redirect()->route('dashboard.admin.index')
            ->with('success', 'Admin berhasil diperbarui');
    }

    /**
     * Hapus admin yang ditentukan dari penyimpanan.
     */
    public function destroy(Admin $admin): RedirectResponse
    {
        // Cegah penghapusan diri sendiri
        if ($admin->id === auth()->id()) {
            return redirect()->route('dashboard.admin.index')
                ->with('error', 'Tidak dapat menghapus akun Anda sendiri');
        }

        $admin->delete();

        return redirect()->route('dashboard.admin.index')
            ->with('success', 'Admin berhasil dihapus');
    }
}
