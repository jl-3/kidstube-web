<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Video;
use App\User;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $testUser = User::orderBy('id', 'desc')->first();

        $smeshariki = Category::whereName('Смешарики')->first();
        $video = Video::create(['url' => 'https://www.youtube.com/watch?v=cPcxuDbexBQ', 'code' => 'cPcxuDbexBQ', 'user_id' => $testUser->id]);
        $video->categories()->attach($smeshariki->id);
        $video = Video::create(['url' => 'https://www.youtube.com/watch?v=COKpq4SyZCQ', 'code' => 'COKpq4SyZCQ', 'user_id' => $testUser->id]);
        $video->categories()->attach($smeshariki->id);

        $fiksiki = Category::whereName('Фиксики')->first();
        $video = Video::create(['url' => 'https://www.youtube.com/watch?v=VR9bGnrgR9I', 'code' => 'VR9bGnrgR9I', 'user_id' => $testUser->id]);
        $video->categories()->attach($fiksiki->id);
        $video = Video::create(['url' => 'https://www.youtube.com/watch?v=yGl33qUsyTo', 'code' => 'yGl33qUsyTo', 'user_id' => $testUser->id]);
        $video->categories()->attach($fiksiki->id);
    }
}
