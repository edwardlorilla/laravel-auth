<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'user_type', 'status', 'photo_id', 'education',
        'first_name', 'middle_name', 'last_name', 'birth_date',
        'gender', 'mobile', 'designation', 'department', 'campus',
        'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
    /**
     * App\Post::find(1)->announcements;
     */
    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
    /**
     * App\Post::find(1)->performances;
     *insert - auth()->user()->performances()->save(new Announcement($validateData));
     *update - auth()->user()->performances()->where('id', id)->update($validateData));
     *delete - auth()->user()->performances()->where('id', id)->delete();
     */
    public function performances()
    {
        return $this->hasMany(Performance::class);
    }
        /**
         * App\Post::find(1)->contributions;
         *insert - auth()->user()->contributions()->save(new Announcement($validateData));
         *update - auth()->user()->contributions()->where('id', id)->update($validateData);
         *delete - auth()->user()->contributions()->where('id', id)->delete();
         */
        public function contributions()
        {
            return $this->hasMany(Contribution::class);
        }
    /**
     * App\Post::find(1)->documents;
     *insert - auth()->user()->documents()->save(new Announcement($validateData));
     *update - auth()->user()->documents()->where('id', id)->update($validateData));
     *delete - auth()->user()->documents()->where('id', id)->delete();
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();
        return $this->api_token;
    }
}
