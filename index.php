<?php
require 'config/config.php';
require 'config/database.php';

$db = new Database();
$con = $db->conectar();
$query = $con->prepare('SELECT id, nombre, precio FROM productos');
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

//session_destroy();
print_r($_SESSION);
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
	<header data-bs-theme="dark">
		<div class="navbar navbar-dark navbar-expand-lg bg-dark shadow-sm">
			<div class="container">
				<a href="#" class="navbar-brand">
					<strong>Magno Games</a></strong>
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
					aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarHeader">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<li clas="nav-item">
							<a href="#" class="nav-link active">Todos los juegos</a>
						</li>
					</ul>
					<a href="carrito.php" class="btn btn-primary">
						<img src="images/carrito/carrito.jpg" width="40" height="40"><span id="num_carrito"
							class="badge bg-secondary"><?php echo $num_carrito ?></span>
					</a>

				</div>
			</div>
		</div>
	</header>
	<!-- SECCIÓN PRINCIPAL DE LA PÁGINA -->
	<main>
		<div class="container">
			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
				<?php foreach ($result as $row) { ?>
					<div class="col">
						<div class="card shadow-sm">
							<?php

							$id = $row['id'];
							$image = "images/juegos/" . $id . "/principal.jpg";

							if (!file_exists($image)) {
								$image = "images/no-pic/no-pic.jpg";
							}

							?>
							<img src="<?php echo $image ?>" height="550px">
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
				<?php } ?>
			</div>
	</main>


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
		</script>

	<script>
		function addProducto(id, token) {
			let url = 'clases/carrito.php';
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

	</script>
</body>

</html>