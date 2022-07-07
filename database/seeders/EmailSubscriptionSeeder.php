<?php

namespace Database\Seeders;

use App\Models\EmailSubscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmailSubscription::create([
            'email' => 'gahasapurba.edu@gmail.com',
        ]);
        
        EmailSubscription::create([
            'email' => 'gahasapurba.tech@gmail.com',
        ]);
    }
}
