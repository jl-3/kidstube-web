<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'thumbnail', 'user_id'
    ];

    /**
     * Returns the author who created this video category on the KidsTube
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Returns all the videos in the specified category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @deprecated Use "videoList" property instead.
     */
    public function videos()
    {
        return $this->belongsToMany(Video::class, 'video_categories');
    }

    /**
     * Returns all the videos in the specified category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videoList()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * Updates category thumbnail for it to match the last video that has been added to it.
     */
    public function updateThumbnail()
    {
        $lastVideo = $this->videoList()->orderBy('updated_at', 'desc')->first();
        if ($lastVideo) {
            $this->thumbnail = $lastVideo->getThumbnailUrl();
            $this->save();
        }
    }
}
