<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Login';

$contenidoPrincipal=<<<EOS
    <h1> Iniciar Sesion </h1>
    <form action="procesarLogin.php" method="POST" id="login">
    <fieldset>
        <legend>Datos para iniciar sesión</legend>

        <div>
            <label for="username">Usuario:</label>
            <input id="username" type="text" name="nombre" placeholder="Usuario" required/>
        </div>        
        <div>    
            <br/><input type="password" name="password" placeholder="Contraseña" required/>
        </div> 
        <div>   
            <br/><br/><button type="submit" id="login-button">INICIAR SESION</button>
        </div>
    </fieldset>
    <h4>¿No tienes una cuenta aún?</h4>
    <a href="registro.php"><button type="button" id="register-button">CREAR CUENTA</button></a>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantilla.php';
