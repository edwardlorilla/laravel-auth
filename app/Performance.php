<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    protected $fillable = ['target', 'ceta', 'etd', 'etp', 'ets', 'etse', 'school_year_start', 'school_year_end', 'semester'];
    /**
    * $comment = App\Comment::find(1);
    * echo $comment->user->title;
    *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
