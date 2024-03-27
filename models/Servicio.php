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
  
    public function validar(){
        if(!$this->nombre){
           self::$alertas["error"][]="Tienes que introducir un nombre del servicio"; 
        }

        if(!$this->precio){
            self::$alertas["error"][]="Tienes que introducir el precio del servicio";
        }
        if(!$this->precio){
            self::$alertas["error"][]="Tienes que introducir el precio del servicio";
        }
        if(!is_numeric($this->precio)){
            self::$alertas["error"][]="Tienes que introducir numeros";
        }

        return self::$alertas;
    }
      
    }
    
?>