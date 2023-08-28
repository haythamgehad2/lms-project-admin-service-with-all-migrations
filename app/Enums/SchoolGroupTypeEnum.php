<?php
namespace App\Enums;

enum SchoolGroupTypeEnum:string {

    case INTERNATIONAL = "international";
    case NATIONAL  = "national";

    /**
     * Get SchoolGroup status list depending on app locale.
     *
     * @return array
     */
    public static function getTypesList(): array
    {
        return [
            self::INTERNATIONAL => trans('admin.school_types.types.international'),
            self::NATIONAL => trans('admin.school_types.types.national'),
        ];
    }
    /**
     * Get SchoolType status list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStatusListWithClass(): array
    {
        return [
            self::INTERNATIONAL => [
                "value" => self::INTERNATIONAL,
                "name" => __('admin.school_types.types.international'),
            ],
            self::NATIONAL => [
                "value" => self::NATIONAL,
                "name" => __('admin.school_types.types.national'),
            ]
        ];
    }
    /**
     * Get SchoolType status depending on app locale.
     *
     * @param bool $status
     * @return string
     */
    public static function getType(string $status):string
    {
        return self::getTypesList()[$status];
    }
    /**
     * Get SchoolType status with class color depending on app locale.
     *
     * @param int $status
     * @return array
     */
    public static function getStatusWithClass(int $status): array
    {
        return self::getStatusListWithClass()[$status];
    }

}
