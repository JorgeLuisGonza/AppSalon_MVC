<?php
namespace Controllers;

use Model\cita;
use Model\CitaServicio;
use Model\Servicio;

class APIControllers{
    public static function index(){
        $servicios = Servicio::all();
         $api = json_encode($servicios);
         echo $api;
    }

    public static function guardar(){
        //almacena la cita y devuelve el ID
        $cita = new cita($_POST);// $_POST recibe los datos que le mandamos con Form Data
        $resultado = $cita->guardar();

        $id = $resultado['id'];
        //Almacena la cita y el servicio
        $idServicios = explode(",",$_POST['servicios']); //separamos lo obtenido en un arreglo que contiene los servicios

        foreach($idServicios as $idServicio){
            $args = [
                'citaId'=>$id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
            }
        
        echo json_encode(['resultado' => $resultado]);
    }
    public static function eliminar(){
   if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['id'];

    $cita = cita::find($id);
    $cita->eliminar();
    header('Location:'.$_SERVER['HTTP_REFERER']);
   }
    }
}