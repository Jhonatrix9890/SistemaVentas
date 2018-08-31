@extends ('layouts.admin')
@section ('contenido')

                <input type="hidden" name"nombre_de_campo" value="                {{$total=0}}   
                @foreach($ingreso->detalles as $det)

                {{$total=$total+($det->cantidad*$det->precioCompra)}}

                @endforeach" />
            
            <div class="row">
              <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="form-group">
                    <label for="nombre">Proveedor</label>
                    <p>{{$ingreso->proveedor->nombre}}</p>
                </div>
              </div>
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
               <div class="form-group">
                  <label>Tipo de Comprobante</label>
                   <p>{{$ingreso->tipoComprovante}}</p>
              </div>
            </div>
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                 <div class="form-group">
                    <label for="serieComprobante">Serie del Comprobante</label>
                    <p>{{$ingreso->serieComprovante}}</p>
                </div>  
            </div>
               <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                   <div class="form-group">
                      <label for="num_comprobante">Numero del Comprobante</label>
                      <p>{{$ingreso->numeroComprovante}}</p> 
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
                                      <th>Precio Compra</th>
                                      <th>Precio Venta</th>
                                      <th>Subtotal</th>
                                </thead>
                                <tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">$/ {{$total}}</h4></th>
                                </tfoot>
                                <tbody>   
                                   @foreach($detalles as $det)   
                                   <tr>
                                      <td>{{$det->articulo}}</td>
                                      <td>{{$det->cantidad}}</td>
                                      <td>{{$det->precioCompra}}</td>
                                      <td>{{$det->precioVenta}}</td>
                                      <td>{{$det->cantidad*$det->precioCompra}}</td>

                                   </tr>
                                   @endforeach
                                </tbody>
                          </table>
                      </div>
                </div>
            </div>
          </div>               
         
     
  @endsection