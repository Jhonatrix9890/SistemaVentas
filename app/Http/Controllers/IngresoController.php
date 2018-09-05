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


    public function __constructor(){


    }

    public function index(Request $request)
    {

      
         if($request){

            $query =trim($request->get('searchText'));
             $ingresos=DB::table('ingreso as i')
             ->join('persona as p', 'i.idproveedor','=','p.idpersona')
             ->join('detalle_ingreso as di', 'i.idingreso','=','di.idingreso')
            ->select('i.idingreso','i.fechahora','p.nombre','i.tipocomprovante','i.seriecomprovante','i.numerocomprovante','i.impuesto','i.estado', DB::raw('sum(di.cantidad*preciocompra) as total'))
            ->where('i.numerocomprovante','LIKE','%'.$query.'%')
            ->orderBy('i.idingreso','dec')
            ->groupBy('i.idingreso','i.fechahora','p.nombre','i.tipocomprovante','i.seriecomprovante','i.numerocomprovante','i.impuesto','i.estado')
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
            $personas=DB::table('persona')->where('tipopersona', '=', 'Proveedor')->get();
            $articulos=DB::table('articulo as art')
            ->select(DB::raw('art.nombre as articulo'), 'art.idarticulo')
            ->where('art.estado','=','Activo')
            ->get();
            return view("compras.ingreso.create",["personas"=>$personas, "articulos"=>$articulos]);

    }

    public function store (IngresoRequest $request)
    {
        try {
            DB::beginTransaction();
            $ingreso = new Ingreso;
            $ingreso->idproveedor=$request->get('idproveedor');
            $ingreso->tipocomprovante=$request->get('tipocomprovante');
            $ingreso->seriecomprovante=$request->get('seriecomprovante');
            $ingreso->numerocomprovante=$request->get('numerocomprovante');
            $mytime = Carbon::now('America/Bogota');
            $ingreso->fechahora=$mytime->toDateTimeString();
            $ingreso->impuesto = '19';
            $ingreso->estado = 'A';
            $ingreso->save();

            $idarticulo = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $preciocompra = $request->get('preciocompra');
            $precioventa = $request->get('precioventa');

            $cont = 0;

            while ($cont<count($idarticulo)) {
                $detalle=new DetalleIngreso();
                $detalle->idingreso=$ingreso->idingreso;
                $detalle->idarticulo=$idarticulo[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->preciocompra=$preciocompra[$cont];
                $detalle->precioventa=$precioventa[$cont];
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
         ->join('articulo as a','d.idarticulo','=','a.idarticulo')
         ->select('a.nombre as articulo', 'd.cantidad', 'd.preciocompra',
         'd.precioventa')
         ->where('d.idingreso','=',$id)
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
