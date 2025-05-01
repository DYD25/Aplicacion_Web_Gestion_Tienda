	<!DOCTYPE html>
	<html lang="es">

	<head>

		<meta charset="utf-8">

		<title> Formulario de Acceso </title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">


		<link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">


		<link rel="stylesheet" href="css/login.css">

		<style type="text/css">

		</style>

		<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
		<script type = "text/javascript" src = "js/scrip.js" >	</script>
	

	</head>

	<body>
		<div id="contenedor">
			<div id="contenedorcentrado">
				<div id="login">
					<form id="loginform" method="post">
						<label for="usuario"> Usuario</label>
						<input id="usuario" type="text" name="usuario" placeholder="Usuario" required>

						<label for="password">Contraseña</label>
						<input id="contrasena" type="password" placeholder="Contraseña" name="contrasena" required>

						<label id="erro"></label>
						<button title="Ingresar" id="ingresar" name="ingresar">Ingresar</button>
					</form>
				</div>
				<div id="derecho">
					<div class="titulo">
						Bienvenido
					</div>
					<hr>

				</div>
			</div>
		</div>

		</div>
	</body>

	</html>


	<script type="text/javascript">
		$("#ingresar").click(function() {
			event.preventDefault();
			var parametros = $("#loginform").serialize();

			$.post("?modulo=sesion-verificar", parametros, function(respuesta) {
				var r = jQuery.parseJSON(respuesta);

				if (r.error == true) {
					$("#erro").text("Por favor verificar el usuario y la contraseña").css("color", "red");
				} else {

					window.location = "?modulo=tienda";

					$("#loginform").get(0).reset();
				}
			});
		});
	</script>