<?php
require 'config/config.php';
require 'config/database.php';

$orden = $_GET['orden'] ?? '';
$buscar = $_GET['q'] ?? '';
$filtro = '';



$ordenes = [
	'asc' => 'nombre ASC',
	'desc' => 'nombre DESC',
	'precio_alto' => 'precio DESC',
	'precio_bajo' => 'precio ASC',
];

$order = $ordenes[$orden] ?? '';

if (!empty($order)) {
	$order = " ORDER BY $order";
}

if ($buscar != '') {
	$filtro = " WHERE (nombre LIKE '%$buscar%' || descripcion LIKE '%$buscar%')";
}

$db = new Database();
$con = $db->conectar();
$query = $con->prepare("SELECT id, nombre, precio FROM productos $filtro $order");
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);


?>



<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Magno Games</title>
	<!-- BOOTSTRAP Y CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link href="css/styles.css" rel="stylesheet">
</head>

<body>
	<!-- BARRA DE NAVEGACIÓN -->
	<?php include 'menu.php' ?>
	<!-- SECCIÓN PRINCIPAL DE LA PÁGINA -->
	<main>
		<div class="col-12 col-md-9">
			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 justify-content-end g-4">
				<div class="col mt-5 mb-2">
					<form action="index.php" id="ordenForm" method="get">
						<select name="orden" id="orden" class="form-select form-select-sm" onchange="submitForm()">
							<option value="">Ordenar por</option>
							<option value="precio_alto" <?php echo ($orden === 'precio_alto') ? 'selected' : ''; ?>>Precio
								más alto</option>
							<option value="precio_bajo" <?php echo ($orden === 'precio_bajo') ? 'selected' : ''; ?>>Precio
								más bajo</option>
							<option value="asc" <?php echo ($orden === 'asc') ? 'selected' : ''; ?>>Nombre A-Z</option>
							<option value="desc" <?php echo ($orden === 'desc') ? 'selected' : ''; ?>>Nombre Z-A</option>
						</select>
					</form>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 mx-auto">
				<?php foreach ($result as $row) { ?>
					<div class="col col-lg-4 col-md-6 col-sm-12 col-xs-12 mb-2 d-flex">
						<div class="card shadow-sm" style="width: 370px;">
							<?php

							$id = $row['id'];
							?>
							<a href="details.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>"
								<?php $image = "images/juegos/" . $id . "/principal.jpg"; ?> </a>
								<?php
								if (!file_exists($image)) {
									$image = "images/no-pic/no-pic.jpg";
								}
								?>

								<img class="img_juego card-img-top" src="<?php echo $image ?>" height="550px" width="370px">
								<div class="card-body">

									<h5 class="card-title"><?php echo $row['nombre'] ?></h5>
									<p class="card-text"><?php echo $row['precio'] ?>€</p>
									<div class="d-flex justify-content-between align-items-center">
										<div class="btn-group">
											<a href="details.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>"
												class="btn btn-primary">Ver detalles</a>

										</div>
										<button class="btn btn-outline-success" type="button"
											onclick="addProducto(<?php echo $row['id']; ?>, '<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')"><img
												src="images/carrito/add_carrito.jpg" width="30" height="30">
										</button>

									</div>

								</div>

						</div>

					</div>
					<!-- aqui va el cierre de php -->
				<?php } ?>
			</div>
	</main>


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
		</script>

	<script>
		function addProducto(id, token) {
			let url = 'recursos/carrito.php';
			let formData = new FormData();
			formData.append('id', id);
			formData.append('token', token);

			fetch(url, {
				method: "POST",
				body: formData,
				mode: 'cors'
			}).then(response => response.json()).then(data => {
				if (data.ok) {
					let elemento = document.getElementById("num_carrito");
					elemento.innerHTML = data.numero;
				}
			});
		}

		function submitForm() {
			document.getElementById('ordenForm').submit();
		}
	</script>
</body>

</html>