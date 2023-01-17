<?php


    foreach($alertas as $key=>$mensajes){ 
        foreach($mensajes as $mensaje){ // aqui recorremos cada una de las los tipos de alertas que haya en el arreglo de
            ?>
            <div class="alerta <?php echo $key; ?>">
            <p class="mensaje_alerta"><?php echo $mensaje; ?> </p>
            </div>
            <?php
        }
    }

?>