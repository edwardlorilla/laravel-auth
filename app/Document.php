<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['file', 'title', 'category_id'];
    /**
    * $comment = App\Comment::find(1);
    * echo $comment->user->title;
    *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    /**
     * App\Post::find(1)->files;
     *insert - auth()->user()->files()->save(new Announcement($validateData));
     *update - auth()->user()->files()->where('id', id)->update($validateData);
     *delete - auth()->user()->files()->where('id', id)->delete();
     */
    public function files()
    {
        return $this->belongsToMany(File::class);
    }
}
