
<?php include '../templates/header.php' ?>
<?php include("../conexion.php");?>
<?php
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

// Verificar si el usuario es administrador
if ($_SESSION['nombreUsuario'] != 'administrador' ) {
    // Si el usuario no es administrador, redirigir a otra página o realizar acciones específicas
    header('Location: ../../productos.php');
    exit();
}



$objConexion = new Conexion();
$mensaje = '';
    
$objConexion = new Conexion();

// Insertar un nuevo libro
if ($_POST) {
    $stock = $_POST['txtStock'];
    $nombre = $_POST['txtNombre'];
    $descripcion = $_POST['txtDescripcion'];
    $precio = $_POST['txtPrecio'];

    $fecha = new DateTime();
    $imagen = $fecha->getTimestamp() . "_" . $_FILES['foto']['name'];

    $imagen_temporal = $_FILES['foto']['tmp_name'];
    move_uploaded_file($imagen_temporal, "../../imagenes/" . $imagen);

    $sql = "INSERT INTO `libro` (`id`, `nombre`, `descripcion`, `foto`, `precio`, `stock`) VALUES (NULL, '$nombre', '$descripcion', '$imagen', '$precio', '$stock')";
    $objConexion->ejecutar($sql);
    header("location:productos.php");
    exit(); // exit() después de redirigir para evitar la ejecución adicional

    
}

// Acción de borrado
if (isset($_GET['borrar'])) {
    $id_borrar = $_GET['borrar'];
    $imagen = $objConexion->consultar("SELECT foto FROM `libro` WHERE id = " . $_GET['modificar']);
        unlink("../../imagenes/" . $imagen[0]['foto']); // Elimino la imagen del código

    // Realizar la acción de borrado, por ejemplo:
    $objConexion->ejecutar("DELETE FROM `libro` WHERE `id` = $id_borrar");
    header("location:productos.php");
}
// Redireccionar a productos.php y procesar actualizaciones si es una solicitud GET
/*if ($_GET) {
    header("location:productos.php");

    

    // Actualizar el precio si se proporciona
    if (isset($_POST['txtPrecio'], $_POST['id'])) {
        $id = $_POST['id'];
        $precio = $_POST['txtPrecio'];
        $sql = "UPDATE `libro` SET `precio` = '$precio' WHERE `libro`.`id` = " . $_GET['modificar'];
        $objConexion->ejecutar($sql);
    }

    
}*/

// Obtener datos de libros
$resultado = $objConexion->consultar("SELECT * FROM `libro`");

?>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header ">Datos del libro</div>
                <div class="card-body">
                <form enctype="multipart/form-data" id="registroForm" method="post">
                     
                    <div class="form-group">
                    <label for="txtNombre">Nombre</label>
                    <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Ingresa el nombre">
                    </div>

                    <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" class="form-control" id="foto" name="foto">
                    </div>

                    <div class="form-group">
                    <label for="txtDescripcion">Descripcion</label>
                    <input type="text" class="form-control" id="txtDescripcion" name="txtDescripcion" placeholder="Ingresa la descripcion">
                    </div>

                    <div class="form-group">
                    <label for="txtPrecio">Precio</label>
                    <input type="number" step="any" class="form-control" id="txtPrecio" name="txtPrecio" placeholder="Ingresa el precio" step="0.01" min="0">
                </div>

                    <div class="form-group">
                    <label for="txtPrecio">UnidadesEnStock</label>
                    <input type="number" class="form-control" id="txtStock" name="txtStock" placeholder="Ingresa el stock" step="0.01" min="0">
                    </div>
                    <div class="d-flex justify-content-end">
                    <button type="submit" class="rounded text-white mt-5 d-flex justify-content-end ">Agregar al catálogo</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

    
        
      
        <div class="col-md-7"> 
    <div class="table">
        <table class="table table-bordered" style="border-color: #0b0b0bc6;">
            <thead >
                <tr>
                    <th scope="col" class="" style="background-color: #ec5779; color: #0b0b0b99;">ID</th>
                    <th scope="col" class="" style="background-color: #ec5779; color: #0b0b0b99;">Nombre</th>
                    <th scope="col" class="" style="background-color: #ec5779; color: #0b0b0b99;">Precio</th>
                    <th scope="col" class="" style="background-color: #ec5779; color: #0b0b0b99;">Acciones</th>
                </tr>
            </thead>
            <tbody>
    <?php foreach ($resultado as $libro) { ?>
        <tr>
            <td scope="row" style="background-color: #ffaacd; color: #0b0b0bc6;"><?php echo $libro['id']; ?></td>
            <td style="background-color: #ffaacd; color: #0b0b0bc6;"><?php echo $libro['nombre']; ?></td>
            <td style="background-color: #ffaacd; color: #0b0b0bc6;"><?php echo $libro['precio']; ?></td>
            <td style="background-color: #ffaacd;" class="d-flex justify-content-end">
                <!-- Corregir el enlace de borrar -->
                <button class="text-white mx-2 rounded">
                    <a class="text-decoration-none text-reset" href="?borrar=<?php echo $libro['id']; ?>">Borrar</a>
                </button>
                <button class="rounded text-white ml-2">
                    <a class="text-decoration-none text-reset" href="detalleLibro.php?id=<?php echo $libro['id']; ?>">Ver libro</a>
                </button>
            </td>
        </tr>
    <?php } ?>
</tbody>
        </table>
    </div>
    </div>
    
</div>
