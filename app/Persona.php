<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table='persona';
    protected $primaryKey='idpersona';
    public $timestamps=false;

    protected $fillable=[
     'tipopersona',
     'nombre',
     'tipodocumento',
     'numerodocumento',
     'direccion',
     'telefono',
     'email',

    ];

    protected $guarded=[


    ];
}
