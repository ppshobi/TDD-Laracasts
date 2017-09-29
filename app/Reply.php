<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['body', 'user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites ()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * Favorites a reply
     */
    public function favourite ()
    {
        if (!$this->favorites()->where(['user_id' => auth()->id()])->exists()) {
            $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }
}
