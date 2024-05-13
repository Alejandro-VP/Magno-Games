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

function validarPassword($password, $repassword)
{
    if (strcmp($repassword, $password) == 0) {
        return true;
    }

    return false;
}

function usuarioRepetido($usuario, $con)
{
    $query = $con->prepare("SELECT id FROM admin WHERE usuario LIKE ? LIMIT 1");
    $query->execute([$usuario]);
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

function login($usuario, $password, $con)
{
    $query = $con->prepare("SELECT id, usuario, contrasena, nombre FROM admin WHERE usuario LIKE ?");
    $query->execute([$usuario]);
    if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        if (password_verify($password, $row['contrasena'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['nombre'];
            $_SESSION['user_type'] = 'admin';
            header('location: inicio.php');
        } else {
            return 'La contraseña es incorrecta.';
        }
    }else{
        return 'El usuario y/o la contraseña son incorrectos.';
        
    }
}
?>