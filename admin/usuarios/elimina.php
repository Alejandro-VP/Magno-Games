<?php

require '../config/database.php';

$db = new Database();
$con = $db->conectar();

$id = $_POST['id'];

$query = $con->prepare('DELETE FROM clientes WHERE id = ?');
$query->execute([$id]);

header('location: index.php');

?>