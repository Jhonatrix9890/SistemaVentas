@extends ('layouts.admin')
@section ('contenido')
<div class="card-header"> <a class="btn btn-primary" href="{{url('almacen/articulo')}}" title="Regresar al listado" role="button">
	<i class="fa fa-reply" aria-hidden="true"></i>
</a></div>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Artículo</h3>
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

	{!! Form::open(['url' => 'almacen/articulo','files'=>'true']) !!}
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						<label for="nombre">Nombre</label>
						<input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre...">
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="form-group">
						<label >Categoria</label>
						<select name="idcategoria" class="form-control">
								@foreach ($categorias as $cat)
								<option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
							 @endforeach
						</select>	
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
								<label for="codigo">Código del artículo</label>
								<input type="text" name="codigo" value="{{old('codigo')}}" class="form-control" placeholder="Codigo...">
						</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
								<label for="stock">Stock</label>
								<input type="number" name="stock" required  value="{{old('stock')}}" class="form-control" placeholder="Stock...">
						</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
								<label for="descripcion">Descripción</label>
								<input type="text" name="descripcion"  value="{{old('descripcion')}}" class="form-control" placeholder="Descripción...">
						</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
								<label for="imagen">Imagen</label>
								<input type="file" name="imagen"  class="form-control" id="imagen" >
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