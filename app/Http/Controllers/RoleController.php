<?php

namespace App\Http\Controllers;

use App\Http\Requests\roles\CreateRolRequest;
use App\Http\Requests\roles\UpdateRolRequest;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Role;
use App\Traits\RoleTrait;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller implements HasMiddleware

{
    use RoleTrait;

    public static function middleware(): array
    {
        return [
            new Middleware('can:admin.roles.index', only: ['index']),
            new Middleware('can:admin.roles.create', only: ['create']),
            new Middleware('can:admin.roles.show', only: ['show']),
            new Middleware('can:admin.roles.edit', only: ['edit']),
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $traduccion = $this->translationRoles();
        $groups_data = $this->groupsPermissions();
        return view('roles.create', compact('groups_data', 'traduccion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRolRequest $request)
    {
        $role = Role::create($request->all());
        $role->permissions()->sync($request->permissions);
        return redirect()->route('admin.roles.index')->with(
            [
                'color' => 'success',
                'message' => 'Rol creado exitosamente'
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $roles = Role::with('permissions')
            ->where('roles.id', $role->id)
            ->get();

        $translation = $this->translationRoles();
        $permissions = [];
        foreach ($roles[0]->permissions as $permission) {
            $parts = explode('.', $permission->name);
            $permissions[$parts[1]][] =  $permission->description;
        }


        return view('components.roles.show_offcanvas', compact('role', 'translation', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rol = Role::with('permissions')->find($id);
        $traduccion = $this->translationRoles();
        $groups_data = $this->groupsPermissions();
        $permissions_rol = [];
        foreach ($rol->permissions as $key => $permiso) {
            $permissions_rol[] = $permiso->id;
        }
        return view('roles.edit', compact('rol', 'traduccion', 'groups_data', 'permissions_rol'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRolRequest $request, Role $role)
    {
        $existingRole = Role::where('name', $request->name)->where('guard_name', "web")->where('id', '!=', $role->id)->first();

        if ($existingRole) {
            throw ValidationException::withMessages([
                'name' => ['Un rol llamado ' . $request->name . ' ya existe'],
            ]);
        }

        $role->update($request->all());
        $role->permissions()->sync($request->permissions);
        return redirect()->route('admin.roles.edit', $role)->with(
            [
                'color' => 'success',
                'message' => 'Rol actualizado exitosamente'
            ]
        );
    }

    public function filterRolByRol($id)
    {
        $rol = Role::with('permissions')->where('name', $id)->first();
        $traduccion = $this->translationRoles();
        $groups_data = $this->groupsPermissions();
        $permissions_rol = [];
        foreach ($rol->permissions as $key => $permiso) {
            $permissions_rol[] = $permiso->id;
        }
        return response()->json([
            "permissions_rol" => $permissions_rol,
            "traduccion" => $traduccion,
            "groups_data" => $groups_data

        ]);
    }

    public function getPermissions($id)
    {
        $user = User::with('permissions')->find($id);
        $traduccion = $this->translationRoles();
        $groups_data = $this->groupsPermissions();
        $permissions_rol = [];
        foreach ($user->permissions as $key => $permiso) {
            $permissions_rol[] = $permiso->id;
        }
        return response()->json([
            "permissions_rol" => $permissions_rol,
            "traduccion" => $traduccion,
            "groups_data" => $groups_data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function groupsPermissions()
    {
        $permissions = Permission::all();
        $groups_data = [];
        foreach ($permissions as $key => $permi) {
            $parts = explode(".", $permi->name);
            $groups_data[$permi->module][$parts[1]][] = $permi;
        }

        return $groups_data;
    }
}
