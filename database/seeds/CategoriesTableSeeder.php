<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\User;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $testUser = User::orderBy('id', 'desc')->first();
        Category::create(['name' => 'Смешарики', 'user_id' => $testUser->id]);
        Category::create(['name' => 'Фиксики', 'user_id' => $testUser->id]);
        Category::create(['name' => 'ABC mouse', 'user_id' => $testUser->id]);
    }
}
