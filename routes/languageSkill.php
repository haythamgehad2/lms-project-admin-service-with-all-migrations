<?php
use App\Http\Controllers\LanguageSkillController;
use Illuminate\Support\Facades\Route;

Route::get('language_skills', [LanguageSkillController::class, 'index'])->middleware(['abilities:view-languageSkill']);
Route::post('language_skills', [LanguageSkillController::class, 'create'])->middleware(['abilities:add-languageSkill']);
Route::put('language_skills/{id}', [LanguageSkillController::class, 'update'])->middleware(['abilities:edit-languageSkill']);
Route::delete('language_skills/{id}', [LanguageSkillController::class, 'delete'])->middleware(['abilities:delete-languageSkill']);
Route::get('language_skills/{id}', [LanguageSkillController::class, 'show'])->middleware(['abilities:view-languageSkill']);
