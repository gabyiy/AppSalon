<?php 
namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController{

    public static function index(Router $router){
        //initiem sesiunea pentru a avea acces la date
        session_start();

        //protejam ruta si doar daca este admin poate intra aici
        isAdmin();   
        //scoatem toate servicile din servici
        $servicios=Servicio::all();
        $router->render("servicios/index",[
            //ii trecem numele pentru a putea aparea in bara
            "nombre"=>$_SESSION["nombre"],
            "servicios"=>$servicios
        ]);

    }

    public static function crear(Router $router){
 session_start();
isAdmin();
 //instatiem servicio pentru a avea acces la date
 $servicio = new  Servicio;

 $alertas = [];
 if($_SERVER["REQUEST_METHOD"]==="POST"){

    //folosim metoda sincronizar pentru a ramane in formular datele introduse de user

    $servicio->sincronizar($_POST);

   $alertas= $servicio->validar();

   if(empty($alertas)){
$servicio->guardar();

header("Location: /servicios");

   }
 }
 $router->render("servicios/crear",[
    "nombre"=>$_SESSION["nombre"],
    "servicio"=>$servicio,
    "alertas"=> $alertas
 ]);
    }
    public static function actualizar(Router $router){
        session_start();
        isAdmin();
        //daca nu exista idul sa nu se intample nimic
        if(!is_numeric( $_GET["id"]))
        return;
        $servicio =  Servicio::find($_GET["id"]);
        $alertas= [];

 if($_SERVER["REQUEST_METHOD"]==="POST"){
   $servicio ->sincronizar($_POST);
   $alertas= $servicio->validar();

   if(empty($alertas)){
      $servicio->guardar();
      header("Location: /servicios ");
   }
    
 }
 $router->render("servicios/actualizar",[
   "nombre"=>$_SESSION["nombre"],
   "servicio"=> $servicio,
   "alertas"=> $alertas
 ]);
    }
    public static function eliminar(){

      
      session_start();
      isAdmin();
            if($_SERVER["REQUEST_METHOD"]==="POST"){
         $id = $_POST["id"];
         $servicio= Servicio::find($id);
         $servicio->eliminar();
         header("Location: /servicios");
      }
  

    }
}

?>