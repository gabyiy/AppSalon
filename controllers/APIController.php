<?php 

namespace Controllers;

use Model\Servicio;

class APIController{
    public static function index(){
        $servicios= Servicio::all();

        //transforma in json
        echo json_encode($servicios);

    }

}
?>