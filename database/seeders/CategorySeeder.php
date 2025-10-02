<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Self Care and Relaxation'],
            ['category_name' => 'Birthday Suprises'],
            ['category_name' => 'Kids Delights'],
            ['category_name' => 'Anniversary Specials'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
    
}
