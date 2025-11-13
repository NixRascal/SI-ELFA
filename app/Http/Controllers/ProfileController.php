<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show profile page
     */
    public function index()
    {
        $admin = Auth::user();
        return view('admin.profile.index', compact('admin'));
    }

    /**
     * Update profile information
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
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $admin = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // Check current password
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak sesuai'
            ]);
        }

        // Update password
        $admin->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('dashboard.profile.index')
            ->with('success', 'Password berhasil diubah');
    }
}
