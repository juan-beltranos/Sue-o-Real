<?php
require './includes/config/database.php';
$db = conectarDB();

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    $email = mysqli_real_escape_string($db,  filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db,  $_POST['password']);

    if (!$email) {
        $errores[] = "El email es obligatorio o no es válido";
    }

    if (!$password) {
        $errores[] = "El Password es obligatorio";
    }

    if (empty($errores)) {

        // Revisar si el usuario existe.
        $query = "SELECT * FROM usuarios WHERE email = '${email}' ";
        $resultado = mysqli_query($db, $query);
        var_dump($resultado);

        if ($resultado->num_rows) {
            // Revisar si el password es correcto
            $usuario = mysqli_fetch_assoc($resultado);
            // var_dump($usuario);
            $auth = password_verify($password, $usuario['password']);

            if ($auth) {
                //El usuario esta autenticado
                session_start();

                //Llenar el arreglo de la sesion
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;
                header('Location: ./admin.php');
            } else {
                $errores[] = "La contraseña es incorrecta";
            }
        } else {
            $errores[] = "El Usuario no existe";
        }
    }
}
?>

<?php include './header.php'; ?>

<main class="container col-md-4 py-2">
    <h1 class="text-center">Iniciar Sesion</h1>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error mt-2">
            <?php echo $error; ?>
        </div>

    <?php endforeach; ?>

    <form method="POST" novalidate>
        <div class="card card-body">
            <fieldset>
                <legend class="text-center">Email y Contraseña</legend>

                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Tu correo electronico" class="form-control">

                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" placeholder="Tu Contraseña" class="form-control">
            </fieldset>
            <br>
            <input type="submit" value="Iniciar Sesion" class="boton">
        </div>
    </form>
</main>

<?php
include './footer.php';
?>