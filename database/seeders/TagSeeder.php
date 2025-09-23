<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class TagSeeder extends Seeder
{
    use WithoutModelEvents; //don’t want model events (like creating or updating) to run during seeding.
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::create([
            'name' => Str::random(10)
        ]);
    }
}
