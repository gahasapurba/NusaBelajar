<?php

namespace Database\Seeders;

use App\Models\CourseCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseCategory::create([
            'name' => 'Programming',
            'slug' => 'programming',
        ]);
        
        CourseCategory::create([
            'name' => 'Design',
            'slug' => 'design',
        ]);
        
        CourseCategory::create([
            'name' => 'Back End',
            'slug' => 'back-end',
        ]);
        
        CourseCategory::create([
            'name' => 'Front End',
            'slug' => 'front-end',
        ]);
        
        CourseCategory::create([
            'name' => 'Data',
            'slug' => 'data',
        ]);
        
        CourseCategory::create([
            'name' => 'Web',
            'slug' => 'web',
        ]);
        
        CourseCategory::create([
            'name' => 'Mobile',
            'slug' => 'mobile',
        ]);
        
        CourseCategory::create([
            'name' => 'Security',
            'slug' => 'security',
        ]);
        
        CourseCategory::create([
            'name' => 'Network',
            'slug' => 'network',
        ]);
        
        CourseCategory::create([
            'name' => 'IOT',
            'slug' => 'iot',
        ]);
    }
}
