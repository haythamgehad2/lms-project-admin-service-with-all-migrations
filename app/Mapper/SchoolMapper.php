<?php

namespace App\Mapper;

use App\Models\School;

class SchoolMapper
{
    public function mapCreate(array $School): array
    {
        return [
            'name' => $School['name'],
            'school_group_id' => $School['school_group_id'],
            'status' => $School['status']??1,
            'music_status' => $School['music_status']??1,
            'admin_id' => $School['admin_id'],
            'username' => $School['username'],
            'school_type_id' => $School['school_type_id'],
            'useremail' => $School['useremail'],
            'subscription_start_date' => $School['subscription_start_date'],
            'subscription_end_date' => $School['subscription_end_date'],
            'package_id' => $School['package_id'],
        ];
    }

    public function mapUpdate(array $School): array
    {
        return [
            'name' => [app()->getLocale() => $School['name']],
            'school_group_id' => $School['school_group_id'],
            'status' => $School['status']??1,
            'music_status' => $School['music_status']??1,
            'admin_id' => $School['admin_id'],
            'username' => $School['username'],
            'useremail' => $School['useremail'],
            'school_type_id' => $School['school_type_id'],
            'subscription_start_date' => $School['subscription_start_date'],
            'subscription_end_date' => $School['subscription_end_date'],
            'package_id' => $School['package_id'],
        ];
    }
}
