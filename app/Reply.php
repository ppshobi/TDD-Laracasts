<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Favoritable;

class Reply extends Model
{
    use Favoritable;
    use RecordsActivity;

    protected $fillable = ['body', 'user_id'];
    protected $with = ['owner', 'favorites'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

}
