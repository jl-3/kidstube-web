<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SimpifyDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->nullable()->after('user_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

        foreach (\App\Video::all() as $video) {
            $cat = $video->categories()->first();
            if ($cat) {
                $video->category()->associate($cat);
                $video->save();
            }
        }

        Schema::dropIfExists('video_categories');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('video_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('video_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->timestamps();

            $table->foreign('video_id')->references('id')->on('videos')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

        foreach (\App\Video::all() as $video) {
            $cat = $video->category;
            if ($cat) {
                $video->categories()->save($cat);
            }
        }

        Schema::table('videos', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
}
