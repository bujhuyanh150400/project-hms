<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminPanelSeeder extends Seeder
{
    /**
     *  php artisan db:seed --class=AdminPanelSeeder
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id'=> 15042000,
            'name' => 'Bùi Huy Anh',
            'email' => 'bujhuyanh150400@gmail.com',
            'password' => '$2a$12$tp6NEGEQTgGgj5dXqRHS4OfYtbw3FuwKpNmlFZoeojM8m1lemprG6', // admin1234
            'birth' => '2000-04-15 00:00:00',
            'address' => 'VN',
            'gender' => 1,
            'phone' => '0917095494',
            'permission' => 16,
            'created_at'=> now(),
            'updated_at'=> now(),
            'updated_by'=> 15042000,
            'created_by'=> 15042000,
            'remember_token'=> Str::random(10),
        ]);
    }
}
