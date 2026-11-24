<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    public function edit()
    {
        return view('admin.account');
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'  => 'required|string|max:100',
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        $user->update($data);

        return back()->with('sukses', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validateWithBag('password', [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', Password::min(8), 'confirmed'],
        ], [
            'current_password.current_password' => 'Password saat ini salah.',
            'password.confirmed'                => 'Konfirmasi password tidak sama.',
            'password.min'                      => 'Password baru minimal 8 karakter.',
        ]);

        $request->user()->update(['password' => Hash::make($data['password'])]);

        return back()->with('sukses', 'Password berhasil diganti.');
    }
}
