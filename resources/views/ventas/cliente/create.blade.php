@extends ('layouts.admin')
@section ('contenido')
<div class="card-header"> <a class="btn btn-primary" href="{{url('ventas/cliente')}}" title="Regresar al listado" role="button">
	<i class="fa fa-reply" aria-hidden="true"></i>
</a></div>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Cliente</h3>
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

	{!! Form::open(['url' => 'ventas/cliente']) !!}
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						<label for="nombre">Nombre</label>
						<input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre...">
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						<label for="direccion">Direccion</label>
						<input type="text" name="direccion" value="{{old('direccion')}}" class="form-control" placeholder="Dirección...">
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						<label for="tipodocumento">Documento</label>
						<select name="tipodocumento" class="form-control">
							<option value="CEDULA">CEDULA</option>
							<option value="RUC">RUC</option>
							<option value="PASAPORTE">PASAPORTE</option>
						</select>	
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
								<label for="numerodocumento">Número de documento</label>
								<input type="text" name="numerodocumento" value="{{old('numerodocumento')}}" class="form-control" placeholder="Número de Documento...">
						</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
								<label for="telefono">Teléfono</label>
								<input type="text" name="telefono"  value="{{old('telefono')}}" class="form-control" placeholder="Telefono...">
						</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
								<label for="email">É-mail</label>
								<input type="email" name="email"  value="{{old('email')}}" class="form-control" placeholder="É-mail...">
						</div>
				</div>
			
			
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						<button class="btn btn-primary" type="submit">Guardar</button>
						<button class="btn btn-danger" type="reset">Cancelar</button>
					</div>
				</div>
			</div>

			{!!Form::close()!!}		
            
		
@endsection