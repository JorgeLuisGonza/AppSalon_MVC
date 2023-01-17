<h1 class="nombre-pagina">Panel de Administracion</h1>
<?php include_once __DIR__.'/../templates/barra.php' ?>

<h2>Buscar citas</h2>
<div class="busqueda">
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
        </div>
    </form>
</div>

<?php 
if(count($citas) === 0){
    echo "<h2>No hay citas el dia de Hoy.</h2>";
}
?> 

<div class="citas-admin">
    <ul class="citas">
    <?php
        $idCita = '';
        foreach($citas as $key => $cita){ 
            if($idCita !== $cita->id){ 
            $idCita = $cita->id;
            $total = 0;
            ?>
            <li>
                <p>ID: <span><?php echo $cita->id; ?></span></p>
                <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                <p>Email: <span><?php echo $cita->email; ?></span></p>
                <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>
                <h3>Servicios</h3>
            <?php }?>
            <p class="servicio"><?php echo $cita->Servicio." $".$cita->Precio; ?></p>
            <?php
            $total = $total + $cita->Precio;
            $actual = $cita->id;
            $proximo = $citas[$key + 1]->id??0; // obtiene el id de la siguiente iteracion..
            if($actual != $proximo){   ?>
            <p>Total a Pagar: <span>$<?php echo $total;?></span></p>
            <form action="/api/eliminar" method="POST">
                <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                <input type="submit" class="boton-eliminar" value="eliminar">
            </form>
    <?php  } } ?>
    </ul>
   
</div>
<?php
$script = "<script src='build/js/buscador.js'></script>"
?>