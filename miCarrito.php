
<?php
include 'templates/cabecera.php';
include 'administrador/conexion.php';

// Iniciar la sesión si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario ha iniciado sesión
if (!(isset($_SESSION['usuario']) && $_SESSION['usuario'] == 'ok')) {
    // Redirigir a la página de inicio de sesión si el usuario no ha iniciado sesión
    header('Location: ../../loginCliente.php');
    exit();
}
$objConexion = new Conexion();
// Obtener datos de libros en el carrito del usuario actual
$ID_Usuario = $_SESSION['id'];
$resultado = $objConexion->consultar("SELECT c.ID_Carrito, l.Nombre, l.Descripcion, l.Foto, l.Precio, c.Cantidad
                                     FROM carrito c, libro l
                                     WHERE c.ID_Libro = l.id AND
                                     c.ID_Usuario = $ID_Usuario");


?>

<div class="jumbotron">
    <h1 class="display-3">Mi carrito</h1>
    <hr class="my-2">
    <div class="col-md-7"> 
        <div class="table">
            <?php if (!empty($resultado)) { ?>
                <table class="table table-bordered" style="border-color: #0b0b0bc6;">
                    <thead>
                        <tr>
                            <th scope="col" class="" style="background-color: #ec5779; color: #0b0b0b99;">Nombre</th>
                            <th scope="col" class="" style="background-color: #ec5779; color: #0b0b0b99;">Descripción</th>
                            <th scope="col" class="" style="background-color: #ec5779; color: #0b0b0b99;">Foto</th>
                            <th scope="col" class="" style="background-color: #ec5779; color: #0b0b0b99;">Precio</th>
                            <th scope="col" class="" style="background-color: #ec5779; color: #0b0b0b99;">Cantidad</th>
                            <th scope="col" class="" style="background-color: #ec5779; color: #0b0b0b99;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultado as $libro) { ?>
                            <tr>
                                <td style="background-color: #ffaacd;   color: #0b0b0bc6;"><?php echo $libro['Nombre']; ?></td>
                                <td style="background-color: #ffaacd; color: #0b0b0bc6;"><?php echo $libro['Descripcion']; ?></td>
                                <td style="background-color: #ffaacd; color: #0b0b0bc6;">
                                    <img src="../../imagenes/<?php echo $libro['Foto']; ?>" alt="Foto del libro" style="max-width: 100px;">
                                </td>
                                <td style="background-color: #ffaacd; color: #0b0b0bc6;"><?php echo $libro['Precio']; ?></td>
                                <td style="background-color: #ffaacd; color: #0b0b0bc6;"><?php echo $libro['Cantidad']; ?></td>
                                <td style="background-color: #ffaacd;" class="d-flex justify-content-end">
                                    <button class=" text-white mx-2 rounded">
                                        <a class="text-decoration-none text-reset" href="?borrar=<?php echo $libro['ID_Carrito']; ?>">Borrar</a>
                                    </button>
                                    <button class="rounded text-white ml-2">
                                        <a class="text-decoration-none text-reset" href="administrador/seccion/detalleLibro.php?id=<?php echo $libro['ID_Libro']; ?>">Ver libro</a>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p class="text-center">El carrito está vacío.</p>
            <?php } ?>
        </div>
    </div>
</div>

<?php
include 'templates/footer.php';
?>
