<?php
namespace App\Mapper;
use App\Models\Country;

class CountryMapper
{
    /**
     * Undocumented function
     *
     * @param array $country
     * @return array
     */
    public function mapCreate(array $country): array
    {
        return [
            'name' => $country['name'],
            'code' => $country['code'],
        ];
    }

    /**
     * Undocumented function
     *
     * @param array $country
     * @return array
     */
    public function mapUpdate(array $country): array
    {
        return [
            'name' => [app()->getLocale() => $country['name']],
            'code' => $country['code'],
        ];
    }
}
