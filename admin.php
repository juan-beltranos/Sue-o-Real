<?php

require './includes/funciones.php';
$auth = estaAutenticado();

if (!$auth) {
  header('Location: ./index.php');
}

//Base de datos
require './includes/config/database.php';

$db = conectarDB();

$query = "SELECT * FROM pijamas";

$resultadoConsulta = mysqli_query($db, $query);

//muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $id = filter_var($id, FILTER_VALIDATE_INT);

  if ($id) {

    //eliminar archivo
    $query = "SELECT imagen FROM pijamas WHERE id_pijama = ${id}";
    $resultado = mysqli_query($db, $query);
    $pijama = mysqli_fetch_assoc($resultado);
    unlink('./imagenes/' . $pijama['imagen']);

    //Eliminar pijama
    $query = "DELETE FROM pijamas WHERE id_pijama = ${id}";
    // echo $query;
    $resultado = mysqli_query($db, $query);
    if ($resultado) {
      header('Location: ./admin.php?resultado=3');
    }
  }
}
?>
<?php include './header.php'; ?>

<main class="container py-4">
  <h1 class="text-center">Administrador de pijamas</h1>
  <?php
  if (intval($resultado) === 1) :  ?>
    <p class="alerta exito">Pijama creada correctamente</p>
  <?php elseif (intval($resultado) === 2) : ?>
    <p class="alerta exito">Pijama actualizada correctamente</p>
  <?php elseif (intval($resultado) === 3) : ?>
    <p class="alerta exito">Pijama Eliminada correctamente</p>
  <?php endif; ?>

  <a href="./crear.php" class="boton">Nueva Pijama</a>
  <br>
  <br>
  <table class="table">
    <thead class="table-danger text-center">
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Titulo</th>
        <th scope="col">Imagen</th>
        <th scope="col">Precio</th>
        <th scope="col">Acciones</th>
      </tr>
    </thead>
    <tbody class="text-center">
      <?php while ($pijama = mysqli_fetch_assoc($resultadoConsulta)) : ?>
        <tr>
          <th scope="row"><?php echo $pijama['id_pijama']; ?></th>
          <td><?php echo $pijama['titulo']; ?></td>
          <td> <img src="./imagenes/<?php echo $pijama['imagen'] ?>" alt="imagen" width="100"> </td>
          <td>$<?php echo $pijama['precio']; ?></td>
          <td>
            <form method="POST">
              <input type="hidden" name="id" value="<?php echo $pijama['id_pijama']; ?>">
              <input type="submit" class="btn btn-danger" value="Eliminar">
              <a href="./actualizar.php?id=<?php echo $pijama['id_pijama']; ?>" class="btn btn-warning">Actualizar</a>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</main>

<?php
//cerrar conexion
mysqli_close($db);

include './footer.php'
?>