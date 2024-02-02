<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public $token;

    //constructoru ia ca parametru emailu unde o sa trimita mesaju de cofirmare numele userului si tokenu
    public function __construct($email,$nombre,$token)
    {
        //iar aici salvam in datele clasei ce primim de la constructor
        $this->email=$email;
        $this->nombre=$nombre;
        $this->token=$token;
    }


    public function enviarConfirmacion(){

        //Creem obiectul de email
        $mail = new PHPMailer();
        //odata ce avem acces la metodele clasei
        //stabilim protocolu
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->SMTPSecure="tls";
$mail->Port = 2525;
$mail->Username = '1b9ecbc2b54a9a';
$mail->Password = 'a60a1c2074471e';

$mail->setFrom("cuentas@appsalon.com");
$mail->addAddress("cuentas@appsalon.com","AppSalon");
$mail->Subject="Confirma tu cuenta";

//Setam html in mai

$mail->isHTML(true);
$mail->CharSet="UTF-8";
$contenido= "<html>";
$contenido .="<p> <strong> Hola " . $this->nombre . " </strong> Has creado tu cuneta en appSaolon ,solo tienes que presionar en el siguente enlance para crear tou cuenta </p>";
//aici trimitem linkul de acces cu tokenul inclus
$contenido .= "<p> Presiona aqui <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . " '> Confirmar cuenta</a></p>";
$contenido .= "<p> Si tu no solicitaste este cambion ignora el coreo</p>";
$contenido .="</html>";

//iar aici  adaugam la textul din variabila contenido
$mail->Body=$contenido;

//Trimetemi mailu

$mail->send();
    }

    public function enviarInstruciones (){

        
        //Creem obiectul de email
        $mail = new PHPMailer();
        //odata ce avem acces la metodele clasei
        //stabilim protocolu
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->SMTPSecure="tls";
$mail->Port = 2525;
$mail->Username = '1b9ecbc2b54a9a';
$mail->Password = 'a60a1c2074471e';

$mail->setFrom("cuentas@appsalon.com");
$mail->addAddress("cuentas@appsalon.com","AppSalon");
$mail->Subject="Restablece tu contrasena";

//Setam html in mai

$mail->isHTML(true);
$mail->CharSet="UTF-8";
$contenido= "<html>";
$contenido .="<p> <strong> Hola " . $this->nombre . " </strong> Este correo esta para restablecer la contrasena </p>";
//aici trimitem linkul de acces cu tokenul inclus
$contenido .= "<p> Presiona aqui <a href='http://localhost:3000/recuperar?token=" . $this->token . " '> Restablecer la contrasena</a></p>";
$contenido .= "<p> Si tu no solicitaste este cambion ignora el coreo</p>";
$contenido .="</html>";

//iar aici  adaugam la textul din variabila contenido
$mail->Body=$contenido;

//Trimetemi mailu

$mail->send();
    }
}

?>