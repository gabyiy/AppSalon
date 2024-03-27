<?php

namespace Controllers;
use MVC\Router;

class CitaController{

    public static function index(Router $router){
            //initiem sesiunea pentru a putea avea acces la numele usuerului
            session_start();

            //Verifica daca userl este autetificat mai intai
            isAuth();

        $router->render("cita/index",[
            "nombre"=>$_SESSION["nombre"],
            "id"=>$_SESSION["id"]


        ]);
    }

}

?>