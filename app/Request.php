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
        'status', 'due_date', 'description', 'quantity', 'paper_size', 'paper_type', 'file', 'closed_date', 'refused_reason', 'satisfaction_grade',  'colored', 'stapled', 'front_back', 'owner_id'
    ];


    public function statusToStr()
    {
        switch ($this->status) {
            case 0:
                return 'Pendente';
            case 1:
                return 'Recusado';
            case 2:
                return 'Concluido';
        }
    }

    public function paper_sizeToStr()
    {
        switch ($this->paper_size) {
            case 1:
                return 'A1';
            case 2:
                return 'A2';
            case 3:
                return 'A3';
            case 4:
                return 'A4';
            case 5:
                return 'A5';
            case 6:
                return 'A6';
        }
    }

    public function paper_typeToStr()
    {
        switch ($this->paper_type) {
            case 0:
                return 'Papel Rascunho';
            case 1:
                return 'Papel Normal';
            case 2:
                return 'Papel Fotogrático';
        }
    }

    public function coloredToStr()
    {
        switch ($this->colored) {
            case 0:
                return 'Preto e Branco';
            case 1:
                return 'Cores';
        }
    }

    public function front_backToStr()
    {
        switch ($this->front_back) {
            case 0:
                return 'Página única';
            case 1:
                return 'Frente e verso';
        }
    }

    public function stapledToStr()
    {
        switch ($this->stapled) {
            case 0:
                return 'Não agrafado';
            case 1:
                return 'Agrafado';
        }
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'owner_id');
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
