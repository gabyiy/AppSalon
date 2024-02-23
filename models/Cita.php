<?php 
namespace Model;

class Cita extends ActiveRecord{

   protected static $tabla = "citas";
    protected static $columnasDB = ["id","usuarioId","hora","fecha"];


    public $id;
    public $fecha;
    public $hora;
    public $usuarioId;

    public function __construct($args=[]){

        $this->id = $args["id"]?? null;
        $this->usuarioId= $args["usuarioId"]??"";
        $this->hora = $args["hora"]?? "";
        $this->fecha = $args["fecha"]?? "";

    }
    
        
    
}


?>