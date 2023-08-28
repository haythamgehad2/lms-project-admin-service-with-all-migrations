<?php

namespace App\Mapper;

use App\Models\Permission;

class PermissionMapper
{
    public function mapCreate(array $permission): array
    {
        return [
            'name' => $permission['name'],
            'code' => $permission['code'],
        ];
    }

    public function mapUpdate(array $permission): array
    {
        return [
            'name' => [app()->getLocale() => $permission['name']],
            'code' => $permission['code'],
        ];
    }
}
