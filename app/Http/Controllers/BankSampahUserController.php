<?php

namespace App\Http\Controllers;

use App\Models\BankSampahUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BankSampahUserController extends Controller
{
    public function index(Request $request)
    {
        $users = BankSampahUser::with('creator')->get();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $users
            ]);
        }

        $data['page_title'] = 'Bank Sampah User';
        $data['table_title'] = 'Daftar Bank Sampah User';
        $data['users'] = $users;

        return view('banksampahusers.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Tambah Bank Sampah User';
        return view('banksampahusers.create', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:banksampahusers,username',
            'password' => 'required|string|min:6',
            'nama_bank_sampah' => 'required|string',
            'alamat' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'jam_operasional' => 'nullable|string',
            'nomor_telepon' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ]);

        $admin = User::whereHas('roles', function($q) {
            $q->where('name', 'Admin');
        })->first();

        $user = new BankSampahUser();
        $user->username = $validated['username'];
        $user->password = Hash::make($validated['password']);
        $user->nama_bank_sampah = $validated['nama_bank_sampah'];
        $user->alamat = $validated['alamat'] ?? null;
        $user->kecamatan = $validated['kecamatan'] ?? null;
        $user->jam_operasional = $validated['jam_operasional'] ?? null;
        $user->nomor_telepon = $validated['nomor_telepon'] ?? null;
        $user->deskripsi = $validated['deskripsi'] ?? null;
        $user->created_by = Auth::id() ?? ($admin ? $admin->id : null);
        $user->save();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Bank Sampah User created successfully',
                'data' => $user
            ], 201);
        }

        return redirect()->route('banksampah-users.index')->with('success', 'Bank Sampah User created successfully!');
    }

    public function bankSampahProfile(Request $request, $id)
    {
        $banksampah = BankSampahUser::findOrFail($id);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        }

        $data = [
            'page_title' => 'Profil Bank Sampah',
            'banksampah' => $banksampah,
        ];

        return view('v2.user.adminbanksampah.adminbank-profile', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Bank Sampah User';
        $data['user'] = BankSampahUser::findOrFail($id);
        return view('banksampahusers.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $user = BankSampahUser::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|unique:banksampahusers,username,' . $id . ',banksampah_id',
            'password' => 'nullable|string|min:6',
            'nama_bank_sampah' => 'required|string',
            'alamat' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'jam_operasional' => 'nullable|string',
            'nomor_telepon' => 'nullable|string',
            'deskripsi' => 'nullable|string',
        ]);

        $user->username = $validated['username'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->nama_bank_sampah = $validated['nama_bank_sampah'];
        $user->alamat = $validated['alamat'] ?? null;
        $user->kecamatan = $validated['kecamatan'] ?? null;
        $user->jam_operasional = $validated['jam_operasional'] ?? null;
        $user->nomor_telepon = $validated['nomor_telepon'] ?? null;
        $user->deskripsi = $validated['deskripsi'] ?? null;
        $user->save();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Bank Sampah User updated successfully',
                'data' => $user
            ]);
        }

        return redirect()->route('banksampah-users.show', $id)->with('success', 'Bank Sampah User updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $user = BankSampahUser::findOrFail($id);
        $user->delete();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Bank Sampah User deleted successfully'
            ]);
        }

        return redirect()->route('banksampah-users.index')->with('success', 'Bank Sampah User deleted successfully!');
    }
}
