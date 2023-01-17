<?php

namespace Model;

class AdminCita extends ActiveRecord{
    protected static $tabla = 'citasservicios';
    protected static $columnasDB = ['id','hora','cliente','email','telefono','Servicio','Precio'];

    public $id;
    public $hora; 
    public $cliente;
    public $email;
    public $telefono;
    public $Servicio;
    public $Precio;

    public function __construct()
    {
        $this->id = $args['id'] ?? null;
        $this->hora =$args['hora'] ?? '';
        $this->cliente = $args['cliente'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono']?? '';
        $this->Servicio = $args['Servicio']??'';
        $this->Precio = $args['Precio'] ?? '';
    }
}