<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DosenSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 25) as $index) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'role' => 'dosen',
                'avatar' => null,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]);
        }
    }
}
