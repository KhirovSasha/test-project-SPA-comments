<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Comment::factory(50)->withParentComment()->create();

        User::factory()->create([
            'userName' => 'test',
            'email' => 'email@test.com',
            'password' => 'test'
        ]);
    }
}
