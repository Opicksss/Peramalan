<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        return view('profile', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'nullable|confirmed|min:8',
        ]);

        try {
            // Hash password jika diubah
            if (!empty($validatedData['password'])) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            } else {
                // Jangan update password jika kosong
                unset($validatedData['password']);
            }

            $user->Update($validatedData);
            return redirect()->back()->with('success', 'Akun Berhasil di Dirubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal Merubah Akun, Email / Password Salah');
        }
    }

    public function foto(Request $request, User $user)
    {
        try {
            $validatedData = $request->validate([
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            if ($request->hasFile('foto')) {
                if ($user->foto && Storage::exists('public/' . $user->foto)) {
                    Storage::delete('public/' . $user->foto);
                }
                $validatedData['foto'] = $request->file('foto')->store('profile', 'public');
            }

            $user->Update($validatedData);
            return redirect()->back()->with('success', 'Foto Profile Berhasil di Dirubah');

        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            // Cek jika pesan error umum, terjemahkan ke Bahasa Indonesia
            if (str_contains($errorMessage, 'The foto field is required')) {
            $errorMessage = 'Foto wajib diunggah.';
            } elseif (str_contains($errorMessage, 'The foto must be an image')) {
            $errorMessage = 'File harus berupa gambar.';
            } elseif (str_contains($errorMessage, 'The foto must be a file of type: jpeg, png, jpg')) {
            $errorMessage = 'Foto harus bertipe jpeg, png, atau jpg.';
            } elseif (str_contains($errorMessage, 'The foto may not be greater than 2048 kilobytes')) {
            $errorMessage = 'Ukuran foto maksimal 2MB.';
            }

            return redirect()
            ->back()
            ->with('error', 'Terjadi kesalahan: ' . $errorMessage)
            ->withInput();
        }
    }

    public function reset(User $user)
    {
        try {
            if ($user->foto && Storage::exists('public/' . $user->foto)) {
                Storage::delete('public/' . $user->foto);
            }

            $user->update(['foto' => null]);

            return redirect()->back()->with('success', 'Foto Profile Berhasil di Direset');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal Mereset Foto Profile');
        }
    }
}
