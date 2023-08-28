<?php

use App\Enums\PeperworkTypeEnum;

    return [

        'countries' =>[
            'list'=>'List of countries returned successfully',
            'show'=>'Country list returned successfully',
            'create'=>'Country list entered successfully',
            'update'=>'Country list updated successfully',
            'delete' => 'The country was deleted successfully' ,
            'not_create'=>'The country was not created successfully',
            'not_update'=>'The country was not updated successfully',
            'not_delete'=>'The country was not deleted successfully'
          ],


        'schools' => [
            'list'=>'list of schools returned successfully',
            'show'=> 'Schools returned successfully',
            'create' => 'Schools entered successfully',
            'update' => 'School updated successfully',
            'delete' => 'The school was deleted successfully' ,
            'not_create'=>'The school was not created successfully',
            'not_update'=>'The school was not updated successfully',
            'not_delete'=>'The school was not deleted successfully',
            'level_assigned_school_success'=>'Levels assigned to the school',
            'level_assigned_school_field'=>'levels assigned to the school',
            'level_term_list'=>'levels and chapters returned successfully',
            'level_term_not_return_list'=>'levels and chapters were not returned successfully'


        ],


        'terms' => [
            'list' => 'list of classes returned successfully',
            'show' => 'Class returned successfully',
            'create'=>'class entered successfully',
            'update'=>'class updated successfully',
            'delete'=>'classes canceled successfully',
            'not_create'=>'Class not created successfully',
            'not_update'=>'classes were not updated successfully',
            'not_delete'=>'Not deleting classes successfully',

        ],

        'levels' => [
            'list' => 'The list of classes was returned successfully',
            'show' => 'Student rollback successfully',
            'create'=>'Student entered successfully',
            'update'=>'The class has been updated successfully',
            'delete'=>'the class has been canceled successfully',
            'not_create'=>'The course was not created successfully',
            'not_update'=>'The course was not updated successfully',
            'not_delete'=>'The course has not been successfully deleted.'
        ],

        'roles' => [
            'list' => 'Job list returned successfully',
            'show' => 'The function returned successfully',
            'create'=>'function entered successfully',
            'update'=>'job updated successfully',
            'delete'=>'The job was successfully deleted',
            'default_role_delete'=>'The role has not been deleted, the role is default',
            'not_create'=>'The job was not created successfully',
            'not_update'=>'The job was not updated successfully',
            'not_delete'=>'The job was not deleted successfully'
        ],

        'packages' => [
            'list' => 'List of packages returned successfully',
            'show' => 'Package returned successfully',
            'create'=>'The package has been inserted successfully',
            'update'=>'The package has been updated successfully',
            'delete'=>'the package has been successfully deleted',
            'not_create'=>'The package was not created successfully',
            'not_update'=>'The package was not updated successfully',
            'not_delete'=>'The package was not deleted successfully.'
        ],

        'school_types' => [
            'list' => 'School type list successfully returned',
            'show' => 'School type returned successfully',
            'create'=>'School type entered successfully',
            'update'=>'School type updated successfully',
            'delete'=>'School type was deleted successfully',
            'not_create'=>'The school type was not created successfully',
            'not_update'=>'The school type was not updated successfully',
            'not_delete'=>'The school type was not deleted successfully',
            'types'=>[
                'national'=>'National',
                'international'=>'International'
            ]
        ],

        'classes' => [
            'list' => 'List of classes successfully returned',
            'show' => 'Classes returned successfully',
            'create'=>'Classes entered successfully',
            'update'=>'Classes updated successfully',
            'delete'=>'classes have been successfully deleted',
            'classes_missions_num_filed'=>'Sorry, the minimum number of missions is not reached',
            'not_create'=>'Classes were not created successfully',
            'not_update'=>'Classes were not updated successfully',
            'not_delete'=>'Not able to delete classes successfully'
        ],


        'users' => [
            'list' => 'User list returned successfully',
            'show' => 'User returned successfully',
            'create'=>'user entered successfully',
            'update'=>'User updated successfully',
            'delete'=>'User update canceled successfully',
            'not_create'=>'The user was not created successfully',
            'not_update'=>'The user was not updated successfully',
            'not_delete'=>'The user was not deleted successfully'
        ],

        'learning paths' => [
            'list' => 'List of learning paths returned successfully',
            'show' => 'learning path returned successfully',
            'create'=>'learning paths entered successfully',
            'update'=>'Learning paths have been updated successfully',
            'delete'=>'learning tracks have been successfully deleted',
            'learningpath_status_change_success'=>'Learning path task status changed successfully',
            'learningpath_status_not_change_success'=>'The learning path tasks status was not changed successfully',
            'not_create'=>'The learning pathways were not created successfully',
            'not_update'=>'The learning paths were not modified successfully',
            'not_delete'=>'The learning path was not deleted successfully'
        ],

        'videobanks' => [
            'list' => 'Video list successfully returned',
            'show' => 'The video was returned successfully',
            'create'=>'Video inserted successfully',
            'update'=>'Video updated successfully',
            'delete'=>'the video was deleted successfully',
            'not_create'=>'The video was not created successfully',
            'not_update'=>'The video was not updated successfully',
            'not_delete'=>'The video was not deleted successfully',
        ],

        'questions' => [
            'list' => 'Question list successfully returned',
            'show' => 'Question returned successfully',
            'create'=>'Question entered successfully',
            'update'=>'Question updated successfully',
            'delete'=>'The question was deleted successfully',
            'not_create'=>'The question was not created successfully',
            'not_update'=>'The question was not updated successfully',
            'not_delete'=>'The question was not deleted successfully.'
        ],

        'school_groups' => [
            'list' => 'School group list returned successfully',
            'show' => 'School group returned successfully',
            'create'=>'School group entered successfully',
            'update'=>'School group updated successfully',
            'delete'=>'School group has been successfully deleted',
            'not_create'=>'The school group was not created successfully',
            'not_update'=>'The school group was not updated successfully',
            'not_delete'=>'The school group was not deleted successfully.'
        ],

        'questions_types' => [
            'list' => 'Question type list successfully returned',
            'show' => 'Question type returned successfully',
            'create'=>'Question type entered successfully',
            'update'=>'Question type updated successfully',
            'delete'=>'question type has been deleted successfully',
            'not_create'=>'The question type was not created successfully',
            'not_update'=>'The question type was not updated successfully',
            'not_delete'=>'The question type was not deleted successfully.'
        ],


        'questions_difficulties' => [
            'list' => 'Question difficulty list successfully returned',
            'show' => 'Question difficulty returned successfully',
            'create'=>'Question difficulty entered successfully',
            'update'=>'Question difficulty updated successfully',
            'delete'=>'The question has been successfully deleted',
            'not_create'=>'Question difficulty was not created successfully',
            'not_update'=>'The question difficulty was not modified successfully',
            'not_delete'=>'The question difficulty was not removed successfully.'
        ],

        'bloom_categories' => [
            'list' => 'Bloom category list returned successfully',
            'show' => 'Bloom category returned successfully',
            'create'=>'Bloom category entered successfully',
            'update'=>'Bloom category has been updated successfully',
            'delete'=>'Bloom category has been successfully deleted',
            'not_create'=>'The Bloom category was not created successfully',
            'not_update'=>'The Bloom category was not updated successfully',
            'not_delete'=>'The Bloom category was not successfully deleted.'
        ],


        'language_skills' => [
            'list' => 'Language skills list returned successfully',
            'show' => 'Language skills returned successfully',
            'create'=>'language skills entered successfully',
            'update'=>'language skills updated successfully',
            'delete'=>'Skills successfully deleted',
            'not_create'=>'The language skills were not created successfully',
            'not_update'=>'The language skills were not updated successfully',
            'not_delete'=>'The language skills were not successfully deleted'
        ],

           'language_methods' => [
            'list' => 'List method language returned successfully',
            'show' => 'language method returned successfully',
            'create'=>'language method entered successfully',
            'update'=>'language method updated successfully',
            'delete'=>'The language method was successfully deleted',
            'not_create'=>'The language method was not created successfully',
            'not_update'=>'The language method was not modified successfully',
            'not_delete'=>'The language method was not deleted successfully.'
        ],

        'paper_works' => [
            'list' => 'The list of worksheets was successfully returned',
            'show' => 'The worksheet was returned successfully',
            'create'=>'The worksheet has been inserted successfully',
            'update'=>'worksheet updated successfully',
            'delete'=>'The worksheet has been deleted successfully',
            'not_create'=>'The worksheet was not created successfully',
            'not_update'=>'The worksheet was not updated successfully',
            'not_delete'=>'The worksheet was not deleted successfully',
            'types' => [
                'participatory'=>'Participatory paperwork',
                 'single'=>'Single paperwork',
            ]
        ],

        'missions' => [
            'list' => 'The mission list was successfully returned',
            'show' => 'The mission was returned successfully',
            'create'=>'The mission was entered successfully',
            'update'=>'mission updated successfully',
            'delete'=>'the mission was successfully canceled',
            'list_contents'=>'List contents returned successfully',
            'selected_learningpath_content_success'=>'the content of the mission was selected successfully',
            'selected_learningpath_content_error'=>'The mission content was not selected successfully',
            'rearrange_success'=>'rearrange_success',
            'rearrange_error'=>'The mission was not rearranged successfully',
            'not_create'=>'The mission was not created successfully',
            'not_update'=>'The mission was not updated successfully',
            'not_delete'=>'The mission was not canceled successfully'
        ],

        'quizzes' => [
            'list' => 'List of quiz returned successfully',
            'show' => 'quiz returned successfully',
            'create'=>'quiz entered successfully',
            'update'=>'quiz updated successfully',
            'delete'=>'the quiz was canceled successfully',
            'not_create'=>'The quiz was not created successfully',
            'not_update'=>'The quiz was not modified successfully',
            'not_delete'=>'The quiz was not canceled successfully',
            'types'=>[
                'default'=>'Default',
                'manual'=>'Manual',
                'automatic'=>'Automatic',
            ]
        ],

        'enrollments' => [
            'list' => 'Employee registration list returned successfully',
            'show' => 'Employee registration returned successfully',
            'create'=>'Employee registration entered successfully',
            'update'=>'Employee registration has been updated successfully',
            'delete'=>'The employee has been successfully deregistered',
            'not_create'=>'The employee registration was not created successfully',
            'not_update'=>'The employees registration was not modified successfully',
            'not_delete'=>'The employee was not successfully deregistered'
        ],

        'student_enrollments' => [
            'list' => 'Student registration list returned successfully',
            'show' => 'Student registration returned successfully',
            'create'=>'Student registration entered successfully',
            'update'=>'Student registration has been updated successfully',
            'delete'=>'Student has been successfully deregistered',
            'not_create'=>'Student registration was not created successfully',
            'not_update'=>'Student registration was not modified successfully',
            'not_delete'=>'The student was not deregistered successfully'
        ],



];
