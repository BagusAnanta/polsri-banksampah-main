<?php

/**
 * ON DEPRECATED, ALL LOGIC CODE HAS MOVE INTO AUTHCONTROLLER
 * THIS CODE FOR REFERENCE, PLEASE REMOVE IF ALL CODE ALREADY 
 * RUNNING AND THIS CODE UNUSED 
 */

namespace App\Http\Controllers;

use App\Models\User;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:user-list', ['only' => 'index']);
    //     $this->middleware('permission:user-create', ['only' => ['create','store']]);
    //     $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
    //     $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    // }


    public function index()
    {
        $data['page_title'] = 'Users';
        $data['table_title'] = 'User List';
        $data['users'] = User::orderby('id', 'asc')->get();

        return view('users.index', $data);
    }

    public function create()
    {
        $data['page_title'] = 'Add Users';
        $data['breadcumb'] = 'Add Users';
        $data['roles'] = Role::pluck('name')->all();

        return view('users.create', $data);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name'   => 'required|string|min:3',
            'username'   => 'required|unique:users,username|alpha_dash',
            'email'   => 'required|email|unique:users,email',
            'password' => 'required',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'role' => 'required',
            'no_rekening' => 'required|numeric',
            'bank'   => 'required|string|min:3',
            'phone' => 'required|numeric',
            'alamat' => 'required'
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

        return redirect()->route('users.index')->with(['success' => 'User added successfully!']);
    }

    public function show($id)
    {
        $data['page_title'] = 'User Profile';
        $data['user'] = User::findOrFail($id);
        return view('users.show', $data);
    }

    public function edit($id)
    {
        $data['page_title'] = 'Edit User';
        $data['breadcumb'] = 'Edit User';
        $data['user'] = User::findOrFail($id);
        $data['roles'] = Role::pluck('name')->all();


        return view('users.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validateData = $request->validate([
            'name'   => 'required|string|min:3',
            'username'   => 'required|alpha_dash|unique:users,username,' . $id,
            'email'   => 'required|unique:users,email,' . $id,
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
            // Delete Img
            if ($user->avatar) {
                $image_path = public_path('ui/images/profile/' . $user->avatar); // Value is not URL but directory file path
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

        // if ($request->hasFile('cv')) {
        //     $cv = $request->file('cv');
        //     $originalName = $cv->getClientOriginalName();
        //     $name = $originalName;
        //     $destinationPath = public_path('ui/doc/cv');
        //     $cv->move($destinationPath, $name);
        //     $user->cv = $name; // or $user->cv = $originalName; if you want to save the original name
        // }

        $user->save();
        // DB::table('model_has_roles')->where('model_id',$id)->delete();
        // $user->assignRole($validateData['role']);

        return redirect()->route('users.show', $id);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $user = User::findOrFail($id);
            if ($user->avatar) {
                $image_path = public_path('ui/images/profile/' . $user->avatar); // Value is not URL but directory file path
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }

            $user->delete();
        });

        return redirect()->route('users.index');
    }

    public function changePassword(Request $request)
    {
        $validateData = $request->validate([
            'password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        $user = User::findOrFail(Auth::user()->id);

        if (Hash::check($validateData['password'], $user->password)) {
            $user->password = Hash::make($request->get('new_password'));
            $user->save();

            return redirect()->route('users.edit', Auth::user()->id)->with('success', 'Password changed successfully!');
        } else {
            return redirect()->route('users.edit', Auth::user()->id)->with('failed', 'Password change failed');
        }
    }

    public function registerUser(Request $request)
    {
        return app(AuthController::class)->register($request);
    }
}
