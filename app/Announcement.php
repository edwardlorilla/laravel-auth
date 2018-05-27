<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['title', 'description'];
    /**
    * $announcement = App\Announcement::find(1);
    * echo $announcement->user->title;
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
