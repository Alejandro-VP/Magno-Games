<?php

define("KEY_TOKEN", "Alejandro-17");
define("MONEDA", "€");

session_start();

$num_carrito = 0;

if (isset($_SESSION['carrito']['productos'])){
    $num_carrito = count($_SESSION['carrito']['productos']);
}

?>