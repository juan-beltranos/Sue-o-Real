<?php
require './includes/funciones.php';
$auth = estaAutenticado();


if (!$auth) {
  header('Location: ./index.php');
}

// Validar la URL por ID válido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: admin.php');
}

//Base de datos
require './includes/config/database.php';
$db = conectarDB();

// Obtener los datos de la propiedad
$consulta = "SELECT * FROM pijamas WHERE id_pijama = ${id}";
$resultado = mysqli_query($db, $consulta);
$pijama = mysqli_fetch_assoc($resultado);

//echo "<pre>";
//var_dump($pijama);
//echo "</pre>";

//consultar para obtener las categorias
$consulta = "SELECT * FROM categoria";
$resultado = mysqli_query($db, $consulta);

//Arreglo con mensajes de errores
$errores = [];

$titulo = $pijama['titulo'];
$descripcion = $pijama['descripcion'];
$precio =  $pijama['precio'];
$categoriaId =  $pijama['id_categoria'];
$imagenPijama = $pijama['imagen'];



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $categoriaId =  mysqli_real_escape_string($db, $_POST['categoria']);

    //Asignar files hacia la variable
    $imagen = $_FILES['imagen'];


    if (!$titulo) {
        $errores[] =  "Debes añadir un titulo";
    }
    if (strlen($descripcion) < 5) {
        $errores[] =  "Debes añadir una descripcion y debe tener al menos 25 caracteres";
    }
    if (!$precio) {
        $errores[] =  "Debes añadir un precio a la pijama";
    }
    if (!$categoriaId) {
        $errores[] =  "Debes escoger una categoria de la pijama";
    }

    //Validar por tamaño
    $medida = 1000 * 1000;

    if ($imagen['size'] > $medida) {
        $errores[] = 'La imagen es muy pesada';
    }

    $nombreImagen = '';

    //reviar que el arreglo de errores este vacio
    if (empty($errores)) {


        // Crear carpeta
        $carpetaImagenes = './imagenes/';

        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';

        /** SUBIDA DE ARCHIVOS */

        if ($imagen['name']) {
            // Eliminar la imagen previa

            unlink($carpetaImagenes . $propiedad['imagen']);

            // // Generar un nombre único
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            // // Subir la imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        } else {
            $nombreImagen = $pijama['imagen'];
        }


        //Insertar en la bd
        $query = "UPDATE pijamas SET titulo = '${titulo}', imagen = '${nombreImagen}', descripcion = '${descripcion}', precio = ${precio}, id_categoria = ${categoriaId} WHERE id_pijama = ${id} ";

        echo $query;

        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            //Redireccionar el usuario
            header('Location: ./admin.php?resultado=2');
        }
    }
}

include './header.php';
?>

<main class="container py-4">
    <h1 class="text-center">ACTUALIZAR PIJAMA</h1>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error mb-2">
            <?php echo $error; ?>
        </div>

    <?php endforeach; ?>

    <a href="./admin.php" class="boton">Volver</a>

    <form class="card card-body" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Informacion General</legend>

            <div class="form-group">
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo de la pijama" class="form-control" value="<?php echo $titulo ?>">
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" class="form-control" accept="image/jpg, image/png, image/jpeg">

                <img src="./imagenes/<?php echo $pijama['imagen'] ?>" alt="imagen pijama" width="200">
            </div>
            <div class="form-group">
                <label for="descripcion">Descripcion:</label>
                <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion de la pijama"><?php echo $descripcion ?></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" class="form-control" placeholder="Precio de la pijama" min="0" value="<?php echo $precio ?>">
            </div>

            <div class="form-group">
                <label>Categoria</label>
                <select name="categoria" id="categoria" class="form-control">
                    <option value="">--Selecciona una categoria--</option>
                    <?php while ($categoria = mysqli_fetch_assoc($resultado)) : ?>
                        <option <?php echo $categoriaId === $categoria['id_categoria'] ? 'selected' : ''; ?> value="<?php echo $categoria['id_categoria'] ?>">
                            <?php echo $categoria['nombre_categoria'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <br>
        </fieldset>
        <input type="submit" value="ACTUALIZAR PIJAMA" class="boton">
    </form>
</main>

<?php
include './footer.php';
?>