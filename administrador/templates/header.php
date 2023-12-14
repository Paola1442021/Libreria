<?php
// Iniciar la sesión si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
   if(!isset($_SESSION['usuario'])){
      header ("Location:../index.php");
   }else{
    if($_SESSION['usuario']=="ok"){
        $nombreUsuario=$_SESSION["nombreUsuario"];
    }
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../stylesheets/styles.css">
    <title>Document</title>
</head>
<body>
    <?php $url="http://".$_SERVER['HTTP_HOST']."/sitiophp" ?>
<nav class="navbar navbar-expand-lg p-2">
    <ul class="nav navbar-nav">
    
       
        <li class="nav-item">
            <a class="nav-link text-white" href="../seccion/productos.php">Libros</a>
        </li>
        <?php
        // Iniciar la sesión
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        // Verificar si el usuario ha iniciado sesión
        if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == 'ok') {
            // El usuario ha iniciado sesión, mostrar el enlace "Cerrar sesión"
            echo '<li class="nav-item">
                    <a class="nav-link text-white" href="../../logout.php">Cerrar sesión</a>
                  </li>';
        }
        ?>
        
    </ul>
</nav>

<div class="container mt-4">
    <div class="row">