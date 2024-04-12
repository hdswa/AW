
<?php
use es\ucm\fdi\aw\Aplicacion;
require_once __DIR__.'/includes/config.php';


$tituloPagina = 'Usuarios Seguidos';


if (isset($_SESSION['nombre'])) {
    $username = $_SESSION['nombre'];
    $user = \es\ucm\fdi\aw\usuarios\Usuario::buscaUsuario($username);


    if (isset($_POST['dejarDeSeguir'])) {
        $nombreDeUsuarioADejarDeSeguir = $_POST['dejarDeSeguir'];
        $user->dejarDeSeguirUsuario($nombreDeUsuarioADejarDeSeguir);
        // Redirigir a la misma página para evitar reenvíos del formulario
        header("Location: seguidos.php");
        exit();
    }


    $usuariosSeguidos = $user->encontrarSeguidos();

    $contenidoPrincipal = "<h1>Usuarios seguidos por $username:</h1>";
    if ($usuariosSeguidos == []) {
        $contenidoPrincipal .= "<p>Todavía no sigues a nadie. Comienza a seguir a otros perfiles para verlos aquí.</p>";
    } else {
        $contenidoPrincipal .= '<div class="usuarios-seguidos-container">';

        foreach ($usuariosSeguidos as $usuarioSeguido) {
            $nombre = htmlspecialchars($usuarioSeguido->getNombre());
            $email = htmlspecialchars($usuarioSeguido->getEmail()); // Asumiendo que quieres mostrar el email
            $foto = htmlspecialchars($usuarioSeguido->getFoto());

            $contenidoPrincipal .= "<div class='usuario-seguido-item'>";
            $contenidoPrincipal .= "<img src='$foto' alt='Foto de perfil de $nombre' style='max-width: 100px; max-height: 100px;' class='imagen_usuario'/>";
            $contenidoPrincipal .= "<h2>$nombre</h2>";
            

            // Formulario para dejar de seguir
            $contenidoPrincipal .= "<form method='post' action=''>";
            $contenidoPrincipal .= "<input type='hidden' name='dejarDeSeguir' value='$nombre'>";
            $contenidoPrincipal .= "<button class='boton-primario' type='submit'>Dejar de seguir</button>";
            $contenidoPrincipal .= "</form>";

            $contenidoPrincipal .= "</div>";
        }

        $contenidoPrincipal .= '</div>';
    } 
}else {
    // Si el usuario no está autenticado, redirigir a la página de login o mostrar un mensaje
    $contenidoPrincipal = "<p>Por favor, <a href='login.php'>inicia sesión</a> para ver los usuarios que sigues.</p>";
}

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];

$app->generaVista('/plantillas/plantilla.php', $params);
