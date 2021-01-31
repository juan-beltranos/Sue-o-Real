<?php

if (!isset($_SESSION)) {
  session_start();
}

//importar bd
require 'includes/config/database.php';
$db = conectarDB();

//consultar
$query = "SELECT * FROM pijamas";

//obtener resultado
$resultado = mysqli_query($db, $query);

?>

<?php include './header.php'; ?>
<div style=" background-color: rgb(103, 219, 184);">
  <!-- Cuerpo -->
  <div class="container py-2">
    <div class="row row-cols-2 row-cols-md-3 g-4">
      <?php while ($pijama = mysqli_fetch_assoc($resultado)) : ?>
        <div class="col">
          <div class="card text-center h-100 shadow  mb-5 bg-white rounded">
            <img src="imagenes/<?php echo $pijama['imagen'] ?>" alt="imagen" class="card-img-top">
            <div class="card-body font-card">
              <h5 class="card-title text-uppercase fw-bold"><?php echo $pijama['titulo'] ?></h5>
              <p class="card-text">
                <?php echo $pijama['descripcion'] ?>
              </p>
              <p class="text-info fw-bold fs-3">$<?php echo $pijama['precio'] ?></p>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</div>

<?php
include './footer.php';
?>