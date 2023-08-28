<?php

namespace Database\Seeders;

use App\Models\PeperWork;
use App\Models\Quiz;
use App\Models\RewardAction;
use App\Models\VideoBank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RewardActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            RewardAction::start_video => [
                "action_name" => "Video Start",
                "action_desc" => "Video Start",
                "model_type" => VideoBank::class,
                "max_trail" => 0,// 0 means first time only
                "jeel_coins" => 50,
                // "second_jeel_coins" => 10,
                // "next_jeel_coins" => 0,
                "jeel_xp" => 50,
                // "second_jeel_xp" => 1,
                // "next_jeel_xp" => 0,
            ],
            RewardAction::complete_video => [
                "action_name" => "Video Complete",
                "action_desc" => "Video Complete",
                "model_type" => VideoBank::class,
                "max_trail" => null,// null means forever
                "jeel_coins" => 50,
                // "second_jeel_coins" => 10,
                // "next_jeel_coins" => 10,
                "jeel_xp" => 50,
                // "second_jeel_xp" => 1,
                // "next_jeel_xp" => 1,
            ],
            RewardAction::finish_exam => [
                "action_name" => "Finish Quiz (Exam)",
                "action_desc" => "Finish Quiz (Exam)",
                "model_type" => Quiz::class,
                "max_trail" => 0,// 0 means first time only
                "jeel_coins" => 50,
                // "second_jeel_coins" => 10,
                // "next_jeel_coins" => 0,
                "jeel_xp" => 50,
                // "second_jeel_xp" => 1,
                // "next_jeel_xp" => 0,
            ],

            RewardAction::finish_exam => [
                "action_name" => "Finish Quiz (Exam)",
                "action_desc" => "Finish Quiz (Exam)",
                "model_type" => Quiz::class,
                "max_trail" => 0,// 0 means first time only
                "jeel_coins" => 50,
                // "second_jeel_coins" => 10,
                // "next_jeel_coins" => 0,
                "jeel_xp" => 50,
                // "second_jeel_xp" => 1,
                // "next_jeel_xp" => 0,
            ],

            RewardAction::finish_exam => [
                "action_name" => "Paper Work (Upload)",
                "action_desc" => "Paper Work (Upload)",
                "model_type" => PeperWork::class,
                "max_trail" => 0,// 0 means first time only
                "jeel_coins" => 50,
                // "second_jeel_coins" => 10,
                // "next_jeel_coins" => 0,
                "jeel_xp" => 50,
                // "second_jeel_xp" => 1,
                // "next_jeel_xp" => 0,
            ],

            RewardAction::finish_exam => [
                "action_name" => "Paper Work (Download)",
                "action_desc" => "Paper Work (Download)",
                "model_type" => PeperWork::class,
                "max_trail" => 0,// 0 means first time only
                "jeel_coins" => 50,
                // "second_jeel_coins" => 10,
                // "next_jeel_coins" => 0,
                "jeel_xp" => 50,
                // "second_jeel_xp" => 1,
                // "next_jeel_xp" => 0,
            ],
        ])
        ->each(function($actionData, $actionName) {
            if (!RewardAction::where("action_unique_name", $actionName)->exists()) {
                echo "Insert action: $actionName".PHP_EOL;
                RewardAction::create(array_merge(['action_unique_name' => $actionName], $actionData));
            }
        });
    }
}
