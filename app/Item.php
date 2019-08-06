<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Item extends Model
{
  protected $table = 'items';

  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'clasificacion','descripcion','modelo','estado', 'path', 'marca','numero_inventario','numero_serie','lugar_id','user_id','user_edit'
    ];

public static function getEnumValues($table, $column)
{
  $type = DB::select( DB::raw("SHOW COLUMNS FROM $table WHERE Field = '$column'") )[0]->Type;
  preg_match('/^enum\((.*)\)$/', $type, $matches);
  $enum = array();
  foreach( explode(',', $matches[1]) as $value )
  {
    $v = trim( $value, "'" );
    $enum = array_add($enum, $v, $v);
  }
  return $enum;
}

}
