<?php

namespace App\Mapper;


class ThemeMapper
{
    /**
     * Undocumented function
     *
     * @param array $theme
     * @return array
     */
    public function mapCreate(array $theme): array
    {
        return [
            'name' => $theme['name'],
            'description' => $theme['description'],
        ];
    }

    /**
     * Undocumented function
     *
     * @param array $theme
     * @return array
     */
    public function mapUpdate(array $theme): array
    {
        return [
            'name' => [app()->getLocale() => $theme['name']],
            'description' => [app()->getLocale() => $theme['description']],
        ];
    }
}
