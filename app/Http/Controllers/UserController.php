<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $userList = User::whereNull('deleted_at')->orderby('created_at', 'desc')->get();

        $data = compact('userList');
        return view('user', $data);
    }

    public function create()
    {
        return view('useradd');
    }

    public function store(Request $request)
    {
        $datetime = Carbon::now();

        // Validate the form data
        $validator = Validator::make($request->all(), [
              'name' => 'required|string',
              'email' => 'required|email|unique:users,email,except,id',
              'password' => 'required|string|min:8',
              'repeat_password' => 'required|string|min:8',
          ]);

        if ($validator->fails()) {
            return redirect()->route('user.create')
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->password != $request->repeat_password) {
            return redirect()->route('user.create')
                ->withErrors('The new password field confirmation does not match.')
                ->withInput();
        }

        User::create([
             'name' => ucwords($request->input('name')),
             'email' => strtolower($request->input('email')),
             'email_verified_at' => $datetime,
             'password' => Hash::make($request->input('password')),
             'remember_token' => Str::random(10),
             'created_at' => $datetime,
         ]);

        return redirect()->route('user')->with('success', 'User Profile added successfully.');
    }

    public function edit($id)
    {
        $userList = User::where('id', '=', $id)->whereNull('deleted_at')->orderby('name', 'asc')->get();
        $data = compact('userList');

        return view('useredit', $data);
    }

    public function modify(Request $request, $id)
    {
        $datetime = Carbon::now();
        $user = User::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'old_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8',
            'repeat_password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.edit', ['id' => $id])
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->new_password != $request->repeat_password) {
            return redirect()->route('user.edit', ['id' => $id])
                ->withErrors('The new password field confirmation does not match.')
                ->withInput();
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->route('user.edit', ['id' => $id])
            ->withErrors('Old password is incorrect.')
            ->withInput();
        }

        try {
            $user->update([
                'name' => ucwords($request->name),
                'email' => strtolower($request->email),
                'email_verified_at' => $datetime,
                'password' => Hash::make($request->new_password),
                'updated_at' => $datetime,
            ]);

            return redirect()->route('user')->with('success', 'User Credentials updated successfully.');
        } catch (\Exception) {
            return redirect()->route('user.edit', ['id' => $user])
            ->withErrors('The email has already been taken.')
            ->withInput();
        }
    }
}
