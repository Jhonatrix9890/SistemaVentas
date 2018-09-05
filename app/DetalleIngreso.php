<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table='detalle_ingreso';
    protected $primaryKey='iddetalle_ingreso';
    public $timestamps=false;

    protected $fillable=[
     'idingreso',
     'idarticulo',
     'cantidad',
     'preciocompra',
     'precioventa',

    ];

    protected $guarded=[
    ];

    public function ingreso()
    {
        return $this->belongsTo('sisVentas\Ingreso', 'idingreso');
    }
}
