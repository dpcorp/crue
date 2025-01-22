<?php

namespace App\Http\Controllers;

use App\Models\OutOfService;
use Illuminate\Http\Request;

class OutOfServiceController extends Controller
{
    public function index()
    {
        $out_of_services = OutOfService::with('ips')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();
        return view('out_of_services.index', compact('out_of_services'));
    }
}
