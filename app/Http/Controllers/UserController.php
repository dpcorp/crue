<?php

namespace App\Http\Controllers;

use App\Http\Requests\users\CreateUserRequest;
use App\Http\Requests\users\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Traits\RoleTrait;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller  implements HasMiddleware
{
    use RoleTrait;

    public static function middleware(): array
    {
        return [
            new Middleware('can:admin.users.index', only: ['index']),
            new Middleware('can:admin.users.create', only: ['create']),
            new Middleware('can:admin.users.show', only: ['show']),
            new Middleware('can:admin.users.edit', only: ['edit']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $user = User::create($request->all());
        $user->permissions()->sync($request->permissions);
        return redirect()->route('admin.users.index')->with([
            'color' => 'success',
            'message' => 'Usuario creado exitosamente'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $translation = $this->translationRoles();
        $permissions = [];
        foreach ($user->permissions as $permission) {
            $parts = explode('.', $permission->name);
            $permissions[$parts[1]][] =  $permission->description;
        }
        return view('components.users.show_offcanvas', compact('user', 'translation', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->permissions()->sync($request->permissions);
        return redirect()->route('admin.users.edit', $user)->with([
            'color' => 'success',
            'message' => 'Usuario actualizado exitosamente'
        ]);
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate(
            [
                'password' => [
                    'required',
                    'required_with:password_confirmation',
                    'same:password_confirmation',
                    'min:6',
                    'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
                ],
                'password_confirmation' => 'required'
            ],
            [
                'password.required' => 'El campo contraseña es obligatorio.',
                'password_confirmation.required' => 'El campo confirmación contraseña es obligatorio.',
                'password.same' => 'Las contraseñas no coinciden.',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
                'password.regex' => 'La contraseña debe contener al menos una letra mayúscula, un número y un carácter especial.'
            ]
        );

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('admin.users.edit', $user)->with([
            'color' => 'success',
            'message' => 'Contraseña actualizada exitosamente'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function getPermissions($id)
    {
        //
    }
}
