<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_one = Role::create(["name" => "Administrador", "hierarchy" => 1, "editable" => 0]);
        $role_two = Role::create(["name" => "Invitado", "hierarchy" => 1, "editable" => 0]);

        //Users
        Permission::create(["name" => "admin.users.index", "description" => "Ver", "module" => "Administración"])->syncRoles([$role_one, $role_two]);
        Permission::create(["name" => "admin.users.create", "description" => "Crear", "module" => "Administración"])->syncRoles([$role_one, $role_two]);
        Permission::create(["name" => "admin.users.show", "description" => "Ver información", "module" => "Administración"])->syncRoles([$role_one, $role_two]);
        Permission::create(["name" => "admin.users.edit", "description" => "Editar", "module" => "Administración"])->syncRoles([$role_one, $role_two]);

        //roles
        Permission::create(["name" => "admin.roles.index", "description" => "Ver", "module" => "Administración"])->syncRoles([$role_one, $role_two]);
        Permission::create(["name" => "admin.roles.create", "description" => "Crear", "module" => "Administración"])->syncRoles([$role_one, $role_two]);
        Permission::create(["name" => "admin.roles.show", "description" => "Ver información", "module" => "Administración"])->syncRoles([$role_one, $role_two]);
        Permission::create(["name" => "admin.roles.edit", "description" => "Editar", "module" => "Administración"])->syncRoles([$role_one, $role_two]);


        //roles
        Permission::create(["name" => "admin.ips.index", "description" => "Ver", "module" => "IPS"])->syncRoles([$role_one, $role_two]);
        Permission::create(["name" => "admin.ips.create", "description" => "Importar", "module" => "IPS"])->syncRoles([$role_one, $role_two]);
        Permission::create(["name" => "admin.ips.show", "description" => "Ver información", "module" => "IPS"])->syncRoles([$role_one, $role_two]);
        Permission::create(["name" => "admin.ips.edit", "description" => "Editar", "module" => "IPS"])->syncRoles([$role_one, $role_two]);


        //roles
        Permission::create(["name" => "admin.occupations.index", "description" => "Ver", "module" => "Ocupaciones"])->syncRoles([$role_one, $role_two]);
        Permission::create(["name" => "admin.occupations.create", "description" => "Importar", "module" => "Ocupaciones"])->syncRoles([$role_one, $role_two]);
        Permission::create(["name" => "admin.occupations.show", "description" => "Ver información", "module" => "Ocupaciones"])->syncRoles([$role_one, $role_two]);

        //roles
        Permission::create(["name" => "admin.out_of_services.index", "description" => "Ver", "module" => "Fuera de servicio"])->syncRoles([$role_one, $role_two]);
    }
}
