<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table='persona';
    protected $primaryKey='idpersona';
    public $timestamps=false;

    protected $fillable=[
     'tipoPersona',
     'nombre',
     'tipoDocumento',
     'numeroDocumento',
     'direccion',
     'telefono',
     'email',

    ];

    protected $guarded=[


    ];
}
