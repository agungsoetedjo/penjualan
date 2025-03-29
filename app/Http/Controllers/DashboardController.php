<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {

        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Silakan login sebagai admin.');
        }
        
        $totalProduk = Produk::count();
        $totalKategori = Kategori::count();

        $kategoriProduk = Kategori::leftJoin('produk', 'kategori.id', '=', 'produk.kategori_id')
            ->selectRaw('kategori.nama, COUNT(produk.id) as total_produk')
            ->groupBy('kategori.nama')
            ->get();

        // Pastikan data tidak kosong
        if ($kategoriProduk->isEmpty()) {
            $kategoriLabels = [];
            $kategoriCounts = [];
        } else {
            $kategoriLabels = $kategoriProduk->pluck('nama')->toArray();
            $kategoriCounts = $kategoriProduk->pluck('total_produk')->toArray();
        }

        return view('dashboard.index', compact('totalProduk', 'totalKategori', 'kategoriLabels', 'kategoriCounts'));
    }

    public function showLogin()
    {
        return view('dashboard.admin_login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $credentials['username'])->first();

        
        if ($user && Hash::check($credentials['password'], $user->password) && $user->role === 'admin') {
            Auth::login($user);
            return redirect()->intended(route('admin.dashboard'))->with('success', 'Login berhasil!');
        }

        return back()->withErrors(['login' => 'Username atau password salah!']);
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Logout berhasil!');
    }

}
