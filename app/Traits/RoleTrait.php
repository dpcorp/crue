<?php

namespace App\Traits;

trait RoleTrait
{
    public function translationRoles()
    {
        return  [
            "users" => "Usuarios",
            "roles" => "Roles",
            "permissions" => "Permisos",
            "occupations" => "Ocupaciones",
            "IPS" => "IPS",
            "out_of_services" => "Fuera de Servicio",
            "blockeds" => "Bloqueos",
            "saturations" => "Saturaciones",
        ];
    }
}
