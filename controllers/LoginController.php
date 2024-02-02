<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;
use PHPMailer\Test\DebugLogTestListener;

class LoginController{

    public static function login(Router $router){

        //creem si aici alerte petru a le adauga , tot in forma de array
        $alertas = [];

        $auth = new Usuario;
        if ($_SERVER["REQUEST_METHOD"]==="POST"){
            //instantiem userul si ii trecem ce primim in post
            //astfel  poate fi salvat in constructor cu args 
            $auth = new Usuario($_POST);

            //aici folosim  o functie pentru a valida ca exista userul
            //iar dupa il salvam in alerte ca sa avem aces atat la mesajul de erroare cat si de succes
        $alertas=    $auth->validarLogin();

            if(empty($alertas)){
                //aici verificam daca exista useru cu ajutorul functie where
                //care ia ca parametri colona ce trebuie verificata si valuarea adica ce avem salvat in auth
                $usuario =Usuario::where("email",$auth->email);

                if($usuario){
                    //daca exista userul verificam passwordul, si daca este true verificam mai departe
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        //odata ce am confirmada userul icempem sesiunea pentru a putea salva datele in
                        //browser si a avea acces la superglobala sesion
                            session_start();
                            $_SESSION["id"]=$usuario->id;
                            $_SESSION["nombre"]=$usuario->nombre . " " . $usuario->apellido;
                            $_SESSION["email"]=$usuario->email;
                            $_SESSION["login"]=true;

                            //Redirectionam userul in functie de datele introduse,daca este admin sau nu de ex
                            if($usuario->admin ==="1"){
                                $_SESSION["admin"]=$usuario->admin ?? null;
                                header("Location: /admin");
                            }else{
                                header("Location: /cita");
                            }

                    }
                }else{
                    //iar daca nu avem un user trimitem o alerta
                    Usuario::setAlerta("error","Usuario no encontrado");

                }
            }
        }
        $alertas=Usuario::getAlertas();
        $router->render("auth/login",[

            "alertas"=>$alertas,
            //ii trimitem si auth adica userul pentru a putea adauga in formularul de login 
            //datele introduse de user
            "auth"=>$auth
        ]);
    }

    public static function logout (){

        echo "desde el logout";
    }

    public static function olvide(Router $router){
        $error=false;
        $alertas=[];
        //in auth salvam toate datel introduse de user
        $auth = new Usuario($_POST);

        //validam emailu si il salvam in alerte
      $alertas =$auth->validarEmail();
        if($_SERVER['REQUEST_METHOD']==="POST"){

            if(empty($alertas)){
                $usuario =Usuario::where("email",$auth->email);
                if($usuario && $usuario->confirmado === "1"){
                    //generam tokenu
                    $usuario->crearToken();
                    //iar dupa il salvam in baza de date
                    $usuario->guardar();

                    //Mai ramane de trimis mailu cu password recovery
                    //creem o nou instanta a clasei email , si ii trimtem clasei email 
                    //mai exacxt contructorului parametri respectivi
                    $usuario=new Email($usuario->email, $usuario->nombre,$usuario->token);
                    $usuario->enviarInstruciones();

                    Usuario::setAlerta("exito","Has manado el correo");
                }else{
                    Usuario::setAlerta("error","El email no es valido");
                }
            }
            $alertas= Usuario::getAlertas();
        }

        $router->render("auth/olvide-password",[
         "alertas"=>$alertas
        ]);
    }
    public static function recuperar(Router $router){

        $alertas=[];

        //citim tokenu de la website pentru a veadea daca concide cu cel al userului

        $token = s($_GET["token"]);

        $usuario = Usuario::where("token",$token);

        $error=false;
        if (empty($usuario)){
            Usuario::setAlerta("error","token no valido");
            $error=true;

        }
//Daca tokenu este valid atunci putem schimba parola

if($_SERVER['REQUEST_METHOD']==="POST"){
    $password= new Usuario($_POST);
    
    $alertas = $password->validarPassword();

    if(empty($alertas)){
        //Daca nu avem nici o erroare facem un delete de la passwordu din obiecutul usuario
        $usuario->password=null;

        //iar aici il asignam dinou userului
        $usuario->password= $password->password;
        //hasheem passu
        $usuario->hashPassword();
        //dilitam tokenu
        $usuario->token=null;
        //salvam datele in obiectul user pe care le trimitem in constructor clasei Usuario
     $resultado=   $usuario->guardar();

     if($resultado){
        header("Location: /");
     }

        Usuario::where("pasword", $password);

    }
}

        

        $alertas = Usuario::getAlertas();
        $router->render('/auth/recuperar',[
            "alertas"=>$alertas,
            "error"=>$error

        ]);
    }

    public static function crear(Router $router){

        //Alerte goale de tip array pentru  salva toate alertele ,pentru a le puetea 
        //utiliza intrun  for each in crear-cuenta.php si a arata toate errorile
        $alertas=[];

            //aici instantiem usuario,asa avem aces la toate functiile din models Usuario
        $usuario = new Usuario;

//cand apasam pe inputu submit din formulariu crear o se actives ruta post ,si o sa putem trimite date 
//in if asta
        if($_SERVER['REQUEST_METHOD']==="POST"){
            //folosim functi sincronizar pentru a salva datele in memorie 
            //functia asta se afla in active record si avem acces la ea datorita eredari pe care o facem 
            //cu extend din usuario
            $usuario->sincronizar($_POST);
           $alertas= $usuario->validarNuevaCuenta();

           //Revizam ca arrayu de alerte este gol

           if(empty($alertas)){
            //Verificam ca userul nu este inregistrat
           $resultado= $usuario->existeUsuario();
            //iar daca exista userul reinitiem dinou alertele ,in caz ca userul nu introduce toate datele
           if ($resultado->num_rows){
          $alertas=  Usuario::getAlertas();
           }else{
            //Daca userul nu este inregfistrat il salvam in memorie
            //hashem pasworldul
            $usuario->hashPassword();
            
            //Generam un token
            $usuario->crearToken();

            //Trimitem emailu ,instantiem clasa email din folderu clases
            $email = new Email($usuario->email,$usuario->nombre,$usuario->token);

            //Iar acum putem trimite confirmare cu functia asta
            $email->enviarConfirmacion();

            //Creem usuario cu fuctia guardar la care avem acces din active record si il salvam

       $resultado=     $usuario->guardar();

       if($resultado){
        header("Location: /mensaje");
    }

           }

           }

        }
        $router->render("auth/crear-cuenta",[
            //facem asta pentru a putea acesa datele in pagina de creaer-cuenta 
            //si astefel putem avea de exemplu un autoload la datele din formular
            "usuario"=>$usuario,
            //si asa ii trecem si alertele
            "alertas"=> $alertas
        
        ]);
    }
    public static function mensaje(Router $router){

        $router->render("/auth/mensaje");
    }
    public static function confirmar(Router $router){
        $usuario = new Usuario;


        $alertas=[];
        // asa savam token din url pagingini
        $token = s($_GET["token"]);

$usuario=Usuario::where("token",$token);


if(empty($usuario)){
    //Daca nu avem user cu tokenul respectiv monstram esaj de erroare
    
    Usuario::setAlerta("error","token no valido");
}else{
    //altfel mofidificam confirmado de la 0 la 1
    $usuario->confirmado="1";
    $usuario->token=null;
    //iar dupa inregistram userul
    $usuario->guardar();
    $usuario::setAlerta("exito","Cuenta comprobada corectamente");
}
//iar aici adaugam la alerte ce am setat cu usuario setAlertas ,si asa putem trimite si alerta respectiva
//in caz ca o avem
$alertas=Usuario::getAlertas();
        $router->render("/auth/confirmar-cuenta",[
            "alertas"=>$alertas
        ]);
    }

}

?>