<?php 
namespace Model;


class Servicio extends ActiveRecord{

    //configuram basa de date

    protected static $tabla = "servicios";
    protected static $columnasDB= ["id","nombre","precio"];

    public $id ;
    public $nombre ;
    public $precio;

    public function __construct($args=[]){
$this->id= $args["id"]?? null;
$this->nombre = $args["nombre"]?? "";
$this->precio= $args["precio"]?? "";
    }
    
      
    }
    
?>