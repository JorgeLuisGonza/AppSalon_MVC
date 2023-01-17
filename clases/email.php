<?php

namespace Clases;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    //estos de aqui son atributos de la clase (es decir datos propios de ella)
    public $email;
    public $nombre;
    public $token;
    
    //en el constructor sincronizamos lo que enviamos con los atributos de la clase.
    //una vez que declaramos un constructor se espera que mandemos los datos para definir el valor de los atributos
    public function __construct($email, $nombre, $token)
    {
        $this->email = $email; // sintacis de objetos asi accedemos a un atributo del mismo (->)
        $this->nombre = $nombre;
        $this->token = $token;

    }
    public function enviarConfirmacion(){
        // crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'f3a9efa65b8828';
        $mail->Password = '144ef6bf20ec90';


        $mail->setFrom('cuentas@appsalon.com'); //aqui iria nuestro email real
        $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        //set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF8';

        $contenido  = "<html>";
        $contenido .= "<p><strong>Hola ".$this->nombre."</strong> has crado tu cuenta en App Salon, confirmala dando click en el siguiente enlace </p>";
        $contenido .= "<p> Presiona aqui: <a href='http://localhost:3000/confirmar-cuenta?token=".$this->token."'>Confirmar cuenta</a></p>"; 
        $contenido .= "<p>Si no solicitaste esta cuenta ignora este mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // Enviar email
        $mail->send();
    }
    public function CambiaPassword(){
        // crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'f3a9efa65b8828';
        $mail->Password = '144ef6bf20ec90';


        $mail->setFrom('cuentas@appsalon.com'); //aqui iria nuestro email real
        $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        //set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF8';

        $contenido  = "<html>";
        $contenido .= "<p><strong>Hola ".$this->nombre."</strong> has solicitado cambiar la contraseña de tu cuenta en App Salon </p>";
        $contenido .= "<p> Presiona aqui: <a href='http://localhost:3000/cambia-password?token=".$this->token."'>Cambiar contraseña</a></p>"; 
        $contenido .= "<p>Si no solicitaste cambiar tu contraseña ignora este mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // Enviar email
        $mail->send();
    }
}