<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIControllers;
use Controllers\citaController;
use Controllers\loginController;
use Controllers\ServicioController;
use MVC\Router;
$router = new Router();
 
 
//Iniciar Sesion
$router->get('/',[loginController::class,'login']);
$router->post('/',[loginController::class,'login']);
$router->get('/logout',[loginController::class,'logout']);

//Recuperar Password
$router->get('/olvide',[loginController::class,'olvide']);
$router->post('/olvide',[loginController::class,'olvide']);
//cambio de contraseña
$router->get('/cambia-password',[LoginController::class,'combiaPassword']);
$router->post('/new-password',[LoginController::class,'newPassword']);
$router->get('/mensajePassword',[LoginController::class,'mensajePassword']);

//crear cuenta
$router->get('/crear_cuenta',[loginController::class,'crear']);
$router->post('/crear_cuenta',[loginController::class,'crear']);

//comprobar cuenta
$router->get('/confirmar-cuenta',[LoginController::class,'confirmar']);
$router->get('/mensaje',[LoginController::class,'mensaje']);

// AREA PRIVADA
$router->get('/cita',[citaController::class,'index']);
$router->get('/admin',[AdminController::class,'index']);


//api de citas..
$router->get('/api/servicios',[APIControllers::class,'index']);
$router->post('/api/citas',[APIControllers::class,'guardar']);
$router->post('/api/eliminar',[APIControllers::class,'eliminar']);

//CRUD de servicios
$router->get('/servicios',[ServicioController::class,'index']);
$router->get('/servicios/crear',[ServicioController::class,'crear']);
$router->post('/servicios/crear',[ServicioController::class,'crear']);
$router->get('/servicios/actualizar',[ServicioController::class,'actualizar']);
$router->post('/servicios/actualizar',[ServicioController::class,'actualizar']);
$router->get('/servicios/eliminar',[ServicioController::class,'eliminar']);
$router->post('/servicios/eliminar',[ServicioController::class,'eliminar']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();