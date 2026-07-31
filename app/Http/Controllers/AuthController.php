<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller {

    public function login(Request $request) {
        $credentials = $request->validate([
            'identifier' => 'nullable|string|max:50',
            'password' => 'required|string',
        ]);

        $identifier = $credentials['identifier'] ?? null;
        $password = $credentials['password'];

        if (!$identifier) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'NIK atau username harus diisi',
                ], 422);
            }
            return back()->withErrors(['credential' => 'NIK atau username harus diisi'])->withInput();
        }

        $user = null;

        $user = User::where('username',$identifier)
            ->orWhereHas('masyarakat', function ($querying) use ($identifier){
                $querying->where('nik', $identifier);
            })->first();

        if (!$user || !Hash::check($password, $user->password)) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'NIK/username atau password salah',
                ], 401);
            }
            return back()->withErrors(['identifier' => 'NIK/username atau password salah'])->withInput();
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        $user = $user->load('masyarakat');

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'data' => $user,
            ]);
        }

        if ($user->hasRole('Super Admin')) {
            return redirect()->route('sa.dashboard')
                ->with('user_name', $user->name);
        } elseif ($user->hasRole('Admin Bank Sampah')) {
            return redirect()->route('admin.dashboard')
                ->with('user_name', $user->name);
        } elseif ($user->hasRole('Masyarakat')) {
            if ($user->masyarakat && $user->masyarakat->verification) {
                $verification = strtolower(trim($user->masyarakat->verification));

                if ($verification === 'menunggu') {
                    return redirect()->route('waiting')
                        ->with('user_name', $user->name)
                        ->with('user_nik', $user->masyarakat->nik)
                        ->with('user_email', $user->email);
                } elseif ($verification === 'ditolak') {
                    Auth::logout();
                    return back()
                        ->withErrors(['credential' => 'Akun Anda ditolak. Hubungi admin.'])
                        ->withInput();
                }
            }

            return redirect()->route('dashboard')
                ->with('user_name', $user->name)
                ->with('user_total_poin', $user->poin)
                ->with('user_total_gramasi', $user->total_gramasi)
                ->with('user_total_selesai', $user->total_selesai)
                ->with('user_total_voucher', $user->voucher);
        }

        return redirect()->route('v1.dashboard');
    }

    # register user + masyarakat data 
    public function register(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string',
            'address' => 'required|string',
            'nik' => 'required|string|size:16|unique:masyarakats,nik',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'identity_photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ],[
            'name.required' => 'Nama wajib diisi',

            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',

            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',

            'phone.required' => 'Nomor telepon wajib diisi',

            'address.required' => 'Alamat wajib diisi',

            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus terdiri dari 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',

            'gender.required' => 'Jenis kelamin wajib dipilih',

            'identity_photo.required' => 'Foto KTP wajib diupload',
            'identity_photo.image' => 'File harus berupa gambar',
            'identity_photo.mimes' => 'Format foto harus JPG, JPEG, PNG atau WEBP',
            'identity_photo.max' => 'Ukuran foto maksimal 2 MB',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->username = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        $user->user_code = 'NSB' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
        $user->save();
        $user->assignRole('Masyarakat');

        $masyarakat = new Masyarakat();
        $masyarakat->user_id = $user->id;
        $masyarakat->nik = $validated['nik'];
        $masyarakat->gender = $validated['gender'];
        $masyarakat->verification = 'Menunggu';

        if ($request->hasFile('identity_photo')) {
            $image = $request->file('identity_photo');
            $name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('ui/images/masyarakat');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $name);
            $masyarakat->identity_photo = 'ui/images/masyarakat/' . $name;
        }

        $masyarakat->save();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Akun berhasil dibuat. Menunggu verifikasi.',
                'data' => [
                    'user' => $user->load('masyarakat'),
                    'masyarakat' => $masyarakat->load('user'),
                ],
            ], 201);
        }

        return redirect()->route('waiting')
            ->with('success', 'Akun berhasil dibuat! Menunggu verifikasi.')
            ->with('user_name', $user->name)
            ->with('user_nik', $masyarakat->nik)
            ->with('user_email', $user->email);
    }

    public function registerUser(Request $request){
        return $this->register($request);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil',
            ]);
        }

        return redirect()->route('login');
    }

    // show profile, but in here I want make universe
    // first, create user profile view first 

    public function profile(Request $request)
    {

        $user = $request->user()->load('masyarakat');

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        }

        return redirect()->route('users.show', $user->id);
    }

    public function changePassword(Request $request)
    {
        $validateData = $request->validate([
            'password' => 'required|string',
            'new_password' => 'required|string|min:8',
        ]);

        $user = Auth::user();

        if (! Hash::check($validateData['password'], $user->password)) {
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password lama tidak cocok',
                ], 422);
            }

            return redirect()->back()->with('failed', 'Password lama tidak cocok');
        }

        $user->password = Hash::make($validateData['new_password']);
        $user->save();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diubah',
            ]);
        }

        return redirect()->route('users.edit', $user->id)->with('success', 'Password changed successfully!');
    }

    public function listUsers(Request $request)
    {
        $users = User::orderby('id', 'asc')->get();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $users,
            ]);
        }

        $data['page_title'] = 'Users';
        $data['table_title'] = 'User List';
        $data['users'] = $users;

        return view('users.index', $data);
    }

    public function createUser()
    {
        $data['page_title'] = 'Add Users';
        $data['breadcumb'] = 'Add Users';
        $data['roles'] = Role::pluck('name')->all();

        return view('users.create', $data);
    }

    public function storeUser(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|min:3',
            'username' => 'required|unique:users,username|alpha_dash',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'role' => 'required',
            'no_rekening' => 'required|numeric',
            'bank' => 'required|string|min:3',
            'phone' => 'required|numeric',
            'alamat' => 'required',
        ]);

        $user = new User();
        $user->name = $validateData['name'];
        $user->username = $validateData['username'];
        $user->email = $validateData['email'];
        $user->no_rekening = $validateData['no_rekening'];
        $user->bank = $validateData['bank'];
        $user->phone = $validateData['phone'];
        $user->address = $request->get('alamat');
        $user->password = Hash::make($validateData['password']);

        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('ui/images/profile');
            $image->move($destinationPath, $name);
            $user->avatar = $name;
        }

        $user->save();
        $user->user_code = 'NSB' . str_pad($user->id, 6, '0', STR_PAD_LEFT);
        $user->save();
        $user->assignRole($validateData['role']);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'User added successfully',
                'data' => $user,
            ], 201);
        }

        return redirect()->route('users.index')->with(['success' => 'User added successfully!']);
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        }

        $data['page_title'] = 'User Profile';
        $data['user'] = $user;

        return view('users.show', $data);
    }

    public function editUser($id)
    {
        $data['page_title'] = 'Edit User';
        $data['breadcumb'] = 'Edit User';
        $data['user'] = User::findOrFail($id);
        $data['roles'] = Role::pluck('name')->all();

        return view('users.edit', $data);
    }

    public function updateUser(Request $request, $id)
    {
        $validateData = $request->validate([
            'name' => 'required|string|min:3',
            'username' => 'required|alpha_dash|unique:users,username,' . $id,
            'email' => 'required|unique:users,email,' . $id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $user = User::findOrFail($id);
        $user->name = $validateData['name'];
        $user->username = $validateData['username'];
        $user->email = $validateData['email'];
        $user->no_rekening = $request->get('no_rekening');
        $user->bank = $request->get('bank');
        $user->phone = $request->get('phone');
        $user->address = $request->get('alamat');

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                $image_path = public_path('ui/images/profile/' . $user->avatar);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }

            $image = $request->file('avatar');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('ui/images/profile/');
            $image->move($destinationPath, $name);
            $user->avatar = $name;
        }

        $user->save();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user,
            ]);
        }

        return redirect()->route('users.show', $id);
    }

    public function destroyUser($id)
    {
        DB::transaction(function () use ($id) {
            $user = User::findOrFail($id);
            if ($user->avatar) {
                $image_path = public_path('ui/images/profile/' . $user->avatar);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }

            $user->delete();
        });

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully',
            ]);
        }

        return redirect()->route('users.index');
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
            $rules['identity_photo'] = 'image|mimes:jpeg,png,jpg,webp|max:2048';
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
            $rules['identity_photo'] = 'image|mimes:jpeg,png,jpg,webp|max:2048';
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
        } else if ($request->has('identity_photo')) {
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
