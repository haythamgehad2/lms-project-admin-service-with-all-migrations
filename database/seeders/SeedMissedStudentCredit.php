<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeedMissedStudentCredit extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->whereDoesntHave("userCredit")
            ->student()
            ->lazy()
            ->each(
                fn($student) => $student->userCredit()->create()
            );
    }
}
