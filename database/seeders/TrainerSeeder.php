<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
public function run()
{
    // إنشاء مدربين تجريبيين
    $trainers = User::factory()->count(5)->create([
        'role' => 'trainer',
        'is_approved' => true
    ]);
    
    // أو الحصول على المدربين المفعلين
    $approvedTrainers = User::approvedTrainers()->get();
}
}