<?php
namespace Controllers;

use MVC\Router;

class citaController {
    public static function index(Router $router){
      isAuth(); //verifica si esta autenticado, en caso contrario se redirecciona
        $router->render('cita/index',[
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    }
}