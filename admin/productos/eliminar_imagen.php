<?php 

//equivale a un if(isset)
$urlImagen = $_POST['urlImagen'] ?? '';

if($urlImagen !== '' && file_exists($urlImagen)){
    unlink($urlImagen);
}


?>