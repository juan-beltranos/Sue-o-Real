<?php
if (!isset($_SESSION)) {
  session_start();
}

$auth = $_SESSION['login'] ?? false;
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@300&family=Dancing+Script&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./public/style.css" />
  <title>Sueño Real</title>
</head>

<body>
  <!-- Just an image -->
  <header class="header">
    <nav class="navbar navbar-expand-lg">
      <div class="container text-center">
        <a class="navbar-brand" href="./index.php">
          <img src="./public/img/logo.png" alt="logo" width="100" /> </a>
       
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon">
            <i class="fas fa-bars" style="color:#fff; font-size:28px;"></i>
          </span>
        </button>
        <span class="titulo text-light">LOS MEJORES PRECIOS DEL MERCADO</span> 
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav ">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="./index.php">Inicio</a>
            </li>
            <li class="nav-item">
              <?php if ($auth) : ?>
                <a href="./admin.php" class="nav-link">Administrador</a>
              <?php endif; ?>
            </li>
            <li class="nav-item">
              <?php if ($auth) : ?>
                <a href="./cerrar-sesion.php" class="nav-link">Cerrar Sesión</a>
              <?php elseif (!$auth) : ?>
                <a href="./login.php" class="nav-link">Iniciar Sesion</a>
              <?php endif; ?>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>