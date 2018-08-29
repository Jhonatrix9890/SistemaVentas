<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table='detalle_ingreso';
    protected $primaryKey='iddetalle_ingreso';
    public $timestamps=false;

    protected $fillable=[
     'idIngreso',
     'idArticulo',
     'cantidad',
     'precioCompra',
     'precioVenta',

    ];

    protected $guarded=[


    ];
}
