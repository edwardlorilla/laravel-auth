<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title'];
    /**
     * App\Post::find(1)->documents;
     *insert - auth()->user()->documents()->save(new Announcement($validateData));
     *update - auth()->user()->documents()->where('id', id)->update($validateData);
     *delete - auth()->user()->documents()->where('id', id)->delete();
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
