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

    public function store(IngresoRequest $request)
    {
        try{
            DB::beginTransaction();
            $ingreso=new Ingreso;
            $ingreso->idProveedor=$request->get('idProveedor');
            $ingreso->tipoComprovante=$request->get('tipoComprovante');
            $ingreso->serieComprovante=$request->get('serieComprovante');
            $ingreso->numeroComprovante=$request->get('numeroComprovante');
            $mytime= Carbono::now('America/Guayaquil');
            $ingreso->fechaHora=$mytime->toDateTimeString();
            $ingresos->impuesto='12';
            $ingreso->estado='A';
            $ingreso->save();

           $idArticulo=$request->get('idArticulo');
           $cantidad=$request->get('cantidad');
           $precioCompra=$request->get('precioCompra');
           $precioVneta=$request->get('precioVenta');
           
           $cont=0;
           while($con5 < count($idArticulo)){
                $detalle = new DetalleIngreso();
                $detalle->ingreso=$ingreso->idingreso;
                $detalle->idArticulo=$idArticulo[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->precioCompra=$precioCompra[$cont];
                $detalle->precioVenta=$precioVenta[$cont];
                $detalle->save();
                 $cont=$cont+1;
           }
           DB::commit();
           return redirect('compras/ingreso');
        }
        catch(\Exception $e){

            DB::rollBACK();
        }
        
    }
    public function show($id){
        $ingreso=DB::table('ingreso as i')
            ->join('personas as p', 'i.idProveedor','=','p.idpersona')
            ->join('detalle_ingreso as di', 'i.idingreso','=','di.idIngreso')
             ->select('i.idingreso','i.fechaHora','p.nombre','i.tipoComprovante','i.serieComprovante','i.numeroComprovante','i.impuesto','i.estado', DB::raw('sum(di.cantidad*precioCompra) as total'))
            ->where('i.idingreso','=',$id)
            ->firtsOrFail();
        $detalle=DB::table('detalle_ingreso ad d')
            ->join('articulo as a','d.idArticulo','=','a.idarticulo')
            ->select('a.nombre as articulo', 'd.cantidad','d.precioCompra','d.precioVenta')
            ->where('d.idIngreso','=',$id)->get();
        return view("compras.ingreso.show",["ingreso"=>$ingreso,'detalle'=>$detalle]);
    }

    public function destroy($id){

        $ingreso=Ingreso::findOrFail($id);
        $ingreso->estado='C';
        $ingreso->update();
        return Redirect::to('compras/ingreso');
    }
}
