<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function showLogin() {
        if (Auth::check())
            return redirect()->route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'kasir.index');
        return view('auth.login');
    }
    public function login(Request $request) {
        $request->validate(['username'=>'required','password'=>'required']);
        if (Auth::attempt($request->only('username','password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'kasir.index');
        }
        return back()->withErrors(['username'=>'Username atau password salah.'])->withInput();
    }
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
