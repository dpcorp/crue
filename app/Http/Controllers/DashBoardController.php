<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->id());
        return view('dashboard.index', compact('user'));
    }
}
