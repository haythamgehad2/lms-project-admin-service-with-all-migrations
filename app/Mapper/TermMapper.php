<?php

namespace App\Mapper;

use App\Models\Term;

class TermMapper
{
    public function mapCreate(array $Term): array
    {
        return [
            'name' => $Term['name'],
            // 'levels' => $Term['levels'],

        ];
    }

    public function mapUpdate(array $Term): array
    {
        return [
            'name' => [app()->getLocale() => $Term['name']],
            // 'levels' => $Term['levels'],

        ];
    }
}
