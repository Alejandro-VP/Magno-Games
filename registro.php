<?php
require 'config/config.php';
require 'config/database.php';
require 'clases/funcionesCliente.php';

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

    if (esNulo([$nombre, $apellidos, $email, $usuario, $password, $repassword])) {
        $errores[] = "Debe llenar todos los campos. ";
    }

    if (!emailValido($email)) {
        $errores[] = "La dirección de correo no es válida.";
    }

    if (!validarPassword($password, $repassword)) {
        $errores[] = "Las contraseñas no coinciden";
    }

    if (usuarioRepetido($usuario, $con)) {
        $errores[] = "El nombre de usuario $usuario ya existe";
    }
    if (emailRepetido($email, $con)) {
        $errores[] = "El email $email ya existe";
    }

    if (count($errores) == 0) {
        $id = registrarCliente([$nombre, $apellidos, $email], $con);
        if ($id > 0) {
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            if (!registrarUsuario([$usuario, $pass_hash, $id], $con)) {
                $errores[] = 'Error al registrar el usuario';
            }
            ;
        } else {
            $errores[] = 'Error al registrar el cliente';
        }
    }
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
            <h2>Datos del cliente</h2>
            <?php mostrarMensajes($errores); ?>
            <form class="row g-3" action="registro.php" method="post" autocomplete="off">
                <div class="col-6">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="col-6">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" required>
                </div>
                <div class="col-6">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <span id="validaEmail" class="text-danger"></span>
                </div>
                <div class="col-6">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" required>
                    <span id="validaUsuario" class="text-danger"></span>
                </div>
                <div class="col-6">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="col-6">
                    <label for="repassword">Repetir contraseña</label>
                    <input type="password" name="repassword" id="repassword" class="form-control" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </div>
            </form>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>

    <script>

        let txtUsuario = document.getElementById('usuario');
        txtUsuario.addEventListener("blur", function () {
            existeUsuario(txtUsuario.value);
        }, false);

        let txtEmail = document.getElementById('email');
        txtUsuatxtEmailrio.addEventListener("blur", function () {
            existeEmail(txtEmail.value);
        }, false);

        function existeUsuario(usuario) {
            let url = "clases/clienteAjax.php"
            let formData = new FormData()
            formData.append("action", "existeUsuario");
            formData.append("usuario", usuario);

            fetch(url, {
                method: 'POST',
                body: formData
            }).then(response => response.json())
                .then(data => {

                    if (data.ok) {
                        document.getElementById('usuario').value = '';
                        document.getElementById('validaUsuario').innerHTML = 'Usuario no disponible';
                    } else {
                        document.getElementById('validaUsuario').innerHTML = '';

                    }
                })
        }

        function existeEmail(email) {
            let url = "clases/clienteAjax.php"
            let formData = new FormData()
            formData.append("action", "existeEmail");
            formData.append("email", email);

            fetch(url, {
                method: 'POST',
                body: formData
            }).then(response => response.json())
                .then(data => {

                    if (data.ok) {
                        document.getElementById('email').value = '';
                        document.getElementById('validaEmail').innerHTML = 'Email no disponible';
                    } else {
                        document.getElementById('validaEmail').innerHTML = '';

                    }
                })
        }


    </script>
</body>

</html>