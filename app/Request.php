<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'requests';

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
        'status', 'due_date', 'description', 'quantity', 'paper_size', 'paper_type', 'file', 'closed_date', 'refused_reason', 'satisfaction_grade',  'colored', 'stapled', 'front_back'
    ];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function printer()
    {
    	return $this->belongsTo('App\Printer');
    }

    public function comments()
    {
    	return $this->hasMany('App\Comment');
    }
}
