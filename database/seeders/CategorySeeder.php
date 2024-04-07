<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoriesArr = [
            [
                'name' => 'Бытовая техника',
                'slug' => str_slug('Бытовая техника'),
            ],
            [
                'name' => 'Садовая техника',
                'slug' => str_slug('Садовая техника'),
            ],
            [
                'name' => 'Персональные компьютеры',
                'slug' => str_slug('Персональные компьютеры'),
            ],
            [
                'name' => 'Товары для офиса',
                'slug' => str_slug('Товары для офиса'),
            ],
        ];

        foreach ($categoriesArr as $item) {
            //dump($item);
            $category = new Category($item);
            $category->save();
        }
    }
}
