<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table='venta';
    protected $primaryKey='idventa';
    public $timestamps=false;

    protected $fillable=[
     'idcliente',
     'tipocomprovante',
     'seriecomprovante',
     'numerocomprovante',     
     'fechahora',
     'impuesto',
     'totalventa',
     'estado',


    ];

    protected $guarded=[


    ];

    public function cliente()
    {
        return $this->belongsTo('sisVentas\Persona', 'idcliente');
    }

    public function detalles()
    {
        return $this->hasMany('sisVentas\DetalleVenta', 'idventa');
    }
}
