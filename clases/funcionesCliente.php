<?php

function registrarCliente(array $data, $con){
    $query = $con->prepare("INSERT INTO clientes (nombre, apellidos, email, fecha_alta) VALUES(?,?,?,now())");
    if($query->execute($data)){
        return $con-> lastInsertId();
    }
    return 0;
}

function registrarUsuario(array $data, $con){
    $query = $con->prepare("INSERT INTO usuarios (usuario, contrasena, id_cliente) VALUES (?,?,?)");
    $query->execute($data);
}

?>