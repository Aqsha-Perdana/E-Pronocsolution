<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
    {
        DB::table('users')->insert([
        'name' => 'pedeadmin',
        'email' => 'admin123@gmail.com',
        'notelp'=> '0987678926',
        'institution' => 'Manakek',
        'password' => Hash::make('123456'),  // Perbaiki HASH menjadi Hash
        'user_group' => 'admin'
    ]);
}}
