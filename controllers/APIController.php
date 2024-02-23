<?php 

namespace Controllers;

use Model\Cita;
use Model\CitaServicios;
use Model\Servicio;

class APIController{
    public static function index(){

        $servicios= Servicio::all();

        //transforma in json
        echo json_encode($servicios);

    }
    public static function guardar(){
        $cita = new Cita($_POST);

        //Salveaza cita si returneaza idul
        $resultado = $cita->guardar();
        $id=$resultado["id"];

        //asa scoatem pozitia fiecarui id cu explode si le salvam
        $idServicios= explode(",",$_POST["servicios"]);

        foreach($idServicios as $idServicio){
            $args=[
                "citaId"=>$id,
                "servicioId"=> $idServicio
            ];
            $citaServicio= new CitaServicios($args);
            $citaServicio->guardar();
        }
        //Returnam un raspuns
        $respuesta=[
            "resultado"=>$resultado
        ];

        //transforma respuesta in json pentru a putea fi citit in js 
        echo json_encode($respuesta);
    }

}
?>