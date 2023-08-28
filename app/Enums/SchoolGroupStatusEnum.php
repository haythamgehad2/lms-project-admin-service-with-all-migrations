<?php
namespace App\Enums;

enum SchoolGroupStatusEnum:int {

    case active =1;
    case inactive  = 2;

    /**
     * Get SchoolGroup status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::active => trans('schoolgroup.active'),
            self::inactive => trans('schoolgroup.inactive')
        ];
    }

    /**
     * Get SchoolGroup status list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStatusListWithClass(): array
    {
        return [
            self::active => [
                "value" => self::active,
                "name" => trans('schoolgroup.active'),
            ],
            self::inactive => [
                "value" => self::inactive,
                "name" => trans('schoolgroup.inactive'),
            ]
        ];
    }

    /**
     * Get country status depending on app locale.
     *
     * @param bool $status
     * @return string
     */
    public static function getStatus(bool $status): string
    {
        return self::getStatusList()[$status];
    }

    /**
     * Get country status with class color depending on app locale.
     *
     * @param int $status
     * @return array
     */
    public static function getStatusWithClass(int $status): array
    {
        return self::getStatusListWithClass()[$status];
    }

}
