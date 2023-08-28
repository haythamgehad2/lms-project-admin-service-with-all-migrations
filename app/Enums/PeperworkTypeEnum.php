<?php
namespace App\Enums;

enum PeperworkTypeEnum:string
{
    case PARTICIPATORY = 'participatory';
    case SINGLE = 'single';


    /**
     * Get SchoolGroup status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::PARTICIPATORY => trans('peperwork.participatory'),
            self::SINGLE => trans('peperwork.single'),

        ];
    }

    /**
     * Get user status list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStatusListWithClass(): array
    {
        return [
            self::PARTICIPATORY => [
                "value" => self::PARTICIPATORY,
                "name" => trans('user.participatory'),
            ],
            self::SINGLE => [
                "value" => self::SINGLE,
                "name" => trans('user.single'),
            ],
        ];
    }

    /**
     * Get User status depending on app locale.
     *
     * @param bool $status
     * @return string
     */
    public static function getStatus(bool $status): string
    {
        return self::getStatusList()[$status];
    }

    /**
     * Get User status with class color depending on app locale.
     *
     * @param int $status
     * @return array
     */
    public static function getStatusWithClass(int $status): array
    {
        return self::getStatusListWithClass()[$status];
    }

}
