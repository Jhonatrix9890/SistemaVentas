<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table='ingreso';
    protected $primaryKey='idingreso';
    public $timestamps=false;

    protected $fillable=[
     'idproveedor',
     'tipocomprovante',
     'seriecomprovante',
     'numerocomprovante',
     'fechahora',
     'impuesto',
     'estado',


    ];

    protected $guarded=[


    ];


    public function proveedor()
    {
        return $this->belongsTo('sisVentas\Persona', 'idproveedor');
    }

    public function detalles()
    {
        return $this->hasMany('sisVentas\DetalleIngreso', 'idingreso');
    }
}
