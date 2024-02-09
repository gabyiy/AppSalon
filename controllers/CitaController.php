<?php

namespace Controllers;
use MVC\Router;

class CitaController{

    public static function index(Router $router){
            //initiem sesiunea pentru a putea avea acces la numele usuerului

        session_start();
        $router->render("cita/index",[
            "nombre"=>$_SESSION["nombre"]

        ]);
    }

}

?>