<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AcountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userss = User::where('id', '!=', auth()->id())
            ->latest()
            ->get();
        return view('acount', compact('userss'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|confirmed|min:8',
            ]);

            $validatedData['password'] = Hash::make($validatedData['password']);

            User::create($validatedData);
            return redirect()->back()->with('success', 'Akun berhasil di tambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan Akun. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required|confirmed|min:8',
            ]);

            $user->Update($validatedData);
            return redirect()->back()->with('success', 'Akun Berhasil di Dirubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal Merubah Akun, Email / Password Salah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            if ($user->foto && Storage::exists('public/' . $user->foto)) {
                Storage::delete('public/' . $user->foto);
            }

            $user->delete();

            return redirect()->back()->with('success', 'Akun berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus Akun. Silakan coba lagi.');
        }
    }
}
