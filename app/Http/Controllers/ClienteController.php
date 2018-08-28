<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use sisVentas\Persona;
use sisVentas\Http\Requests;
use sisVentas\Http\Requests\PersonaRequest;
use Illuminate\Support\Facades\Redirect;
use DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __constructor(){


    }

    public function index(Request $request)
    {

      
         if($request){

            $query =trim($request->get('searchText'));
             $personas=DB::table('persona')
             ->where('nombre','LIKE','%'.$query.'%')
             ->where('tipoPersona','=','Cliente')
             ->orwhere('numeroDocumento','LIKE','%'.$query.'%')
             ->where('tipoPersona','=','Cliente')
             ->orderBy('idpersona','dec')
             ->paginate(7);
             return view('ventas.cliente.index',["personas"=>$personas, "searchText"=>$query]);
         }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            return view("ventas.cliente.create");

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonaRequest $request)
    {
        $persona=new Persona;
        $persona->tipoPersona=$request->get('Cliente');
        $persona->nombre=$request->get('nombre');
        $persona->tipoDocumento=$request->get('tipoDocumento');
        $persona->numeroDocumento=$request->get('numeroDocumento');
        $persona->direccion=$request->get('direccion');
        $persona->email=$request->get('email');
        $persona->save();
        return Redirect::to('ventas/cliente');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("ventas.cliente.show",["persona"=>Persona::findOrFail($id)]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $persona=Persona::findOrFail($id);
       return view("ventas.cliente.edit",compact('persona'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PersonaRequest $request, $id)
    {
        $persona=Persona::findOrFail($id);
        $persona->nombre=$request->get('nombre');
        $persona->tipoDocumento=$request->get('tipoDocumento');
        $persona->numeroDocumento=$request->get('numeroDocumento');
        $persona->direccion=$request->get('direccion');
        $persona->email=$request->get('email');
        $persona->update();
        return Redirect::to('ventas/cliente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $persona=Persona::findOrFail($id);
        $persona->tipoPersona='Inactivo';
        $persona->update();
        return Redirect::to('ventas/persona');
    }
}
