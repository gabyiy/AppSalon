<?php

namespace Model;
use MVC\Router;

class CitaController{

    public static function index(Router $router){

        $router->render("cita/index",[]);
    }

}

?>