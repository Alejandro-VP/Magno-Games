<?php
require 'config/config.php';
require 'config/database.php';

$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
$lista_productos = array();


if ($productos != null) {
    foreach ($productos as $key => $cantidad) {
        $query = $con->prepare("SELECT id, nombre, precio, $cantidad AS cantidad FROM productos WHERE id=?");
        $query->execute([$key]);
        $lista_productos[] = $query->fetch(PDO::FETCH_ASSOC);
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
                    <a href="carrito.php" class="btn btn-primary">
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
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($lista_productos == null) {
                            echo '<tr><td colspan="5" class="text-center"><b>Lista vacía</b></td></tr>';
                        } else {
                            $total = 0;
                            foreach ($lista_productos as $producto) {
                                $_id = $producto['id'];
                                $nombre = $producto['nombre'];
                                $precio = $producto['precio'];
                                $cantidad = $producto['cantidad'];
                                $subtotal = $cantidad * $precio;
                                $total += $subtotal;
                                ?>
                                <tr>
                                    <td><?php echo $nombre ?></td>
                                    <td><?php echo $precio . MONEDA ?></td>
                                    <td>
                                        <input type="number" min="1" step="1" value="<?php echo $cantidad ?>" size="4"
                                            id="cantidad_<?php echo $_id; ?>"
                                            onchange="actualizarCantidad(this.value, <?php echo $_id; ?>)">
                                    </td>
                                    <td>
                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                                            <?php echo $subtotal . MONEDA ?>
                                        </div>
                                    </td>
                                    <td><a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id; ?>"
                                            data-bs-toggle="modal" data-bs-target="#eliminaModal">X</a></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">
                                    <h3 id="total"><?php echo $total . MONEDA ?></h3>
                                </td>
                            </tr>
                        </tbody>
                    <?php } ?>
                </table>
            </div>
            <div class="row">
                <div class="col-md-5 offset-md-7 d-grid gap-2">
                    <button class="btn btn-primary btn-lg">Pagar</button>
                </div>
            </div>
        </div>
    </main>
    <!-- VENTANA MODAL -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="eliminaModalLabel">¡ATENCIÓN!</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea eliminar el producto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Sí</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>

    <script>

        let eliminaModal = document.getElementById('eliminaModal');
        eliminaModal.addEventListener('show.bs.modal', function(event){
            let button = event.relatedTarget;
            let id = button.getAttribute('data-bs-id');
            let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
            buttonElimina.value = id;
        });                         


        function actualizarCantidad(cantidad, id) {
            let url = 'recursos/actualizar_carrito.php';
            let formData = new FormData();
            formData.append('id', id);
            formData.append('action', 'agregar');
            formData.append('cantidad', cantidad);

            fetch(url, {
                method: "POST",
                body: formData,
                mode: 'cors'
            }).then(response => response.json()).then(data => {
                if (data.ok) {
                    let divSubtotal = document.getElementById('subtotal_' + id);
                    divSubtotal.innerHTML = data.sub;

                    let total = 0;
                    let list = document.getElementsByName('subtotal[]');

                    for (let i = 0; i < list.length; i++) {
                        total += parseFloat(list[i].innerHTML.replace(/[€,]/g, ''))
                    };
                    total = new Intl.NumberFormat('es-ES', {
                        maximumFractionDigits: 2
                    }).format(total)
                    document.getElementById('total').innerHTML = total + '<?php echo MONEDA ?>';
                }
            });
        }


        function eliminar() {
            let botonElimina= document.getElementById('btn-elimina');
            let id = botonElimina.value;

            let url = 'recursos/actualizar_carrito.php';
            let formData = new FormData();
            formData.append('id', id);
            formData.append('action', 'eliminar');
           

            fetch(url, {
                method: "POST",
                body: formData,
                mode: 'cors'
            }).then(response => response.json()).then(data => {
                if (data.ok) {
                   location.reload();


                }
            });
        }

    </script>
</body>

</html>