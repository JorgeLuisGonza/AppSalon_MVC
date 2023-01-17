<h1 class="nombre-pagina">Aqui podras cambiar tu contraseña</h1>

<?php include_once __DIR__ .'/../templates/alertas.php'; ?>
<form action="/new-password" class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" placeholder="Introduce tu Nueva Contraseña" name="password" required>
        <input type="hidden" name="token" value="<?php echo $token ?>">
    </div>

    <input type="submit" class="boton" value="Cambia tu Contraseña">
</form>
<div class="acciones">
    <a href="/">Inicia Sesion</a>
</div>