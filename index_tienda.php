<!DOCTYPE html>
<html lang="en">

<head>
	<title>Tienda</title>
	<meta charset="UTF-8">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link rel="stylesheet" href="css/estilo.css">
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/scrip.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
	
	<div class="container">
		<div class="cabeza" center>
			<?php // Contenido de la cabecera 
			require_once("encabezado.php");
			?>
		</div>
	<div class="main">

			<div class="pmenu">
				<?php // Contenido del menú 
				require_once("menu.php");
				?>
			</div>
		
			<div class="cuerpo">
				<div class="esnu">
					<div class="estoy" id="estoy"></div>
					<div>
						<div class="alert success" id="bien">

						</div>
						<div class="alert danger" id="mal">

						</div>
						<div class="alert warning" id="adve">

						</div>
					</div>
					<div class="nuevo" id="nuevo">

					</div>
				</div>

				<hr>
				<?php // Contenido del cuerpo 
				require_once($archivo);
				?>
				<hr>
				<div class="acciones" id="acciones">

				</div>
			</div>
		
			
		</div>
	</div>

</body>

</html>