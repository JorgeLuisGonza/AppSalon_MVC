<?php
namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index(Router $router){

        isAdmin();

     $fecha = $_GET['fecha'] ?? date('Y-m-d'); //busca si hay algo en el url sino la agarrara del servidor
     $fechas = explode('-',$fecha);
     if(!checkdate($fechas[1],$fechas[2],$fechas[0])){
        header('location: /404');
     }
     

        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as Servicio, servicios.precio as Precio ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.servicioId ";
        $consulta .= " WHERE fecha =  '${fecha}'";

        $citas = AdminCita::SQL($consulta);
        $router->render('admin/index',[
            'nombre'=> $_SESSION['nombre'],
            'citas'=> $citas,
            'fecha' => $fecha
        ]);
    }

}