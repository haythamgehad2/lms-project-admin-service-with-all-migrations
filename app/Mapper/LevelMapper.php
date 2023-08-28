<?php

namespace App\Mapper;

use App\Models\Level;

class LevelMapper
{
    public function mapCreate(array $Level): array
    {
        return [
            'name' => $Level['name'],
            'min_levels' => $Level['min_levels'],
            'school_groups' => $Level['school_groups'],
        ];
    }

    public function mapUpdate(array $Level): array
    {
        return [
            'name' => [app()->getLocale() => $Level['name']],
            'min_levels' => $Level['min_levels'],
        ];
    }
}
