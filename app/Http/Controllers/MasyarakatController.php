<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MasyarakatController extends Controller
{
    public function index(Request $request)
    {
        $masyarakats = Masyarakat::with(['user', 'approver'])->get();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $masyarakats
            ]);
        }

        $data['page_title'] = 'Masyarakat';
        $data['table_title'] = 'Daftar Masyarakat';
        $data['masyarakats'] = $masyarakats;

        return view('masyarakats.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Register Masyarakat';
        $data['users'] = User::doesntHave('masyarakat')->get();
        return view('masyarakats.create', $data);
    }

    public function store(Request $request)
    {
        $rules = [
            'nik' => 'required|string|size:16|unique:masyarakats,nik',
            'identity_photo' => 'required',
            'gender' => 'required|in:Laki-laki,Perempuan',
        ];

        if ($request->is('api/*') && !$request->has('user_id')) {
            $rules['name'] = 'required|string';
            $rules['username'] = 'required|string|unique:users,username';
            $rules['email'] = 'required|email|unique:users,email';
            $rules['password'] = 'required|string|min:6';
            $rules['phone'] = 'required|string';
            $rules['alamat'] = 'required|string';
        } else {
            $rules['user_id'] = 'required|exists:users,id|unique:masyarakats,user_id';
        }

        if ($request->hasFile('identity_photo')) {
            $rules['identity_photo'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $validated = $request->validate($rules);

        $userId = $request->get('user_id');

        if (!$userId) {
            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'],
                'address' => $validated['alamat'],
            ]);
            $user->user_code = 'NSB' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
            $user->save();
            $user->assignRole('Masyarakat');
            $userId = $user->id;
        } else {
            $user = User::findOrFail($userId);
            if (!$user->hasRole('Masyarakat')) {
                $user->assignRole('Masyarakat');
            }
        }

        $masyarakat = new Masyarakat();
        $masyarakat->user_id = $userId;
        $masyarakat->nik = $validated['nik'];
        $masyarakat->gender = $validated['gender'];
        $masyarakat->verification = $request->get('verification', 'Menunggu');

        if ($request->hasFile('identity_photo')) {
            $image = $request->file('identity_photo');
            $name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('ui/images/masyarakat');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $name);
            $masyarakat->identity_photo = 'ui/images/masyarakat/' . $name;
        } else {
            $masyarakat->identity_photo = $request->get('identity_photo');
        }

        $masyarakat->save();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Masyarakat profile created successfully',
                'data' => $masyarakat->load('user')
            ], 201);
        }

        return redirect()->route('masyarakats.index')->with('success', 'Masyarakat profile registered successfully!');
    }

    public function show(Request $request, $id)
    {
        $masyarakat = Masyarakat::with(['user', 'approver'])->findOrFail($id);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $masyarakat
            ]);
        }

        $data['page_title'] = 'Detail Masyarakat';
        $data['masyarakat'] = $masyarakat;
        return view('masyarakats.show', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit Masyarakat';
        $data['masyarakat'] = Masyarakat::findOrFail($id);
        return view('masyarakats.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $masyarakat = Masyarakat::findOrFail($id);

        $rules = [
            'nik' => 'required|string|size:16|unique:masyarakats,nik,' . $id . ',masyarakat_id',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'verification' => 'nullable|in:Menunggu,Disetujui,Ditolak',
        ];

        if ($request->hasFile('identity_photo')) {
            $rules['identity_photo'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $validated = $request->validate($rules);

        $masyarakat->nik = $validated['nik'];
        $masyarakat->gender = $validated['gender'];

        if ($request->has('verification')) {
            $oldVerif = $masyarakat->verification;
            $newVerif = $request->get('verification');
            $masyarakat->verification = $newVerif;

            if ($newVerif === 'Disetujui' && $oldVerif !== 'Disetujui') {
                $admin = User::whereHas('roles', function($q) {
                    $q->where('name', 'Admin');
                })->first();
                $masyarakat->approved_by = Auth::id() ?? ($admin ? $admin->id : null);
            }
        }

        if ($request->hasFile('identity_photo')) {
            if ($masyarakat->identity_photo) {
                $oldPath = public_path($masyarakat->identity_photo);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $image = $request->file('identity_photo');
            $name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('ui/images/masyarakat');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $name);
            $masyarakat->identity_photo = 'ui/images/masyarakat/' . $name;
        } elseif ($request->has('identity_photo')) {
            $masyarakat->identity_photo = $request->get('identity_photo');
        }

        $masyarakat->save();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Masyarakat profile updated successfully',
                'data' => $masyarakat->load('user')
            ]);
        }

        return redirect()->route('masyarakats.show', $id)->with('success', 'Masyarakat profile updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        $masyarakat = Masyarakat::findOrFail($id);

        if ($masyarakat->identity_photo) {
            $path = public_path($masyarakat->identity_photo);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $masyarakat->delete();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Masyarakat profile deleted successfully'
            ]);
        }

        return redirect()->route('masyarakats.index')->with('success', 'Masyarakat profile deleted successfully!');
    }
}
