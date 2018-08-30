<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table='venta';
    protected $primaryKey='idventa';
    public $timestamps=false;

    protected $fillable=[
     'idCliente',
     'tipoComprovante',
     'serieComprovante',
     'numeroComprovante',     
     'fechaHora',
     'impuesto',
     'totalVenta',
     'estado',


    ];

    protected $guarded=[


    ];
}
