<?php

namespace Database\Seeders;

use App\Models\QuestionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        QuestionType::query()->truncate();

        $questionsTypes = [
            ['name' => ['ar'=>'اختر الإجابة الصحيحة','en'=>'Mcq'], 'slug' => 'mcq','is_default' => 1,],
            ['name' => ['ar'=>'اختر الإجابة الصحيحة','en'=>'Chosse The Correct Answer'], 'slug' => 'choose_answer','is_default' => 1,'parent_id'=>1],
            ['name' => ['ar'=>'ضع علامة صح او خطاء','en'=>'True & False'], 'slug' => 'true_false','is_default' => 1,],
            ['name' => ['ar'=>'ضع علامة صح او خطاء','en'=>'Chosse The True or False'], 'slug' => 'chosse_true_false','is_default' => 1,'parent_id'=>3],
            ['name' => ['ar'=>'سؤال متعدد الخيارات','en'=>'Select'], 'slug' => 'select','is_default' => 1,],
            ['name' => ['ar'=>'سؤال متعدد الخيارات','en'=>'Chosse The Correct Answers'], 'slug' => 'chosse_answers','is_default' => 1,'parent_id'=>5],
            ['name' => ['ar'=>'مطابقة الاجابات الصحيحة','en'=>'Matching'], 'slug' => 'match','is_default' => 1,],
            ['name' => ['ar'=>'وصل الاجابات الصحيحة','en'=>'Match one to Many'], 'slug' => 'match_one_to_many','is_default' => 1,'parent_id'=>7],
            ['name' => ['ar'=>'وصل الاجابة الصحيحة','en'=>'Match one to one'], 'slug' => 'match_one_to_one','is_default' => 1,'parent_id'=>7],
            ['name' => ['ar'=>'المزاوجة والتوافق','en'=>'Drag & Drop'], 'slug' => 'drag_and_drop','is_default' => 1,],
            ['name' => ['ar'=>'السحب والإفلات' ,'en'=>'Drag & Drop Many'], 'slug' => 'drag_and_drop_one','is_default' => 1,'parent_id'=>10],
            ['name' => ['ar'=>'السحب والإفلات المتعدد','en'=>'Drag & Drop With Sorting'], 'slug' => 'drag_and_drop_many','is_default' => 1,'parent_id'=>10],
        ];


          // $questionsTypes = [
        //     ['name' => 'اختر الإجابة الصحيحة', 'slug' => 'mcq','is_default' => 1,],
        //     ['name' => 'اختر الإجابة الصحيحة', 'slug' => 'choose_answer','is_default' => 1,'parent_id'=>1],
        //     ['name' => 'ضع علامة صح او خطاء', 'slug' => 'true_false','is_default' => 1,],
        //     ['name' => 'ضع علامة صح او خطاء', 'slug' => 'chosse_true_false','is_default' => 1,'parent_id'=>3],
        //     ['name' => 'سؤال متعدد الخيارات', 'slug' => 'select','is_default' => 1,],
        //     ['name' => 'سؤال متعدد الخيارات', 'slug' => 'chosse_answers','is_default' => 1,'parent_id'=>5],
        //     ['name' => 'مطابقة الاجابات الصحيحة', 'slug' => 'match','is_default' => 1,],
        //     ['name' => 'وصل الاجابات الصحيحة', 'slug' => 'match_one_to_many','is_default' => 1,'parent_id'=>7],
        //     ['name' => 'وصل الاجابة الصحيحة', 'slug' => 'match_one_to_one','is_default' => 1,'parent_id'=>7],
        //     ['name' => 'المزاوجة والتوافق', 'slug' => 'drag_and_drop','is_default' => 1,],
        //     ['name' => 'السحب والإفلات' , 'slug' => 'drag_and_drop_one','is_default' => 1,'parent_id'=>10],
        //     ['name' => 'السحب والإفلات المتعدد', 'slug' => 'drag_and_drop_many','is_default' => 1,'parent_id'=>10],
        // ];

        foreach($questionsTypes as $questionType){
            QuestionType::create($questionType);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');


    }
}
