<?php

// Iniciar la sesión si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == 'ok') {
    // El usuario ha iniciado sesión, obtener el nombre de usuario
    $nombreUsuario = $_SESSION['nombreUsuario'];

    // Verificar si el usuario es administrador
   /* if ($nombreUsuario == 'administrador') {
        include 'administrador/templates/header.php';
    } else {*/
        // Incluir el encabezado común para otros usuarios
        // Puedes personalizarlo según tus necesidades
        include 'templates/cabecera.php';
    
} else {
    // Redirigir a la página de inicio de sesión si el usuario no ha iniciado sesión
    header('Location: login.php');
    exit();
}
?>

<div class="col">
    <div class="row align-items-md-stretch mt-2">
        <div class="col">
            <div class="h-100 p-2">
                <h2>Bienvenido <?php echo $nombreUsuario; ?> </h2>
                <hr>
                <!-- Otro contenido de la página de inicio -->
            </div>
        </div>
    </div>
</div>

<?php
// Verificar si el usuario es administrador
/*if ($nombreUsuario == 'administrador') {
    include 'administrador/templates/footer.php';
} else {*/
    include 'templates/footer.php';
/*}*/
?>

