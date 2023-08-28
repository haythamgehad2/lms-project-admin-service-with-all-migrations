<?php
namespace App\Enums;

use Illuminate\Support\Collection;

class QuestionDifficultyTypes {
    const easy = "easy";
    const medium = "medium";
    const hard = "hard";

    public static function getTypes(): Collection {
        return collect([
            self::easy,
            self::medium,
            self::hard,
        ]);
    }
}
