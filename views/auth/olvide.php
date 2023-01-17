<h1 class="nombre-pagina">Recuperar contraseña</h1>
<p class="descripcion-pagina">Por favor escribe tu email para reestablecer tu contraseña</p>
<?php
  include_once __DIR__."/../templates/alertas.php"
?>
<form action="/olvide" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu email" name="email">
    </div>

    <input type="submit" class="boton" value="Enviar">
</form>

<div class="acciones">
    <a href="/">Inicia Sesion</a>
    <a href="/crear_cuenta">Crear cuenta</a>
</div>