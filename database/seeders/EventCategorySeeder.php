<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EventCategory::create([
            'name' => 'Programming',
            'slug' => 'programming',
        ]);
        
        EventCategory::create([
            'name' => 'Design',
            'slug' => 'design',
        ]);
        
        EventCategory::create([
            'name' => 'Back End',
            'slug' => 'back-end',
        ]);
        
        EventCategory::create([
            'name' => 'Front End',
            'slug' => 'front-end',
        ]);
        
        EventCategory::create([
            'name' => 'Data',
            'slug' => 'data',
        ]);
        
        EventCategory::create([
            'name' => 'Web',
            'slug' => 'web',
        ]);
        
        EventCategory::create([
            'name' => 'Mobile',
            'slug' => 'mobile',
        ]);
        
        EventCategory::create([
            'name' => 'Security',
            'slug' => 'security',
        ]);
        
        EventCategory::create([
            'name' => 'Network',
            'slug' => 'network',
        ]);
        
        EventCategory::create([
            'name' => 'IOT',
            'slug' => 'iot',
        ]);
    }
}
