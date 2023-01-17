<?php
namespace Controllers;

use Clases\Email;
use Model\Usuario;
use MVC\Router;

class loginController{
    public static function login(Router $router){
        $alertas = [];
        $auth = new Usuario;
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
           $auth = new Usuario($_POST); // creamos una instancia de usuario unicamente con el correo y contraseña(que metio usuario en formulario)
           $alertas = $auth->validarLogin();

           if(empty($alertas)){
            //colocaron email y password ahora hay que validar..
            // validamos si el usuario existe
            $usuario = Usuario::where('email',$auth->email); // esta es una instancia con lo que encontemos en la BD(buscamos por email)
            if($usuario){
                //el usuario existe, debemos validar que el usuario este confirmado y que la contraseña sea correcta
                if($alertas = $usuario->comprobarPasswordyComprobado($auth->password)){
                    session_start();
                    $_SESSION['id'] = $usuario->id;
                    $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                    $_SESSION['email'] = $usuario->email;
                    $_SESSION['login'] = true;

                    //redireccionar
                    if($usuario->admin){
                        $_SESSION['admin'] = $usuario->admin ?? null;
                        header('Location: /admin');
                    }else{
                        header('Location: /cita');
                    }
                    
                }
            }else{
                Usuario::setAlerta('error','Correo no encontrado');
            }
           }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/login',[
            'alertas'=>$alertas,
            'auth'=>$auth
        ]);
    }
    public static function logout(){
        session_start();
        $_SESSION = [];
        header('location: /');
    }
    public static function olvide(Router $router){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            if(empty($alertas)){ //no devuelve alertas 
                $usuario = Usuario::where('email',$auth->email);
                if($usuario && $usuario->confirmado === "1"){
                    //aqui debemos generar un nuevo token que le permita al usuario cambiar su contraseña
                     // generar un token unico
                    $usuario->generarToken();
                     //enviar por email el token  para poder cambiar contraseña
                    $email = new Email($usuario->email,$usuario->nombre,$usuario->token);
                    $email->CambiaPassword();
                    
                    // Sincronizamos el usuario en DB con el que hay en memoria (asignamos el token)
                    $usuario->guardar();
                    header('location: /mensajePassword');
                }else{
                    Usuario::setAlerta('error','El usuario no existe o no esta confirmado');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide',[
            'alertas' => $alertas
        ]);

    }
    public static function mensajePassword(Router $router){
        $router->render('auth/mensajePassword');
    }
    public static function combiaPassword(Router $router){
        $alertas = [];
        $token = s($_GET['token']); // accedemos a la variable de la url y sanitizamos esa entrada
        $usuario = Usuario::where('token',$token);
        if(empty($usuario)){
            $alertas['error'][] = 'Tu token no es valido';
        }
        $router->render('auth/cambia-Password',[
            'alertas'=>$alertas,
            'token'=>$token
        ]);
    }
    public static function newPassword(Router $router){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $usuario = Usuario::where('token',$auth->token);
            if(empty($usuario)){
                $alertas['error'][] = 'Tu token no es valido';
            }else{
                $usuario->password =  password_hash($auth->password, PASSWORD_BCRYPT);
                $usuario->token = '';
                $resultado = $usuario->guardar();
                if($resultado){
                    $alertas['exito'][] = 'Haz cambiado tu contraseña'; 
                }
            }

        }
        $router->render('auth/new-Password',[
            'alertas'=>$alertas
        ]);
    }
    
    public static function crear(Router $router){
        $usuario = new Usuario; 

        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] ==='POST'){
            //instanciamos al usuario
             $usuario->sincronizar($_POST);//Sincronizamos todo lo que hay en la superglobal POST
             $alertas= $usuario->validarNuevaCuenta();

             if(empty($alertas)){
               //en este punto se pasaron todas las validaciones ahora debemos validar si el usuario existe o no
               $resultado = $usuario->existeUsuario();

               if($resultado->num_rows){
                 $alertas = Usuario::getAlertas();
               }else{
                // hasehar la password
                $usuario->hashPassword();

                // generar un token unico
                $usuario->generarToken();

                //enviar por email el token 
                $email = new Email($usuario->email,$usuario->nombre,$usuario->token);
                $email->enviarConfirmacion();
                
                // crear el usuario 
                $resultado = $usuario->guardar();
                if($resultado){
                    header('location: /mensaje');
                }
                // debuguear($email);
               }
             }
        }
        $router->render('auth/crear-cuenta',[
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router){
        $alertas = [];

        $token = s($_GET['token']); // accedemos a la variable de la url y sanitizamos esa entrada
        $usuario = Usuario::where('token',$token);
       if(empty($usuario)){
        //si no nos devuelve una coincidencia de token mostramos un mensaje de error
        $alertas['error'][] = 'Tu token no es valido';
       }else{
        // si hay una coincidencia actualizamos el campo 'confirmado' por un 1
        $usuario->confirmado = '1'; // asi modificamos un valor del objeto en memoria...
        $usuario->token = '';
        $usuario->guardar(); // este metodo sincroniza nuestra tabla con los valores del objeto actual en memoria...
        $alertas['exito'][] = 'Felicidades tu cuenta ahora esta activada..';
       }
        $router->render('auth/confirmar-cuenta',[
            'alertas'=>$alertas
        ]);
    }
}