<?php

if (!isset($_SESSION)) {
  session_start();
}

$limite = 9;

//importar bd
require 'includes/config/database.php';
$db = conectarDB();

//consultar
$query = "SELECT * FROM pijamas LIMIT ${limite}";

//obtener resultado
$resultado = mysqli_query($db, $query);

?>

<?php include './header.php'; ?>

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
include './footer.php';
  ?>