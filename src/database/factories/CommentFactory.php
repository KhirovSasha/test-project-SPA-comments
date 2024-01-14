<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'userID' => User::factory(),
            'text' => $this->faker->paragraph,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function nullParentCommentId()
    {
        return $this->state(function (array $attributes) {
            return [
                'ParentCommentID' => null,
            ];
        });
    }

    public function withParentComment($parentCommentId)
    {
        return $this->state(function (array $attributes) use ($parentCommentId) {
            return [
                'ParentCommentID' => $parentCommentId,
            ];
        });
    }
}
