<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table='ingreso';
    protected $primaryKey='idingreso';
    public $timestamps=false;

    protected $fillable=[
     'idProveedor',
     'tipoComprovante',
     'serieComprovante',
     'numeroCompras',
     'fechaHora',
     'impuesto',
     'estado',


    ];

    protected $guarded=[


    ];
}
