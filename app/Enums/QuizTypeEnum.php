<?php
namespace App\Enums;

use Illuminate\Support\Collection;

enum QuizTypesEnum:string {

    const DEFAULT = "default";
    const MANUAL = "manual";
    const AUTOMATIC = "automatic";

    /**
     * Get SchoolGroup status list depending on app locale.
     *
     * @return array
     */
    public static function getTypesList(): array
    {
        return [
            self::DEFAULT => __('admin.quizzes.types.default'),
            self::MANUAL => __('admin.quizzes.types.manual'),
            self::AUTOMATIC => __('admin.quizzes.types.automatic'),
        ];
    }

      /**
     * Get User status depending on app locale.
     *
     * @param bool $status
     * @return string
     */
    public static function getType(string $type): string
    {
        return self::getTypesList()[$type];
    }



}
