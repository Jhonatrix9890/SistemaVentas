<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\VentaRequest;
use sisVentas\Venta;
use sisVentas\DetalleVenta;
use DB;
use Carbon\Carbon;
use Response;
use  Illuminate\Support\Facades\Collection;

class VentaController extends Controller
{
    
    public function __constructor(){
        $this->middleware('auth');

    }

    public function index(Request $request)
    {

      
         if($request){

            $query =trim($request->get('searchText'));
             $ventas=DB::table('venta as v')
             ->join('persona as p', 'v.idCliente','=','p.idpersona')
             ->join('detalle_venta as dv', 'v.idventa','=','dv.idVenta')
            ->select('v.idventa','v.fechaHora','p.nombre','v.tipoComprovante','v.serieComprovante','v.numeroComprovante','v.impuesto','v.estado','v.totalVenta')
            ->where('p.nombre','LIKE','%'.$query.'%')
            ->orderBy('v.idventa','dec')
            ->groupBy('v.idventa','v.fechaHora','p.nombre','v.tipoComprovante','v.serieComprovante','v.numeroComprovante','v.impuesto','v.estado', 'v.totalVenta')
             ->paginate(7);
             return view('ventas.venta.index',["ventas"=>$ventas, "searchText"=>$query]);
         }
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
            $personas=DB::table('persona')->where('tipoPersona', '=', 'Cliente')->get();
            $articulos=DB::table('articulo as art')
            ->join('detalle_ingreso as de', 'art.idarticulo','=','de.idArticulo')
            ->select(DB::raw('CONCAT(art.codigo, " ", art.nombre) as articulo'),
             'art.idarticulo', 'art.stock', DB::Raw('avg(de.precioVenta) as  precioPromedio' ))
            ->where('art.estado','=','Activo')
            ->where('art.stock','>','0')
            ->groupBy('articulo', 'art.idarticulo','art.stock')
            ->get();
            return view("ventas.venta.create",["personas"=>$personas, "articulos"=>$articulos]);

    }

    public function store (VentaRequest $request)
    {
        try {
            DB::beginTransaction();
            $venta = new Venta;
            $venta->idCliente=$request->get('idCliente');
            $venta->tipoComprovante=$request->get('tipoComprovante');
            $venta->serieComprovante=$request->get('serieComprovante');
            $venta->numeroComprovante=$request->get('numeroComprovante');
            $venta->totalVenta=$request->get('totalVenta');
            
            $mytime = Carbon::now('America/Bogota');
            $venta->fechaHora=$mytime->toDateTimeString();
            $venta->impuesto = '18';
            $venta->estado = 'A';
            $venta->save();

            $idArticulo = $request->get('idArticulo');
            $cantidad = $request->get('cantidad');
            $descuento = $request->get('descuento');
            $precioVenta = $request->get('precioVenta');

            $cont = 0;

            while ($cont<count($idArticulo)) {
                $detalle=new DetalleVenta();
                $detalle->idVenta=$venta->idventa;
                $detalle->idArticulo=$idArticulo[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->descuento=$descuento[$cont];
                $detalle->precioVenta=$precioVenta[$cont];
                $detalle->save();
                $cont=$cont+1;
            }

            DB::commit();
        } catch (Exception $e) 
        {
            DB::rollback();
        }

        return Redirect::to('ventas/venta');
    }

    public function show($id){
        
        $venta=Venta::with('cliente')->findOrFail($id);      
         
        $detalles=DB::table('detalle_venta as d')
        ->join('articulo as a','d.idArticulo','=','a.idarticulo')
        ->select('a.nombre as articulo', 'd.cantidad', 'd.precioVenta',
        'd.descuento')
        ->where('d.idVenta','=',$id)
        ->get();
        return view("ventas.venta.show",compact('venta','detalles'));       
    }

    

    public function destroy($id){

        $venta=Venta::findOrFail($id);
        $venta->estado='C';
        $venta->update();
        return Redirect::to('ventas/venta');
    }
}
