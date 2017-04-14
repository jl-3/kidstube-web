<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'code', 'user_id', 'category_id',
    ];

    /**
     * Returns the author who added video to the KidsTube
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Returns the category where the video belongs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Returns all the categories of the specified video
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @deprecated Use "category" property instead.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'video_categories');
    }

    /**
     * Returns the URL to the video thumbnail image
     *
     * @return string
     */
    public function getThumbnailUrl()
    {
        return 'https://img.youtube.com/vi/'.$this->code.'/0.jpg';
    }
}
