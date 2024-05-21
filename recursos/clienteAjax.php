<?php 

require '../config/database.php';
require '../clases/funcionesCliente.php';

$data = [];

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $db = new Database();   
    $con = $db->conectar();
    
    if ($action == 'existeUsuario') {  
        $data['ok'] = usuarioRepetido($_POST['usuario'],$con);
    }elseif ($action == 'existeEmail') {
        $data['ok'] = emailRepetido($_POST['email'],$con);
    }
}

echo json_encode($data);

?>