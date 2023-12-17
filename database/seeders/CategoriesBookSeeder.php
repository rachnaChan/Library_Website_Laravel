<?php

namespace Database\Seeders;

use App\Models\Categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categories::create([
            'categories_name' => 'Operating System',
            'user_categories' => '2',

        ]);

        Categories::create([
            'categories_name' => 'Research Methodology',
            'user_categories' => '2',

        ]);
        
        Categories::create([
            'categories_name' => 'Network Security',
            'user_categories' => '2',

        ]);
    }
}
