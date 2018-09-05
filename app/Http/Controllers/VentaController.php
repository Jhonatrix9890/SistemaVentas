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
             ->join('persona as p', 'v.idcliente','=','p.idpersona')
             ->join('detalle_venta as dv', 'v.idventa','=','dv.idventa')
            ->select('v.idventa','v.fechahora','p.nombre','v.tipocomprovante','v.seriecomprovante','v.numerocomprovante','v.impuesto','v.estado','v.totalventa')
            ->where('p.nombre','LIKE','%'.$query.'%')
            ->orderBy('v.idventa','dec')
            ->groupBy('v.idventa','v.fechahora','p.nombre','v.tipocomprovante','v.seriecomprovante','v.numerocomprovante','v.impuesto','v.estado', 'v.totalventa')
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
            $personas=DB::table('persona')->where('tipopersona', '=', 'Cliente')->get();
            $articulos=DB::table('articulo as art')
            ->join('detalle_ingreso as de', 'art.idarticulo','=','de.idarticulo')
            ->select(DB::raw('art.nombre as articulo'),
             'art.idarticulo', 'art.stock', DB::Raw('avg(de.precioventa) as  preciopromedio' ))
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
            $venta->idcliente=$request->get('idcliente');
            $venta->tipocomprovante=$request->get('tipocomprovante');
            $venta->seriecomprovante=$request->get('seriecomprovante');
            $venta->numerocomprovante=$request->get('numerocomprovante');
            $venta->totalventa=$request->get('totalventa');
            
            $mytime = Carbon::now('America/Bogota');
            $venta->fechahora=$mytime->toDateTimeString();
            $venta->impuesto = '18';
            $venta->estado = 'A';
            $venta->save();

            $idarticulo = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $descuento = $request->get('descuento');
            $precioventa = $request->get('precioventa');

            $cont = 0;

            while ($cont<count($idarticulo)) {
                $detalle=new DetalleVenta();
                $detalle->idventa=$venta->idventa;
                $detalle->idarticulo=$idarticulo[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->descuento=$descuento[$cont];
                $detalle->precioventa=$precioventa[$cont];
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
        ->join('articulo as a','d.idarticulo','=','a.idarticulo')
        ->select('a.nombre as articulo', 'd.cantidad', 'd.precioventa',
        'd.descuento')
        ->where('d.idventa','=',$id)
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
