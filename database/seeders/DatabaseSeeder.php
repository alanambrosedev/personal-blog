<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // save in DB use create
        User::factory(10)->create();

        // variations of Post model
        Post::factory()->suspended()->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Has Many relationship in factories
        Category::factory(10)
            ->has(Post::factory()->withTags()->count(20))
            ->create();
        // Has Many using magic methods
        Category::factory()->hasPosts(2)->create();
        // Has Many with attributes
        Category::factory()->hasPosts(3, ['name' => 'Post 1'])->create();

        // Make (not saved in DB for testing purpose)
        $user = User::factory()->count(3)->make();

        // override attributes or use state(). Mass assignment is disabled always when using factorties
        Category::factory()->create(['name' => 'Category 1']);
        Category::factory()->state(['name' => 'Category 1'])->create();

        // seeders run in order
        $this->call([
            UserSeeder::class,
            TagSeeder::class,
        ]);

        // Use sequence to alternate or randomize values
        $users = User::factory()->count(3)->state(new Sequence([
            'is_admin' => false,
            'is_admin' => true,
        ]))->create(); // this alternates true/false for is_admin column

        // BelongsTo (If Posts belong to a User)
        $posts = Post::factory()->count(2)->for(User::factory())->create();
        // BelongsTo with magic method
        // (count() means generate 3 posts)
        $posts = Post::factory()->count(3)->forUser(['name' => 'Alan'])->create();

        // We can also use existing user instance for factories
        Post::factory()->count(2)->for($users)->create();

        // recycle() Reuses an existing model across multiple factories
        Post::factory()->count(2)->recycle($user)->create();
        
    }
}
