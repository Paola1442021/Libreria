<?php include '../templates/header.php' ?>
<?php include("../conexion.php");?>

<?php
// detalleLibro.php
$detallesLibro = null; // Inicializamos $detallesLibro en null

if (isset($_GET['id'])) {
    $libroId = $_GET['id'];
    $objConexion = new Conexion();

    // Usa consultas preparadas
    $sql = "SELECT * FROM `libro` WHERE id = ?";
    $detallesLibro = $objConexion->consultarConParametro($sql, [$libroId]);
} 
?>
    <div class="col-md-4">
        <div class="card">
            <img class="card-img-top rounded" style="max-height: 600px; object-fit: cover;" src="../../imagenes/<?php echo $detallesLibro[0]['foto']?>" alt="Title" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="card" style="border: none;">
            <div class="card-body p-4">
                <?php if ($detallesLibro): ?>
                    <h2 class="card-title text-white"><?php echo $detallesLibro[0]['nombre']?></h4>
                    <p class="card-text text-white"><?php echo $detallesLibro[0]['descripcion']?></p>
                    <p class="card-text text-white">Precio: <?php echo $detallesLibro[0]['precio']?></p>

                    <button class="rounded text-white">
    <a class="text-decoration-none text-reset" href="editarLibro.php?id=<?php echo $libroId; ?>">Editar libro</a>
</button>

                <?php else: ?>
                    <p>No se encontraron detalles para este libro.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
        include'../templates/footer.php';
    ?>
