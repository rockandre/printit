<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments';

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
        'comment',
    ];


    public function comments()
    {
        return $this->hasMany('App\Comment', 'parent_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function request()
    {
    	return $this->belongsTo('App\Request');
    }
}
