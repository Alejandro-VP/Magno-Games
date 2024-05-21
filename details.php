<?php
require 'config/config.php';
require 'config/database.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';
$db = new Database();
$con = $db->conectar();

if ($id == '' || $token == '') {
    echo 'Error en la petición';
    exit;
}else{

    $token_temp = hash_hmac('sha1', $id, KEY_TOKEN);

    if($token == $token_temp){
        $query = $con->prepare('SELECT count(id) FROM productos WHERE id=?');
        $query->execute([$id]);
        if($query->fetchColumn() > 0){
            $query = $con->prepare('SELECT nombre, descripcion, precio FROM productos WHERE id=?');
            $query->execute([$id]);
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $precio = $row['precio'];
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
        }
    }else{
        echo 'Error en la petición, el token no coincide';
        exit;
    }

}

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
	<?php include 'menu.php' ?>
<!-- SECCIÓN PRINCIPAL DE LA PÁGINA -->
	<main>
		<div class="container">
			<div class="row pt-4">
                <div class="col-sm-6 col-xs-12 order-md-1">
                <?php $image = "images/juegos/". $id . "/principal.jpg"; ?>
                <img src="<?php echo $image?>"  height="550px" width="400px">
                </div>
                
                <div class="col-sm-6 order-md-2">
                    <h2><?php echo $nombre ?></h2>
                    <h2><?php echo $precio . MONEDA; ?></h2>
                    <p class="lead pt-2" >
                        <?php echo $descripcion?>
                    </p>
                    <div class="d-grid gap-3 col-10 mx-auto">
                        <button class="btn btn-primary" type="button">Comprar ahora</button>
                        <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_temp; ?>')">Añadir al carrito</button>
                    </div>
                </div>
            </div>
		</div>
	</main>


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
		crossorigin="anonymous"></script>

    <script>
        function addProducto(id, token){
            let url = 'recursos/carrito.php';
            let formData = new FormData();
            formData.append('id', id);
            formData.append('token', token);

            fetch(url, {
                method: "POST",
                body:formData,
                mode: 'cors'
            }).then(response => response.json()).then(data => {
                if(data.ok){
                    let elemento = document.getElementById("num_carrito");
                    elemento.innerHTML = data.numero;
                }
            });
        }

    </script>



</body>

</html>