<?php
include 'templates/cabecera.php';
include 'administrador/conexion.php';
// Iniciar la sesión si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$objConexion = new Conexion();
$mensaje = '';

if ($_POST) {
    // Validación del usuario cliente
    $usuario = $_POST['usuario'];
    $contrasenia = $_POST['contrasenia'];

    $sql = "SELECT * FROM usuarios WHERE usuario = :usuario AND contrasenia = :contrasenia";
    $id = "SELECT id FROM usuarios WHERE usuario = :usuario AND contrasenia = :contrasenia";

    $params = array(':usuario' => $usuario, ':contrasenia' => $contrasenia);
    $resultado = $objConexion->consultarConParametro($sql, $params);

    if ($resultado && count($resultado) > 0) {
        $_SESSION['usuario'] = 'ok';
        $_SESSION['id'] = $id;

        $_SESSION['nombreUsuario'] = $usuario;
        header('Location: inicio.php');
        exit();
    } else {
        $mensaje = 'El usuario o la contraseña son incorrectos';
    }

    // Validación del usuario administrador
    if ($usuario == "administrador" && $contrasenia == "sistema") {
        $_SESSION['usuario'] = 'ok';
        $_SESSION['nombreUsuario'] = 'administrador';
        header('Location: administrador/seccion/productos.php');
        exit();
    } else {
        $mensaje = 'El usuario o contraseña son incorrectos';
    }
}

?>

<!-- Resto del código HTML -->

<div class="container">
    <div class="row justify-content-center mt-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <label for="">Usuario</label>
                            <input type="text" class="form-control" name="usuario" placeholder="Ingresa un nombre de usuario">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Contraseña</label>
                            <input type="password" class="form-control" name="contrasenia" placeholder="Ingresa una contraseña">
                        </div>
                        
                        <button type="submit" id="" class="btn-login rounded text-white m-2">Loguearse</button>
                        <?php
                        if (isset($mensaje) && !empty($mensaje)) { ?>
                            <div class="alert alert-danger">
                                <?php echo $mensaje; ?>
                            </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'administrador/templates/footer.php';
?>
