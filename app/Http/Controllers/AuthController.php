<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequests\ChangePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            "title" => "Masuk"
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        // cek apakah user aktif
        $credentials['is_active'] = 1;

        $remember = $request->get('remember') == "on" ?? false;

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Anda berhasil login.');
        }

        return back()->with(
            'failed',
            'Login gagal, silahkan coba lagi!',
        )->withInput();
    }

    public function logout()
    {
        auth()->logout();

        request()->session()->regenerate();
        request()->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil keluar.');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = auth()->user();
        $currentPassword = $request->current_password;
        $newPassword = $request->new_password;

        if (!Hash::check($currentPassword, $user->password))
            return redirect()->back()->with('failed', 'Gagal mengubah password.');

        $user->password = Hash::make($newPassword);
        $user->save();

        auth()->logout();
        request()->session()->regenerate();
        request()->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Password berhasil diubah, Silahkan login dengan password baru!');
    }
}
