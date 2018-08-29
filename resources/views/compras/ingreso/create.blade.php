@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Ingreso</h3>
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

	{!! Form::open(['url' => 'compras/ingreso']) !!}
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<label for="proveedor">Proveedor</label>
						<select name="idProveedor" id="idProveedor" class="form-control selectpicker" data-live-search="true">
							@foreach($personas as $per)
							<option value="{{$per->idpersona}}">{{$per->nombre}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<label for="tipoComprovante">Tipo de Comprobante</label>
						<select name="tipoComprovante" class="form-control">
							<option value="BOLETA">BOLETA</option>
							<option value="FACTURA">FACTURA</option>
							<option value="TICKET">TICKET</option>
						</select>	
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="form-group">
								<label for="serieComprovante">Serie del Comprobante</label>
								<input type="text" name="serieComprovante" value="{{old('serieComprovante')}}" class="form-control" placeholder="Serie de comprobante...">
						</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
							<label for="numeroComprovante">Número del Comprobante</label>
							<input type="text" name="numeroComprovante" value="{{old('numeroComprovante')}}" class="form-control" placeholder="Número de comprobante...">
					</div>
				</div>

			</div>
			<div class="row">
				<div class="panel panel-primary">
					<div class="panel-body">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
							<div class="form-group">
								<label for="articulo">Artículos</label>
								<select name="idAerticulo" id="idArticulo" class="form-control selectpicker" data-live-search="true">
								@foreach($articulos as $ar)
								<option value="{{$ar->idarticulo}}">{{$ar->articulo}}</option>
								@endforeach
			      				</select>
							</div>
						</div>			
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						<div class="form-group">
								<label for="cantidad">Cantidad</label>
								<input type="number" id="pcantidad" name="pcantidad" value="{{old('pcantidad')}}" class="form-control" placeholder="Cantidad...">
						</div>
				</div>
		
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						<div class="form-group">
								<label for="precioCompra">Precio de compra</label>
								<input type="number" id="pprecioCompra" name="pprecioCompra" value="{{old('pprecioCompra')}}" class="form-control" placeholder="Precio de compra...">
						</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						<div class="form-group">
								<label for="precioVenta">Precio de venta</label>
								<input type="numbre" id="pprecioVenta" name="pprecioVenta" value="{{old('pprecioVenta')}}" class="form-control" placeholder="Precio de venta...">
						</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
						<div class="form-group">
								<label for="precioVenta"></label>
								<button class="btn btn-primary" type="submit">Agregar al Detalle</button>
						</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<table  id="detalles" class="table table-striped table-bordered table-condensed table-hover">
							<thead style="background-color:#A9D0F5">
								<th>Opciones</th>
								<th>Artículo</th>
								<th>Cantidad</th>
								<th>Precio Compra</th>
								<th>Precio Venta</th>
								<th>Subtotal</th>
							</thead>
							<tfoot>
								<th>Total</th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th><h4 id="total">S/. 0.00</h4></th>	
							</tfoot>
							<tbody>

							</tbody>

						</table>
				</div>
			</div>
		</div>				
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<input name="_token" value="{{csrf_token()}}" type="hidden"></input>
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
		</div>
	</div>

			{!!Form::close()!!}		
            
		
@endsection