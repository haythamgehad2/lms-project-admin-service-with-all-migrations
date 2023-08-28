<?php

namespace Database\Seeders;

use App\Enums\QuestionDifficultyTypes;
use App\Models\QuestionDifficulty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionDifficultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        QuestionDifficulty::query()->truncate();


        $now = now()->toDateTimeString();
        $questionsTypes = [
            [
                'name' => ['ar' => 'سهل','en' => 'easy'],
                'slug' => QuestionDifficultyTypes::easy,
                'is_default' => 1,
                "grade_points" => 3,
                "created_at" => $now
            ],
            [
                'name' => ['ar' => 'متوسط','en' => 'medium'],
                'slug' => QuestionDifficultyTypes::medium,
                'is_default' => 1,
                "grade_points" => 5,
                "created_at" => $now
            ],
            [
                'name' => ['ar' => 'صعب','en' => 'hard'],
                'slug' => QuestionDifficultyTypes::hard,
                'is_default' => 1,
                "grade_points" => 7,
                "created_at" => $now
            ],
        ];

        foreach($questionsTypes as $questionType){
            QuestionDifficulty::create($questionType);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}
