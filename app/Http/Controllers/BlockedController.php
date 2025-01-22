<?php

namespace App\Http\Controllers;

use App\Models\Blocked;
use Illuminate\Http\Request;

class BlockedController extends Controller
{
    public function index()
    {
        $blockeds = Blocked::with('ips')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();
        return view('blockeds.index', compact('blockeds'));
    }
}
