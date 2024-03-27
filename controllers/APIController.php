<?php 

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
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
            $citaServicio= new CitaServicio($args);
            $citaServicio->guardar();
        }
        //Returnam un raspuns
        echo json_encode(['resultado' => $resultado]);

    }

    public static function eliminar(){
        if($_SERVER["REQUEST_METHOD"]==="POST");
        //salvam idul pe care il primim prin [post]
        $id= $_POST["id"];

        //gasim id cu functia din cita 
        $cita =Cita::find($id);
        $cita->eliminar();
        //dupa ce am eliminat cita spunem sa ne redirectioneze la acxeasi pagina 

        header("Location:" .$_SERVER["HTTP_REFERER"]);
    }
 
}
?>