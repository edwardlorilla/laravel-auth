<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['file', 'type', 'name'];
    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }
}
