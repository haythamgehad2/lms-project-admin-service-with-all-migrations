<?php

namespace App\Mapper;

use App\Models\Package;

class PackageMapper
{
    public function mapCreate(array $package): array
    {
        return [
            'name' => $package['name'],
            'description' => $package['description'],
            'price' => $package['price'],
            'classes_count' => $package['classes_count'],
        ];
    }

    public function mapUpdate(array $package): array
    {
        return [
            'name' => [app()->getLocale() => $package['name']],
            'description' => [app()->getLocale() => $package['description']],
            'price' => $package['price'],
            'classes_count' => $package['classes_count'],
        ];
    }
}
