<?php

namespace App\Mapper;

class RoleMapper
{
    public function mapCreate(array $role): array
    {
        return [
            'name' => $role['name'],
            'code' => $role['code'],
        ];
    }

    public function mapUpdate(array $role): array
    {
        return [
            'name' => [app()->getLocale() => $role['name']],
            'code' => $role['code'],
        ];
    }
}
