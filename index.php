<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Magno Games</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link href="css/styles.css" rel="stylesheet">
</head>

<body>
	<header data-bs-theme="dark">
		<div class="navbar navbar-dark navbar-expand-lg bg-dark shadow-sm">
			<div class="container">
				<a href="#" class="navbar-brand">
					<strong>Magno Games</strong>
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
						<li>
							<a href="#" class="nav-link">Contacto</a>
						</li>
					</ul>
					<a href="carrito.php" class="btn btn-primary"><img src="images/carrito/carrito.jpg" width="40" height="40"> </a>
				</div>
			</div>
		</div>
	</header>

	<main>
		<div class="container">
			<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
				<div class="col">
					<div class="card shadow-sm">
						<img src="images/juegos/rdr2.jpg">
						<div class="card-body">
							<h5 class="card-title">Red Dead Redemption 2</h5>
							<p class="card-text">59,99€</p>
							<div class="d-flex justify-content-between align-items-center">
								<div class="btn-group">
									<a href="" class="btn btn-primary">Ver detalles</a>

								</div>
								<a href="" class="btn btn-success"><img src="images/carrito/add_carrito.jpg" width="30" height="30"></a>
							</div>
						</div>
					</div>
				</div>
			</div>
	</main>


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
		crossorigin="anonymous"></script>
</body>

</html>