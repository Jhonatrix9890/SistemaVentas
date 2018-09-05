@extends ('layouts.admin')
@section ('contenido')
<div class="card-header"> <a class="btn btn-primary" href="{{url('ventas/venta')}}" title="Regresar al listado" role="button">
	<i class="fa fa-reply" aria-hidden="true"></i>
</a></div>

            <div class="row">
              <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="form-group">
                    <label for="nombre">Cliente</label>
                    <p>{{$venta->cliente->nombre}}</p>
                </div>
              </div>
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
               <div class="form-group">
                  <label>Tipo de Comprobante</label>
                   <p>{{$venta->tipocomprovante}}</p>
              </div>
            </div>
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                 <div class="form-group">
                    <label for="serieComprobante">Serie del Comprobante</label>
                    <p>{{$venta->seriecomprovante}}</p>
                </div>  
            </div>
               <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                   <div class="form-group">
                      <label for="num_comprobante">Numero del Comprobante</label>
                      <p>{{$venta->numerocomprovante}}</p> 
                    </div>
              </div>
            </div>
            <div class="row">
                  <div class="panel panel-primary">
                    <div class="panel-body">
                      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                         
                              <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                  <thead style="background-color: #A9D0F5">                                   
                                      <th>Articulo</th>
                                      <th>Cantidad</th>
                                      <th>Precio Venta</th>
                                      <th>Descuento</th>
                                      <th>Subtotal</th>
                                </thead>
                                <tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">$/ {{$venta->totalventa}}</h4></th>
                                </tfoot>
                                <tbody>   
                                   @foreach($detalles as $det)   
                                   <tr>
                                      <td>{{$det->articulo}}</td>
                                      <td>{{$det->cantidad}}</td>
                                      <td>{{$det->precioventa}}</td>
                                      <td>{{$det->descuento}}</td>
                                      <td>{{($det->cantidad*$det->precioventa)-$det->descuento}}</td>

                                   </tr>
                                   @endforeach
                                </tbody>
                          </table>
                      </div>
                </div>
            </div>
          </div>               
         
     
  @endsection