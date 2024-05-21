<?php
require '../config/config.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $token = $_POST['token'];

    $token_temp = hash_hmac('sha1', $id, KEY_TOKEN);

    if ($token == $token_temp) {

        if (isset($_SESSION['carrito']['productos'][$id])) {
            $_SESSION['carrito']['productos'][$id] += 1;
        } else {
            $_SESSION['carrito']['productos'][$id] = 1;
        }

        $data['numero'] = count($_SESSION['carrito']['productos']);
        $data['ok'] = true;
    } else {
        $data['ok'] = false;
    }


} else {
    $data['ok'] = false;
}

echo json_encode($data);

?>