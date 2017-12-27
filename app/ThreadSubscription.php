<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreadSubscription extends Model
{
    protected  $fillable = ['user_id', 'thread_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
