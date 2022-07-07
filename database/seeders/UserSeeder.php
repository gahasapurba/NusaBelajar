<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin NusaBelajar',
            'email' => 'nusabelajar@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s', time()),
            'password' => bcrypt('nusa#belajar07'),
            'avatar' => 'https://lh3.googleusercontent.com/a-/AOh14GgKauqTYkvaa8-8x3ytNR6reiu-fCE_GMZ4gvbX=s96-p',
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Gahasa Purba',
            'email' => 'gahasapurba.edu@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s', time()),
            'password' => bcrypt('gahasa#mentor07'),
            'avatar' => 'https://lh3.googleusercontent.com/a-/AOh14GgzCM2lSGCRLn8vz1ey8ws9r4ZNK055zZy8OUkM=s96-c',
            'is_mentor' => true,
        ]);

        User::create([
            'name' => 'Gahasa Purba',
            'email' => 'gahasapurba.tech@gmail.com',
            'email_verified_at' => date('Y-m-d H:i:s', time()),
            'password' => bcrypt('gahasa#user07'),
            'avatar' => 'https://lh3.googleusercontent.com/a-/AOh14GjMeEJTt2DUU8vjAexVJXidpeXzFi2IE0ycypUf=s96-c',
        ]);
    }
}
