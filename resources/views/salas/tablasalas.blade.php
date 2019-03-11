@section('ventana_emergente')
	<input type="button" id="activarRegistro" value="Mostrar" name="mostrar">
<div class="oscurecer" id="oscurecer">
			
	</div>
	<div class="registrar" id="registrar">
		<div class="cerrarRegistro" id="cerrarRegistro">
			x
		</div>
		<h1>Registro</h1>
		<form action="" method="get" accept-charset="utf-8">
			<input type="text" name="nombre" placeholder="Nombre...">
			<input type="text" name="apellido_pat" placeholder="Apellido Paterno...">
			<input type="text" name="apellido_mat" placeholder="Apellido Materno...">
			<input type="date" name="fecha_nac">
			<input type="text" name="email" placeholder="Correo...">
			<input type="text" name="pass" placeholder="Contraseña...">
			<input type="button" value="Registrar" name="crear">
		</form>
	</div>

@endsection