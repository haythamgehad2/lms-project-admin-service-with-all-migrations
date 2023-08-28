<?php

namespace App\Mapper;

class ClassMapper
{
    public function mapCreate(array $Class): array
    {
        return [
            'name' => $Class['name']
        ];
    }

    public function mapUpdate(array $Class): array
    {
        return [
            'name' => [app()->getLocale() => $Class['name']]
        ];
    }
}
