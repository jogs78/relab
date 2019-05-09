<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pc extends Model
{
    protected $table = 'pcs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id','num_maquina','tiene_camara','tiene_bocinas','num_serie_cpu','ram','disco_duro','sistema_operativo','sistema_operativo_activado','cable_vga','tiene_monitor','num_serie_monitor','tiene_teclado','tiene_raton','controlador_red','paq_office_version','paq_office_activado','observaciones'
    ];
}
