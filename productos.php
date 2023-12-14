<?php
include 'templates/cabecera.php';
include("administrador/conexion.php");

// Iniciar la sesión si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$objConexion = new Conexion();

/*// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == 'ok') {
    // Verificar si se ha enviado el formulario de compra
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comprar'])) {
        $ID_Usuario = $_SESSION['id'];
        $idLibro = $_POST['id'];

        // Obtener el ID_Carrito correspondiente al usuario
        $idCarroQuery = "SELECT c.ID_Carrito
         FROM carrito c
         WHERE c.ID_Usuario = :ID_Usuario";
// Después de obtener el ID_Carrito correspondiente al usuario
echo "ID_Carrito: " . $idCarroQuery;

        // Preparar la consulta
        $stmt = $objConexion->prepare($idCarroQuery);

        // Asociar parámetros
        $stmt->bindParam(':ID_Usuario', $ID_Usuario, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener resultados
        $idCarroResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar si el usuario ya tiene un carrito
        if (!empty($idCarroResult)) {
            $idCarro = $idCarroResult[0]['ID_Carrito'];

            // Verificar si el libro ya está en el carrito
            $libroEnCarroQuery = "SELECT COUNT(*) AS countLibroEnCarro
                                  FROM carrito
                                  WHERE ID_Carrito = :ID_Carrito AND ID_Libro = :ID_Libro";

            // Preparar la consulta
            $stmt = $objConexion->prepare($libroEnCarroQuery);

            // Asociar parámetros
            $stmt->bindParam(':ID_Carrito', $idCarro, PDO::PARAM_INT);
            $stmt->bindParam(':ID_Libro', $idLibro, PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener resultados
            $libroEnCarroResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($libroEnCarroResult[0]['countLibroEnCarro'] == 0) {
                // El libro no está en el carrito, agregarlo
                $sql = "INSERT INTO `carrito` (`ID_Carrito`, `ID_Usuario`, `ID_Libro`, `Cantidad`) VALUES (:ID_Carrito, :ID_Usuario, :ID_Libro, 1)";

                // Preparar la consulta
                $stmt = $objConexion->prepare($sql);

                // Asociar parámetros
                $stmt->bindParam(':ID_Carrito', $idCarro, PDO::PARAM_INT);
                $stmt->bindParam(':ID_Usuario', $ID_Usuario, PDO::PARAM_INT);
                $stmt->bindParam(':ID_Libro', $idLibro, PDO::PARAM_INT);

                // Ejecutar la consulta
                $stmt->execute();

                header("location: productos.php");
                exit(); // exit() después de redirigir para evitar la ejecución adicional
            } else {
                // El libro ya está en el carrito
                echo "El libro ya está en tu carrito.";
            }
        } else {
            // El usuario no tiene un carrito, debes manejar este caso según tus necesidades
            echo "Error: No se encontró el carrito del usuario.";
        }
    }
}
*/
// Obtener datos de libros
$resultado = $objConexion->consultar("SELECT * FROM `libro`");
?>

<?php foreach ($resultado as $libro) { ?>
    <div class="card col-md-2 m-4 p-0">
        <img class="card-img-top" style="max-height: 500px; object-fit: cover;" src="imagenes/<?php echo $libro['foto']; ?>" alt="Title" />
        <div class="card-body">
            <h4 class="card-title"><?php echo $libro['nombre']; ?></h4>
            <form method="post" action="">
                <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">
                <button type="submit" class="btn-general rounded text-white ml-2" name="comprar">Comprar</button>
            </form>
        </div>
    </div>
<?php } ?>

<?php include 'templates/footer.php'; ?>
