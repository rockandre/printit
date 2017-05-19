<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'printers';

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
    'name',
    ];

    public function requests()
    {
    	return $this->hasMany('App\Request');
    }
}
