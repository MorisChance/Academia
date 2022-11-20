<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        Faculty::create(['name' => '外国語学部']);
        Faculty::create(['name' => '文学部']);
        Faculty::create(['name' => '経済学部']);
        Faculty::create(['name' => '教育学部']);
        Faculty::create(['name' => '法学部']);
        Faculty::create(['name' => '理工学部']);
        Faculty::create(['name' => '工学部']);
        Faculty::create(['name' => '農学部']);
        Faculty::create(['name' => '水産学部']);
        Faculty::create(['name' => '獣医学部']);
        Faculty::create(['name' => '医学部']);
        Faculty::create(['name' => '薬学部']);
        Faculty::create(['name' => '歯学部']);
    }
}

