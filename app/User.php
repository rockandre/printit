<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';


     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'department_id', 'profile_photo', 'profile_url', 'presentation', 'print_evals', 'prints_counts', 'admin', 'blocked', 'activated', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function requests()
    {
        return $this->hasMany('App\Request', 'owner_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }
}