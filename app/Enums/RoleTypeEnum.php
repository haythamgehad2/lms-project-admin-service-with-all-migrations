<?php
namespace App\Enums;

enum RoleTypeEnum:int
{
   case SUPER_ADMIN_ROLE_ID = 1;
   case SCHOOLADMIN_ROLE_ID = 2;
   case SUPERVISOR_ROLE_ID = 3;
   case TEACHER_ROLE_ID = 4;
   case STUDENT_ROLE_ID = 5;
   case PARENT_ROLE_ID = 6;

    /**
     * Get SchoolGroup status list depending on app locale.
     *
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
            self::SUPER_ADMIN_ROLE_ID => trans('role.SUPER_ADMIN_ROLE_ID'),
            self::SCHOOLADMIN_ROLE_ID => trans('role.SCHOOLADMIN_ROLE_ID'),
            self::SUPERVISOR_ROLE_ID => trans('role.SUPERVISOR_ROLE_ID'),
            self::TEACHER_ROLE_ID => trans('role.TEACHER_ROLE_ID'),
            self::STUDENT_ROLE_ID => trans('role.STUDENT_ROLE_ID'),
            self::PARENT_ROLE_ID => trans('role.PARENT_ROLE_ID'),

        ];
    }

    /**
     * Get Role Type list with class color depending on app locale.
     *
     * @return array
     */
    public static function getStatusListWithClass(): array
    {
        return [
            self::SUPER_ADMIN_ROLE_ID => [
                "value" => self::SUPER_ADMIN_ROLE_ID,
                "name" => trans('role.SUPER_ADMIN_ROLE_ID'),
            ],
            self::SCHOOLADMIN_ROLE_ID => [
                "value" => self::SCHOOLADMIN_ROLE_ID,
                "name" => trans('role.SCHOOLADMIN_ROLE_ID'),
            ],
            self::SUPERVISOR_ROLE_ID => [
                "value" => self::SUPERVISOR_ROLE_ID,
                "name" => trans('role.SUPERVISOR_ROLE_ID'),
            ],
            self::TEACHER_ROLE_ID => [
                "value" => self::TEACHER_ROLE_ID,
                "name" => trans('role.TEACHER_ROLE_ID'),
            ],

            self::STUDENT_ROLE_ID => [
                "value" => self::STUDENT_ROLE_ID,
                "name" => trans('role.STUDENT_ROLE_ID'),
            ],
            self::PARENT_ROLE_ID => [
                "value" => self::PARENT_ROLE_ID,
                "name" => trans('role.PARENT_ROLE_ID'),
            ]
        ];
    }

    /**
     * Get Role Type depending on app locale.
     *
     * @param bool $status
     * @return string
     */
    public static function getStatus(bool $status): string
    {
        return self::getStatusList()[$status];
    }

    /**
     * Get Role Type with class color depending on app locale.
     *
     * @param int $status
     * @return array
     */
    public static function getStatusWithClass(int $status): array
    {
        return self::getStatusListWithClass()[$status];
    }

}
