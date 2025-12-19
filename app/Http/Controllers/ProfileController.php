<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('dashboard.profile');
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $user->id,
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'username', 'alamat', 'no_telp');

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['foto_profil'] = $path;
        }

        $user->update($data);

        return redirect()->route('admin.profile.edit')->with('success', 'Profil berhasil diperbarui');
    }

    public function editAccount()
    {
        return view('dashboard.account');
    }

    public function updateAccount(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai'])->withInput();
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.account.edit')->with('success', 'Password berhasil diperbarui');
    }
}
