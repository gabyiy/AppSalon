<?php 

 namespace Model;

use Classes\Email;

 class Usuario extends ActiveRecord {

    //baza de date
// aici ii trecem tabla pe care vrem sa o accesam
    protected static $tabla='usuarios';
// si aici o sa iteram peste toate columenle cu ajutoru dunctiiei din ActivRecord de la care eredam
    protected static $columnasDB= ['id',"nombre",'apellido','admin','telefono','password','email','confirmado','token'];

    //aici le creem la fiecare variabile
    public $id;
    public $nombre;
    public $apellido;
    public $admin;
    public $telefono;
    public $password;
    public $email;
    public $confirmado;
    public $token;

//facem constructoru care va primi argumente dar pe defaul o sa fie empty
    public function __construct($args = []){
        //iar aici adaugam ce avem la this ,adica constantele cre le avem in clasa or sa 
        // se updateze cu ce primim din formular si il transferam cu ajutoru la args

        $this->id= $args['id']?? null;
        $this->nombre= $args['nombre']?? "";
        $this->apellido= $args['apellido']?? "";
        $this->admin= $args['admin']?? "0";
        $this->telefono= $args['telefono']?? "";
        $this->password= $args['password']?? "";
        $this->email= $args['email']?? "";
        $this->confirmado= $args['confirmado']?? "0";
        $this->token= $args['token']?? "";
    }
     

    //Mesaje de validare pentru crea de cuenta


    public function validarNuevaCuenta(){

        if(!$this->nombre){
            //asa acesam functia estatic alertas din active record sii ii adaugam un mesaj de erroare in caz
            //ca nu introduce numele o sa primeasca alerta
            self::$alertas["error"][]="El nombre del cliente es obligatorio";

        } if(!$this->apellido){
           
            self::$alertas["error"][]="El apellido del cliente es obligatorio";

        }
        if(!$this->email){
           
            self::$alertas["error"][]="El apellido del cliente es obligatorio";

        }
        if(!$this->password){
           
            self::$alertas["error"][]="El password del cliente es obligatorio";

        }
        if(!$this->telefono){
           
            self::$alertas["error"][]="El telefono del cliente es obligatorio";

        }
    
        if(strlen($this->password)<6){
            self::$alertas["error"][]="El password tiene que tener mas de 6 digitos";
        }
        return self::$alertas;
    }

    //functia care revizeaza daca exista userul ,tabla fiind usuario
    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla ." WHERE email = '" . $this->email . "' LIMIT 1";

        //asa acesam baza de date de forma statica si apoi acesam metoda de query
        //si daca avem mai multe num rows inseamna ca userul exista
        $resultado = self::$db->query($query);
        if($resultado){
            self::$alertas["error"][]="El  Usuario ya existe";

        }
        //returnam resutadul pentru a putea avea acces in login controler la el 
        //si al folosi acolo
        return $resultado;
    }
    //hashem passwordu ci bcrypt
    public function hashPassword(){
    $this->password=password_hash($this->password,PASSWORD_BCRYPT);
    }


    //functia pentru token
    public function crearToken(){
        $this->token=uniqid();
    }

    public function comprobarPasswordAndVerificado($password){
        //aici verificam passwordul introdus de user este lafel cu ecel din baza de datw
        $resultado = password_verify($password,$this->password);
        //aici vedem daca userul este confirmat 
        if(!$resultado || !$this->confirmado){
            self::$alertas["error"][]= "Password incorecto o tu cuenta no ha sido confirmada";
        }else{
            return true;
        }
    }


    public function validarLogin(){
    
        if(!$this->password){   
            self::$alertas['error'][]="Tienes que introducir un password ";
        }
        return self::$alertas;
    }

    public function validarEmail(){

        if(!$this->email){
            self::$alertas['error'][]="Tienes que introducir un email ";
        }
        
        return self::$alertas;

    }

    public function  validarPassword(){
        if(!$this->password){
            self::$alertas["error"][]="Tienes que introducir un password";
        }
        if(strlen($this->password)<6){
            self::$alertas["error"][]="El password tiene que tener mas de 6 caracteres";
        }

        return self::$alertas;
    }
    }


?>
