<?php
//Base de datos
require '../../includes/config/database.php';
$db = conectarDB();

//consultar para obtener los vendedores
$consulta = "SELECT * FROM categoria";
$resultado = mysqli_query($db, $consulta);

//Arreglo con mensajes de errores
$errores = [];

$titulo = '';
$descripcion = '';
$precio = '';
$categoriaId = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $categoriaId =  mysqli_real_escape_string($db, $_POST['categoria']);

    // Asignar files hacia una variable
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
    if (!$imagen['name'] || $imagen['error']) {
        $errores[] = 'La Imagen es Obligatoria';
    }
    //Validar por tamaño
    $medida = 1000 * 1000;

    if ($imagen['size'] > $medida) {
        $errores[] = 'La imagen es muy pesada';
    }

    //reviar que el arreglo de errores este vacio
    if (empty($errores)) {
        /** SUBIDA DE ARCHIVOS */

        // Crear carpeta
        $carpetaImagenes = '../../imagenes/';

        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        // Generar un nombre único
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";


        // Subir la imagen
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);


        //Insertar en la bd
        $query = "INSERT INTO pijamas (titulo, imagen, descripcion, precio, id_categoria) VALUES ( '$titulo','$nombreImagen', '$descripcion', '$precio', '$categoriaId' )";

        // echo $query;
        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            //Redireccionar el usuario
            header('Location: ../../admin?resultado=1');
        }
    }
}

include '../../includes/templates/header.php';
?>

<main class="container py-4">
    <h1 class="text-center">CREAR NUEVA PIJAMA</h1>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error mb-2">
            <?php echo $error; ?>
        </div>

    <?php endforeach; ?>

    <a href="../../admin/index.php" class="boton">Volver</a>

    <form class="card card-body" method="POST" action="./crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Informacion General</legend>

            <div class="form-group">
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo de la pijama" class="form-control" value="<?php echo $titulo ?>">
            </div>
            <div class="form-group">
                <label for="imagen">Imagen:</label>
                <input  type="file" id="imagen" accept="image/jpeg, image/png" name="imagen" class="form-control">
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
        <input type="submit" value="CREAR PIJAMA" class="boton">
    </form>
</main>

<?php
include '../../includes/templates/footer.php';
?>