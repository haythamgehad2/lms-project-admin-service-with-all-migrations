<?php

namespace App\Mapper;

use App\Models\SchoolType;

class SchoolTypeMapper
{
    public function mapCreate(array $schoolType): array
    {
        return [
            'name' => $schoolType['name']
        ];
    }

    public function mapUpdate(array $schoolType): array
    {
        return [
            'name' => [app()->getLocale() => $schoolType['name']]
        ];
    }
}
