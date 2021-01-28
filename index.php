<?php
$limite = 9;

//importar bd
require 'includes/config/database.php';
$db = conectarDB();

//consultar
$query = "SELECT * FROM pijamas LIMIT ${limite}";

//obtener resultado
$resultado = mysqli_query($db, $query);

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous" />
  <link rel="stylesheet" href="./public/style.css" />
  <title>Sueño Real</title>
</head>

<body>
  <!-- Just an image -->
  <header class="header">
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand" href="index.php">
          <img src="./public/img/logo.jpeg.png" alt="logo" width="100" /></a>
        <button 
        class="navbar-toggler navbar-toggler-right" 
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav" 
        aria-controls="navbarNav" 
        aria-expanded="false" 
        aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Pijamas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Iniciar Sesion</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Cuerpo -->
  <div class="container py-2">
    <div class="row row-cols-2 row-cols-md-3 g-4">
      <?php while ($pijama = mysqli_fetch_assoc($resultado)) : ?>
        <div class="col">
          <div class="card text-center h-100">
            <img src="imagenes/<?php echo $pijama['imagen'] ?>" alt="imagen" class="card-img-top">
            <div class="card-body">
              <h5 class="card-title"><?php echo $pijama['titulo'] ?></h5>
              <p class="card-text">
                <?php echo $pijama['descripcion'] ?>
              </p>
              <p>$<?php echo $pijama['precio'] ?></p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <?php
  require 'includes/funciones.php';
  incluirTemplate('footer');
  ?>