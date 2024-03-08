
<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Aplicacion.php';
require_once __DIR__.'/includes/clases/usuario.php';

$tituloPagina = 'Usuarios Seguidos';


if (isset($_SESSION['nombre'])) {
    $username = $_SESSION['nombre'];
    $user = Usuario::buscaUsuario($username);


    if (isset($_POST['dejarDeSeguir'])) {
        $nombreDeUsuarioADejarDeSeguir = $_POST['dejarDeSeguir'];
        $user->dejarDeSeguirUsuario($nombreDeUsuarioADejarDeSeguir);
        // Redirigir a la misma página para evitar reenvíos del formulario
        header("Location: seguidos.php");
        exit();
    }


    $usuariosSeguidos = $user->encontrarSeguidos();

    $contenidoPrincipal = "<h1>Usuarios Seguidos por $username</h1>";
    if ($usuariosSeguidos == []) {
        $contenidoPrincipal .= "<p>Todavia no sigues a nadie.</p>";
    } else {
        $contenidoPrincipal .= '<div class="usuarios-seguidos-container">';

        foreach ($usuariosSeguidos as $usuarioSeguido) {
            $nombre = htmlspecialchars($usuarioSeguido->getNombre());
            $email = htmlspecialchars($usuarioSeguido->getEmail()); // Asumiendo que quieres mostrar el email
            $foto = htmlspecialchars($usuarioSeguido->getFotoDePerfil());

            $contenidoPrincipal .= "<div class='usuario-seguido-item'>";
            $contenidoPrincipal .= "<img src='$foto' alt='Foto de perfil de $nombre' style='max-width: 100px; max-height: 100px;'>";
            $contenidoPrincipal .= "<h2>$nombre</h2>";
            $contenidoPrincipal .= "<p>$email</p>";

            // Formulario para dejar de seguir
            $contenidoPrincipal .= "<form method='post' action=''>";
            $contenidoPrincipal .= "<input type='hidden' name='dejarDeSeguir' value='$nombre'>";
            $contenidoPrincipal .= "<button type='submit'>Dejar de seguir</button>";
            $contenidoPrincipal .= "</form>";

            $contenidoPrincipal .= "</div>";
        }

        $contenidoPrincipal .= '</div>';
    } 
}else {
    // Si el usuario no está autenticado, redirigir a la página de login o mostrar un mensaje
    $contenidoPrincipal = "<p>Por favor, <a href='login.php'>inicia sesión</a> para ver los usuarios que sigues.</p>";
}

require_once __DIR__.'/includes/vistas/plantillas/plantilla.php';
