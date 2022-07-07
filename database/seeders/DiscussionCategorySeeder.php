<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiscussionCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiscussionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DiscussionCategory::create([
            'name' => 'Programming',
            'slug' => 'programming',
        ]);
        
        DiscussionCategory::create([
            'name' => 'Design',
            'slug' => 'design',
        ]);
        
        DiscussionCategory::create([
            'name' => 'Back End',
            'slug' => 'back-end',
        ]);
        
        DiscussionCategory::create([
            'name' => 'Front End',
            'slug' => 'front-end',
        ]);
        
        DiscussionCategory::create([
            'name' => 'Data',
            'slug' => 'data',
        ]);
        
        DiscussionCategory::create([
            'name' => 'Web',
            'slug' => 'web',
        ]);
        
        DiscussionCategory::create([
            'name' => 'Mobile',
            'slug' => 'mobile',
        ]);
        
        DiscussionCategory::create([
            'name' => 'Security',
            'slug' => 'security',
        ]);
        
        DiscussionCategory::create([
            'name' => 'Network',
            'slug' => 'network',
        ]);
        
        DiscussionCategory::create([
            'name' => 'IOT',
            'slug' => 'iot',
        ]);
    }
}
