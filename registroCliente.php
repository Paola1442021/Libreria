<?php
include 'templates/cabecera.php';
include 'administrador/conexion.php';

// Iniciar la sesión si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$objConexion = new Conexion();
$mensaje = '';

// Insertar un nuevo usuario
if ($_POST) {
    $usuario = $_POST['usuario'];
    $contrasenia = $_POST['contrasenia'];

    // Iniciar transacción para garantizar la consistencia de la base de datos
    $objConexion->ejecutar("START TRANSACTION");

    try {
        // Insertar nuevo usuario
        $sqlUsuario = "INSERT INTO `usuarios` (`id`, `usuario`, `contrasenia`) VALUES (NULL, '$usuario', '$contrasenia')";
        $idUsuario = $objConexion->ejecutar($sqlUsuario);

        // Crear un carrito asociado al nuevo usuario
        $sqlCarrito = "INSERT INTO `carrito` (`ID_Carrito`, `ID_Usuario`) VALUES (NULL, $idUsuario)";
        $objConexion->ejecutar($sqlCarrito);

        // Confirmar la transacción
        $objConexion->ejecutar("COMMIT");

        // Redirigir a la página de inicio de sesión
        header("location: loginCliente.php");
        exit(); // exit() después de redirigir para evitar la ejecución adicional
    } catch (Exception $e) {
        // Si hay algún error, deshacer la transacción
        $objConexion->ejecutar("ROLLBACK");

        // Manejar el error según tus necesidades
        $mensaje = "Error al registrar el usuario: " . $e->getMessage();
    }
}
?>
<!-- Resto del código HTML -->

<div class="container">
        <div class="row  justify-content-center mt-3">
            <div class="col-md-4">
             
            <div class="card">
                <div class="card-header">Registro</div>
                <div class="card-body">
                    <form method="post">
                    <div class = "form-group">
                    <label for="">Usuario</label>
                    <input type="text" class="form-control" name="usuario" placeholder="Ingresa un nombre de usuario">
                    </div>
                    <div class="form-group">
                    <label for="exampleInputPassword1">Contraseña</label>
                    <input type="password" class="form-control" name="contrasenia" placeholder="Ingresa una contraseña">
                    </div>
                    
                    <button type="submit" class="btn btn-registro rounded text-white m-2" style="background-color: #7e2e84; border-color: #7e2e84; padding: 5px 12px;">
    Registrarse
</button>
                    
                    </form>
                    
                    
                </div>
            </div>
            

            </div>
        
            
        </div>
    </div>
    

<?php
include 'administrador/templates/footer.php';
?>