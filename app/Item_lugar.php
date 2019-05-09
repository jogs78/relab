<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_lugar extends Model
{
    protected $table = 'item_lugar';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lugar_id', 'item_id', 'updated_at'
    ];
}
