<?php

namespace Model;

class Usuario extends ActiveRecord{
    // base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id','nombre','apellido','email','telefono','admin','confirmado','token','password'];
    
    // creamos un atributo por columna 
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;
    public $password;

    //creamos el constructor
    public function __construct($args = []) // va a tomar argumentos y por default es un arreglo vacio
    {
        // a nuestra clase le mandamos un argumento (arreglo).... lo asignamos a los atributos de la clase
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
        $this->password = $args['password'] ?? '';


    }
    //aqui vamos a validar el login
    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'La contraseña es obligatoria';
        }
        return self::$alertas;
    }

    //validamos el email
    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        return self::$alertas;
    }

    // ------Mensajes de validacion para la cracion de la cuenta-------
    public function validarNuevaCuenta(){ //es publico porque accederemos a el desde loginController
        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre del cliente es obligatorio';
        }
        if(!$this->apellido){
            self::$alertas['error'][] = 'El apellido del cliente es obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'El Email del cliente es obligatorio';
        }
        if(!$this->telefono){
            self::$alertas['error'][] = 'El telefono del cliente es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'La contraseña es obligatorio';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'La contraseña debe contener al menos 6 caracteres';
        }

        return self::$alertas;
    }
    //para saber si el usuario existe
    public function existeUsuario(){
        $query = "SELECT * FROM ". self::$tabla." WHERE email = '".$this->email."' LIMIT 1";
       
        $resultado= self::$db->query($query);

       if($resultado->num_rows){ // si resultado en su campo num_rows devuelve mas de 0 quiere decir que el usuario ya existe
        self::$alertas["error"][] = 'El usuario ya existe';
       }
       
       return $resultado;
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT); // ASI SE HASHEA UN PASSWORD
    }

    public function generarToken(){
        $this->token = uniqid();
    }

    public function comprobarPasswordyComprobado($password){
        $resultado = password_verify($password,$this->password);
        if(!$resultado ||!$this->confirmado){ // si una de las dos es false...
           self::$alertas['error'][] = 'Password incorrecto o tu cuenta no esta confirmada';
        }else{
            return true;
        }
    }

}