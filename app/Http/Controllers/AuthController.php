<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function login(LoginRequest $request)
    {
        $credentials = request()->only('email', 'password');
        $user = User::where('email', $request->email)->get()->take(1);
        if (count($user) != 0) {
            if ($user[0]['status'] == 0) {
                return redirect()->to('/')->with([
                    'icon' => 'fa-solid fa-triangle-exclamation',
                    'title' => 'Alerta',
                    'message' => 'No puedes ingresar a este sistema de información',
                    'color' => 'danger',
                ]);
            }
        }

        if (Auth::attempt($credentials)) {
            return redirect()->to('admin/dashboard')->with([
                'icon' => 'fa-solid fa-circle-check',
                'title' => '¡Bienvenido!',
                'message' => 'CRUE - Centro Regulador de Urgencias, Emergencias y Desastres',
                'color' => 'primary',
            ]);
        } else {
            return redirect()->to('/')->with([
                'icon' => 'fa-solid fa-circle-info',
                'title' => 'Tus datos no coinciden',
                'message' => 'Revisa que tu usuario y contraseña sean correctos',
                'color' => 'warning',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/')->with([
            'message' => 'Sesión cerrada.',
            'color' => 'success',
        ]);
    }
}
