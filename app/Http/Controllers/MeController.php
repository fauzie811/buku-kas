<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showProfile()
    {
        $user = Auth::user();

        return view('profile.index', compact('user'));
    }

    public function saveProfile(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'name' => ['nullable', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'alpha_num', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->update($request->only(['name', 'username', 'email']));

        return redirect()->back()->with('success', 'Berhasil memperbarui profil.');
    }

    public function showPasswordForm()
    {
        return view('profile.change-password');
    }

    public function savePassword(Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'string', 'confirmed'],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', 'Berhasil mengganti katasandi.');
    }
}
