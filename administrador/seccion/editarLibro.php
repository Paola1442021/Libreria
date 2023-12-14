<?php include '../templates/header.php' ?>
<?php include("../conexion.php");?>

<?php
if (isset($_GET['id'])) {
    $libroId = $_GET['id'];
    $objConexion = new Conexion();

    // Usa consultas preparadas
    $sql = "SELECT * FROM `libro` WHERE id = ?";
    $detallesLibro = $objConexion->consultarConParametro($sql, [$libroId]);
} 

// Verifica si se envió el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editNombre'])) {
    $libroNombre = $_POST['editNombre'];
    $descripcion = $_POST['editDescripcion'];

    $objConexion = new Conexion();

    // Actualizar el nombre y la descripción en la base de datos
    $sql = "UPDATE `libro` SET `nombre` = '$libroNombre', `descripcion` = '$descripcion' WHERE `libro`.`id` = $libroId";
    $objConexion->ejecutar($sql);

    // Redirigir a productos.php después de la actualización
    header("Location: productos.php");
    exit();
}
?>

<div class="col-md-4">
    <div class="card">
        <img class="card-img-top rounded" style="max-height: 600px; object-fit: cover;" src="../../imagenes/<?php echo $detallesLibro[0]['foto']?>" alt="Title" />
    </div>
</div>

<div class="col-md-8">
    <div class="card" style="border: none;">
        <div class="card-body">
            
            <!-- Formulario de edición -->
            <form method="post" action="editarLibro.php?id=<?php echo $libroId; ?>">
                <div class="form-group">
                    <label for="editNombre">Editar Nombre:</label>
                    <input type="text" class="form-control" id="editNombre" name="editNombre" value="<?php echo $detallesLibro[0]['nombre']; ?>">
                </div>

                <div class="form-group">
                    <label for="editDescripcion">Editar Descripción:</label>
                    <textarea class="form-control" id="editDescripcion" name="editDescripcion" rows="5"><?php echo $detallesLibro[0]['descripcion']; ?></textarea>
                </div>

                <button type="submit" class="text-white rounded mt-2">Guardar Cambios</button>
            </form>
           
        </div>
    </div>
</div>