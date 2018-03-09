<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function user_index(Request $request) {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function user_create() {
        return view('admin.users.create');
    }

    public function user_store(Request $request)
    {
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
        ]);
        $request->session()->flash('alert-success', 'User was added!');
        return back();
    }
}
