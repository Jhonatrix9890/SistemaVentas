<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;
use sisVentas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Ingreso;
use sisVentas\DetalleIngreso;
use sisVentas\Http\Requests\IngresoRequest;
use DB;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Facades\Collection;
use Illuminate\Database\QueryException;


class IngresoController extends Controller
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
             $ingresos=DB::table('ingreso as i')
             ->join('persona as p', 'i.idProveedor','=','p.idpersona')
             ->join('detalle_ingreso as di', 'i.idingreso','=','di.idIngreso')
            ->select('i.idingreso','i.fechaHora','p.nombre','i.tipoComprovante','i.serieComprovante','i.numeroComprovante','i.impuesto','i.estado', DB::raw('sum(di.cantidad*precioCompra) as total'))
            ->where('i.numeroComprovante','LIKE','%'.$query.'%')
            ->orderBy('i.idingreso','dec')
            ->groupBy('i.idingreso','i.fechaHora','p.nombre','i.tipoComprovante','i.serieComprovante','i.numeroComprovante','i.impuesto','i.estado')
             ->paginate(7);
             return view('compras.ingreso.index',["ingresos"=>$ingresos, "searchText"=>$query]);
         }
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
            $personas=DB::table('persona')->where('tipoPersona', '=', 'Proveedor')->get();
            $articulos=DB::table('articulo as art')
            ->select(DB::raw('CONCAT(art.codigo, " ", art.nombre) as articulo'), 'art.idarticulo')
            ->where('art.estado','=','Activo')
            ->get();
            return view("compras.ingreso.create",["personas"=>$personas, "articulos"=>$articulos]);

    }

    public function store (IngresoRequest $request)
    {
        try {
            DB::beginTransaction();
            $ingreso = new Ingreso;
            $ingreso->idProveedor=$request->get('idProveedor');
            $ingreso->tipoComprovante=$request->get('tipoComprovante');
            $ingreso->serieComprovante=$request->get('serieComprovante');
            $ingreso->numeroComprovante=$request->get('numeroComprovante');
            $mytime = Carbon::now('America/Bogota');
            $ingreso->fechaHora=$mytime->toDateTimeString();
            $ingreso->impuesto = '19';
            $ingreso->estado = 'A';
            $ingreso->save();

            $idArticulo = $request->get('idArticulo');
            $cantidad = $request->get('cantidad');
            $precioCompra = $request->get('precioCompra');
            $precioVenta = $request->get('precioVenta');

            $cont = 0;

            while ($cont<count($idArticulo)) {
                $detalle=new DetalleIngreso();
                $detalle->idIngreso=$ingreso->idingreso;
                $detalle->idArticulo=$idArticulo[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->precioCompra=$precioCompra[$cont];
                $detalle->precioVenta=$precioVenta[$cont];
                $detalle->save();
                $cont=$cont+1;
            }

            DB::commit();
        } catch (Exception $e) 
        {
            DB::rollback();
        }

        return Redirect::to('compras/ingreso');
    }

    public function show($id){
        
        $ingreso=Ingreso::with('proveedor')->findOrFail($id);      
       

         $detalles=DB::table('detalle_ingreso as d')
         ->join('articulo as a','d.idArticulo','=','a.idarticulo')
         ->select('a.nombre as articulo', 'd.cantidad', 'd.precioCompra',
         'd.precioVenta')
         ->where('d.idIngreso','=',$id)
         ->get();    
         return view("compras.ingreso.show",compact('ingreso', 'detalles'));  
    }

    

    public function destroy($id){

        $ingreso=Ingreso::findOrFail($id);
        $ingreso->estado='C';
        $ingreso->update();
        return Redirect::to('compras/ingreso');
    }
}
