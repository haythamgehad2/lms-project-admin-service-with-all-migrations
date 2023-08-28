<?php
namespace App\Enums;

enum UserStatusEnum:int
{
    case ACTIVE_STATUS = 1;
    case BLOCKED_STATUS = 2;
    case DEACTIVATED_STATUS = 3;
    case UNVERIFIED_STATUS = 4;

    /**
     * Get SchoolGroup status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::ACTIVE_STATUS => trans('user.ACTIVE_STATUS'),
            self::BLOCKED_STATUS => trans('user.BLOCKED_STATUS'),
            self::DEACTIVATED_STATUS => trans('user.DEACTIVATED_STATUS'),
            self::UNVERIFIED_STATUS => trans('user.UNVERIFIED_STATUS'),
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
            self::ACTIVE_STATUS => [
                "value" => self::ACTIVE_STATUS,
                "name" => trans('user.ACTIVE_STATUS'),
            ],
            self::BLOCKED_STATUS => [
                "value" => self::BLOCKED_STATUS,
                "name" => trans('user.BLOCKED_STATUS'),
            ],
            self::DEACTIVATED_STATUS => [
                "value" => self::DEACTIVATED_STATUS,
                "name" => trans('user.DEACTIVATED_STATUS'),
            ],
            self::UNVERIFIED_STATUS => [
                "value" => self::UNVERIFIED_STATUS,
                "name" => trans('user.UNVERIFIED_STATUS'),
            ]
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
