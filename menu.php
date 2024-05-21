<header data-bs-theme="dark">
		<div class="navbar navbar-dark navbar-expand-lg bg-dark shadow-sm">
			<div class="container">
				<a href="index.php" class="navbar-brand">
					<strong>Magno Games</a></strong>
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
					aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarHeader">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<li clas="nav-item">
							<a href="index.php" class="nav-link active">Todos los juegos</a>
						</li>
					</ul>
					<form action="index.php" method="get" autocomplete="off">
						<div class="input-group pe-3">
							<input type="text" name="q" id="q" class="form-control form-control-sm"
								placeholder="Buscar..." aria-describedby="icon-buscar">
							<button type="submit" class="btn btn-outline-info">
								<img src="images/buscar/lupa.jpg" width="30" height="30">
							</button>
						</div>
					</form>
					<a href="carrito_checkout.php" class="btn btn-primary me-2">
						<img src="images/carrito/carrito.jpg" width="40" height="40"><span id="num_carrito"
							class="badge bg-secondary"><?php echo $num_carrito ?></span>
					</a>
					<?php if (isset($_SESSION['user_id'])) { ?>
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="btn_session">
                        <?php echo $_SESSION['user_name']; ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btn_session">
                            <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                        </ul>
                    </div>
					<?php } else { ?>
						<a href="login.php" class="btn btn-success">Log in</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</header>