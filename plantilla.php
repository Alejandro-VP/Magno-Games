<?php
require 'config/config.php';
require 'config/database.php';
require 'recursos/funcionesCliente.php';

$db = new Database();
$con = $db->conectar();

$errores = [];

if (!empty($_POST)) {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $repassword = trim($_POST['repassword']);

    
}

//session_destroy();

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
    <main>
        <div class="container">
         
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>

    
</body>

</html>