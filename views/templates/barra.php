<div class="barra">
    <p>Hola <?php echo $nombre??''; ?> </p>
    <a href="/logout" class="boton">Cerrar Sesión</a>
</div>

<?php if(isset($_SESSION['admin'])){ ?>
    <div class="barra-servicios">
        <a class="boton-azul" href="/admin">Ver Citas</a>
        <a class="boton-azul" href="/servicios">Ver Servicios</a>
        <a class="boton-azul" href="/servicios/crear">Nuevo Servicio</a>
    </div>

   <?php } ?>