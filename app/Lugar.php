<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
	protected $table = 'lugars';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'foto','nombre','user_add','user_edit'
    ];
}
