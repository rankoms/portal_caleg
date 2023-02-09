<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $default_user_value = [
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10)
        ];
        $super_admin = User::create(array_merge([
            'email' => 'super_admin@super_admin.com',
            'name' => 'super admin',
            'role' => 'super_admin'
        ], $default_user_value));
        $admin1 = User::create(array_merge([
            'email' => 'admin1@admin1.com',
            'name' => 'admin1',
            'role' => 'admin'
        ], $default_user_value));
    }
}
