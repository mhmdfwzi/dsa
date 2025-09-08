<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'برمجة', 'description' => 'دورات في مجال البرمجة والتطوير'],
            ['name' => 'تصميم', 'description' => 'دورات في مجال التصميم الجرافيكي والويب'],
            ['name' => 'لغات', 'description' => 'دورات لتعليم اللغات الأجنبية'],
            ['name' => 'أعمال', 'description' => 'دورات في مجال إدارة الأعمال والتسويق'],
            ['name' => 'موسيقى', 'description' => 'دورات في مجال الموسيقى والعزف'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description']
            ]);
        }
    }
}