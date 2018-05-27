<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $fillable = ['amount', 'transaction_id'];
    /**
    * $comment = App\Comment::find(1);
    * echo $comment->transaction->title;
    *
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

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
