<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TpiController extends Controller
{
    public function create()
    {
        return view('tpi.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'alamat' => $request->alamat,
            'role' => 'tpi',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('tpi.index')->with('success', 'TPI berhasil ditambahkan.');
    }

    public function index()
    {
        $users = User::where('role', 'tpi')->get();
        return view('tpi.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('tpi.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->alamat = $request->alamat;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('tpi.index')->with('success', 'TPI berhasil diperbarui.');
    }


    public function toggleStatus(User $user)
{
    $user->status = !$user->status;
    $user->save();

    return redirect()->route('tpi.index')->with('success', 'Status TPI berhasil diubah.');
}

}