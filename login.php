<?php
require 'config/config.php';
require 'config/database.php';
require 'clases/funcionesCliente.php';

$db = new Database();
$con = $db->conectar();

$errores = [];

if (!empty($_POST)) {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
   
    if(esNulo([$usuario, $password])) {
        $errores [] = 'Debes introducir tu usuario y contraseña';
    }
    if (count($errores) == 0) {
        $errores[] = login($usuario, $password, $con);
    }
}

//session_destroy();
//print_r($_SESSION);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Magno Games</title>
    <!-- BOOTSTRAP Y CSS -->
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- BARRA DE NAVEGACIÓN -->
    <header data-bs-theme="dark">
        <div class="navbar navbar-dark navbar-expand bg-dark shadow-sm">
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
                    <a href="carrito_checkout.php" class="btn btn-primary">
                        <img src="images/carrito/carrito.jpg" width="40" height="40"><span id="num_carrito"
                            class="badge bg-secondary"><?php echo $num_carrito ?></span>
                    </a>

                </div>
            </div>
        </div>
    </header>
    <!-- SECCIÓN PRINCIPAL DE LA PÁGINA -->
    <main class="form-login m-auto pt-4">
        <h2>Iniciar sesión</h2>
        <?php echo mostrarMensajes($errores)?>
        <form class="row g-3" action="login.php" method="post" autocomplete="off">

            <div class="form-floating">
                <input class="form-control" type="text" name="usuario" id="usuario" placeholder="Usuario">
                <label for="usuario">Usuario</label>
            </div>
            <div class="form-floating">
                <input class="form-control" type="password" name="password" id="password" placeholder="Contraseña">
                <label for="usuario">Contraseña</label>
            </div>
            <div class="d-grid gap-3 col-12">
                <button type="submit" class="btn btn-primary">Entrar</button>
            </div>
            <hr>
            <div class="col-12">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></div>
        </form>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>


</body>

</html>