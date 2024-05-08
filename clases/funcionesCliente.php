<?php

function esNulo(array $param)
{
    foreach ($param as $parametro) {
        if (strlen(trim($parametro)) < 1) {
            return true;
        }
    }
    return false;
}

function emailValido($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}


function validarPassword($password, $repassword)
{
    if (strcmp($repassword, $password) == 0) {
        return true;
    }

    return false;
}

function usuarioRepetido($usuario, $con)
{
    $query = $con->prepare("SELECT id FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $query->execute([$usuario]);
    if ($query->fetchColumn() > 0) {
        return true;
    }
    return false;
}

function emailRepetido($email, $con)
{
    $query = $con->prepare("SELECT id FROM clientes WHERE email LIKE ? LIMIT 1");
    $query->execute([$email]);
    if ($query->fetchColumn() > 0) {
        return true;
    }
    return false;
}

function mostrarMensajes(array $errores)
{
    if (count($errores) > 0) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert"><ul>';
        foreach ($errores as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';

    }
}

function registrarCliente(array $data, $con)
{
    $query = $con->prepare("INSERT INTO clientes (nombre, apellidos, email, fecha_alta) VALUES(?,?,?,now())");
    if ($query->execute($data)) {
        return $con->lastInsertId();
    }
    return 0;
}

function registrarUsuario(array $data, $con)
{
    $query = $con->prepare("INSERT INTO usuarios (usuario, contrasena, id_cliente) VALUES (?,?,?)");
    $query->execute($data);
}

?>