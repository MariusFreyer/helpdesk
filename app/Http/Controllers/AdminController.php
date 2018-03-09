<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function user_index(Request $request) {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
}
