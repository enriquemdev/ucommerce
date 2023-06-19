<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Schema::create('users', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('email')->unique();
        //     $table->tinyInteger('is_staff')->default(0); // 0 for Client, 1 for Staff
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('password');
        //     $table->rememberToken();
        //     $table->foreignId('current_team_id')->nullable();
        //     $table->string('profile_photo_path', 2048)->nullable();
        //     $table->timestamps();
        // });

        DB::table('users')->insert([
            'name' => 'noad',
            'email' => 'noad@gmail.com',
            'is_staff' => 0,
            'password' => '$2y$10$IahmE8unUOBhWgUwwrVBn.EPoKCsEN1XgkKFgG5qvD2.ohYeRO7Uy',
        ]);

        DB::table('users')->insert([
            'name' => 'ad',
            'email' => 'ad@gmail.com',
            'is_staff' => 1,
            'password' => '$2y$10$IahmE8unUOBhWgUwwrVBn.EPoKCsEN1XgkKFgG5qvD2.ohYeRO7Uy',
        ]);

        DB::table('cat_departments')->insert([
            'name' => 'Rivas',
            'description' => 'Sur de Nicaragua',
        ]);

        DB::table('company_branches')->insert([
            'name' => 'Rivas',
            'cat_department_id' => 1,
        ]);
    }
}
