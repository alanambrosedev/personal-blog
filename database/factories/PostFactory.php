<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'post' => fake()->paragraph(),
            'image' => fake()->imageUrl(),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }

    public function withTags()
    {
        return $this->afterCreating(function (Post $post) {
            $post->tags()->attach(Tag::factory()->count(3)->create());
        });
    }

    public function suspended()
    {
        return $this->state(fn () => [
            'status' => 0,
        ]);
    }

    // Factories can run code after making or after creating a model.
    // automatically calls the configure() method if it exists.
    public function configure()
    {
        return $this->afterMaking(function (Post $post) {
            // run after the model is made (not saved)
            $post->title = strtoupper($post->title);
        })->afterCreating(function (Post $post) {
            // run after the model is saved
            $post->tags()->attach(Tag::factory()->count(2)->create());
        });
    }
}
