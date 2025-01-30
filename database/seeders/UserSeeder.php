<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $users = User::factory()->count(50)->make()->each(function ($user) {
                $user->save();
            });
        }
        catch (\Exception $e) {
            //skip errors
        }
    }
}
