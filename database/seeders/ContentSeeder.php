<?php

namespace Database\Seeders;

use App\Models\BloomCategory;
use App\Models\User;
use App\Models\Level;
use App\Models\Theme;
use App\Models\Country;
use App\Models\LanguageMethod;
use App\Models\LanguageSkill;
use App\Models\LearningPath;
use App\Models\Mission;
use App\Models\Package;
use App\Models\PeperWork;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionDifficulty;
use App\Models\SchoolGroup;
use Illuminate\Support\Str;
use App\Models\QuestionType;
use App\Models\Quiz;
use App\Models\SchoolType;
use App\Models\Term;
use App\Models\VideoBank;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::whereHas("roles", fn($r) => $r->where("code", "jeeladmin"))->first();

        $country = Country::create([
            'name' => ['ar' => "Egypt"], 'code' => "EG"
        ]);

        $schoolGroup = SchoolGroup::create([
            'name' => "School Group, {$country->getTranslation('name', 'ar')}",
            'country_id' => $country->id,
            'type' => 'national',
            'status' => 1,
            'music_status' => 1,
            'owner_id' => $admin->id ?? 0
        ]);

        $theme = Theme::create([
            'name' => ['ar' => "Theme Name, {$country->getTranslation('name', 'ar')}",],
            'description' => ['ar' => "Theme Desc, {$country->getTranslation('name', 'ar')}",]
        ]);

        $level = Level::create([
            'name' => ['ar' => "Level Name, {$country->getTranslation('name', 'ar')}",],
            'min_levels' => 3
        ]);
        $level->themes()->attach($theme->id);
        $level->school_groups()->attach($schoolGroup->id);

        $parentQuestionType = QuestionType::create([
            'name' => ['ar' => "Question Type Name, {$country->getTranslation('name', 'ar')}",],
            'slug' => "mcq",
        ]);
        $subQuestionType = QuestionType::create([
            'name' => ['ar' => "Sub Question Type Name, {$country->getTranslation('name', 'ar')}",],
            'slug' => Str::slug("Sub Question Type Name, {$country->getTranslation('name', 'ar')}"),
            'parent_id' => $parentQuestionType->id
        ]);

        $questionDifficulty = QuestionDifficulty::create([
            'name' => ['ar' => "Question Difficulty Name, {$country->getTranslation('name', 'ar')}",],
            'slug' => Str::slug("Question Difficulty Name, {$country->getTranslation('name', 'ar')}"),
        ]);

        $langSkill = LanguageSkill::create([
            'name' => ['ar' => "Lang Skill Name, {$country->getTranslation('name', 'ar')}",],
            'slug' => Str::slug("Lang Skill Name, {$country->getTranslation('name', 'ar')}"),
        ]);

        $langMethod = LanguageMethod::create([
            'name' => ['ar' => "Lang Method Name, {$country->getTranslation('name', 'ar')}",],
            'slug' => Str::slug("Lang Method Name, {$country->getTranslation('name', 'ar')}"),
        ]);

        $bloomCategory = BloomCategory::create([
            'name' => ['ar' => "Bloom Category Name, {$country->getTranslation('name', 'ar')}",],
            'slug' => Str::slug("Bloom Category Name, {$country->getTranslation('name', 'ar')}"),
        ]);

        $learningPath = LearningPath::create([
            'name' => ['ar' => "Learning Path Name, {$country->getTranslation('name', 'ar')}",],
            'description' => ['ar' => "Learning Path Desc, {$country->getTranslation('name', 'ar')}",],
        ]);

        $video = VideoBank::create([
            'original_name' => "Video Title, {$country->getTranslation('name', 'ar')}",
            'title' => ['ar' => "Video Title, {$country->getTranslation('name', 'ar')}",],
            'description' => ['ar' => "Video Desc, {$country->getTranslation('name', 'ar')}",],
            'learning_path_id' => $learningPath->id,
            'level_id' => $level->id,
            'disk' => 'videos_disk',
            'path' => 'no_video.mp4',
        ]);

        $paperWork = PeperWork::create([
            'name' => ['ar' => "Paper Work Name, {$country->getTranslation('name', 'ar')}",],
            'description' => ['ar' => "Paper Work Desc, {$country->getTranslation('name', 'ar')}",],
            'type' => 'single',
            'level_id' => $level->id,
            'learning_path_id' => $learningPath->id,
            'path' => "no_paper_work.pdf",
            'disk' => "papers_work",
        ]);

        $term = Term::create([
            'name' => ['ar' => "Term Name, {$country->getTranslation('name', 'ar')}"]
        ]);
        $term->levels()->attach($level->id);

        $question = Question::create([
            'question' => ['ar' => "Question, {$country->getTranslation('name', 'ar')}",],
            'question_audio' => "no_question_audio.mp3",
            'question_type_id' => $parentQuestionType->id,
            'language_skill_id' => $langSkill->id,
            'bloom_category_id' => $bloomCategory->id,
            'language_method_id' => $langMethod->id,
            'question_type_sub_id' => $subQuestionType->id,
            'learning_path_id' => $learningPath->id,
            'question_difficulty_id' => $questionDifficulty->id,
            'hint' => ['ar' => "Question Hint, {$country->getTranslation('name', 'ar')}",],
            'question_pattern' => "text",
            'level_id' => $level->id
        ]);
        QuestionAnswer::create([
            'answer' => ['ar' => "Answer 1, {$country->getTranslation('name', 'ar')}",],
            'question_id' => $question->id,
            'correct' => 1,
            'answer_audio' => "no_answer.mp3",
        ]);
        QuestionAnswer::create([
            'answer' => ['ar' => "Answer 2, {$country->getTranslation('name', 'ar')}",],
            'question_id' => $question->id,
            'correct' => 0,
            'answer_audio' => "no_answer.mp3",
        ]);

        $quiz = Quiz::create([
            'name' => ['ar' => "Quiz Name, {$country->getTranslation('name', 'ar')}",],
            'description' => ['ar' => "Quiz Desc, {$country->getTranslation('name', 'ar')}",],
            'total_question' => 1,
            'type' => "default",
            'level_id' => $level->id,
            'learning_path_id' => $learningPath->id,
            'total_grade' => 100,
            'success_grade' => 55,
            'calc_type' => "max"
        ]);
        $quiz->questionsDifficulties()->attach($questionDifficulty->id, ['total_question' => 1]);
        $quiz->quizQuestions()->attach($question->id);

        $mission = Mission::create([
            'name' => ['ar' => "Mission Name, {$country->getTranslation('name', 'ar')}",],
            'description' => ['ar' => "Mission Desc, {$country->getTranslation('name', 'ar')}",],
            'data_range' => 10,
            'country_id' => $country->id,
            'level_id' => $level->id,
            'term_id' => $term->id,
            'is_selected' => 1,
            'order' => 1,
            'start_date' => now()->toDateTimeString(),
            'end_date' => now()->addDays(10)->toDateTimeString(),
        ]);
        $mission->learningPaths()->attach($learningPath->id);
        $mission->videosBanks()->attach($video->id, ['is_selected' => 1, 'order' => 1, 'learning_path_id' => $learningPath->id]);
        $mission->quizzes()->attach($quiz->id, ['is_selected' => 1, 'order' => 1, 'learning_path_id' => $learningPath->id]);
        $mission->papersWork()->attach($paperWork->id, ['is_selected' => 1, 'order' => 1, 'learning_path_id' => $learningPath->id]);

        Package::create([
            'name' => ['ar' => "Package Name, {$country->getTranslation('name', 'ar')}",],
            'description' => ['ar' => "Package Desc, {$country->getTranslation('name', 'ar')}",],
            'price' => 1500,
            'classes_count' => 3
        ]);

        SchoolType::create([
            'name' => ['ar' => "School Type Name, {$country->getTranslation('name', 'ar')}",],
        ]);
    }
}
