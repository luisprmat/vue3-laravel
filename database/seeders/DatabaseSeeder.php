<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categoryNames = [
            'Tecnología',
            'Educación',
            'Ciencia',
            'Política',
            'Economía',
        ];

        foreach ($categoryNames as $name) {
            Category::create(['name' => $name]);
        }

        $categories = Category::pluck('id');

        for ($i = 0; $i < 18; $i++) {
            Post::factory()->create([
                'category_id' => $categories->random(),
            ]);
        }

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
