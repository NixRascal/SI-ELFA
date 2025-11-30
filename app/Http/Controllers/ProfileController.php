<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil
     */
    public function index()
    {
        $admin = Auth::user();
        return view('admin.profile.index', compact('admin'));
    }

    /**
     * Perbarui informasi profil
     */
    public function update(Request $request)
    {
        $admin = Auth::user();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email,' . $admin->id,
        ]);

        $admin->update($validated);

        return redirect()->route('dashboard.profile.index')
            ->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Perbarui password
     */
    public function updatePassword(Request $request)
    {
        $admin = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Cek password saat ini
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak sesuai'
            ]);
        }

        // Perbarui password
        $admin->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('dashboard.profile.index')
            ->with('success', 'Password berhasil diubah');
    }
    /**
     * Hapus akun
     */
    public function destroy(Request $request)
    {
        $admin = Auth::user();

        Auth::logout();

        $admin->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Akun Anda telah berhasil dihapus.');
    }
}
