<?php

namespace App\Mapper;

use App\Models\SchoolGroup;

class SchoolGroupMapper
{
    public function mapCreate(array $SchoolGroup): array
    {
        return [
            'name' => $SchoolGroup['name'],
            'country_id' => $SchoolGroup['country_id'],
            'status' => $SchoolGroup['status']??1,
            'music_status' => $SchoolGroup['music_status']??1,
            'owner_id' => $SchoolGroup['owner_id'],
            'username' => $SchoolGroup['username']
        ];
    }

    public function mapUpdate(array $SchoolGroup): array
    {
        return [
            'name' => [app()->getLocale() => $SchoolGroup['name']],
            'country_id' => $SchoolGroup['country_id'],
            'status' => $SchoolGroup['status']??1,
            'music_status' => $SchoolGroup['music_status']??1,
            'owner_id' => $SchoolGroup['owner_id'],
            'username' => $SchoolGroup['username']
        ];
    }
}
