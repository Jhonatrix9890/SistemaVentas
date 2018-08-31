@extends ('layouts.admin')
@section ('contenido')
 <div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
   <h3>Nueva Venta</h3>
   @if (count($errors)>0)
   <div class="alert alert-danger">
    <ul>
    @foreach ($errors->all() as $error)
     <li>{{$error}}</li>
    @endforeach
    </ul>
   </div>
   @endif
            </div>
        </div>
   {!!Form::open(array('url'=>'ventas/venta','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
            <div class="row">
             <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="form-group">
             <label for="nombre">Cliente</label>
             <select name="idCliente" id="idCliente" class="form-control selectpicker" data-live-search="true">
              @foreach($personas as $persona)
              <option value="{{$persona->idpersona}}">{{$persona->nombre}}</option>
              @endforeach
              </select>
            </div>
       </div>
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
               <div class="form-group">
               <label>Tipo de Comprobante</label>
               <select name="tipoComprovante" id="tipoComprovante" class="form-control">
               <option value="Boleta">Boleta</option>
               <option value="Factura">Factura</option>
               <option value="Ticket">Ticket</option>
               </select>
            </div>
            </div>
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                 <div class="form-group">
             <label for="serieComproVante">Serie del Comprobante</label>
             <input type="text" name="serieComprovante" id="serieComprovante" value="{{old('serieComprovante')}}" class="form-control" placeholder="Serie del Comprobante..">
            </div>
            </div>
               <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                 <div class="form-group">
              <label for="num_comprobante">Numero del Comprobante</label>
              <input type="text" name="numeroComprovante" id="numeroComprovante" required value="{{old('numeroComprovante')}}" class="form-control" placeholder="Numero del Comprobante..">
            </div>
            </div>
            </div>
            <div class="row">
            <div class="panel panel-primary">
            <div class="panel-body">
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
            <label>Articulo</label>
            <select name="pidArticulo" id="pidArticulo" class="form-control selectpicker" data-live-search="true">
            @foreach($articulos as $articulo)
            <option value="{{$articulo->idarticulo}}_{{$articulo->stock}}_{{$articulo->precioPromedio}}">{{$articulo->articulo}}</option>
            @endforeach
            </select>
            </div>
            </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
            <label for="cantidad">Cantidad</label>
              <input type="number" name="pcantidad" id="pcantidad" class="form-control" placeholder="Cantidad">
              </div>
              </div>
              <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                <div class="form-group">
                <label for="stock">Stock</label>
                  <input type="number" name="pstock" id="pstock"  disabled class="form-control" placeholder="Stock">
                  </div>
                  </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
            <label for="precioVenta">Precio de Venta</label>
             <input type="number" name="pprecioVenta" disabled  id="pprecioVenta" class="form-control" placeholder="P.Venta...">
             </div>
             </div>
             <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
              <div class="form-group">
              <label for="Descuento">Descuento</label>
               <input type="number" name="pdescuento" id="pdescuento" class="form-control" placeholder="Descuento...">
               </div>
               </div>

            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
            <button class="btn btn-primary" type="button" id="bt_add">Agregar</button>
            </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
            <thead style="background-color: #A9D0F5">
            <th>Opciones</th>
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
            <th><h4 id="total">$/ 0.00</h4> <input type="hidden" name="totalVenta" id="totalVenta" ></th>
            </tfoot>
            <tbody>              
            </tbody>
            </table>
            </div>
            </div>
            </div>
            </div>
           <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">         
            <div class="form-group">
            <input name="_token" value="{{ csrf_token() }}" type="hidden"></input>
             <button class="btn btn-primary" type="submit">Guardar</button>
             <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
            </div>
            </div>
   {!!Form::close()!!}  
         @push ('scripts')
         <script>
           $(document).ready(function(){
        $('#bt_add').click(function(){
         agregar();
         });
       });

  var cont=0;
  total=0;
  subtotal=[];
  $("#guardar").hide();
  $("#pidArticulo").change(mostrarValores);

  function mostrarValores(){
    
    datosArticulo=document.getElementById('pidArticulo').value.split('_');
    $("#pprecioVenta").val(datosArticulo[2]);
    $("#pstock").val(datosArticulo[1]);

  }

  function agregar(){
    datosArticulo=document.getElementById('pidArticulo').value.split('_');
   

    idArticulo=datosArticulo[0];
    articulo=$("#pidArticulo option:selected").text();
    cantidad=$("#pcantidad").val();
    descuento=$("#pdescuento").val();
    precioVenta=$("#pprecioVenta").val();
    stock=$("#pstock").val();

    if (idArticulo!="" && cantidad!="" && cantidad>0 && descuento!="" && precioVenta!="")
    {
      if(cantidad>=stock){
        subtotal[cont]=(cantidad*precioVenta)-descuento;
       total=total+subtotal[cont];
       var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idArticulo[]" value="'+idArticulo+'">'+articulo+'</td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input type="number" name="precioVenta[]" value="'+precioVenta+'"></td><td><input type="number" name="descuento[]" value="'+descuento+'"></td><td>'+subtotal[cont]+'</td></tr>';
       cont++;
       limpiar();
       $('#total').html("$/ " + total);
       $('#totalVenta').val(total);
       evaluar();
       $('#detalles').append(fila);


      }
      else{

        alert("Error la cantidad ingresada supera el  stock");
   

      }
       
    }
    else
    {
      alert("Error al ingresar el detalle de la venta, revise los datos del articulo");
    }
  
  }
  function limpiar(){
    $("#pcantidad").val("");
    $("#pdescuento").val("");
    $("#pprecioVenta").val("");
  }

  function evaluar()
  {
    if (total>0)
    {
      $("#guardar").show();
    }
    else
    {
      $("#guardar").hide(); 
    }
   }

   function eliminar(index){
    total=total-subtotal[index]; 
    $("#totalVenta").val(total);   
    $("#fila" + index).remove();
    evaluar();

  }
         </script>
         @endpush
         @endsection﻿